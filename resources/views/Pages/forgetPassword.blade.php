<x-Layout.Horizontal.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('forgot-password-form');
            const spinner = document.getElementById('spinner');
            const alertBox = document.getElementById('response-alert');

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const email = document.getElementById('emailSend').value;
                // console.log("🚀 ~ email:", email)
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                spinner.style.display = 'inline-block'; // Tampilkan spinner saat form disubmit
                alertBox.style.display = 'none'; // Sembunyikan alert box setiap kali form disubmit

                fetch('{{ route('forget.passwrod.email') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ email: email }) // Pastikan data yang dikirim adalah objek dengan properti email
                })
                    .then(response => response.json())
                    .then(data => {
                        spinner.style.display = 'none'; // Sembunyikan spinner setelah mendapat respons

                        if (data.status === 'success') {
                            alertBox.classList.remove('alert-danger');
                            alertBox.classList.add('alert-success');
                            alertBox.textContent = 'Link reset password telah dikirim ke email Anda.';
                        } else {
                            alertBox.classList.remove('alert-success');
                            alertBox.classList.add('alert-danger');
                            if (data.message) {
                                alertBox.textContent = data.message;
                            } else {
                                alertBox.textContent = 'Terjadi kesalahan, silakan coba lagi.';
                            }
                        }
                        alertBox.style.display = 'block';
                    })
                    .catch(error => {
                        spinner.style.display = 'none'; // Sembunyikan spinner jika terjadi kesalahan
                        alertBox.classList.remove('alert-success');
                        alertBox.classList.add('alert-danger');
                        alertBox.textContent = 'Terjadi kesalahan, silakan coba lagi.';
                        alertBox.style.display = 'block';
                        console.error('Error:', error);
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
                            <button type="submit" class="btn btn-primary">
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