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
        $('#userDetailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name'); // Extract info from data-* attributes
            var joinedAt = button.data('joinedat');
            var companyName = button.data('companyname');

            var modal = $(this);
            modal.find('#userName').text(name);
            modal.find('#userJoinedAt').text(joinedAt);
            modal.find('#userCompanyName').text(companyName);
        });
    </script>
    
    <script>
        window.onload = function() {
            getLocation(); // Mendapatkan lokasi pengguna dan memuat data pertama kali
        };

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById("location").innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;

            var searchQuery = $('input[name="search"]').val(); // Ambil nilai pencarian

            // Memuat konten dari URL yang disediakan ke dalam elemen dengan ID adsListsWithDistance
            // $('#adsListsWithDistance').load("{{ route('agent.getAgentsByDistrict') }}" + '?latitude=' + lat + '&longitude=' + long + '&search=' + searchQuery);
            $.ajax({
                        url: "{{ route('agent.getAgentsByDistrict') }}",
                        type: 'GET',
                        data: {
                            latitude: lat,
                            longitude: long,
                            search: searchQuery
                        },
                        success: function(response) {
                            $('#adsListsWithDistance').html(response.html); // Update content dengan hasil dari server
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    document.getElementById("location").innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    document.getElementById("location").innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    document.getElementById("location").innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    document.getElementById("location").innerHTML = "An unknown error occurred."
                    break;
            }
        }
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form dari submit secara default

                var searchQuery = $('input[name="search"]').val(); // Ambil nilai pencarian

                // Mendapatkan lokasi pengguna untuk dimasukkan dalam pencarian
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var long = position.coords.longitude;

                    // AJAX request untuk memuat data ke adsListsWithDistance
                    $.ajax({
                        url: "{{ route('agent.getAgentsByDistrict') }}",
                        type: 'GET',
                        data: {
                            latitude: lat,
                            longitude: long,
                            search: searchQuery
                        },
                        success: function(response) {
                            $('#adsListsWithDistance').html(response.html); // Update content dengan hasil dari server
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                });
            });
        });
    </script>
 <script>
        function showSampleLocations(inputValue) {
            if (inputValue.length < 2) {
                document.getElementById('sampleLocations').innerHTML = '';
                return;
            }
          
            const url = `{{route('tool.searchDistricts')}}`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // if you are using Laravel with CSRF protection
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
                    
                    // Tambahkan event listener untuk menangani klik
                    locationItem.addEventListener('click', () => {
                    
                        document.getElementById('searchLok').value = item.name;
                        document.getElementById('sampleLocations').innerHTML = '';
                        document.getElementById('adsListsWithDistance').innerHTML = '';
                        latitude = item.meta.lat;
                        longitude = item.meta.long;
                        districtId = item.id;
                        // showPosition(currentPage)
                        navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var long = position.coords.longitude;

                    // AJAX request untuk memuat data ke adsListsWithDistance
                    $.ajax({
                        url: "{{ route('agent.getAgentsByDistrict') }}",
                        type: 'GET',
                        data: {
                            latitude: lat,
                            longitude: long,
                            district_id: districtId
                        },
                        success: function(response) {
                            $('#adsListsWithDistance').html(response.html); // Update content dengan hasil dari server
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                });
                        console.log(item.meta); // Menampilkan item.meta di console saat diklik
                    });
                    
                    sampleLocationsDiv.appendChild(locationItem);
                });
            })
            .catch(error => {
                console.error('Error fetching location data:', error);
            });

        }
        function searchLocation() {

// alert(88);
// const inputElement = document.querySelector('.location-input input');
// const locationText = inputElement.value;
// currentPage = 1;
console.log('Lokasi yang dicari:', locationText);

document.getElementById('adsListsWithDistance').innerHTML = '';
showPosition(currentPage);

}
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
    <x-Item.PropertySearchBar beliSewa=false>
    </x-Item.PropertySearchBar>
    <div class="row mt-3">
        <h2 class="text-center w-100 text-white">Cari Agen</h2> <!-- Judul baru -->
         
        <!--end col-->
    </div>
    <div class="row mt-3" id="adsListsWithDistance"></div>

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