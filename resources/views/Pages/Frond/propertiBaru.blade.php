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

        #beli-tab {
            color: white;
            background-color: #47C8C5;
        }

        .tab:not(#beli-tab):hover {
            background-color: #f0f0f0;
        }

        /* Search Bar */
        .search-bar {
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .btn-success {
            background-color:  #f0f0f0; 
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
            max-height: 300px;
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
    @endslot
    @slot('js')
    <script>
    let currentPage = 1;
    const perPage = 5;
    let latitude = null;
    let longitude = null;
    let isFirstLoad = true;

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
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
    const urlEsklisif = `{{ route('tool.getAdsListsWithDistance.booster.eksklusif') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}`;
    const urlBooster = `{{ route('tool.getAdsListsWithDistance.booster.sundul') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}`;
    const url = `{{ route('tool.getAdsListsWithDistance') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}`;
    
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
</script>

    @endslot
    @slot('body')

    
    

 

    <div class="container mt-2">
        


        <!-- Search Bar -->
        <div class="search-bar d-flex align-items-center">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="propertyTypeDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-home mr-2"></i>Tipe Properti
                </button>
                <div class="dropdown-menu" aria-labelledby="propertyTypeDropdown">
                     
                </div>
            </div>
            <div class="location-input flex-grow-1 ml-3">
                <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
                <input type="text" class="form-control border-0"
                    placeholder="Lokasi, keyword, area, project, developer">
            </div>
            <button class="btn btn-success ml-3"  >
                <i class="fas fa-search"></i>
            </button>

        </div>


        

        <!-- end wrapper -->
         
        <div  id="adsListsWithDistance" class="row mt-5"></div>
  
        <div class="row mt-2 mb-2">
    <div class="col-12 d-flex justify-content-center">
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