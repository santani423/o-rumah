<x-Layout.Horizontal.Master>
    @slot('body')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Pengajuan {{$typePengajuan->name}} Berhasil</h5>
                    <p class="card-text">
                        Terima kasih telah mengajukan {{$typePengajuan->name}} di O Rumah. Pengajuan Anda telah berhasil kami terima dan akan segera diproses.
                    </p>
                    <p class="card-text">
                        Kode {{$typePengajuan->name}}: {{ $pengajuan->uuid }}<br>
                        Kode Properti: {{ $pengajuan->code_pengajuan }}<br>
                        Nama: {{ $pengajuan->nama_lengkap }}<br>
                        Email: {{ $pengajuan->email }}
                    </p>
                   
                    <p class="card-text">
                        Kami akan segera menghubungi Anda untuk langkah selanjutnya. Jika Anda memiliki pertanyaan atau memerlukan informasi lebih lanjut, jangan ragu untuk menghubungi agen kami.
                    </p>
                    <p class="card-text">
                        Terima kasih telah memilih O Rumah.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>
