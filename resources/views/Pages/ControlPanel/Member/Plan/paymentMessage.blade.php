<x-Layout.Vertical.Master title="Payment">
    @slot('js')
    <script>
        $(document).ready(function () {
            $('#submitPayment').click(function (e) {
                const description =
                    "Plan : " +
                    '{{$plan->name}}' +
                    " max_ads_posted : " +
                    ' {{$plan->max_ads_posted}}';
                e.preventDefault();
                var paymentData = {
                    _token: '{{ csrf_token() }}', // Menambahkan CSRF token
                    payer_email: '{{ $user->email }}',
                    description: description,
                    amount: '{{ $total }}',
                    slug: '{{ $slug }}'
                };

                // Menampilkan spinner
                $('#spinner').show();

                $.ajax({
                    url: "{{route('payments')}}",
                    type: 'POST',
                    data: paymentData,
                    success: function (response) {
                        // alert('Pembayaran berhasil!');
                        // console.log(response);
                        window.location.href = response.payment.checkout_link; // Redirect ke link checkout
                    },
                    error: function () {
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    },
                    complete: function () {
                        // Menyembunyikan spinner setelah request selesai
                        $('#spinner').hide();
                    }
                });
            });
        });
    </script>
    @endslot
    @slot('body')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-success  ">
                Invoice Pembayaran
            </div>
            <div class="card-body bg-light">
                <h5 class="card-title">Detail Pembayaran</h5>
                <p class="card-text">Berikut adalah rincian biaya yang harus dibayar:</p>
                <table class="table table-hover">
                    <thead class="bg-success text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $plan->name}}</td>
                            <td>1</td>
                            <td>{{$formattedPrice}}</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>PPN (11%)</td>
                            <td>-</td>
                            <td>{{$formattedPricePPN}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <h5>Total: {{$formattedPriceTotal}}</h5>
                </div>
                <!-- Tombol Submit Payment -->
                <!-- Tombol Submit Payment dengan Spinner -->
                <button id="submitPayment" class="btn btn-success mt-3">
                    Submit Payment
                    <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                        style="display: none;"></span>
                </button>
            </div>
            <div class="card-footer text-muted">
                Pembayaran dilakukan paling lambat 2 hari setelah invoice diterima.
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>