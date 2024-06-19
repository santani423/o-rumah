<x-Layout.Horizontal.Master>
    @slot('css')
    <style>
        .custom-img-size {
            width: 50px;
            height: auto;
            /* Menjaga rasio aspek gambar */
        }
    </style>
    @endslot
    @slot('body')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about1.jpg') }}"
                    alt="Card image cap" />
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <blockquote class="blockquote">
                        <p>
                            o-Rumah adalah platform properti yang memberikan kemudahan KPR online dan proses properti
                            lelang bagi penggunanya, serta mengkombinasikan fitur marketplace untuk UKM (Merchant) dan
                            penjualan makanan (Food) dengan batasan jangkauan 3 km sebagai pelengkap dalam 1 aplikasi.
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <blockquote class="blockquote">
                        <h6>Fitur dan benefit menarik - Buyer</h6>
                        <ul>
                            <li>Kepastian kemampuan KPR untuk properti pilihan sampai BPR</li>
                            <li>Dilakukan secara online, mengurangi fotokopi dokumen, waktu koordinasi</li>
                            <li>Dukungan LBH untuk produk lelang</li>
                            <li>Profiling Agen, Notaris, LBH untuk dipilih sesuai selera</li>
                        </ul>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <blockquote class="blockquote">
                        <h6>Fitur dan benefit menarik - Buyer</h6>
                        <ul>
                            <li>Menghemat waktu dalam kordinasi dengan bank</li>
                            <li>Kejelasan closing jika buyer potensial</li>
                            <li>Terinfokan progress buyer</li>
                            <li>Bisa melakukan aktifitas lain di fitur merchant dan food untuk perekrutan dan
                                mendapatkan bonus</li>
                            <li>Rewards</li>
                        </ul>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about2.png') }}"
                                alt="Card image cap" />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about.png') }}"
                                alt="Card image cap" />
                        </div>
                        <div class="col-lg-12">
                            <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about4.jpg') }}"
                                alt="Card image cap" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about5.png') }}"
                                alt="Card image cap" />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about6.jpg') }}"
                                alt="Card image cap" />
                        </div>
                        <div class="col-lg-6 mb-3">
                            <img class="card-img-top img-fluid" src="{{ asset('assets/aboutAs/about7.png') }}"
                                alt="Card image cap" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <h6>Marketplace Property</h6>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <img class="card-img-top img-fluid " width="50"
                                src="{{ asset('assets/aboutAs/about8.jpg') }}" alt="Card image cap" />
                        </div>
                        <div class="col-lg-4 mb-3">
                            <h6>Marketplace Food & Merchant</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    @endslot
</x-Layout.Horizontal.Master>