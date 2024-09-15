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
    window.onload = function() {
        getLocation();
    };

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, function() {
                // Jika lokasi tidak ditemukan, gunakan nilai default
                showPosition(null);
            });
        } else {
            // Geolocation tidak didukung, gunakan nilai default
            showPosition(null);
        }
    }

    function showPosition(position) {
        var lat = position ? position.coords.latitude : null; // Default ke null jika tidak ada lokasi
        var long = position ? position.coords.longitude : null; // Default ke null jika tidak ada lokasi

        var searchQuery = $('input[name="search"]').val();

        $.ajax({
            url: "{{ route('omerchant.listing') }}",
            type: 'GET',
            data: {
                latitude: lat,
                longitude: long,
                search: searchQuery
            },
            success: function(response) {
                $('#adsListsWithDistance').html(response.html);
            },
            error: function(xhr) {
                console.error('Error:', xhr);
            }
        });
    }

    $(document).ready(function() {
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            var searchQuery = $('input[name="search"]').val();

            navigator.geolocation.getCurrentPosition(function(position) {
                showPosition(position);
            }, function() {
                // Jika lokasi tidak ditemukan, gunakan nilai default
                showPosition(null);
            });
        });

        // Load more button
        $('#loadMore').on('click', function() {
            var button = $(this);
            var currentPage = button.data('page');
            var nextPage = currentPage + 1;
            var searchQuery = $('input[name="search"]').val();

            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position ? position.coords.latitude : null;
                var long = position ? position.coords.longitude : null;

                $('#spinner').removeClass('d-none');
                $.ajax({
                    url: "{{ route('omerchant.listing') }}",
                    type: 'GET',
                    data: {
                        latitude: lat,
                        longitude: long,
                        search: searchQuery,
                        page: nextPage
                    },
                    success: function(response) {
                        $('#adsListsWithDistance').append(response.html);
                        button.data('page', nextPage);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                    },complete: function() {
                        $('#spinner').addClass('d-none');
                    }
                });
            }, function() {
                // Jika lokasi tidak ditemukan, gunakan nilai default
                var lat = null;
                var long = null;

                $('#spinner').removeClass('d-none');
                $.ajax({
                    url: "{{ route('omerchant.listing') }}",
                    type: 'GET',
                    data: {
                        latitude: lat,
                        longitude: long,
                        search: searchQuery,
                        page: nextPage
                    },
                    success: function(response) {
                        $('#adsListsWithDistance').append(response.html);
                        button.data('page', nextPage);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                    },complete: function() {
                        $('#spinner').addClass('d-none');
                    }
                });
            });
        });
    });
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
        <!-- Search Bar -->
        <div class="search-bar d-flex align-items-center">
            <form id="searchForm" class="d-flex flex-grow-1">
                <div class="location-input flex-grow-1 ml-3">
                    <!-- <i class="fas fa-map-marker-alt mr-2 text-warning"></i> -->
                    <input type="text" name="search" class="form-control border-0" placeholder="Cari Merchant" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-success ml-3"><span id="spinnerSearch" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <!-- end Slider -->
        <div class="card mt-2">
            <div class="card-body">
                <div class="nav-container">
                    <div class="nav-links row">
                    @foreach ($kategori as $ktg)
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('omerchant.by.kategori', $ktg->slug) }}" class="text-wrap text-break">
                            <img src="@if($ktg->gambar) {{asset($ktg->gambar)}} @else {{asset('/assets/icons/homeIconbg6.png')}} @endif" class="menu-icon" alt=""><br>{{ $ktg->nama }}
                            </a>
                        </div>
                    @endforeach

                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-12">
                <h4 class="">Rekomendasi Sesuai Pencarianmu</h4>
            </div>
         

        </div>
        <div id="adsListsWithDistance" class="row mt-5">
            <!-- List of food ads will be loaded here -->
        </div>
        <div class="d-flex justify-content-center mt-3 mb-3">
       
                <button id="loadMore" class="btn btn-primary" data-page="1" style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white">Next  <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span></button>
            </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>