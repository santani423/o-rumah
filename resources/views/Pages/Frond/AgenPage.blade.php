<x-Layout.Horizontal.Master title="LBH">
    @slot('js')

    <script>
        $('#userDetailModal').on('show.bs.modal', function (event) {
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
    @endslot
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

        .btn-success {
            background-color: #2ECC71;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-success i {
            color: white;
        }

        .btn-success:focus {
            box-shadow: none;
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

        .reduced-margin .card {
            margin: 0 5px;
            /* Mengurangi margin kiri dan kanan */
        }
        .rounded-circle {
        border-radius: 50%;
        width: 64px;
        height:  64px;
    }
    </style>
    <style>
        .small {
            font-size: 0.1em;
            /* Atau ukuran yang lebih kecil sesuai kebutuhan */
        }
    </style>

    @endslot
    @slot('body')
    <!-- Search Bar -->
    <div class="search-bar d-flex align-items-center mt-3">
        
        <div class="location-input flex-grow-1 ml-3">
            <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
            <input type="text" class="form-control border-0" placeholder="Lokasi, keyword, area, project, developer">
        </div>
        <button class="btn btn-success ml-3">
            <i class="fas fa-search"></i>
        </button>
    </div>
    <div class="row mt-3">
        <h2 class="text-center w-100 text-white">Cari Agen</h2> <!-- Judul baru -->
        @foreach ($userLists as $user)
        <x-Layout.Item.UserProfileCard :user="$user">
            @slot('content')
            <div class="row">
                                    <div class="col-md-4">
                                        <div class="card rounded-0 border border-1">
                                            <div class="card-body text-center pr-2 pl-2">
                                                <p class="small">Total Properti</p>
                                                <h6 class="mt-0 font-18">500</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card rounded-0 border border-1">
                                            <div class="card-body text-center pr-2 pl-2">
                                                <p class="small">Terjual / Tersewa</p>
                                                <h6 class="mt-0 font-18">500</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card rounded-0 border border-1 pr-0 pl-0 mr-0 ml-0">
                                            <div class="card-body text-center">
                                                <p class="small">Harga rata-rata</p>
                                                <h6 class="mt-0 font-18">500</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            @endslot
    </x-Layout.Item.UserProfileCard >
        @endforeach
        <!--end col-->
    </div>

    <!-- Modal Detail User -->
    <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel"
        aria-hidden="true">
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