<x-Layout.Horizontal.Master>
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
    const perPage = 5;
    let latitude = null;
    let longitude = null;
    let isFirstLoad = true; 
    let beliSewa = 'Jual';
    let typeProperti = null;
    let districtId = null;
    
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
            loadAds(currentPage); // Load ads with latitude and longitude as null
        } else {
            document.getElementById("location").innerHTML = "Geolocation is not supported by this browser.";
            loadAds(currentPage); // Load ads with latitude and longitude as null
        }
    }

    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        loadAds(currentPage);
    }

    function showError(error) {
        let errorMessage = "";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                errorMessage = "User denied the request for Geolocation.";
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                errorMessage = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                errorMessage = "An unknown error occurred.";
                break;
        }
        document.getElementById("location").innerHTML = errorMessage;
        loadAds(currentPage); // Load ads with latitude and longitude as null
    }
    
    function loadAds(page) {
    const urlEsklisif = `{{ route('tool.getAdsListsWithDistance.booster.eksklusif') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&district=${districtId}`;
    const urlBooster = `{{ route('tool.getAdsListsWithDistance.booster.sundul') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&district=${districtId}`;
    const url = `{{ route('tool.getAdsListsWithDistance') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&district=${districtId}`;
    
    document.getElementById('loadingSpinner').style.display = 'block'; // Show the spinner

    if (isFirstLoad) {
        // Fetch urlEsklisif first only on the first load
        // Fetch urlEsklisif first only on the first load
fetch(urlEsklisif)
    .then(response => response.text())
    .then(data => {
        appendAdsBooster(data, 'adsListsWithDistance');
        // Fetch the main url after urlEsklisif is done
        return fetch(urlBooster);
    })
    .then(response => response.text())
    .then(data => {
        appendAdsBooster(data, 'adsListsWithDistance');
        // Set the flag to false after the first load
        isFirstLoad = false;
        // Fetch the main url after urlBooster is done
        return fetch(url);
    })
    .then(response => response.text())
    .then(data => {
        appendAds(data, 'adsListsWithDistance');
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        document.getElementById('loadingSpinner').style.display = 'none'; // Hide the spinner
    });

        fetch(urlBooster)
            .then(response => response.text())
            .then(data => {
                appendAdsBooster(data, 'adsListsWithDistance');
                // Set the flag to false after the first load
                isFirstLoad = false;
                // Fetch the main url after urlBooster is done
                return fetch(url);
            })
            .then(response => response.text())
            .then(data => {
                appendAds(data, 'adsListsWithDistance');
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                document.getElementById('loadingSpinner').style.display = 'none'; // Hide the spinner
            });
    } else {
        // Fetch the main url if it's not the first load
        fetch(url)
            .then(response => response.text())
            .then(data => {
                appendAds(data, 'adsListsWithDistance');
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                document.getElementById('loadingSpinner').style.display = 'none'; // Hide the spinner
            });
    }
}

function appendAdsBooster(html, containerId) {
    const container = document.getElementById(containerId);
    container.insertAdjacentHTML('beforeend', html);
}

function appendAds(html, containerId) {
    const container = document.getElementById(containerId);
    container.insertAdjacentHTML('beforeend', html);
}

    document.getElementById('nextButton').addEventListener('click', function() {
        currentPage++;
        loadAds(currentPage);
    });

    // Check location and load the first set of ads when the page loads
    window.onload = function () {
        getLocation();
    };

    function linkBanner(link){
    
        window.location.href = link;
    }

    function searchLocation() {

        alert(88);
    // const inputElement = document.querySelector('.location-input input');
    // const locationText = inputElement.value;
    // currentPage = 1;
    console.log('Lokasi yang dicari:', locationText);
    
    document.getElementById('adsListsWithDistance').innerHTML = '';
    loadAds(currentPage);
    
}

// Panggil fungsi ini ketika tombol pencarian ditekan
document.querySelector('.btn-success').addEventListener('click', searchLocation);

</script>
<script>
   
    function showTab(tabId) {
        // Menghapus kelas 'active' dari semua tab
        beliSewa = tabId;
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
         
        // Menambahkan kelas 'active' ke tab yang dipilih
        document.getElementById(tabId + '-tab').classList.add('active');
        document.getElementById('adsListsWithDistance').innerHTML = '';

        currentPage = 1;
        loadAds(currentPage);
    }
    function selectPropertyType(propertyTypeId) {
        console.log('propertyTypeId',propertyTypeId);
        
        // Lakukan sesuatu dengan ID tipe properti yang dipilih
        typeProperti = propertyTypeId;
        console.log('ID Tipe Properti yang Dipilih:', propertyTypeId);
        document.getElementById('propertyTypeDropdown').innerHTML = '<i class="fas fa-home mr-2"></i>'+propertyTypeId;
        // Contoh: Kirim ID ke server atau lakukan tindakan lain
        document.getElementById('adsListsWithDistance').innerHTML = '';

currentPage = 1;
loadAds(currentPage);
      
    }
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
                        districtId = item.code;
                        loadAds(currentPage)
                        console.log(item.meta); // Menampilkan item.meta di console saat diklik
                    });
                    
                    sampleLocationsDiv.appendChild(locationItem);
                });
            })
            .catch(error => {
                console.error('Error fetching location data:', error);
            });

        }
    </script>
    @endslot
    @slot('body')

    
 
 

    <div class="container mt-5">
        <!-- Tabs -->
        <x-Item.PropertySearchBar>
        </x-Item.PropertySearchBar>


      

        <!-- end wrapper -->
        <div  id="adsListsWithDistance" class="row mt-5"></div>
        <div class="row mt-2">
    <div class="col-12 d-flex justify-content-center mb-3">
    <button type="button" class="btn   "  
        style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white" id="nextButton">
        Next <div class="spinner-border text-primary" role="status" id="loadingSpinner" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
    </button>
    </div>
    <div class="row mt-3">
            <div class="col-12 d-flex justify-content-center">
                
            </div>
        </div>
</div>


        
   
    </div>
    @endslot


</x-Layout.Horizontal.Master>
