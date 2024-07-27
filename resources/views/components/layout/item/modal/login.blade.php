<div class="modal fade loginDanRegistrasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert" class="alert d-none" role="alert"></div>
                <form id="loginForm" class="form-horizontal m-t-20">
                    @csrf <!-- CSRF Token -->

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Email" name="email" autocomplete="off">
                            <!-- Ubah placeholder jika perlu -->
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 position-relative">
                            <input class="form-control" type="password" required="" placeholder="Password" name="password" id="password">
                            <i class="fa fa-eye-slash toggle-password" data-toggle-target="password"></i>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('forget.password') }}" class="text-black">
                                    <label class="mb-0">Lupa Password?</label>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button id="loginButton" class="btn btn-block waves-effect waves-light" style="background-color: #47C8C5; border-color: #47C8C5; color: white;" type="submit">
                                <span id="loginButtonText">Log In</span>
                                <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-sm-5 m-t-20" style="cursor: pointer;">
                            <a data-toggle="modal" data-animation="bounce" data-target=".Registrasi" class="text-black" data-dismiss="modal" aria-label="Close"><i class="mdi mdi-account-circle"></i>
                                <small>Tidak Punya Akun ?</small></a>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const loginButtonText = document.getElementById('loginButtonText');
        const loginSpinner = document.getElementById('loginSpinner');
        const alertBox = document.getElementById('alert');

        loginForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            // Show spinner and disable button
            loginButtonText.classList.add('d-none');
            loginSpinner.classList.remove('d-none');
            loginButton.disabled = true;

            const formData = new FormData(loginForm);

            fetch("{{ route('auth.in.login') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Hide spinner and enable button
                loginButtonText.classList.remove('d-none');
                loginSpinner.classList.add('d-none');
                loginButton.disabled = false;

                if (data.redirect) {
                    window.location.href = "https://member.o-rumah.com/auth_get.php?Auth_Email="+data.email+"&Auth_Pass="+data.password;
                } else {
                    alertBox.classList.remove('d-none', 'alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.textContent = data.message;
                }
            })
            .catch(error => {
                // Hide spinner and enable button
                loginButtonText.classList.remove('d-none');
                loginSpinner.classList.add('d-none');
                loginButton.disabled = false;

                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = 'Terjadi kesalahan saat login. Silakan coba lagi.';
                console.error('Error:', error);
            });
        });

    
    });
</script>
