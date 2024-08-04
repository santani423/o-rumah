<x-Layout.Vertical.Master title="Riwayat Transaksi">
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">

                <h4 class="page-title">Riwayat Transaksi</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Wrapper untuk membuat tabel responsif -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Deskripsi</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Jumlah</th>
                                    <th>Masa Aktif</th>
                                    <th>Invoice</th> <!-- Kolom baru untuk tombol Invoice -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $key => $trs)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ $trs->tgl_transaksi }}</td>
                                        <td>{{ $trs->description }}</td>
                                        <td>{{ $trs->payment_method }}</td>
                                        <td>Rp.{{ number_format($trs->amount, 2) }}</td>
                                        <td>{{ $trs->updated_at_formatted }} - {{ $trs->updated_at_plus_one_year }}</td>
                                        <td>
                                            <a href="{{ route('member.plans.invoice', ['transactionId' => $trs->id]) }}"
                                                class="btn btn-turquoise">Invoice</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <!-- end col -->
    </div>

    @endslot
</x-Layout.Vertical.Master>