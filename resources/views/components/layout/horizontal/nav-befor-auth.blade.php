<li class="list-inline-item mt-2">
    <!-- Tombol untuk membuka modal login/registrasi -->
    <button type="button" class="btn   " data-toggle="modal" data-animation="bounce" data-target=".loginDanRegistrasi"
        style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white">
        Login / Registrasi
    </button>

    <!-- Menampilkan pesan error jika ada dalam sesi -->
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <!-- Menampilkan daftar validasi error jika ada -->
    <!-- @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->
</li>