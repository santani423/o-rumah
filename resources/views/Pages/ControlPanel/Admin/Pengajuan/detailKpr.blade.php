<x-Layout.Vertical.Master>
    @slot('css')
    <link href="{{asset('zenter/vertical/assets/plugins/magnific-popup/magnific-popup.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('zenter/vertical/assets/plugins/dropzone/dist/dropzone.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('zenter/vertical/assets/plugins/dropify/css/dropify.min.css')}}" rel="stylesheet" />
    @endslot
    @slot('js')
    <!-- Magnific popup -->
    <script src="{{asset('zenter/vertical/assets/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/lightbox.js')}}"></script>

    <!-- Dropzone js -->
    <script src="{{asset('zenter/vertical/assets/plugins/dropzone/dist/dropzone.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/plugins/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/upload.init.js')}}"></script>

    @endslot
    @slot('body')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title font-20 mt-0">
                    Detail KPR
                </h3>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $kpr->kpr_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $kpr->kpr_email }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $kpr->kpr_phone }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $kpr->kpr_occupation }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $kpr->status }}</td>
                        </tr>
                        <tr>
                            <th>Agen</th>
                            <td>{{ $kpr->namaAgen }}</td>
                        </tr>
                        <tr>
                            <th>Bank Umum</th>
                            <td>{{ $kpr->bank_umum_name }}</td>
                        </tr>
                        <tr>
                            <th>Bank BPR</th>
                            <td>{{ $kpr->bank_bpr_name }}</td>
                        </tr>
                        <tr>
                            <th>Status KPR</th>
                            <td>{{ $kpr->status }}</td>
                        </tr>
                    </tbody>
                </table>
                <form action="{{route('admin.email.bank')}}" method="post">
                    @csrf
                    <input type="hidden" name="kpr_id" value="{{$kpr->id}}">
                    <button class="btn btn-turquoise">Kirm Email</button>
                </form>
                <form action="{{route('admin.pengajuan.kpr.setting.status', $kpr->id)}}" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-6 col-form-label">Status Pengajuan KPR</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="example-text-input">
                                <option value="pending">pending</option>
                                <option value="rejected">rejected</option>
                                <option value="approved">approved</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right"><button class="btn btn-turquoise">Simpan Status</button></div>
                </form>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        Upload Data Bank Umum
                    </h4>


                    <form action="{{ route('admin.kpr.file.bank') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="bank_id" value="{{$kpr->bank_id}}">
                        <input type="hidden" name="kpr_id" value="{{$kpr->id}}">
                        <input type="hidden" name="file_type" value="bank_umum">
                        <div class="m-b-20">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple" class="dropify" />
                            </div>
                        </div>

                        <div class="text-center m-t-15">
                            <button type="submit" class="btn btn-turquoise waves-effect waves-light">
                                Simpan
                            </button>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama File</th>
                                <th>Tipe File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filebankUmum as $file)
                                <tr>
                                    <td>{{ $file['file_name'] }}</td>
                                    <td>{{ $file['file_type'] }}</td>
                                    <td>
                                        <a href="{{ asset($file['file_path'] . '/' . $file['file_name']) }}"
                                            class="btn btn-turquoise" download>
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        Upload Data Bank BPR
                    </h4>


                    <form action="{{ route('admin.kpr.file.bank') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="bank_id" value="{{$kpr->bank_id}}">
                        <input type="hidden" name="kpr_id" value="{{$kpr->id}}">
                        <input type="hidden" name="file_type" value="bank_bpr">
                        <div class="m-b-20">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple" class="dropify" />
                            </div>
                        </div>

                        <div class="text-center m-t-15">
                            <button type="submit" class="btn btn-turquoise waves-effect waves-light">
                                Simpan
                            </button>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama File</th>
                                <th>Tipe File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filebankBpr as $file)
                                <tr>
                                    <td>{{ $file['file_name'] }}</td>
                                    <td>{{ $file['file_type'] }}</td>
                                    <td>
                                        <a href="{{ asset($file['file_path'] . '/' . $file['file_name']) }}"
                                            class="btn btn-turquoise" download>
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                :linkTujuan="route('property-detail', $ads->slug)">
            </x-Layout.Item.ProductItem>
            <x-Layout.Item.AgentContactCard :agent="$agent" :ads="$ads"></x-Layout.Item.AgentContactCard>
            <div class="card card-body">
                <h4 class="card-title">Dokumen</h4>
                <div class="row">
                    @foreach ([['image' => $kpr->image_ktp, 'title' => 'KTP Suami Istri', 'filename' => 'KTP_Suami_Istri'], ['image' => $kpr->image_kk, 'title' => 'Kartu Keluarga', 'filename' => 'Kartu_Keluarga'], ['image' => $kpr->image_surat_nikah, 'title' => 'Surat Nikah', 'filename' => 'Surat_Nikah'], ['image' => $kpr->image_rekening_koran, 'title' => 'Rekening Koran', 'filename' => 'Rekening_Koran'], ['image' => $kpr->image_slip_gaji, 'title' => 'Slip Gaji', 'filename' => 'Slip_Gaji']] as $doc)
                        <div class="mb-2 mr-2 d-flex col-lg-6 flex-column align-items-center" style="width: 120px;">
                            <div class="popup-gallery d-flex flex-wrap">
                                <a href="{{ asset($doc['image']) }}" title="{{ $doc['title'] }}">
                                    <img src="{{ asset($doc['image']) }}" alt="{{ $doc['title'] }}" class="img-fluid">
                                </a>
                                <p>{{ $doc['title'] }}</p>

                            </div>
                            <a href="{{ asset($doc['image']) }}" class="btn btn-turquoise"
                                download="{{ $doc['filename'] }}">Download</a>
                        </div>
                    @endforeach
                </div>
                <a href="{{route('admin.pengajuan.kpr.downloadKprFiles', $kpr->id)}}" class="btn btn-turquoise">Download
                    ZIP </a>
            </div>
        </div>

    </div>
    @endslot
</x-Layout.Vertical.Master>