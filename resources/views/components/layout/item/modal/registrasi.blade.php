<style>
    .modal-body {
        overflow-y: auto;
        /* Memungkinkan scrolling vertikal jika konten melebihi tinggi elemen */
        max-height: 80vh;
        /* Maksimal tinggi modal body, vh adalah persentase dari tinggi viewport */
    }
</style>
<form class="form-horizontal m-t-20" action="{{ route('auth.in.registrasi') }}" method="post">
    <div class="modal fade Registrasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
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
                            <input class="form-control" type="text" required="" placeholder="Nama Lengkap" name="nama"
                                id="nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-12">Username</label>
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Username" name="username"
                                id="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-12">Alamat Email</label>
                        <div class="col-12">
                            <input class="form-control" type="email" required="" placeholder="Alamat Email" name="email"
                                id="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="noWa" class="col-12">Nomor WhatsApp</label>
                        <div class="col-12">
                            <input class="form-control" type="text" required="" placeholder="Nomor WhatsApp" name="noWa"
                                id="noWa">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-12">Password</label>
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Password"
                                name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ulang_password" class="col-12">Ulang Password</label>
                        <div class="col-12">
                            <input class="form-control" type="password" required="" placeholder="Ulang Password"
                                name="ulang_password" id="ulang_password">
                        </div>
                    </div>

                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn  btn-block waves-effect waves-light btn-succsess" style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white" type="button" data-toggle="modal" data-target=".pilihType">Daftar</button>
                        </div>
                    </div>
                    <div class="col-sm-5 m-t-20">
                        <a data-toggle="modal" data-animation="bounce" data-target=".loginDanRegistrasi"
                            class="text-muted " data-dismiss="modal" aria-label="Close"><i
                                class="mdi mdi-account-circle"></i>
                            <small>Sudah Punya Akun ?</small></a>
                    </div>
                </div>



            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade pilihType" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
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
                                <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                    style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType"
                                            id="radioCustomer" value="customer">
                                    </div>
                                    <!-- <img src="{{asset('assets/icons/agent.png')}}" alt=""> -->
                                    <h5 class="card-title">Customer</h5>
                                    <p class="card-text text-center">Kelola dan promosikan properti anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioAgent').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                    style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioAgent"
                                            value="agent">
                                    </div>
                                    <!-- <img src="{{asset('assets/icons/agent.png')}}" alt=""> -->
                                    <h5 class="card-title">Agen</h5>
                                    <p class="card-text text-center">Kelola dan promosikan properti anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioFood').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                    style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioFood"
                                            value="food">
                                    </div>
                                    <!-- <img src="{{asset('assets/icons/food.png')}}" alt=""> -->
                                    <h5 class="card-title">Food</h5>
                                    <p class="card-text text-center">Promosikan bisnis makanan dan toko anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioMerchant').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                    style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType"
                                            id="radioMerchant" value="merchant">
                                    </div>
                                    <!-- <img src="{{asset('assets/icons/merchant.png')}}" alt=""> -->
                                    <h5 class="card-title">Merchant</h5>
                                    <p class="card-text text-center">Promosikan bisnis makanan dan toko anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioNotaris').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                    style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType"
                                            id="radioNotaris" value="notaris">
                                    </div>
                                    <!-- <img src="{{asset('assets/icons/notaris.png')}}" alt=""> -->
                                    <h5 class="card-title">Notaris</h5>
                                    <p class="card-text text-center">Layani kebutuhan legalitas dan dokumentasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card" onclick="document.getElementById('radioLbh').checked = true;">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                    style="height: 100%; position: relative;">
                                    <div class="form-check" style="position: absolute; top: 0; right: 0;">
                                        <input class="form-check-input" type="radio" name="pilihanType" id="radioLbh"
                                            value="lbh">
                                    </div>
                                    <!-- <img src="{{asset('assets/icons/notaris.png')}}" alt=""> -->
                                    <h5 class="card-title">LBH</h5>
                                    <p class="card-text text-center">Layani kebutuhan legalitas dan dokumentasi</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn   btn-block waves-effect waves-light " style="background-color: #47C8C5;
            border-color: #47C8C5;
            color: white" type="submit" data-toggle="modal" data-target=".pilihType">Pilih</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>