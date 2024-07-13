<!-- HTML -->
<div class="container">
    <div class="form-group row">
        <label for="search-agent-input" class="col-sm-2 col-form-label">Cari Agent</label>
        <div class="col-sm-10">
            <input class="form-control" id="search-agent-input" type="text" oninput="searchAgent()" />
            <div id="agentResults" class="mt-3"></div>
        </div>
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
            console.log('Agen yang dipilih:', selectedAgent);
            $('#confirmAgentModal').modal('hide');  
        }
    });
</script>
