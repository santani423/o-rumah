<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{$url}}" method="post">
                @csrf
                @method($method)
                <div class="card-body">
                    <input type="hidden" id="lat" name="lat" />
                    <input type="hidden" id="lng" name="lng" />
                    <input type="hidden" id="district" name="district" />
                    <input type="hidden" id="districtId" name="districtId" />
                    <h4 class="header-title mt-0">Lokasi</h4>
                    <h6 class="sub-title mb-3">Provinsi</h6>
                    <!-- Form Search Select Input -->
                    <select id="provinceSelect" class="form-control" style="width: 100%">
                        @foreach ($provinces as $prv)
                            <option value="{{ $prv->code }}">{{ $prv->name }}</option>
                        @endforeach
                    </select>
                    <h6 class="sub-title mb-3">Kabupaten / Kota</h6>
                    <!-- Form Search Select Input -->
                    <select id="kabupatenKotaSelect" class="form-control">

                    </select>
                    <h6 class="sub-title mb-3">Kecamatan</h6>
                    <!-- Form Search Select Input -->
                    <select id="kecamatanSelect" class="form-control">

                    </select>
                    <div id="selectedValue" class="mt-3"></div>
                    <div id="results"></div>
                    <div id="map"></div>
                    <div class="form-group mb-0">
                        <label class="mb-2 pb-1">Area/Kawasan</label>
                        <input type="text" name="area" class="form-control" value="{{ old('area') }}" required
                            placeholder="Area/Kawasan" />
                        @error('area')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-2 pb-1">Alamat Lengkap</label>
                        <textarea name="adres" id="" class="form-control" cols="30"
                            rows="10">{{ old('adres') }}</textarea>

                        @error('adres')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="text-align: right;">
                        <button class="btn btn-turquoise mt-2">Lanjut</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end col -->
</div>

<!-- Menambahkan JavaScript untuk Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var selectElement = document.getElementById('provinceSelect');
        var selectedValueDiv = document.getElementById('selectedValue');
        var kabupatenKotaSelect = document.getElementById('kabupatenKotaSelect');
        var kecamatanSelect = document.getElementById('kecamatanSelect');
        var map;

        selectElement.addEventListener('change', function () {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            kecamatanSelect.innerHTML = '';
            $('#kabupatenKotaSelect').load("{{ route('tool.selectKabupatenKota') }}?code=" + selectedOption.value);
        });

        kabupatenKotaSelect.addEventListener('change', function () {
            var selectedOption = kabupatenKotaSelect.options[kabupatenKotaSelect.selectedIndex];
            kecamatanSelect.innerHTML = '';
            $('#kecamatanSelect').load("{{ route('tool.kecamatanSelect') }}?code=" + selectedOption.value);
        });

        kecamatanSelect.addEventListener('change', function () {
            var selectedOption = kecamatanSelect.options[kecamatanSelect.selectedIndex];
            $.ajax({
                url: "{{ route('tool.showDistirct') }}",
                type: 'POST',
                data: {
                    code: selectedOption.value
                },
                success: function (response) {
                    var meta = JSON.parse(response.meta);
                    var lat = meta.lat;
                    var lng = meta.long;
                    var districtId = response.id;
                    var district = response.name;

                    // Memperbarui nilai input dengan data kecamatan yang dipilih oleh pengguna
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                    document.getElementById('districtId').value = districtId;
                    document.getElementById('district').value = district;
                    var elemen = document.getElementById('map');
                    elemen.style.width = '100%'; // Mengubah lebar menjadi 800px
                    elemen.style.height = '400px';
                    // Menghapus peta sebelumnya (jika ada) dan menampilkan peta baru dengan koordinat kecamatan yang dipilih
                    if (map) {
                        map.off(); // Menghapus semua event listener peta sebelumnya
                        map.remove();
                    }

                    map = L.map('map').setView([lat, lng], 13);

                    // Menambahkan layer OpenStreetMap ke peta
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Menambahkan marker pada posisi kecamatan yang dipilih
                    L.marker([lat, lng]).addTo(map);

                    // Menambahkan event listener untuk menangkap klik pada peta
                    map.on('click', function (e) {
                        var lat = e.latlng.lat;
                        var lng = e.latlng.lng;

                        // Memperbarui nilai input dengan koordinat yang dipilih oleh pengguna
                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;

                        // Menghapus marker sebelumnya (jika ada) dan menambahkan marker baru pada posisi yang dipilih oleh pengguna
                        map.eachLayer(function (layer) {
                            if (layer instanceof L.Marker) {
                                map.removeLayer(layer);
                            }
                        });

                        L.marker([lat, lng]).addTo(map);
                    });
                },
                error: function () {
                    $('#results').html('Error: Tidak dapat mengambil data');
                }
            });
        });
    });



</script>


<script>(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
        ({ key: "AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg", v: "beta" });</script>