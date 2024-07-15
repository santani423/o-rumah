<style>
    .modal-body {
        overflow-y: auto;
        max-height: 80vh;
    }

    .toggle-password {
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 10px;
        z-index: 2;
    }
</style>

<form class="form-horizontal m-t-20" action="{{ route('auth.in.registrasi') }}" method="post" onsubmit="return validateForm()">
    <div class="modal fade Registrasi" id="Registrasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                            <span id="noWa-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_lr" class="col-12">Password</label>
                        <div class="col-12 position-relative">
                            <input class="form-control" type="password" required="" placeholder="Password" name="password" id="password_lr">
                            <span id="password-error" class="text-danger"></span>
                            <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password_lr')"></i>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ulang_password" class="col-12">Ulang Password</label>
                        <div class="col-12 position-relative">
                            <input class="form-control" type="password" required="" placeholder="Ulang Password" name="ulang_password" id="ulang_password">
                            <span id="ulang_password-error" class="text-danger"></span>
                            <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('ulang_password')"></i>
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button id="submit-button" class="btn btn-block waves-effect waves-light btn-success" data-target=".pilihType" style="background-color: #47C8C5; border-color: #47C8C5; color: white" type="button">Daftar</button>
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
    <div class="modal fade pilihType" id="pilihTypeModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioAplikator').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioAplikator" value="aplikator">
                                    </div>
                                    <h5 class="card-title">Aplikator</h5>
                                    <p class="card-text text-center">Membuat dan mengembangkan aplikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-block waves-effect waves-light btn-success" style="background-color: #47C8C5; border-color: #47C8C5; color: white" type="submit">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // Tambahkan event listeners untuk menghapus pesan error saat pengguna mulai mengetik di input fields
    const fields = ['nama', 'username', 'email', 'noWa', 'password_lr', 'ulang_password'];
    fields.forEach(field => {
        document.getElementById(field).addEventListener('input', () => {
            document.getElementById(`${field}-error`).innerText = '';
        });
    });

    document.getElementById('submit-button').addEventListener('click', function (event) {
        if (validateForm()) {
            // Hide the Registrasi modal and show the pilihType modal if validation passes
            $('#Registrasi').modal('hide');
            $('#pilihTypeModal').modal('show');
        }
    });

    function validateForm() {
        let isValid = true;

        const nama = document.getElementById('nama').value.trim();
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const noWa = document.getElementById('noWa').value.trim();
        const password = document.getElementById('password_lr').value.trim();
        const ulang_password = document.getElementById('ulang_password').value.trim();

        if (!nama) {
            document.getElementById('nama-error').innerText = 'Nama lengkap harus diisi.';
            isValid = false;
        }

        if (!username) {
            document.getElementById('username-error').innerText = 'Username harus diisi.';
            isValid = false;
        }

        if (!email) {
            document.getElementById('email-error').innerText = 'Alamat email harus diisi.';
            isValid = false;
        }

        if (!noWa) {
            document.getElementById('noWa-error').innerText = 'Nomor WhatsApp harus diisi.';
            isValid = false;
        }

        if (!password) {
            document.getElementById('password-error').innerText = 'Password harus diisi.';
            isValid = false;
        }

        if (password !== ulang_password) {
            document.getElementById('ulang_password-error').innerText = 'Password tidak cocok.';
            isValid = false;
        }

        return isValid;
    }

    function togglePasswordVisibility(fieldId) {
        var input = document.getElementById(fieldId);
        var icon = input.nextElementSibling;
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
