<div class="modal fade loginDanRegistrasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="form-horizontal m-t-20" action="#" method="POST">
                    @csrf <!-- CSRF Token -->

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Email" name="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Password"
                                name="password" id="password">
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <label class="text-black mb-0">
                                    <input type="checkbox" onclick="togglePasswordVisibility()"> Lihat Password
                                </label>
                                <a href="{{ route('forget.passwrod') }}" class="text-black">
                                    <label class="mb-0">Lupa Password?</label>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-block waves-effect waves-light" style="background-color: #47C8C5; border-color: #47C8C5; color: white;" type="button" id="loginButton" onclick="loginFun()">Log In</button>
                        </div>
                    </div>
                    <div class="form-group m-t-10 mb-0 row">
                        <div class="col-sm-5 m-t-20" style="cursor: pointer;">
                            <a data-toggle="modal" data-animation="bounce" data-target=".Registrasi" class="text-black"
                                data-dismiss="modal" aria-label="Close"><i class="mdi mdi-account-circle"></i>
                                <small>Tidak Punya Akun ?</small></a>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function() {
        $('#loginButton').on('click', function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default
            loginFun();
        });
    });

    function loginFun() {
        var email = $('input[name="email"]').val();
        var password = $('input[name="password"]').val();

        // Validasi form
        if (email === "" || password === "") {
            alert('Email dan password harus diisi.');
            return;
        }

        var formData = {
            email: email,
            password: password,
            _token: $('input[name="_token"]').val() // CSRF token
        };

        $.ajax({
            url: `{{ route('auth.in.login') }}`,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle response dari server
                if (response.success) {
                    // Login pertama berhasil, lanjut ke login kedua
                    
                    
                    // window.location.href = "https://member.o-rumah.com/auth_get.php?Auth_Email="+response.data.email+"&Auth_Pass="+response.data.password ;  
                   
                } else {
                    alert('Login pertama gagal: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle error login pertama
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText;
                alert('Login pertama gagal: ' + errorMessage);
            }
        });
    }

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>
