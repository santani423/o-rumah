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
        let agentId = "{{$agentId}}";
        // alert(agentId);

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
            // loadAds(currentPage);
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
            const url = `{{ route('tool.getAdsListsWithDistance') }}?latitude=${latitude}&longitude=${longitude}&perPage=${perPage}&page=${page}&district=${districtId}&ads_type=${beliSewa}&typeProperti=${typeProperti}&agentId=${agentId}`;

            document.getElementById('loadingSpinner').style.display = 'block'; // Show the spinner
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
    </script>
    @endslot
    @slot('body')



  

    <div class="container mt-1">
        <!-- Tabs -->

        <input type="hidden" id="searchLok">
        <div id="sampleLocations" class="mt-2"></div>

        





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
                 
            </div>



        
    </div>
    @endslot


</x-Layout.Horizontal.Master>