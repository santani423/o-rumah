<x-Layout.Horizontal.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('forgot-password-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const email = document.getElementById('email').value;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                            alert('Link reset password telah dikirim ke email Anda.');
                        } else {
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
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