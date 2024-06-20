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
                <form class="form-horizontal m-t-20" action="{{ route('auth.in.login') }}" method="POST">
                    @csrf <!-- CSRF Token -->

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Username" name="email">
                            <!-- Ubah placeholder jika perlu -->
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Password"
                                name="password" id="password">
                            <label class="mt-2 text-black ">
                                <input type="checkbox" onclick="togglePasswordVisibility()"> Lihat Password
                            </label>
                            <a href="{{route('forget.passwrod')}}" class="text-black float-right mt-2">
                                <label>Lupa Password?</label>
                            </a>
                        </div>
                    </div>



                    <!-- <div class="form-group row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn   btn-block waves-effect waves-light" style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white" type="submit">Log
                                In</button>
                        </div>
                    </div>
                    <div class="form-group m-t-10 mb-0 row">
                        <!-- <div class="col-sm-7 m-t-20">
                            <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i>
                                <small>Forgot your password ?</small></a>
                        </div> -->
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
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>