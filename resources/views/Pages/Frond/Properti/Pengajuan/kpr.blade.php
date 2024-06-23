<x-Layout.Horizontal.Master>
    @slot('css')
    <style>
        .custom-control-input {
            border: 1px solid #ccc;
            /* Ganti #ccc dengan warna border yang diinginkan */
            padding: 5px;
            /* Opsional: untuk memberikan sedikit padding */
        }
    </style>
    <!-- Dropzone css -->
    <link href="{{asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('zenter/horizontal/assets/plugins/dropify/css/dropify.min.css')}}" rel="stylesheet" />

    <link href="{{asset('zenter/horizontal/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    @endslot
    @slot('js')
    <!-- Dropzone js -->
    <script src="{{asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.js')}}"></script>
    <script src="{{asset('zenter/horizontal/assets/plugins/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('zenter/horizontal/assets/pages/upload.init.js')}}"></script>
    @endslot
    @slot('body')
    <div class="row mt-3">
        <div class="col-md-6">
            <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                :linkTujuan="route('property-detail', $ads->slug)">
            </x-Layout.Item.ProductItem>
            <x-Layout.Item.AgentContactCard :agent="$agent" :ads="$ads"></x-Layout.Item.AgentContactCard>
        </div>

        <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title font-20 mt-0">Dokument Pengajuan KPR</h3>
                <p class="card-text">Silahkan lengkapi seluruh dokumen untuk pengajuan KPR </p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Auth()->user())
                <form action="{{ route('linkKpr.store') }}" method="post" enctype="multipart/form-data">
    
                    @else
                    <form action="{{ route('visitor.linkKpr.store') }}" method="post" enctype="multipart/form-data">

                @endif
                    <input type="hidden" name="ads_id" value="{{$ads->ads_id}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Bank Umum</label>
                                <select class="select2 form-control mb-3 custom-select" name="bankUmum">
                                    <option>Select</option>
                                    @foreach ($bankUmum as $wilayah => $bks)
                                        <optgroup label="{{$wilayah}}">
                                            @foreach ($bks['banks'] as $bk)
                                                <option value="{{$bk['id']}}">
                                                    {{$bk['alias_name']}}
                                                </option>
                                            @endforeach 
                                        </optgroup>
                                    @endforeach 
                                </select>
                                @if ($errors->has('bankUmum'))
                                    <span class="error">{{ $errors->first('bankUmum') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Bank BPR</label>
                                <select class="select2 form-control mb-3 custom-select" name="bankBpr">
                                    <option>Select</option>
                                    @foreach ($bankBpr as $wilayah => $bks)
                                        <optgroup label="{{$wilayah}}">
                                            @foreach ($bks['banks'] as $bk)
                                                <option value="{{$bk['id']}}">
                                                    {{$bk['alias_name']}}
                                                </option>
                                            @endforeach 
                                        </optgroup>
                                    @endforeach 
                                </select>
                                @if ($errors->has('bankBpr'))
                                    <span class="error">{{ $errors->first('bankBpr') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="control-label">Pekerjaan</label>
                                </div>
                                <div class="col-md-9">
                                    <!-- {{$job}} -->
                                    @foreach ($job as $key => $jb) 
                                        <div class="form-check-inline my-1"
                                            style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="pekerjaan{{$key}}" name="pekerjaan"
                                                    class="custom-control-input" value="{{$jb->id}}">
                                                <label class="custom-control-label"
                                                    for="pekerjaan{{$key}}">{{$jb->title}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($errors->has('pekerjaan'))
                                        <span class="error">{{ $errors->first('pekerjaan') }}</span>
                                    @endif
                                </div>
                            </div> <!--end row-->

                            <div class="col-md-6"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Nama Lengkap</label>
                                <input type="text" class="form-control" name="namaLengkap" required
                                    placeholder="Masukan Nama Lengkap" />
                                @if ($errors->has('namaLengkap'))
                                    <span class="error">{{ $errors->first('namaLengkap') }}</span>
                                @endif
                            </div>
                        </div> <!--end row-->
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Email </label>
                                <input type="email" class="form-control" name="email" required
                                    placeholder="Masukan Email " />
                                @if ($errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div> <!--end row-->
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">No Telephone </label>
                                <input type="text" class="form-control" name="noHp" required
                                    placeholder="Masukan Telepon" />
                                @if ($errors->has('noHp'))
                                    <span class="error">{{ $errors->first('noHp') }}</span>
                                @endif
                            </div>
                        </div> <!--end row-->

                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">KTP Pemohon Suami/Istri </label>
                                <input type="file" id="input-file-now1" name="imageSrc" class="dropify" />
                                @if ($errors->has('imageSrc'))
                                    <span class="error">{{ $errors->first('imageSrc') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Kartu Keluarga </label>
                                <input type="file" id="input-file-now2" name="imagekkSrc" class="dropify" />
                                @if ($errors->has('imagekkSrc'))
                                    <span class="error">{{ $errors->first('imagekkSrc') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                        <div class="form-group mb-0">
                            <label class="mb-2 pb-1">NPWP </label>
                            <input type="file" id="input-file-now2" name="" class="dropify" />
                        </div>
                    </div> -->
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Surat Nikah Atau Surat Cerai</label>
                                <input type="file" id="input-file-now2" class="dropify" name="fotoSuratNikahSrc" />
                                @if ($errors->has('fotoSuratNikahSrc'))
                                    <span class="error">{{ $errors->first('fotoSuratNikahSrc') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Rekening Koran 3 Bulan Terakhir</label>
                                <input type="file" id="input-file-now2" class="dropify" name="fotoRekeningKoranSrc" />
                                @if ($errors->has('fotoRekeningKoranSrc'))
                                    <span class="error">{{ $errors->first('fotoRekeningKoranSrc') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="mb-2 pb-1">Sip Gaji</label>
                                <input type="file" id="input-file-now2" class="dropify" name="fotoSlipGajiSrc" />
                                @if ($errors->has('fotoSlipGajiSrc'))
                                    <span class="error">{{ $errors->first('fotoSlipGajiSrc') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 bg-light mt-3">
                            <div class="col-md-12 bg-light mt-3">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox mt-3">
                                        <input type="checkbox" class="custom-control-input" id="agreement"
                                            data-parsley-multiple="groups" name="agreement" value="1"
                                            data-parsley-mincheck="2">
                                        @if ($errors->has('agreement'))
                                            <span class="error">{{ $errors->first('agreement') }}</span>
                                        @endif
                                        <label class="custom-control-label" for="agreement">Saya menyetujui bahwa
                                            dokumen
                                            dipercayakan kepada ORumah untuk dipergunakan proses pengajuan BI
                                            checking/KPR
                                            untuk dipergunakan seperlu nya
                                            <a href="#" data-toggle="modal" data-animation="bounce"
                                                data-target=".bs-example-modal-center" class="text-primary">Baca
                                                Selengkapnya</a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 mt-3 text-right">
                            <button href="#" class="btn btn-success waves-effect waves-light">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Syarat & Ketentuan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ol class="list-group list-group-flush">
                                <li class="list-group-item">1. Foto yang dipasang adalah foto properti minimal 3 (tiga)
                                    dan
                                    kualitas foto harus bagus, jelas serta tidak pecah atau buram.</li>
                                <li class="list-group-item">2. Foto yang dipasang adalah benar foto properti yang sedang
                                    di-iklankan.</li>
                                <li class="list-group-item">3. Foto harus menunjukkan properti yang dijual. Kecuali
                                    untuk
                                    ruko & apartemen, boleh mencantumkan foto gedung dan atau menampilkan bangunan yang
                                    ada di sekitarnya. Dengan syarat: agent memberikan informasi listing mana yang
                                    dijual di bagian deskripsi.</li>
                                <li class="list-group-item">4. Foto hanya boleh di-edit untuk mencantumkan logo company.
                                    Selain logo, tidak diperkenankan menambah apapun pada foto seperti dibingkai,
                                    dicantumkan alamat, blog, telepon, website lain, atau nama agen. Kecuali spanduk
                                    atau plang tersebut memang sudah menyatu dengan properti.</li>
                                <li class="list-group-item">5. Foto 3D, foto bangunan yang belum jadi atau sedang
                                    direnovasi diperkenankan tayang dengan mencantumkan keterangan bahwa listing
                                    tersebut adalah listing secondary.</li>
                                <li class="list-group-item">6. Multiple foto thumbnail image dalam satu foto file tidak
                                    diperbolehkan.</li>
                                <li class="list-group-item">7. Harga yang dimasukkan adalah harga yang realistis dan
                                    tidak
                                    boleh 0 (nol).</li>
                                <li class="list-group-item">8. Tagline listing dan deskripsi listing tidak diperbolehkan
                                    untuk mencantumkan nama, nomor telepon, alamat email, dan link website / blog /
                                    forum, dll.</li>
                            </ol>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

        </div>@endslot
</x-Layout.Horizontal.Master>