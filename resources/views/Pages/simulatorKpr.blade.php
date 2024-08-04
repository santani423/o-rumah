<x-Layout.Horizontal.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaInput = document.getElementById('harga');
            const uangMukaInput = document.getElementById('uang-muka');
            const maksimumKprInput = document.getElementById('maksimum-kpr');
            const bungaKprInput = document.getElementById('bunga-kpr');
            const tahunCicilanSelect = document.getElementById('tahun-cicilan');
            const hasilCicilan = document.getElementById('hasil-cicilan');

            function formatRupiah(angka, prefix) {
                var numberString = angka.replace(/[^,\d]/g, '').toString(),
                    split = numberString.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            }

            function updateUangMukaDanMaksimumKpr() {
                const harga = parseFloat(hargaInput.value.replace(/[^,\d]/g, '')) || 0;
                const uangMuka = parseFloat(uangMukaInput.value.replace(/[^,\d]/g, '')) || 0;
                maksimumKprInput.value = formatRupiah((harga - uangMuka).toFixed(0).toString(), 'Rp ');
            }

            function hitungCicilan() {
                const harga = parseFloat(hargaInput.value.replace(/[^,\d]/g, '')) || 0;
                const bunga = parseFloat(bungaKprInput.value) || 0;
                const tahunCicilan = parseInt(tahunCicilanSelect.value) || 0;
                const uangMuka = parseFloat(uangMukaInput.value.replace(/[^,\d]/g, '')) || 0;
                const pokokPinjaman = harga - uangMuka;
                const bungaBulanan = bunga / 100 / 12;
                const jumlahBulan = tahunCicilan * 12;

                const cicilan = pokokPinjaman * (bungaBulanan / (1 - Math.pow(1 + bungaBulanan, -jumlahBulan)));
                hasilCicilan.textContent = 'Perkiraan Cicilan Bulanan: ' + formatRupiah(cicilan.toFixed(0).toString(), 'Rp ');
            }

            function formatInputValue(input) {
                input.value = formatRupiah(input.value, 'Rp ');
            }

            hargaInput.addEventListener('input', function() {
                formatInputValue(hargaInput);
                updateUangMukaDanMaksimumKpr();
                hitungCicilan();
            });

            uangMukaInput.addEventListener('input', function() {
                formatInputValue(uangMukaInput);
                updateUangMukaDanMaksimumKpr();
                hitungCicilan();
            });

            bungaKprInput.addEventListener('input', hitungCicilan);
            tahunCicilanSelect.addEventListener('change', hitungCicilan);

            // Initialize
            updateUangMukaDanMaksimumKpr();
        });
    </script>
    @endslot
    @slot('body')
    <div class="d-flex justify-content-center align-items-start vh-100 mt-5">
        <div class="row w-100">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center"> 
                        <h5>Simulasi KPR</h5> 
                        <hr>
                        <div id="response-alert" class="alert" style="display:none;" role="alert"></div>
                        <form id="kpr-simulation-form">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="harga" class="col-sm-4 col-form-label text-start">Harga</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="harga" name="harga" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="uang-muka" class="col-sm-4 col-form-label text-start">Uang Muka</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="uang-muka" name="uang-muka" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="maksimum-kpr" class="col-sm-4 col-form-label text-start">Maksimum KPR</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="maksimum-kpr" name="maksimum-kpr" readonly required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="bunga-kpr" class="col-sm-4 col-form-label text-start">Bunga KPR (%)</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="bunga-kpr" name="bunga-kpr" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="tahun-cicilan" class="col-sm-4 col-form-label text-start">Tahun Cicilan</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="tahun-cicilan" name="tahun-cicilan" required>
                                        <option value="10">10 Tahun</option>
                                        <option value="15">15 Tahun</option>
                                        <option value="20">20 Tahun</option>
                                        <option value="30">30 Tahun</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <button type="submit" class="btn btn-success">Hitung Simulasi</button> -->
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center"> 
                        <h5>Angsuran/Bulan Fix</h5>
                        <hr>
                        <div id="hasil-cicilan" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>
