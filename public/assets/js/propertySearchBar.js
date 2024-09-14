// Fungsi untuk menampilkan lokasi sampel saat mengetik pencarian lokasi
function showSampleLocations(inputValue) {
    if (inputValue.length < 2) {
        document.getElementById('sampleLocations').innerHTML = '';
        return;
    }

    fetch(`{{route('tool.searchDistricts')}}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ keyword: inputValue })
    })
    .then(response => response.json())
    .then(data => {
        const sampleLocationsDiv = document.getElementById('sampleLocations');
        sampleLocationsDiv.innerHTML = '';

        data.forEach(item => {
            const locationItem = document.createElement('div');
            locationItem.textContent = item.name;
            locationItem.classList.add('sample-location-item');
            
            locationItem.addEventListener('click', () => {
                $('#searchLok').val(item.name);
                latitude = item.meta.lat;
                longitude = item.meta.long;
                districtId = item.id;
                sampleLocationsDiv.innerHTML = '';
                currentPage = 1;
                loadAgents(currentPage); // Memuat agen berdasarkan distrik yang dipilih
            });

            sampleLocationsDiv.appendChild(locationItem);
        });
    })
    .catch(error => {
        console.error('Error fetching location data:', error);
    });
}

// Fungsi untuk mencari lokasi
function searchLocation() {
    console.log('Lokasi yang dicari:', locationText);
    $('#adsListsWithDistance').html(''); // Kosongkan daftar agen
    currentPage = 1;
    loadAgents(currentPage);
}

// Fungsi untuk memuat lebih banyak agen
function loadMoreAgents() {
    currentPage++;
    loadAgents(currentPage); // Muat halaman berikutnya
}

// Menangani submit dari form pencarian
$(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah form submit secara default
        searchLocation(); // Panggil fungsi pencarian lokasi
    });
});