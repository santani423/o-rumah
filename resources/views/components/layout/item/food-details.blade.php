<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<div class="row">
    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        <h5> {{ $ads->title }}</h5>
        <h5 style="color: blue;">Rp. {{  number_format($ads->price, 0, ',', '.') }}</h5>
        <p> {{ $ads->address }}</p>
        <p> {{ $ads->area }} </p>
    </div>

    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        <h5>Deskripsi</h5>
        {!!$ads->description!!}
    </div>
    <div class="col-lg-12" style="border-bottom: 1px solid #ccc;">
        <h5>MAP</h5>
        <div id="propertyMap" style="height: 300px;"></div>
    </div>
</div>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('propertyMap').setView([{{ $ads->districtLocation_lat }}, {{ $ads->districtLocation_long }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $ads->lat }}, {{ $ads->lng }}]).addTo(map);
    });
</script>