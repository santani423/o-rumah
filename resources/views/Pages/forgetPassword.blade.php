<x-Layout.Horizontal.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('forgot-password-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const email = document.getElementById('email').value;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const alertBox = document.getElementById('response-alert');

                fetch('{{ route('forget.passwrod.email') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ email: email })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alertBox.classList.remove('alert-danger');
                            alertBox.classList.add('alert-success');
                            alertBox.textContent = 'Link reset password telah dikirim ke email Anda.';
                        } else {
                            alertBox.classList.remove('alert-success');
                            alertBox.classList.add('alert-danger');
                            alertBox.textContent = 'Terjadi kesalahan, silakan coba lagi.';
                        }
                        alertBox.style.display = 'block';
                    })
                    .catch(error => {
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
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Masukkan email Anda">
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>