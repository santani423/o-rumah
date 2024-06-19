<x-Layout.Horizontal.Master>
    @slot('body')
    <div class="card">
        <div class="card-header">
            Data Pengajuan KPR
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code KPR</th>
                        <th>Nama Agen</th>
                        <th>Bank Umum</th>
                        <th>Bank BPR</th>
                        <th>Status Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuanKpr as $kpr)
                        <tr>
                            <td>{{ $kpr->uuid }}</td>
                            <td>{{ $kpr->namaAgen }}</td>
                            <td>{{ $kpr->bank_umum_name }}</td>
                            <td>{{ $kpr->bank_bpr_name }}</td>
                            <td>{{ $kpr->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>