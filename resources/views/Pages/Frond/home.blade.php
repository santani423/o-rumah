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
    const urlBooster = `{{ route('tool.getAdsListsWithDistance.booster.home') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&ads_type=${beliSewa}`;
    const url = `{{ route('tool.getAdsListsWithDistance') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&ads_type=${beliSewa}`;
    
    document.getElementById('loadingSpinner').style.display = 'block'; // Show the spinner

    if (isFirstLoad) {
        // Fetch urlBooster first only on the first load
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
    const inputElement = document.querySelector('.location-input input');
    const locationText = inputElement.value;
    currentPage = 1;
    console.log('Lokasi yang dicari:', locationText);
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
        // Lakukan sesuatu dengan ID tipe properti yang dipilih
        typeProperti = propertyTypeId;
        console.log('ID Tipe Properti yang Dipilih:', propertyTypeId);
        // Contoh: Kirim ID ke server atau lakukan tindakan lain
    }
</script>
    @endslot
    @slot('body')

    
    <div class="row">
        <div class="col-md-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($bannerLists as $key => $bnr)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" @if($key == 0) class="active" @endif>
                        </li>
                    @endforeach
                </ol>
                <div class="carousel-inner" role="listbox">
                    @foreach ($bannerLists as $key => $bnr)
                        <div class="carousel-item @if($key == 0) active @endif" onclick="linkBanner(`{{$bnr->url}}`)">
                            <img class="d-block img-fluid" src="{{asset('storage/' . $bnr->image)}}" alt="First slide">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

 

    <div class="container mt-5">
        <!-- Tabs -->

        <div class="row justify-content-center">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="tab-container mb-2">
            <div class="tab active" id="jual-tab" onclick="showTab('jual')">Beli</div>
            <div class="tab " id="sewa-tab" onclick="showTab('sewa')">Sewa</div>
        </div>
    </div>
</div>


        <!-- Search Bar -->
        <div class="search-bar d-flex align-items-center">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="propertyTypeDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-home mr-2"></i>Tipe Properti
                </button>
                <div class="dropdown-menu" aria-labelledby="propertyTypeDropdown">
                    @foreach($tipeProperti as $tipe)
                        <a class="dropdown-item" href="#" onclick="selectPropertyType({{ $tipe->id }})">{{ $tipe->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="location-input flex-grow-1 ml-3">
                <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
                <input type="text" class="form-control border-0"
                    placeholder="Lokasi, keyword, area">
            </div>
            <button class="btn btn-success ml-3"  >
                <i class="fas fa-search"></i>
            </button>

        </div>


        <div class="card mt-2">
            <div class="card-body">
                <div class="nav-container">
                    <div class="nav-links row">
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('latest') }}"><i class="fas fa-home"></i><br>Properti</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('auction') }}"><i class="fas fa-gavel"></i><br>Properti Lelang</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('ofoods') }}"><i class="fas fa-utensils"></i><br>O-Foods</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('omerchant') }}"><i class="fas fa-store"></i><br>O-Merchant</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('law-helper') }}"><i class="fas fa-balance-scale"></i><br>Cari LBH</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('notaris') }}"><i class="fas fa-file-signature"></i><br>Cari Notaris</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('agent') }}"><i class="fas fa-user-tie"></i><br>Cari Agen</a>
                        </div>
                        <div class="nav-item col-6 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('omerchant') }}"><i class="fas fa-ellipsis-h"></i><br>Lainnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end wrapper -->
        <div  id="adsListsWithDistance" class="row mt-5"></div>
        <div class="row mt-2">
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


        <div class="card mt-2">
            <div class="card-body" style=" background-color: #f0f0f0;">
                <div class="nav-container">
                    <div class="nav-links d-flex justify-content-between">
                     
                        <div class="nav-item ml-2">
                            <a href="https://bankmaju.com/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center"> 
                                    <img src="{{asset('assets/company/logo-bank-maju-241x100-1.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-2">
                                </div>
                            </a>
                        </div>
                        <div class="nav-item ml-2">
                            <a href="https://bankmaju.com/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center"> 
                                    <img src="{{asset('assets/company/btn.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-2">
                                </div>
                            </a>
                        </div>
                        <div class="nav-item ml-2">
                            <a href="https://bankmaju.com/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center"> 
                                    <img src="{{asset('assets/company/bca.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-2">
                                </div>
                            </a>
                        </div>
                       

                    </div>
                </div>
            </div>
        </div>
   
    </div>
    @endslot


</x-Layout.Horizontal.Master>