<x-Layout.Horizontal.Master>
    @slot('body')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Pengajuan KPR Berhasil</h5>
                    <p class="card-text">
                        Terima kasih telah mengajukan KPR di O Rumah. Pengajuan Anda telah berhasil kami terima dan akan segera diproses.
                    </p>
                    <p class="card-text">
                        Kode Pengajuan KPR: {{ $kpr->uuid }}<br>
                        Kode Properti: {{ $ads->uuid }}<br>
                        Nama: {{ $kpr->kpr_name }}<br>
                        Email: {{ $kpr->kpr_email }}
                    </p>
                    <p class="card-text">
                        Nama Agen: {{ $agent->name }}<br>
                        Email Agen: {{ $agent->email }}<br>
                        No HP Agen: {{ $agent->wa_phone }}
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
