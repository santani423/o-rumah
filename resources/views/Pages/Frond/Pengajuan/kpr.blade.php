<x-Layout.Horizontal.Master>
     @slot('css')
     <!-- Dropzone css -->
     <link href="{{ asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('zenter/horizontal/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
     <link href="{{ asset('zenter/horizontal/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
     <style>
        span#select2-bankUmumSelect-container{
            background-color: #47C8C5;
        }
        span#select2-bankBPRSelect-container{
            background-color: #47C8C5;
        }
     </style>
     @endslot

     @slot('js')
     <!-- Dropzone js -->
     <script src="{{ asset('zenter/horizontal/assets/plugins/dropzone/dist/dropzone.js') }}"></script>
     <script src="{{ asset('zenter/horizontal/assets/plugins/dropify/js/dropify.min.js') }}"></script>
     <script src="{{ asset('zenter/horizontal/assets/pages/upload.init.js') }}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

     <script>
         $(document).ready(function() {
             $('#bankUmumSelect, #bankBPRSelect, #jenisPinjamanSelect, #jenisJaminanSelect').select2({
                 templateResult: formatState,
                 templateSelection: formatState,
                 escapeMarkup: function(markup) {
                     return markup;
                 },
                 minimumResultsForSearch: -1 // Disable search
             });

             $('input[name="statusPernikahan"]').on('change', function() {
                 if ($(this).val() === 'menikah') {
                     $('#suratNikahContainer').show();
                 } else {
                     $('#suratNikahContainer').hide();
                 }
             });

             if ($('input[name="statusPernikahan"]:checked').val() === 'menikah') {
                 $('#suratNikahContainer').show();
             } else {
                 $('#suratNikahContainer').hide();
             }

             // Handle form submission with AJAX
             $('#pengajuanForm').on('submit', function(e) {
                 e.preventDefault(); // Prevent default form submission

                 // Show spinner
                 $('#submitBtn').attr('disabled', true);
                 $('#submitBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...');

                 // Collect all form data except for files
                 var formData = $(this).serialize();

                 $.ajax({
                     url: $(this).attr('action'),
                     type: 'POST',
                     data: formData, // Send only non-file data
                     success: function(response) {
                         console.log(response);

                         // Redirect ke routing yang diinginkan setelah data berhasil disimpan
                         if (response.success) { // pastikan ada flag sukses di response
                             var id = response.pengajuan_id; // ambil id dari response jika ada
                             var slug = response.slug; // ambil slug dari response jika ada
                             window.location.href = `/pengajuan/${id}/${slug}`;
                         } else {
                             alert('Terjadi kesalahan, data tidak lengkap.');
                         }
                         // Handle success response
                         //  alert('Data berhasil disimpan!');

                         // Optionally handle file upload here if necessary
                         // var fileData = new FormData();
                         // fileData.append('fileJaminan', $('input[name="fileJaminan"]')[0].files[0]);
                         // fileData.append('imageSrc', $('input[name="imageSrc"]')[0].files[0]);
                         // fileData.append('imagekkSrc', $('input[name="imagekkSrc"]')[0].files[0]);
                         // fileData.append('fotoRekeningKoranSrc', $('input[name="fotoRekeningKoranSrc"]')[0].files[0]);
                         // fileData.append('fotoSlipGajiSrc', $('input[name="fotoSlipGajiSrc"]')[0].files[0]);

                         // $.ajax({
                         //     url: '/upload-files', // Your upload route
                         //     type: 'POST',
                         //     data: fileData,
                         //     contentType: false,
                         //     processData: false,
                         //     success: function(fileResponse) {
                         //         // Handle file upload success
                         //         alert('Files uploaded successfully!');
                         //     },
                         //     error: function(fileResponse) {
                         //         // Handle file upload error
                         //         alert('Terjadi kesalahan saat mengunggah file.');
                         //     }
                         // });
                     },
                     error: function(response) {
                         // Handle error response
                         alert('Terjadi kesalahan saat menyimpan data.');
                     },
                     complete: function() {
                         // Hide spinner and re-enable button
                         $('#submitBtn').attr('disabled', false);
                         $('#submitBtn').html('Kirim');
                     }
                 });
             });
         });

         function formatState(state) {
             if (!state.id) {
                 return state.text;
             }

             var imageUrl = $(state.element).data('image');
             var $state;

             if (imageUrl) {
                 $state = $('<span><img src="' + imageUrl + '" class="img-flag" style="width: 80px; height: auto; margin-right: 8px;" /> ' + state.text + '</span>');
             } else {
                 $state = $('<span>' + state.text + '</span>');
             }

             return $state;
         }
     </script>

     @endslot

     @slot('body')
     <div class="card">
         <div class="card-body">
             <h3 class="card-title font-20 mt-0">Dokumen  {{$typePengajuan->name}}</h3>
             <p class="card-text">Silahkan lengkapi seluruh dokumen untuk pengajuan {{$typePengajuan->name}}</p>
             @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
             @endif

             <form id="pengajuanForm" action="{{ route('type_pengajuans.store', $slug) }}" method="post" enctype="multipart/form-data">
                 @csrf
            
                 <div class="row">
    @if($typePengajuan->id == 2)
                    <div class="col-md-12">                 <div class="row">
                     <!-- Select Jenis Pinjaman -->
                     <div class="col col-lg-6 col-sm-6">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Jenis Pinjaman</label>
                             <select class="select2 form-control mb-3 custom-select" name="jenisPinjaman" id="jenisPinjamanSelect">
                                 <option value="">Pilih Jenis Pinjaman</option>
                                 @foreach ($jenisPinjaman as $jp)
                                 <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                                 @endforeach
                             </select>
                             @if ($errors->has('jenisPinjaman'))
                             <span class="error">{{ $errors->first('jenisPinjaman') }}</span>
                             @endif
                         </div>
                     </div>
                   
                     <!-- Select Jenis Jaminan -->
                     <div class="col col-lg-6 col-sm-6">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Jenis Jaminan</label>
                             <select class="select2 form-control mb-3 custom-select" name="jenisJaminan" id="jenisJaminanSelect">
                                 <option value="">Pilih Jenis Jaminan</option>
                                 @foreach ($jenisJaminan as $jj)
                                 <option value="{{ $jj->id }}">{{ $jj->nama }}</option>
                                 @endforeach
                             </select>
                             @if ($errors->has('jenisJaminan'))
                             <span class="error">{{ $errors->first('jenisJaminan') }}</span>
                             @endif
                         </div>
                     </div>
                 </div>
</div>
  @else
                      <input type="hidden"   name="jenisJaminan" class="form-check-input" value="1">
                      <input type="hidden"   name="jenisPinjaman" class="form-check-input" value="1">
                @endif
                     <!-- Select Bank Umum -->
                     <div class="col-md-6">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Bank Umum</label>
                             <select style="background-color: #47C8C5; color:white" class="select2 form-control mb-3 custom-select" name="bankUmum" id="bankUmumSelect">
                                 <option value="">Pilih Bank Umum</option>
                                 @foreach ($bankUmum as $bk)
                                 <option value="{{ $bk->id }}" data-image="{{ asset('storage/' . $bk->image) }}">
                                   
                                 </option>
                                 @endforeach
                             </select>
                             @if ($errors->has('bankUmum'))
                             <span class="error">{{ $errors->first('bankUmum') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Select Bank BPR -->
                     <div class="col-md-6">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Bank BPR</label>
                             <select style="background-color: #47C8C5;" class="select2 form-control mb-3 custom-select" name="bankBpr" id="bankBPRSelect">
                                 <option value="">Pilih Bank BPR</option>
                                 @foreach ($bankBpr as $bk)
                                 <option value="{{ $bk->id }}" data-image="{{ asset('storage/' . $bk->image) }}">
                                     
                                 </option>
                                 @endforeach
                             </select>
                             @if ($errors->has('bankBpr'))
                             <span class="error">{{ $errors->first('bankBpr') }}</span>
                             @endif
                         </div>
                     </div>


                     <!-- Other form fields... -->

                     <!-- Status Pernikahan -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Status Pernikahan</label>
                             <div class="form-check">
                                 <input type="radio" id="single" name="statusPernikahan" class="form-check-input" value="belum_menikah">
                                 <label class="form-check-label" for="single">Belum Menikah</label>
                             </div>
                             <div class="form-check">
                                 <input type="radio" id="married" name="statusPernikahan" class="form-check-input" value="menikah">
                                 <label class="form-check-label" for="married">Menikah</label>
                             </div>
                             @if ($errors->has('statusPernikahan'))
                             <span class="error">{{ $errors->first('statusPernikahan') }}</span>
                             @endif
                         </div>
                     </div>

                     <div id="suratNikahContainer" class="col-md-12" style="display: none;">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Surat Nikah Atau Surat Cerai</label>
                             <input type="file" id="input-file-now2" class="dropify" />
                             <!-- <input type="file" id="input-file-now2" class="dropify" name="fotoSuratNikahSrc" /> -->
                             @if ($errors->has('fotoSuratNikahSrc'))
                             <span class="error">{{ $errors->first('fotoSuratNikahSrc') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Nama Lengkap -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Nama Lengkap</label>
                             <input type="text" class="form-control" name="namaLengkap" required placeholder="Masukan Nama Lengkap" />
                             <!-- <input type="text" class="form-control" required placeholder="Masukan Nama Lengkap" /> -->
                             @if ($errors->has('namaLengkap'))
                             <span class="error">{{ $errors->first('namaLengkap') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Email -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Email</label>
                             <input type="email" class="form-control" name="email" required placeholder="Masukan Email" />
                             <!-- <input type="email" class="form-control" required placeholder="Masukan Email" /> -->
                             @if ($errors->has('email'))
                             <span class="error">{{ $errors->first('email') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Pekerjaan -->
                     <div class="col-md-12">
                         <div class="form-group row">
                             <div class="col-md-12">
                                 <label class="control-label">Pekerjaan</label>
                             </div>
                             <div class="col-md-9">
                                 @foreach ($job as $key => $jb)
                                 <div class="form-check-inline my-1" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                                     <div class="custom-control custom-radio">
                                         <input type="radio" id="pekerjaan{{$key}}" name="pekerjaan" class="custom-control-input" value="{{$jb->id}}">
                                         <label class="custom-control-label" for="pekerjaan{{$key}}">{{$jb->title}}</label>
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

                     <!-- No Telephone -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">No Telephone</label>
                             <input type="text" class="form-control" name="noHp" required placeholder="Masukan Telepon" />
                             @if ($errors->has('noHp'))
                             <span class="error">{{ $errors->first('noHp') }}</span>
                             @endif
                         </div>
                     </div>
                     <!-- Form Upload File Jaminan -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Upload File Jaminan</label>
                             <input type="file" id="input-file-now2" class="dropify" name="fileJaminan" />
                             @if ($errors->has('fileJaminan'))
                             <span class="error">{{ $errors->first('fileJaminan') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Jaminan -->
                     <!-- <div class="col-md-12">
                        <div class="form-group mb-0">
                            <label class="mb-2 pb-1">Jaminan</label>
                            <input type="file" id="input-file-now2" name="file_jaminan" class="dropify" />
                            @if ($errors->has('file_jaminan'))
                            <span class="error">{{ $errors->first('file_jaminan') }}</span>
                            @endif
                        </div>
                    </div> -->
                     <!-- KTP Pemohon -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">KTP Pemohon Suami/Istri</label>
                             <input type="file" id="input-file-now1" name="imageSrc" class="dropify" />
                             @if ($errors->has('imageSrc'))
                             <span class="error">{{ $errors->first('imageSrc') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Kartu Keluarga -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Kartu Keluarga</label>
                             <input type="file" id="input-file-now2" name="imagekkSrc" class="dropify" />
                             @if ($errors->has('imagekkSrc'))
                             <span class="error">{{ $errors->first('imagekkSrc') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Rekening Koran -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Rekening Koran 3 Bulan Terakhir</label>
                             <input type="file" id="input-file-now2" class="dropify" name="fotoRekeningKoranSrc" />
                             @if ($errors->has('fotoRekeningKoranSrc'))
                             <span class="error">{{ $errors->first('fotoRekeningKoranSrc') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Slip Gaji -->
                     <div class="col-md-12">
                         <div class="form-group mb-0">
                             <label class="mb-2 pb-1">Slip Gaji</label>
                             <input type="file" id="input-file-now2" class="dropify" name="fotoSlipGajiSrc" />
                             @if ($errors->has('fotoSlipGajiSrc'))
                             <span class="error">{{ $errors->first('fotoSlipGajiSrc') }}</span>
                             @endif
                         </div>
                     </div>

                     <!-- Agreement -->
                     <div class="col-md-12 bg-light mt-3">
                         <div class="col-md-12 bg-light mt-3">
                             <div class="form-group">
                                 <div class="custom-control custom-checkbox mt-3">
                                     <input type="checkbox" class="custom-control-input" id="agreement" name="agreement" value="1">
                                     @if ($errors->has('agreement'))
                                     <span class="error">{{ $errors->first('agreement') }}</span>
                                     @endif
                                     <label class="custom-control-label" for="agreement">Saya menyetujui bahwa dokumen dipercayakan kepada ORumah untuk dipergunakan proses pengajuan BI checking/KPR untuk dipergunakan seperlu nya <a href="#" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-center" class="text-primary">Baca Selengkapnya</a></label>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- Submit Button -->
                     <div class="col-md-12 mt-3 text-right">
                         <button type="submit" id="submitBtn" class="btn btn-success waves-effect waves-light">Kirim</button>
                     </div>
                 </div>
             </form>
         </div>
     </div>
     <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                         <li class="list-group-item">1. Foto yang dipasang adalah foto properti minimal 3 (tiga) dan kualitas foto harus bagus, jelas serta tidak pecah atau buram.</li>
                         <li class="list-group-item">2. Foto yang dipasang adalah benar foto properti yang sedang di-iklankan.</li>
                         <li class="list-group-item">3. Foto harus menunjukkan properti yang dijual. Kecuali untuk ruko & apartemen, boleh mencantumkan foto gedung dan atau menampilkan bangunan yang ada di sekitarnya. Dengan syarat: agent memberikan informasi listing mana yang dijual di bagian deskripsi.</li>
                         <li class="list-group-item">4. Foto hanya boleh di-edit untuk mencantumkan logo company. Selain logo, tidak diperkenankan menambah apapun pada foto seperti dibingkai, dicantumkan alamat, blog, telepon, website lain, atau nama agen. Kecuali spanduk atau plang tersebut memang sudah menyatu dengan properti.</li>
                         <li class="list-group-item">5. Foto 3D, foto bangunan yang belum jadi atau sedang direnovasi diperkenankan tayang dengan mencantumkan keterangan bahwa listing tersebut adalah listing secondary.</li>
                         <li class="list-group-item">6. Multiple foto thumbnail image dalam satu foto file tidak diperbolehkan.</li>
                         <li class="list-group-item">7. Harga yang dimasukkan adalah harga yang realistis dan tidak boleh 0 (nol).</li>
                         <li class="list-group-item">8. Tagline listing dan deskripsi listing tidak diperbolehkan untuk mencantumkan nama, nomor telepon, alamat email, dan link website / blog / forum, dll.</li>
                     </ol>
                 </div>
             </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
     </div>
     <!-- Modal here... -->
     @endslot
 </x-Layout.Horizontal.Master>