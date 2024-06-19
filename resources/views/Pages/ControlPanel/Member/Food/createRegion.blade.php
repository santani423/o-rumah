<x-Layout.Vertical.Master>



    @slot('css')
    <!-- Menambahkan CSS untuk Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        #map {
            height: 100%;
        }
    </style>
    @endslot

    @slot('js')
    <!-- Menambahkan JavaScript untuk Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        $(document).ready(function () {
            var map; // Variabel untuk menyimpan referensi peta

            $('#searchInput').select2({
                placeholder: 'Masukkan nilai pencarian...',
                ajax: {
                    url: '{{ route('tool.searchAds') }}',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return { id: item.code, text: item.name };
                            })
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function (e) {
                var data = e.params.data;
                $.ajax({
                    url: '{{ route('tool.showDistirct') }}',
                    type: 'POST',
                    data: {
                        code: data.id
                    },
                    success: function (response) {
                        console.log(response)
                        var meta = JSON.parse(response.meta);
                        if (map) {
                            map.remove();
                        }

                        document.getElementById('lat').value = meta.lat;
                        document.getElementById('lng').value = meta.long;
                        document.getElementById('districtId').value = response.id;
                        document.getElementById('district').value = response.name;
                        initMap(meta.lat, meta.long);
                    },
                    error: function () {
                        $('#results').html('Error: Tidak dapat mengambil data');
                    }
                });
            });

            function initMap(lat, lng) {
                $('#map').css({ height: '500px', width: '100%' });
                console.log("Inisialisasi peta dengan koordinat:", lat, lng);
                map = L.map('map').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                L.marker([lat, lng]).addTo(map);
            }
        });

        // Initialize and add the map
        let map;

        async function initMap() {
            // The location of Uluru
            const position = { lat: -25.344, lng: 131.031 };
            // Request needed libraries.
            //@ts-ignore
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 4,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerView({
                map: map,
                position: position,
                title: "Uluru",
            });
        }

        initMap();
    </script>
    <script>(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
            ({ key: "AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg", v: "beta" });</script>

    @endslot
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Pasang Iklan</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-Layout.Item.PropertyRegionForm :url="route('member.food.store-listing')">
    </x-Layout.Item.PropertyRegionForm>
    @endslot
</x-Layout.Vertical.Master>