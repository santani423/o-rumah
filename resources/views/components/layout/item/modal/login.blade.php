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
                            <i class="fa fa-eye-slash toggle-password" data-toggle-target="password" style="cursor: pointer; position: absolute; right: 15px; top: 40%; transform: translateY(-50%);"></i>
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
    $(document).ready(function () {
        $('#loginForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            // Show spinner and disable button
            $('#loginButtonText').addClass('d-none');
            $('#loginSpinner').removeClass('d-none');
            $('#loginButton').prop('disabled', true);

            const formData = $(this).serialize();

            $.ajax({
                url: "{{ route('auth.in.login') }}",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // Hide spinner and enable button
                    $('#loginButtonText').removeClass('d-none');
                    $('#loginSpinner').addClass('d-none');
                    $('#loginButton').prop('disabled', false);

                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        $('#alert').removeClass('d-none alert-success').addClass('alert-danger').text(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Hide spinner and enable button
                    $('#loginButtonText').removeClass('d-none');
                    $('#loginSpinner').addClass('d-none');
                    $('#loginButton').prop('disabled', false);

                    $('#alert').removeClass('d-none alert-success').addClass('alert-danger').text('Terjadi kesalahan saat login. Silakan coba lagi.');
                    console.error('Error:', error);
                }
            });
        });

        // $('.toggle-password').on('click', function () {
        //     const target = $('#' + $(this).data('toggle-target'));
        //     if (target.attr('type') === 'password') {
        //         target.attr('type', 'text');
        //         $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        //     } else {
        //         target.attr('type', 'password');
        //         $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        //     }
        // });
    });
</script>
