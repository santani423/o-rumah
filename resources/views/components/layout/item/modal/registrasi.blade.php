<style>
    .modal-body {
        overflow-y: auto;
        max-height: 80vh;
    }
</style>

<form class="form-horizontal m-t-20" action="{{ route('auth.in.registrasi') }}" method="post" onsubmit="return validateForm()">
    <div class="modal fade Registrasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama" class="col-12">Nama Lengkap</label>
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Nama Lengkap" name="nama" id="nama">
                            <span id="nama-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-12">Username</label>
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Username" onkeyup="cekUsername()" name="username" id="username">
                            <span id="username-error" class="text-danger"></span>
                            <span id="username-status"></span>
                            <ul id="username-references"></ul>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-12">Alamat Email</label>
                        <div class="col-12">
                            <input class="form-control" type="email" required="" placeholder="Alamat Email" name="email" id="email">
                            <span id="email-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="noWa" class="col-12">Nomor WhatsApp</label>
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Nomor WhatsApp" name="noWa" id="noWa">
                            <!-- <span id="noWa-error" class="text-danger"></span> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-12">Password</label>
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Password" name="password" id="password">
                            <!-- <span id="password-error" class="text-danger"></span> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ulang_password" class="col-12">Ulang Password</label>
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Ulang Password" name="ulang_password" id="ulang_password">
                            <!-- <span id="ulang_password-error" class="text-danger"></span> -->
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button id="submit-button"  class="btn btn-block waves-effect waves-light btn-success" style="background-color: #47C8C5; border-color: #47C8C5; color: white" type="submit" data-toggle="modal" data-target=".pilihType">Daftar</button>
                        </div>
                    </div>
                    <div class="col-sm-5 m-t-20">
                        <a data-toggle="modal" data-animation="bounce" data-target=".loginDanRegistrasi" class="text-muted" data-dismiss="modal" aria-label="Close">
                            <i class="mdi mdi-account-circle"></i>
                            <small>Sudah Punya Akun?</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pilihType" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar Sebagai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioCustomer').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioCustomer" value="customer">
                                    </div>
                                    <h5 class="card-title">Customer</h5>
                                    <p class="card-text text-center">Kelola dan promosikan properti anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioAgent').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioAgent" value="agent">
                                    </div>
                                    <h5 class="card-title">Agen</h5>
                                    <p class="card-text text-center">Kelola dan promosikan properti anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioFood').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioFood" value="food">
                                    </div>
                                    <h5 class="card-title">Food</h5>
                                    <p class="card-text text-center">Promosikan bisnis makanan dan toko anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioMerchant').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioMerchant" value="merchant">
                                    </div>
                                    <h5 class="card-title">Merchant</h5>
                                    <p class="card-text text-center">Promosikan bisnis makanan dan toko anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioNotaris').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioNotaris" value="notaris">
                                    </div>
                                    <h5 class="card-title">Notaris</h5>
                                    <p class="card-text text-center">Layani kebutuhan legalitas dan dokumentasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioLbh').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioLbh" value="lbh">
                                    </div>
                                    <h5 class="card-title">LBH</h5>
                                    <p class="card-text text-center">Layani kebutuhan legalitas dan dokumentasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-block waves-effect waves-light" style="background-color: #47C8C5; border-color: #47C8C5; color: white" type="submit">Pilih</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    function cekUsername() {
        var username = $('#username').val();

        if (username.includes(' ')) {
            $('#username-error').text('Username tidak boleh mengandung spasi.');
            $('#username-status').text('');
            $('#username-references').empty();
            return;
        } else {
            $('#username-error').text('');
        }

        if (username) {
            $.ajax({
                url: "{{ route('cek-username') }}",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    username: username
                },
                success: function (response) {
                    $('#username-references').empty(); 
                    if (response.exists) {
                        $('#username-status').text('Username sudah ada').css('color', 'red');
                        var references = response.references;
                        references.forEach(function(ref) {
                            $('#username-references').append('<li onclick="pilihUsername(\'' + ref + '\')">' + ref + '</li>');
                        });
                    } else {
                        $('#username-status').text('Username tersedia').css('color', 'green');
                    }
                }
            });
        } else {
            $('#username-status').text('');
            $('#username-references').empty(); 
        }
    }

    function pilihUsername(username) {
        $('#username').val(username);
        $('#username-status').text('Username tersedia').css('color', 'green');
        $('#username-references').empty();
    }

    function validateForm() {
    var isValid = true;

    var nama = $('#nama').val().trim();
    var username = $('#username').val().trim();
    var email = $('#email').val().trim();
    var noWa = $('#noWa').val().trim();
    var password = $('#password').val().trim();
    var ulang_password = $('#ulang_password').val().trim();

    if (!nama) {
        $('#nama-error').text('Nama Lengkap harus diisi.');
        isValid = false;
    } else {
        $('#nama-error').text('');
    }
    if (!username) {
        $('#username-error').text('Username harus diisi.');
        isValid = false;
    } else if ($('#username-status').text() !== 'Username tersedia') {
        $('#username-error').text('Username tidak valid.');
        isValid = false;
    } else {
        $('#username-error').text('');
    }
    if (!email) {
        $('#email-error').text('Alamat Email harus diisi.');
        isValid = false;
    } else {
        $('#email-error').text('');
    }
    if (!noWa) {
        $('#noWa-error').text('Nomor WhatsApp harus diisi.');
        isValid = false;
    } else {
        $('#noWa-error').text('');
    }
    if (!password) {
        $('#password-error').text('Password harus diisi.');
        isValid = false;
    } else {
        $('#password-error').text('');
    }
    if (!ulang_password) {
        $('#ulang_password-error').text('Ulang Password harus diisi.');
        isValid = false;
    } else if (password !== ulang_password) {
        $('#ulang_password-error').text('Password dan Ulang Password tidak sesuai.');
        isValid = false;
    } else {
        $('#ulang_password-error').text('');
    }

    // Update tombol berdasarkan hasil validasi
    if (isValid) {
        $('#submit-button').attr('data-toggle', 'modal');
        $('#submit-button').attr('data-target', '.pilihType');
    } else {
        $('#submit-button').removeAttr('data-toggle');
        $('#submit-button').removeAttr('data-target');
    }

    return isValid;
}

</script>
