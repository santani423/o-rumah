<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<div class="row">
    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        @if($ads->title)
            <h5> {{ $ads->title }}</h5>
        @endif
        @if($ads->price)
            <h5 style="color: blue;">Rp. {{  number_format($ads->price, 0, ',', '.') }}</h5>
        @endif
        @if($ads->address)
            <p> {{ $ads->address }}</p>
        @endif
        @if($ads->area)
            <p> {{ $ads->area }} </p>
        @endif
    </div>
    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        <h5>Informasi Properti</h5>
        <table class="table">
            <tbody>
                @if($ads->year_built)
                    <tr>
                        <td class="col-3">Tahun DI Bangun</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->year_built }}</td>
                    </tr>
                @endif
                @if($ads->jk)
                    <tr>
                        <td class="col-3">Kamar Tidur</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->jk }}</td>
                    </tr>
                @endif
                @if($ads->jkm)
                    <tr>
                        <td class="col-3">Kamar Mandi</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->jkm }}</td>
                    </tr>
                @endif
                @if($ads->jl)
                    <tr>
                        <td class="col-3">Jumlah Lantai</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->jl }}</td>
                    </tr>
                @endif
                @if($ads->lt)
                    <tr>
                        <td class="col-3">Luas Tanah</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->lt }} m²</td>
                    </tr>
                @endif
                @if($ads->lb)
                    <tr>
                        <td class="col-3">Luas Bangunan</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->lb }} m²</td>
                    </tr>
                @endif
                @if($ads->dl)
                    <tr>
                        <td class="col-3">Daya Listrik</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->dl }}</td>
                    </tr>
                @endif
                @if($ads->sertifikat)
                    <tr>
                        <td class="col-3">Sertifikat</td>
                        <td class="col-1">:</td>
                        <td>{{ $ads->sertifikat }}</td>
                    </tr>
                @endif 
                @if($ads->house_facility)
                                @php
                                    $facilities = json_decode($ads->house_facility, true);
                                @endphp
                                @if(is_array($facilities))
                                    <tr>
                                        <td class="col-3">Kondisi Perabotan</td>
                                        <td class="col-1">:</td>
                                        <td>
                                            <ul>
                                                @foreach($facilities as $facility)
                                                    <li>{{ $facility }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endif
                @endif
                <tr>
                    <td class="col-3">Kondisi Perabotan</td>
                    <td class="col-1">:</td>
                    <td>{{ $ads->furniture_condition }}</td>
                </tr>

                @if($ads->other_facility)
                                @php
                                    $facilities = json_decode($ads->other_facility, true);
                                @endphp
                                @if(is_array($facilities))
                                    <tr>
                                        <td class="col-3">Kondisi Perabotan</td>
                                        <td class="col-1">:</td>
                                        <td>
                                            <ul>
                                                @foreach($facilities as $facility)
                                                    <li>{{ $facility }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endif
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        <h5>Deskripsi</h5>
        {!!$ads->description!!}
    </div>
    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        <h5>MAP</h5>
        <div id="propertyMap" style="height: 300px;"></div>
        @if ($ads->video)

            <h5>YouTube</h5>
            <iframe width="560" height="315" src="{{ $ads->video }}" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        @endif

    </div>
</div>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('propertyMap').setView([{{ $ads->lat }}, {{ $ads->lng }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $ads->lat }}, {{ $ads->lng }}]).addTo(map);
    });
</script>