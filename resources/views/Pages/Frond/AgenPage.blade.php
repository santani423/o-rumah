<x-Layout.Horizontal.Master title="Agent">
    @slot('css')
    <style>
        /* Tabs */
        .tab-container {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 10px 20px;
            cursor: pointer;
            color: #999;
            background-color: white;
        }

        .active {
            color: white;
            background-color: #47C8C5;
        }

        /* .tab:not(#beli-tab):hover {
        background-color: #f0f0f0;
    } */

        /* Search Bar */
        .search-bar {
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .btn-success {
            background-color: #f0f0f0;
        }

        .dropdown-toggle {
            border: none;
            background: none;
            box-shadow: none;
        }

        .dropdown-toggle:focus {
            box-shadow: none;
        }

        .location-input {
            display: flex;
            align-items: center;
            border-left: 1px solid #ddd;
            padding-left: 10px;
        }

        .location-input input {
            flex-grow: 1;
        }

        .card {
            width: calc(100% - 4px);
            margin: 2px;
        }

        /* Styling for the navbar */
        .nav-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Styling for the navbar links */
        .nav-links a {
            margin-right: 20px;
            text-decoration: none;
            color: #000;
        }

        .nav-links {
            display: flex;
            justify-content: space-between;
            overflow-x: auto;
            white-space: nowrap;
        }

        .nav-item {
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Carousel */
        .carousel-item {
            text-align: center;
        }

        .carousel-item img {
            width: 100%;
            height: auto;
            border-radius: 15px;
        }

        .carousel-inner {
            border-radius: 15px;
            overflow: hidden;
        }
    </style>
    <style>
        .sample-location-item {
            padding: 5px;
            cursor: pointer;
        }

        .sample-location-item:hover {
            background-color: #f0f0f0;
        }
    </style>
    <style>
        .form-group {
            margin-bottom: 1em;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5em;
        }

        .location-input {
            position: relative;
        }

        #sampleLocations {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 10;
            background-color: white;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
        }.small,small {
    font-size: 70%;
    font-weight: 400
}
    </style>
    @endslot
    @slot('js')
    <script>
    let currentPage = 1;
    const perPage = 8;
    let latitude = null;
    let longitude = null;
    let isFirstLoad = true; 
    let beliSewa = 'Jual';
    let typeProperti = false;
    let districtId = null;

    // Modal untuk detail user
    $('#userDetailModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var modal = $(this);
        modal.find('#userName').text(button.data('name'));
        modal.find('#userJoinedAt').text(button.data('joinedat'));
        modal.find('#userCompanyName').text(button.data('companyname'));
    });

    // Fungsi untuk mendapatkan lokasi dan menampilkan data agen saat halaman dimuat
    window.onload = function() {
        getLocation();
    };

    // Fungsi untuk mendapatkan geolocation pengguna
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.error("Geolocation is not supported by this browser.");
            // Jika geolocation tidak didukung, tetap memuat data agen
            loadAgents(currentPage); 
        }
    }

    // Menampilkan posisi setelah geolocation berhasil
    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        loadAgents(currentPage); // Memuat agen berdasarkan posisi saat halaman pertama kali dimuat
    }

    // Fungsi untuk menangani kesalahan saat mendapatkan geolocation
    function showError(error) {
        let errorMsg;
        switch (error.code) {
            case error.PERMISSION_DENIED:
                errorMsg = "User denied the request for Geolocation.";
                break;
            case error.POSITION_UNAVAILABLE:
                errorMsg = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                errorMsg = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                errorMsg = "An unknown error occurred.";
                break;
        }
        console.warn(errorMsg);

        // Tetap memuat agen tanpa geolocation
        loadAgents(currentPage);
    }

    // Fungsi untuk memuat agen berdasarkan lokasi pengguna dan query pencarian
    function loadAgents(page) {
        var searchQuery = $('input[name="search"]').val(); // Ambil nilai pencarian

        // Jika latitude dan longitude tidak tersedia, gunakan default atau kosongkan
        var lat = latitude || null;
        var long = longitude || null;

        $.ajax({
            url: "{{ route('agent.getAgentsByDistrict') }}",
            type: 'GET',
            data: {
                latitude: lat,
                longitude: long,
                search: searchQuery,
                page: page
            },
            success: function(response) {
                if (page === 1) {
                    $('#adsListsWithDistance').html(response.html); // Load pertama kali
                } else {
                    $('#adsListsWithDistance').append(response.html); // Append untuk halaman berikutnya
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
            }
        });
    }

    // Fungsi untuk menampilkan lokasi sampel saat mengetik pencarian lokasi
    function showSampleLocations(inputValue) {
        if (inputValue.length < 2) {
            document.getElementById('sampleLocations').innerHTML = '';
            return;
        }

        fetch(`{{route('tool.searchDistricts')}}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ keyword: inputValue })
        })
        .then(response => response.json())
        .then(data => {
            const sampleLocationsDiv = document.getElementById('sampleLocations');
            sampleLocationsDiv.innerHTML = '';

            data.forEach(item => {
                const locationItem = document.createElement('div');
                locationItem.textContent = item.name;
                locationItem.classList.add('sample-location-item');
                
                locationItem.addEventListener('click', () => {
                    $('#searchLok').val(item.name);
                    latitude = item.meta.lat;
                    longitude = item.meta.long;
                    districtId = item.id;
                    sampleLocationsDiv.innerHTML = '';
                    currentPage = 1;
                    loadAgents(currentPage); // Memuat agen berdasarkan distrik yang dipilih
                });

                sampleLocationsDiv.appendChild(locationItem);
            });
        })
        .catch(error => {
            console.error('Error fetching location data:', error);
        });
    }

    // Fungsi untuk mencari lokasi
    function searchLocation() {
        console.log('Lokasi yang dicari:', locationText);
        $('#adsListsWithDistance').html(''); // Kosongkan daftar agen
        currentPage = 1;
        loadAgents(currentPage);
    }

    // Fungsi untuk memuat lebih banyak agen
    function loadMoreAgents() {
        currentPage++;
        loadAgents(currentPage); // Muat halaman berikutnya
    }

    // Menangani submit dari form pencarian
    $(document).ready(function() {
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit secara default
            searchLocation(); // Panggil fungsi pencarian lokasi
        });
    });
</script>


    @endslot

    @slot('body')
    <!-- Search Bar -->
    <!-- <div class="search-bar d-flex align-items-center mt-3">
        <form action="{{ route('agent.search.page') }}" method="post" class="d-flex align-items-center w-100">
            @csrf
            <div class="location-input flex-grow-1 ml-3">
                <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
                <input type="text" name="search" class="form-control border-0" placeholder="Nama atau Nama Pengguna" value="{{ request()->input('search') }}">
            </div>
            <button type="submit" class="btn btn-success ml-3">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div> -->
    <x-Item.PropertySearchBar beliSewa=0>
    </x-Item.PropertySearchBar>
    <div class="row mt-3">
        <h2 class="text-center w-100 text-white">Cari Agen</h2> <!-- Judul baru -->
         
        <!--end col-->
    </div>
    <div class="row mt-3" id="adsListsWithDistance"></div>
  <!-- Next Button to Load More Agents -->
  <div class="d-flex justify-content-center mt-3 mb-3">
        <button id="nextPage" class="btn btn-primary mt-3" onclick="loadMoreAgents()" style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white">Next</button>
    </div>
    <!-- Modal Detail User -->
    <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailModalLabel">Detail Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Nama: <span id="userName"></span></p>
                    <p>Bergabung Sejak: <span id="userJoinedAt"></span></p>
                    <p>Perusahaan: <span id="userCompanyName"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @endslot
</x-Layout.Horizontal.Master>