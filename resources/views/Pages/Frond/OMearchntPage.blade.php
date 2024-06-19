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
            background-color: #2ECC71;
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
            /* Mengurangi total lebar dengan 2px padding di setiap sisi */
            margin: 2px;
            /* Padding eksternal untuk card */
        }

        /* Styling for the navbar  */
        .nav-container {
            display: flex;
            justify-content: center;
            /* Menengahkan item-item secara horizontal */
            align-items: center;
            /* Menengahkan item-item secara vertikal */
            height: 100%;
            /* Mengatur tinggi container agar penuh */
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
            /* Memungkinkan scrolling horizontal */
            white-space: nowrap;
            /* Mencegah item dari wrapping ke baris baru */
        }

        .nav-item {
            flex: 0 0 auto;
            /* Mencegah item dari stretching */
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 0 0 auto;
            text-align: center;
        }
    </style>

    @endslot
    @slot('js')
    <script>
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
            // Menggunakan load() untuk memuat konten dari URL yang disediakan

            $('#adsListsWithDistance').load('{{ route('tool.getMarchantListsWithDistance') }}' + '?latitude=' + lat + '&longitude=' + long);
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

        window.onload = function () {
            getLocation();
        };
    </script>
    @endslot

    @slot('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">


                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($bannerLists as $key => $bnr)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" @if($key == 0)
                            class="active" @endif></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        @foreach ($bannerLists as $key => $bnr)
                            <div class="carousel-item @if($key == 0) active @endif">
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
        </div> <!-- end col -->


    </div> <!-- end row -->

    <div class="container mt-5">
        <!-- Search Bar -->
        <div class="search-bar d-flex align-items-center">

            <div class="location-input flex-grow-1 ml-3">
                <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
                <input type="text" class="form-control border-0" placeholder="Lokasi, keyword ">
            </div>
            <button class="btn btn-success ml-3">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <!-- end Slider -->
        <div class="card mt-2">
            <div class="card-body">
                <div class="nav-container">
                    <div class="nav-links row">
                        @foreach ($kategori as $ktg)
                            <div class="nav-item col-6 col-md-4 col-lg-1 mb-3">
                                <a href="{{ route('ofoods.by.kategori', $ktg->nama) }}"><i
                                        class="fas fa-utensils"></i><br>{{$ktg->nama}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-12">
                <h4 class="text-white">Rekomendasi Sesuai Pencarianmu</h4>
            </div>
            @foreach($adsLists as $ads)
                <div class="col-md-6 col-lg-6 col-xl-3 mb-3">

                    <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                        :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                        :linkTujuan="route('ofood-detail', $ads->slug)">
                    </x-Layout.Item.ProductItem>

                </div><!-- end col -->
            @endforeach

        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>