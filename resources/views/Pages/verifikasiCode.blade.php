<x-Layout.Horizontal.Master>
    @slot('body')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Verifikasi Kode</h3>
                    @if (session('error'))
                        <div id="response-alert" class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div id="info-alert" class="alert alert-info" role="alert">
                        Kami telah mengirimkan kode verifikasi ke nomor WhatsApp Anda.
                        <br>
                        Belum mendapatkan kode verifikasi? <a href="{{route('forget.passwrod')}}" id="resend-code">Kirim Ulang</a>
                    </div>
                    <form id="verification-code-form" action="{{ route('verification.code') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="verification_code">Kode Verifikasi</label>
                            <input type="text" class="form-control" id="verification_code" name="verification_code" required placeholder="Masukkan kode verifikasi Anda">
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <span id="spinner" style="display:none;">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </span>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('verification-code-form').addEventListener('submit', function() {
        document.getElementById('spinner').style.display = 'inline-block';
    });

    $('#resend-code').on('click', function(e) {
        e.preventDefault();
        let contact = "nomor_WhatsApp"; // Ganti ini dengan cara mendapatkan nomor WhatsApp pengguna
        let sendMethod = "whatsApp"; // M
