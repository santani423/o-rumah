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
        var currentPage = 1; // Halaman awal

        function loadAds(lat, long, page = 1) {
            var searchQuery = $('input[name="search"]').val(); // Ambil nilai pencarian

            // Memuat konten dari URL yang disediakan ke dalam elemen dengan ID adsListsWithDistance
            $.ajax({
                url: "{{ route('ofoods.listing') }}",
                type: 'GET',
                data: {
                    latitude: lat,
                    longitude: long,
                    search: searchQuery,
                    page: page // Kirim informasi halaman ke server
                },
                success: function(response) {
                    if (page === 1) {
                        $('#adsListsWithDistance').html(response.html); // Update content dengan hasil dari server
                    } else {
                        $('#adsListsWithDistance').append(response.html); // Tambahkan hasil baru ke konten lama
                    }

                    // Periksa apakah ada data lagi untuk dimuat
                    if (!response.hasMorePages) {
                        // $('#nextButton').hide(); // Sembunyikan tombol jika sudah tidak ada data
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                }
            });
        }

        $(document).ready(function() {
            // Saat tombol "Next" diklik
            $('#nextButton').on('click', function() {
                currentPage++; // Naikkan halaman saat tombol diklik
                loadAds(0, 0, currentPage); // Muat data halaman berikutnya
            });
        });

        // Saat form pencarian disubmit
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dari submit secara default
            currentPage = 1; // Reset ke halaman pertama
            loadAds(0, 0, currentPage); // Muat data dari awal sesuai pencarian
        });

        // Panggil fungsi loadAds saat halaman dimuat pertama kali
        window.onload = function() {
            loadAds(0, 0, 1); // Muat data pertama kali
        };
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

    <div class="container mt-5">
        <!-- Search Bar -->
        <div class="search-bar d-flex align-items-center">
            <form id="searchForm" class="d-flex flex-grow-1">
                <div class="location-input flex-grow-1 ml-3">
                    <!-- <i class="fas fa-map-marker-alt mr-2 text-warning"></i> -->
                    <input type="text" name="search" class="form-control border-0" placeholder="Cari Food" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-success ml-3">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>


        <!-- Categories -->
        <div class="card mt-2">
            <div class="card-body">
                <div class="nav-container">
                    <div class="nav-links row">
                        @foreach ($kategori as $ktg)
                        <div class="nav-item col-4 col-md-4 col-lg-3 mb-3">
                            <a href="{{ route('ofoods.by.kategori', $ktg->slug) }}" class="text-wrap text-break">
                                <img src="@if($ktg->gambar) {{asset($ktg->gambar)}} @else {{asset('/assets/icons/homeIconbg6.png')}} @endif" class="menu-icon" alt=""><br>{{ $ktg->nama }}
                            </a>
                        </div>
                        @endforeach
                        <div class="nav-item col-4 col-md-4 col-lg-3">
                            
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3">
                            
                        </div>
                        <div class="nav-item col-4 col-md-4 col-lg-3">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="text-white">Rekomendasi Sesuai Pencarianmu</h4>
            </div>
        </div>
       
        <div id="adsListsWithDistance" class="row mt-5">
            <!-- List of food ads will be loaded here -->
        </div>
        
    </div>
    <div class="row justify-content-center">
            <button id="nextButton" class="btn btn-primary btn-next" style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white">Next</button>
        </div>

    @endslot
</x-Layout.Horizontal.Master>