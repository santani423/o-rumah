<div class="container">
    <div class="form-group row">
        <label for="search-agent-input" class="col-sm-2 col-form-label">Cari Agent</label>
        <div class="col-sm-10">
            <input class="form-control" id="search-agent-input" type="text" oninput="searchAgent()" />
            <div id="agentResults" class="mt-3"></div>
        </div>
    </div>

    <div class="mt-5">
        <table id="titipAdsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Owner</th>
                    <th>Receiver</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="titipAdsList">
                <!-- List TitipAds akan dimuat di sini -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmAgentModal" tabindex="-1" role="dialog" aria-labelledby="confirmAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmAgentModalLabel">Konfirmasi Pilihan Agen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin memilih agen ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmAgentButton">Ya, Pilih Agen</button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedAgent = null;

    function searchAgent() {
        const inputValue = document.getElementById('search-agent-input').value;
        const agentResultsDiv = document.getElementById('agentResults');

        // Jika input kosong, kosongkan daftar agen dan keluar dari fungsi
        if (inputValue.trim() === '') {
            agentResultsDiv.innerHTML = '';
            return;
        }

        const url = "{{ route('agent.search') }}"; // Menggunakan route helper Laravel

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Jika menggunakan Laravel dengan perlindungan CSRF
            },
            body: JSON.stringify({ keyword: inputValue })
        })
        .then(response => response.json())
        .then(data => {
            agentResultsDiv.innerHTML = '';

            data.forEach(item => {
                const agentItem = document.createElement('div');
                agentItem.textContent = item.name;
                agentItem.classList.add('agent-item');

                // Tambahkan event listener untuk menangani klik
                agentItem.addEventListener('click', () => {
                    selectedAgent = item;
                    $('#confirmAgentModal').modal('show'); // Tampilkan modal konfirmasi
                });

                agentResultsDiv.appendChild(agentItem);
            });
        })
        .catch(error => {
            console.error('Error fetching agent data:', error);
        });
    }

    document.getElementById('confirmAgentButton').addEventListener('click', () => {
        if (selectedAgent) {
            const url = "{{ route('titip-ads.store') }}"; // Route untuk menyimpan data titip ads

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    ads_id: '{{$ads->ads_id}}',
                    user_owner_id: `{{Auth::user()->id}}`,
                    user_receiver_id: selectedAgent.id // Menggunakan ID agen yang dipilih
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    loadTitipAds(); // Muat ulang daftar TitipAd setelah berhasil menyimpan
                } else {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
                $('#confirmAgentModal').modal('hide'); // Sembunyikan modal setelah konfirmasi
            })
            .catch(error => {
                console.error('Error saving agent data:', error);
            });
        }
    });

    function loadTitipAds() {
        const url = "{{ route('titip-ads.list') }}"; // Route untuk mengambil daftar TitipAd

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            const titipAdsListDiv = document.getElementById('titipAdsList');
            titipAdsListDiv.innerHTML = '';

            data.forEach((item, index) => {
                const row = document.createElement('tr');
                
                const idCell = document.createElement('td');
                idCell.textContent = index + 1;
                row.appendChild(idCell);
                
                const ownerCell = document.createElement('td');
                ownerCell.textContent = item.owner.name;
                row.appendChild(ownerCell);
                
                const receiverCell = document.createElement('td');
                receiverCell.textContent = item.receiver.name;
                row.appendChild(receiverCell);
                
                const statusCell = document.createElement('td');
                statusCell.textContent = item.status;
                row.appendChild(statusCell);

                titipAdsListDiv.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching TitipAd data:', error);
        });
    }

    function addTitipAdToTable(titipAd) {
        const titipAdsListDiv = document.getElementById('titipAdsList');
        
        const row = document.createElement('tr');
        
        const idCell = document.createElement('td');
        idCell.textContent = titipAd.id;
        row.appendChild(idCell);
        
        const ownerCell = document.createElement('td');
        ownerCell.textContent = titipAd.owner.name;
        row.appendChild(ownerCell);
        
        const receiverCell = document.createElement('td');
        receiverCell.textContent = titipAd.receiver.name;
        row.appendChild(receiverCell);
        
        const statusCell = document.createElement('td');
        statusCell.textContent = titipAd.status;
        row.appendChild(statusCell);

        titipAdsListDiv.appendChild(row);
    }

    // Panggil fungsi loadTitipAds saat halaman dimuat
    document.addEventListener('DOMContentLoaded', loadTitipAds);
</script>

