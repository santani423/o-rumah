<x-Layout.Horizontal.Master>
    @slot('body')
    <div class="card">
        <div class="card-header">
            Data Pengajuan Lelang
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code Lealng</th>
                        <th>Tanggal Dibuat</th>
                        <th>Nama Agen</th>
                        <th>Slug Iklan</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuanLelang as $lelang)
                        <tr>
                            <td>{{ $lelang->uuid }}</td>
                            <td>{{ $lelang->created_at }}</td>
                            <td>{{ $lelang->namaAgen }}</td>
                            <td>{{ $lelang->ads_slug }}</td>
                            <td>{{ $lelang->kpr_name }}</td>
                            <td>{{ $lelang->kpr_email }}</td>
                            <td>{{ $lelang->kpr_phone }}</td>
                            <td>{{ $lelang->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>