<x-Layout.Horizontal.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = $('#forgot-password-form');
            const spinner = $('#spinner');
            const alertBox = $('#response-alert');
            let sendMethod = 'email'; // Default method

            $('#emailBtn').on('click', function () {
                sendMethod = 'email';
                $('#emailBtn').addClass('btn-success').removeClass('btn-secondary');
                $('#whatsappBtn').addClass('btn-secondary').removeClass('btn-success');
                $('#inputLabel').text('Email');
                $('#emailSend').attr('type', 'email').attr('placeholder', 'Masukkan email Anda').val('');
            });

            $('#whatsappBtn').on('click', function () {
                sendMethod = 'whatsapp';
                $('#whatsappBtn').addClass('btn-success').removeClass('btn-secondary');
                $('#emailBtn').addClass('btn-secondary').removeClass('btn-success');
                $('#inputLabel').text('Nomor WhatsApp');
                $('#emailSend').attr('type', 'text').attr('placeholder', 'Masukkan nomor WhatsApp Anda').val('');
            });

            form.on('submit', function (event) {
                event.preventDefault();

                const contact = $('#emailSend').val();
                const token = $('meta[name="csrf-token"]').attr('content');

                spinner.show();  
                alertBox.hide();  

                $.ajax({
                    url: `{{ route('forget.passwrod.email') }}?contact=${contact}&method=${sendMethod}`,
                    type: 'get',
                    success: function (data) {
                        spinner.hide(); // Sembunyikan spinner setelah mendapat respons
                        console.log(data);
                        if (data.status === 'success') {
                            alertBox.removeClass('alert-danger').addClass('alert-success');
                            alertBox.text(`Link reset password telah dikirim ke ${sendMethod === 'email' ? 'email' : 'WhatsApp'} Anda.`);
                            // alert(sendMethod);
                            if (sendMethod === 'whatsapp') {
                                // alert(sendMethod);
                        window.location.href = "{{ route('passwrod.verifikasi.code') }}";
                    }
                        } else {
                            alertBox.removeClass('alert-success').addClass('alert-danger');
                            if (data.message) {
                                alertBox.text(data.message);
                            } else {
                                alertBox.text('Terjadi kesalahan, silakan coba lagi.');
                            }
                        }
                        alertBox.show();
                    },
                    error: function (error) {
                        spinner.hide(); // Sembunyikan spinner jika terjadi kesalahan
                        alertBox.removeClass('alert-success').addClass('alert-danger');
                        alertBox.text('Terjadi kesalahan, silakan coba lagi.');
                        alertBox.show();
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
    @endslot

    @slot('body')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Lupa Password</h3>
                    <div id="response-alert" class="alert" style="display:none;" role="alert"></div>
                    <form id="forgot-password-form">
                        @csrf
                        <div class="form-group">
                            <label for="email" id="inputLabel">Email</label>
                            <input type="email" class="form-control" id="emailSend" name="emailSend" required
                                placeholder="Masukkan email Anda">
                        </div>
                        <div class="form-group text-center mt-4">
                            <div class="btn-group" role="group">
                                <button type="button" id="emailBtn" class="btn btn-success">Email</button>
                                <button type="button" id="whatsappBtn" class="btn btn-secondary">WhatsApp</button>
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <span id="spinner" style="display:none;">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </span>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>
