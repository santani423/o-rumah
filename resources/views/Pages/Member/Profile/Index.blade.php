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
    <!--Wysiwig js-->
    <script src="{{asset('zenter/vertical/assets/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/editor.init.js')}}"></script>
    @endslot
    @slot('body')
    <div class="card">
        <div class="card-header">
            Profile Pengguna
        </div>
        <div class="card-body">
            <form action="{{route('member.profile.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}"
                        required>
                </div>
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" class="form-control" id="username" disabled name="username"
                        value="{{Auth::user()->username}}">
                </div>
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{Auth::user()->phone}}">
                </div>
                <div class="form-group">
                    <label for="wa_phone">WhatsApp</label>
                    <input type="text" class="form-control" id="wa_phone" name="wa_phone"
                        value="{{Auth::user()->wa_phone}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" disabled autocomplete="off"
                        value="{{Auth::user()->email}}" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" value=""
                        autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="profile_pengguna">Profile </label>
                    <input type="file" class="dropify" id="profile_pengguna" name="profile_pengguna"
                        data-default-file="{{asset(Auth::user()->image)}}">
                </div>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea d id="elm1" name="bio">{!!Auth::user()->bio!!}</textarea>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" id="address" name="address">{!!Auth::user()->address!!}</textarea>
                </div>
                <div class="form-group">
                    <label for="company_name">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="company_name" name="company_name"
                        value="{{Auth::user()->company_name}}">
                </div>
                <div class="form-group">
                    <label for="company_image">Logo Perusahaan</label>
                    <input type="file" class="dropify" id="company_image" name="company_image"
                        data-default-file="{{asset(Auth::user()->company_image)}}">
                </div>
                <div class="form-group">
                    <label for="bank_name">Nama Bank</label>
                    <input type="text" class="form-control" id="bank_name" value="{{Auth::user()->bank_name}}"
                        name="bank_name">
                </div>
                <div class="form-group">
                    <label for="bank_number">Nomor Rekening Bank</label>
                    <input type="text" class="form-control" id="bank_number" value="{{Auth::user()->bank_number}}"
                        name="bank_number">
                </div>


                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>