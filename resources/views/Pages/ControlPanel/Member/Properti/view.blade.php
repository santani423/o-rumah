<x-Layout.Vertical.Master title="Contorl Ads">
    @slot('css')
    <link href="{{ asset('zenter/horizontal/assets/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('zenter/horizontal/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

    <style>
        .square {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            /* Membuat pembungkus berbentuk bujur sangkar */
        }

        .square-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Menyesuaikan gambar agar tetap proporsional */
        }
    </style>
    @endslot

    @slot('js')
    <!-- Magnific popup -->
    <script src="{{ asset('zenter/horizontal/assets/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('zenter/horizontal/assets/pages/lightbox.js') }}"></script>
    <!-- Dropzone js -->
    <script src="{{ asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.js') }}"></script>
    <script src="{{ asset('zenter/horizontal/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('zenter/horizontal/assets/pages/upload.init.js') }}"></script>
    <script>
        let numreportview = 0;
        let adsId = @json($ads->ads_id);
        let start_date_ads = @json($ads->start_date_ads);

        document.addEventListener('DOMContentLoaded', function() {
            // Handle Image Modal
            $('#imageModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);
                modal.find('#modalImage').attr('src', url);
            });

            // Handle Confirm Modal
            var form;
            $('#confirmModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                form = button.closest('form');
                var modal = $(this);
            });

            $('#confirmButton').on('click', function() {
                if (form) {
                    form.submit();
                }
            });

            // Initialize Dropify
            $('.dropify').dropify();

            // Handle Image Modal
            $('#imageModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var mediaId = button.data('media-id');
                var modal = $(this);
                modal.find('#mediaId').val(mediaId);
            });
        });

        function setFormMediaId(id) {
            $('#mediaIdValue').val(id);
        }

        function vewReport() {

            if (numreportview <= 0) {
                var today = new Date();
                var year = today.getFullYear();
                var month = String(today.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
                var day = String(today.getDate()).padStart(2, '0');

                var currentDate = year + '-' + month + '-' + day;
                reportAds(null,null);
                numreportview++
            }
        }
    </script> <!-- Load Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['line', 'corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            reportAds(startDate,endDate);

        });

        function reportAds(startDate,endDate) {
        

            $.ajax({
                url: "{{ route('ads.views.filter') }}",
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    start_date: startDate,
                    end_date: endDate,
                    adsId: adsId
                },
                beforeSend: function() {
                    // Tampilkan spinner saat proses ajax dimulai
                    $('#spinner').show();
                },
                success: function(response) {
                    updateTable(response);
                    drawChart(response);
                },
                error: function() {
                    alert('Gagal memuat data');
                },
                complete: function() {
                    // Sembunyikan spinner setelah proses selesai
                    $('#spinner').hide();
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#viewsTable tbody');
            tableBody.empty(); // Kosongkan tabel sebelum mengisi ulang

            var totalViews = 0; // Variable untuk menyimpan total views

            data.forEach(function(row) {
                var date = row.date;
                var views = row.views;

                // Tambahkan views ke totalViews
                totalViews += views;

                var newRow = '<tr>' +
                    '<td>' + date + '</td>' +
                    '<td>' + views + '</td>' +
                    '</tr>';

                tableBody.append(newRow);
            });

            // Tambahkan baris total di akhir tabel
            var totalRow = '<tr>' +
                '<td><strong>Total</strong></td>' +
                '<td><strong>' + totalViews + '</strong></td>' +
                '</tr>';

            tableBody.append(totalRow);
        }


        function drawChart(data) {
    var chartDiv = document.getElementById('chart_div');
    
    // Check if the data is empty
    if (data.length === 0) {
        chartDiv.innerHTML = "<p>No data available to display the chart.</p>";
        return; // Stop execution if data is empty
    }

    var chartData = new google.visualization.DataTable();
    chartData.addColumn('date', 'Tanggal');
    chartData.addColumn('number', 'Jumlah View');

    data.forEach(function(row) {
        var dateParts = row.date.split('-'); // Split 'YYYY-MM-DD'
        var year = parseInt(dateParts[0]);
        var month = parseInt(dateParts[1]) - 1;
        var day = parseInt(dateParts[2]);
        chartData.addRow([new Date(year, month, day), row.views]);
    });

    var options = {
        chart: {
            title: 'Laporan Jumlah View Iklan'
        },
        width: '100%',
        height: 500,
        hAxis: {
            format: 'dd MMM yyyy',
            title: 'Tanggal'
        },
        vAxis: {
            title: 'Jumlah View'
        }
    };

    var chart = new google.charts.Line(chartDiv);
    chart.draw(chartData, options);
}

    </script>
    @endslot

    @slot('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if(!$navLink) active @endif" data-toggle="tab" href="#properti" role="tab">Tentang Properti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($navLink == 'galeri') active @endif" data-toggle="tab" href="#galeri" role="tab">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($navLink == 'lokasi') active @endif" data-toggle="tab" href="#lokasi" role="tab">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($navLink == 'booster') active @endif" data-toggle="tab" href="#booster" role="tab">Booster</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($navLink == 'depositAds') active @endif" data-toggle="tab" href="#depositAds" role="tab">Titip Ads</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($navLink == 'reportView') active @endif" data-toggle="tab" href="#reportView" onclick="vewReport()" role="tab">Report View</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane @if(!$navLink) active @endif p-3" id="properti" role="tabpanel">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 200px">Tipe Iklan</th>
                                        <td>{{ $ads['ads_type'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Tipe Properti</th>
                                        <td>{{ $ads['property_type'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Judul Iklan</th>
                                        <td>{{ $ads['title'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Harga</th>
                                        <td>{{ number_format($ads['price'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Nama Komplek</th>
                                        <td>{{ $ads['housing_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Nama Cluster</th>
                                        <td>{{ $ads['cluster_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Luas Tanah</th>
                                        <td>{{ $ads['lt'] }} m²</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Luas Bangunan</th>
                                        <td>{{ $ads['lb'] }} m²</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Tahun Dibangun</th>
                                        <td>{{ $ads['year_built'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Tipe Sertifikat</th>
                                        <td>
                                            @if (!empty($ads['certificate']))
                                            @php
                                            $certificate = json_decode($ads['certificate']);
                                            @endphp
                                            @if (is_array($certificate) && !empty($certificate))
                                            <ul>
                                                @foreach ($certificate as $facility)
                                                <li>{{ $facility }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            Tidak tersedia
                                            @endif
                                            @else
                                            Tidak tersedia
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Kamar Tidur</th>
                                        <td>{{ $ads['jk'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Kamar Mandi</th>
                                        <td>{{ $ads['jkm'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Jumlah Lantai</th>
                                        <td>{{ $ads['dl'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Fasilitas</th>
                                        <td>
                                            @if (!empty($ads['house_facility']))
                                            @php
                                            $house_facility = json_decode($ads['house_facility']);
                                            @endphp
                                            @if (is_array($house_facility) && !empty($house_facility))
                                            <ul>
                                                @foreach ($house_facility as $facility)
                                                <li>{{ $facility }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            Tidak tersedia
                                            @endif
                                            @else
                                            Tidak tersedia
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Kondisi Prabotan</th>
                                        <td>{{ $ads['furniture_condition'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Fasilitas Perumahan</th>

                                        <td>
                                            @if (!empty($ads['other_facility']) && $ads['other_facility'] != 'null')
                                            <ul>
                                                @foreach (json_decode($ads['other_facility']) as $facility)
                                                <li>{{ $facility }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            Tidak tersedia
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('listing.control-panel.properti.edit.tentang-properti', $ads['slug']) }}">
                                <button class="btn btn-turquoise">Edit</button>
                            </a>
                        </div>

                        <div class="tab-pane @if($navLink == 'galeri') active @endif p-3" id="galeri" role="tabpanel">
                            <div class="container zoom-gallery">
                                <div class="row">
                                    @foreach($media as $key => $md)
                                    <div class="col-md-4 mb-4">
                                        <div class="square">
                                            <a href="{{ asset($md['url']) }}" title="Media {{ ++$key }}" data-url="{{ asset($md['url']) }}">
                                                <img src="{{ asset($md['url']) }}" alt="" class="img-fluid square-img" />
                                            </a>
                                        </div>
                                        @if($ads['image'] != $md['url'])
                                        <form action="{{ route('listing.control-panel.properti.set.media.utama', ['ads_properties_id' => $ads['ads_properties_id']]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="url" value="{{ $md['url'] }}">
                                            <button type="button" class="btn btn-turquoise mt-2" data-toggle="modal" data-target="#confirmModal" data-url="{{ $md['url'] }}">Jadikan Utama</button>
                                        </form>
                                        @else
                                        <button class="btn btn-success mt-2">Utama</button>
                                        @endif
                                        <button type="button" class="btn btn-turquoise mt-2" data-toggle="modal" data-target="#imageModal" onclick="setFormMediaId(`{{ $md['id'] }}`)" data-url="{{ $md['url'] }}">Edit</button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Image Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Ubah Media</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <form id="mediaForm" action="{{ route('listing.control-panel.properti.set.media.update', ['ads_properties_id' => $ads['ads_properties_id']]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="mediaId" id="mediaIdValue">
                                                <div class="col-xl-12">
                                                    <input type="file" id="input-file-now" class="dropify" name="media" required />
                                                </div>
                                                <button type="submit" class="btn btn-turquoise mt-3">Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Modal -->
                            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menjadikan gambar ini sebagai media utama?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-turquoise" id="confirmButton">Jadikan Utama</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane p-3 @if($navLink == 'lokasi') active @endif" id="lokasi" role="tabpanel">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 200px">Provinsi</th>
                                        <td>{{ $ads['name_provinces'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Kabupaten/Kota</th>
                                        <td>{{ $ads['name_cities'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Kecamatan</th>
                                        <td>{{ $ads['district_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Area</th>
                                        <td>{{ $ads['area'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 200px">Alamat</th>
                                        <td>{{ $ads['address'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('listing.control-panel.properti.edit.addres', $ads['slug']) }}">
                                <button class="btn btn-turquoise">Edit</button>
                            </a>
                        </div>

                        <div class="tab-pane p-3 @if($navLink == 'booster') active @endif" id="booster" role="tabpanel">
                            <button type="button" class="btn btn-turquoise waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-sm">Booster</button>
                            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="boosterModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="boosterModal">Booster</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('boosterAds.store') }}" method="post">
                                                <div class="form-group row">
                                                    @csrf
                                                    <input type="hidden" name="ads_id" value="{{ $ads->ads_id }}">
                                                    <label class="col-sm-2 col-form-label">Posisi Booster</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="booster_id" required>
                                                            <option value="">Pilih Posisi</option>
                                                            @foreach($bosterAdsType as $bat)
                                                            <option value="{{ $bat->id }}">{{ $bat->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <button class="btn btn-turquoise">Pasang</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Booster</th>
                                        <th>Di Terapkan Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($BosterAds as $key => $ba)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ $ba->title }}</td>
                                        <td>{{ $ba->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane p-3 @if($navLink == 'depositAds') active @endif" id="depositAds" role="tabpanel">
                            <x-Member.Item.TitipAds :ads="$ads" />
                        </div>

                        <div class="tab-pane p-3 @if($navLink == 'reportView') active @endif" id="reportView" role="tabpanel">
                           
                            <form id="filterForm">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="startDate">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="endDate">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="endDate" name="end_date" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Filter</button>
                            </form>
                            <div id="spinner" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <!-- Tabel untuk menampilkan data view ads -->
                            <h3 class="mt-4">Tabel Jumlah View Iklan</h3>
                            <div class="mt-4" style="overflow-x: auto;">
                                <div id="chart_div" style="min-width: 600px; height: auto;"></div>
                            </div>
                            <table class="table table-bordered table-striped" id="viewsTable">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jumlah View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan ditambahkan secara dinamis melalui AJAX -->
                                </tbody>
                            </table>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>