<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <!-- Card Wrapper -->
            <div class="card">
                <div class="card-body">
                    <div class="page-title-box">
                        <h4 class="page-title">Riwayat Transaksi</h4>
                    </div>
                    <div class="invoice-box">
                        <table class="table">
                            <!-- <tr>
                                <td>ID Transaksi:</td>
                                <td>{{ $transaksi->transaksis_id }}</td>
                            </tr> -->
                            <tr>
                                <td>Plan:</td>
                                <td>{{ $transaksi->description }}</td>
                            </tr>
                            <tr>
                                <td>Harga:</td>
                                <td>Rp{{ number_format($transaksi->price, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Metode Pembayaran:</td>
                                <td>{{ $transaksi->payment_method }}</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran:</td>
                                <td>{{ $transaksi->payment_status }}</td>
                            </tr>
                            <tr>
                                <td>Waktu Transaksi:</td>
                                <td>{{ $transaksi->transaction_time }}</td>
                            </tr>
                            <tr>
                                <td>Status Transaksi:</td>
                                <td>{{ $transaksi->transaction_status }}</td>
                            </tr>
                            <!-- <tr>
                                <td>Informasi Tambahan:</td>
                                <td>{{ $transaksi->additional_info }}</td>
                            </tr> -->
                        </table>
                        <!-- Print Button -->
                        <button onclick="printInvoice()" class="btn btn-success">Cetak Invoice</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    @endslot
</x-Layout.Vertical.Master>

<script>
    function printInvoice() {
        window.print();
    }
</script>