<x-Layout.Horizontal.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const form = $('#forgot-password-form');
    const spinner = $('#spinner');
    const alertBox = $('#response-alert');

    form.on('submit', function (event) {
        event.preventDefault();

        const email = $('#emailSend').val();
        const token = $('meta[name="csrf-token"]').attr('content');

        spinner.show(); // Tampilkan spinner saat form disubmit
        alertBox.hide(); // Sembunyikan alert box setiap kali form disubmit

        $.ajax({
            url: "{{ route('forget.passwrod.email') }}?email="+email,
            type: 'get',
            // headers: {
            //     'X-CSRF-TOKEN': token // Tambahkan header token CSRF
            // },
            // contentType: 'application/json',
            // data: JSON.stringify({ email: email }),
            success: function (data) {
                spinner.hide(); // Sembunyikan spinner setelah mendapat respons
                console.log(data);
                if (data.status === 'success') {
                    alertBox.removeClass('alert-danger').addClass('alert-success');
                    alertBox.text('Link reset password telah dikirim ke email Anda.');
                } else {
                    alertBox.removeClass('alert-success').addClass('alert-danger');
                    if (data.message) {
                        alertBox.text(data.message);
                    } else {
                        alertBox.text('Terjadi kesalahan, silakan coba lagi.');
                    }
                }
                alertBox.show();
            },
            error: function (error) {
                spinner.hide(); // Sembunyikan spinner jika terjadi kesalahan
                alertBox.removeClass('alert-success').addClass('alert-danger');
                alertBox.text('Terjadi kesalahan, silakan coba lagi.');
                alertBox.show();
                console.error('Error:', error);
            }
        });
    });
});

    </script>
    @endslot

    @slot('body')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Lupa Password</h3>
                    <div id="response-alert" class="alert" style="display:none;" role="alert"></div>
                    <form id="forgot-password-form">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="emailSend" name="emailSend" required
                                placeholder="Masukkan email Anda">
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <span id="spinner" style="display:none;">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </span>
                                Kirim Link Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>