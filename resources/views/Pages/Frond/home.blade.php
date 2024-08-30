<x-Layout.Horizontal.Master>
    @slot('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

    <!-- Tambahkan CSS -->
    <style>
        .card {
            position: relative;
            overflow: hidden;
        }

        .arrow-circle {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: 2px solid #47C8C5;
            /* Warna border */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
        }

        .arrow-circle i {
            color: #47C8C5;
            /* Warna panah */
            font-size: 16px;
        }

        .card-link {
            text-decoration: none;
        }

        .icon-label {
            display: inline-block;
            max-width: 100%;
            white-space: normal;
            font-size: 10px;
            /* Memungkinkan teks untuk dibungkus */
            overflow: hidden;
            text-align: center;
            word-wrap: break-word;
            /* Memaksa pemotongan kata */
        }

        .small-card {
            width: 100%;
            height: 60%;
            /* Atur ukuran lebar kartu */
            /* padding: 10px; */
            /* Mengurangi padding untuk ukuran yang lebih kompak */
            margin: 0 auto;
            /* Rata tengah untuk kolom */
        }

        .card-body {
            padding: 5px;
            /* Mengurangi padding dalam body kartu */
        }

        .card-title {
            font-size: 14px;
            /* Ukuran font lebih kecil untuk judul */
            margin-bottom: 5px;
        }

        .card-text {
            font-size: 12px;
            /* Ukuran font lebih kecil untuk teks */
        }

        .arrow-circle {
            position: absolute;
            bottom: 10px;
            /* Posisikan di bawah */
            right: 10px;
            /* Posisikan di kanan */
            font-size: 16px;
            /* Ukuran ikon lebih kecil */
            background-color: #f8f9fa;
            border-radius: 50%;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    @endslot
    @slot('js')
    <script>
        let currentPage = 1;
        const perPage = 8;
        let latitude = null;
        let longitude = null;
        let district = null;
        let isFirstLoad = true;
        let beliSewa = 'Jual';
        let typeProperti = false;
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
            // console.log('dddd',district);
            document.getElementById('sampleLocations').innerHTML = '';
            // const urlBooster = `{{ route('tool.getAdsListsWithDistance.booster.home') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&ads_type=${beliSewa}&property_type=${typeProperti}&district=${district}`;
            const urlBooster = `{{ route('tool.getAdsListsWithDistance.booster.home') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&district=${districtId}&ads_type=${beliSewa}&typeProperti=${typeProperti}`;
            const url = `{{ route('tool.getAdsListsWithDistance') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&district=${districtId}&ads_type=${beliSewa}&typeProperti=${typeProperti}`;

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
        window.onload = function() {
            getLocation();
        };

        function linkBanner(link) {

            window.location.href = link;
        }

        function searchLocation() {
            // const inputElement = document.querySelector('.location-input input');
            // const locationText = inputElement.value;
            // currentPage = 1;
            // console.log('Lokasi yang dicari:', locationText);

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
            // Lakukan sesuatu dengan ID tipe properti yang dipilih
            typeProperti = propertyTypeId;
            console.log('ID Tipe Properti yang Dipilih:', propertyTypeId);
            document.getElementById('propertyTypeDropdown').innerHTML = '<i class="fas fa-home mr-2"></i>' + propertyTypeId;
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
                    body: JSON.stringify({
                        keyword: inputValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const sampleLocationsDiv = document.getElementById('sampleLocations');
                    sampleLocationsDiv.innerHTML = '';

                    data.forEach(item => {
                        console.log('item jj', item);
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
                            district = item.code;
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


    <div class="row">
        <div class="col-md-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($bannerLists as $key => $bnr)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" @if($key==0) class="active" @endif>
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



    <div class="container mt-1">
        <!-- Tabs -->
        <x-Item.PropertySearchBar>
        </x-Item.PropertySearchBar>


        <div class="card mt-1">
            <div class="card-body">
                <div class="nav-container">
                    <div class="nav-links row">
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('latest') }}">
                                <img src="{{asset('/assets/icons/homeIcon5-removebg-preview.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">Properti</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('auction') }}">
                                <img src="{{asset('/assets/icons/homeIcon4-removebg-preview.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">Properti Lelang</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('ofoods') }}">
                                <img src="{{asset('/assets/icons/homeIconbg6.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">O-Foods</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('omerchant') }}">
                                <img src="{{asset('/assets/icons/foodMarchant/merchant.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">O-Merchant</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('agent') }}">
                                <img src="{{asset('/assets/icons/homeIcon1-removebg-preview.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">Cari Agen</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('notaris') }}">
                                <img src="{{asset('/assets/icons/homeIcon2-removebg-preview.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">Cari Notaris</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('law-helper') }}">
                                <img src="{{asset('/assets/icons/homeIcont3-removebg-preview.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">Cari Law Office</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="https://estate.o-rumah.com/login">
                                <img src="{{asset('/assets/icons/foodMarchant/estate.png')}}" class="menu-icon" alt="">
                                <br>
                                <span class="icon-label">Estate</span>
                            </a>
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-2">
            @foreach($typePengajuan as $type)
            <div class="col-md-6 mb-2">
                <!-- Tambahkan hyperlink ke card -->
                <a href="{{ route('type_pengajuans.show', $type->slug) }}" class="card-link">
                    <div class="card small-card h-100 position-relative">
                        <div class="card-body" style="padding: 0.01;">
                            <h6 class="card-title">{{ $type->name }}</h6>
                            <p class="card-text">{{ $type->description }}</p>
                        </div>
                        <!-- Tanda panah berbentuk lingkaran -->
                        <div class="arrow-circle">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- end wrapper -->
        <div id="adsListsWithDistance" class="row mt-1"></div>
        <div class="row mt-1">
            <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn   " style="background-color: #47C8C5;
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


        <div class="card mt-1">
            <div class="card-body" style=" background-color: #f0f0f0;">
                <div class="nav-container">
                    <div class="nav-links d-flex justify-content-between">

                        <div class="nav-item ml-2">
                            <a href="https://www.permatabank.com/id/home/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/company/permata-removebg-preview.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-1">
                                </div>
                            </a>
                        </div>
                        <div class="nav-item ml-2">
                            <a href="https://www.bankmuamalat.co.id/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/company/muamalat-removebg-preview.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-1">
                                </div>
                            </a>
                        </div>
                        <div class="nav-item ml-2">
                            <a href="https://bankmaju.com/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/company/logo-bank-maju-241x100-1.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-1">
                                </div>
                            </a>
                        </div>
                        <!-- <div class="nav-item ml-2">
                            <a href="https://bankmaju.com/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/company/btn.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-1">
                                </div>
                            </a>
                        </div>
                        <div class="nav-item ml-2">
                            <a href="https://bankmaju.com/" style="text-decoration: none; color: inherit;">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{asset('assets/company/bca.png')}}" alt="Bank Maju Logo" style="height: 80px; width: auto;" class="img-fluid mt-1">
                                </div>
                            </a>
                        </div> -->


                    </div>
                </div>
            </div>
        </div>

    </div>
    @endslot


</x-Layout.Horizontal.Master>