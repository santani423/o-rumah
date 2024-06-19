<x-Layout.Vertical.Master>
    @slot('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        document.getElementById('upload').addEventListener('change', handleFile, false);

        function handleFile(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (event) {
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                // Get the first sheet name
                const sheetName = workbook.SheetNames[0];
                // Convert the first sheet to JSON
                const sheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(sheet);

                const tableHtml = `
                    <div class="table-responsive-sm">
                      <table class="table">
                        <thead>
                          <tr> 
                            <th scope="col">Kode KPR</th>
                            <th scope="col">Nama Pengajuan</th>
                            <th scope="col">No HP Visitor</th>
                            <th scope="col">Nama File KTP</th>
                            <th scope="col">Status</th>
                            <th scope="col">Proses</th>
                          </tr>
                        </thead> 
                        <tbody id="bodyResponse"></tbody>
                      </table>
                    </div>
                `;
                $('#responseKprBank').html(tableHtml);

                jsonData.forEach(function (obj) {
                    $.ajax({
                        url: `{{route('admin.pengajuan.kpr.upload.xlxs')}}`,
                        type: 'GET',
                        data: {
                            tanggal: obj.Tanggal,
                            kodeKpr: obj["Kode KPR"],
                            namaPengajuan: obj["Nama Pengajuan"],
                            noVisitor: obj["No HP Visitor"],
                            fileKtp: obj["Nama File KTP"],
                            status: obj.Status,
                            proses: obj.Proses,
                        },
                        success: function (response) {
                            var statusClass = response.error ? 'warning' : 'success';
                            const dataTable = `
                                <tr class="table-${statusClass}"> 
                                    <td>${obj["Kode KPR"]}</td>
                                    <td>${obj["Nama Pengajuan"]}</td>
                                    <td>${obj["No HP Visitor"]}</td>
                                    <td>${obj["Nama File KTP"]}</td>
                                    <td>${obj.Status}</td>
                                    <td>${obj.Proses}</td>
                                </tr>`;
                            $('#bodyResponse').append(dataTable);
                            if (!response.error) {
                                $.ajax({
                                    url: `{{route('admin.email.responseBackPengajuanKpr')}}`,
                                    type: 'GET',
                                    data: {
                                        kpr_id: response.kpr_id,
                                    },
                                    success: function (rsp) {
                                        console.log('tes fun email', rsp);
                                    },
                                    error: function () {
                                        $('#results').html('Error: Tidak dapat mengambil data');
                                    }
                                });
                            }
                        },
                        error: function () {
                            $('#results').html('Error: Tidak dapat mengambil data');
                        }
                    });
                });
            };

            reader.readAsArrayBuffer(file);
        }

        $(document).on('click', '#generateJson', function () {
            const selectedRows = $('input[name="selectRow"]:checked').closest('tr');
            if (selectedRows.length > 0) {
                const selectedData = [];
                selectedRows.each(function () {
                    const row = $(this).closest('tr');
                    selectedData.push({
                        kodeKpr: row.find('td').eq(1).text(),
                        namaPengajuan: row.find('td').eq(2).text(),
                        noVisitor: row.find('td').eq(3).text(),
                        fileKtp: row.find('td').eq(4).text(),
                        status: row.find('td').eq(5).text(),
                        proses: row.find('td').eq(6).text()
                    });
                });
                console.log(JSON.stringify(selectedData));
            } else {
                alert("No rows selected");
            }
        });

        $(document).on('click', '#downloadExcel', function () {
            const selectedRows = $('input[name="selectRow"]:checked').closest('tr');
            if (selectedRows.length > 0) {
                const selectedData = [];
                selectedRows.each(function () {
                    const row = $(this).closest('tr');
                    selectedData.push({
                        "Kode KPR": row.find('td').eq(1).text(),
                        "Nama Pengajuan": row.find('td').eq(2).text(),
                        "No HP Visitor": row.find('td').eq(3).text(),
                        "Nama File KTP": null,
                        "Status": null,
                        "Proses": null
                    });
                });

                const worksheet = XLSX.utils.json_to_sheet(selectedData);
                const newWorkbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(newWorkbook, worksheet, 'Sheet1');
                XLSX.writeFile(newWorkbook, 'SelectedData.xlsx');
            } else {
                alert("No rows selected");
            }
        });
    </script>
    @endslot
    @slot('body')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="pr-1">Select</th>
                            <th class="pr-1">Code</th>
                            <th class="pr-1">Ads ID</th>
                            <th class="pr-1">User ID</th>
                            <th class="pr-1">Bank ID</th>
                            <th class="pr-1">Bank BPR ID</th>
                            <th class="pr-1">Job ID</th>
                            <th class="pr-2">Nama</th>
                            <th class="pr-2">Email</th>
                            <th class="pr-1">Telepon</th>
                            <th class="pr-2">Pekerjaan</th>
                            <th class="pr-1">Status</th>
                            <th class="pr-2">Nama Agen</th>
                            <th class="pr-2">Nama Bank Umum</th>
                            <th class="pr-2">Email Bank Umum</th>
                            <th class="pr-2">Nama Bank BPR</th>
                            <th class="pr-2">Email Bank BPR</th>
                            <th class="pr-2">Dibuat Pada</th>
                            <th class="pr-2">Diperbarui Pada</th>
                            <th class="pr-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kpr as $item)
                            <tr>
                                <td><input type="checkbox" name="selectRow" class="selectRow"></td>
                                <td>{{ $item->uuid }}</td>
                                <td>{{ $item->ads_id }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->bank_id }}</td>
                                <td>{{ $item->bank_bpr_id }}</td>
                                <td>{{ $item->job_id }}</td>
                                <td>{{ $item->kpr_name }}</td>
                                <td>{{ $item->kpr_email }}</td>
                                <td>{{ $item->kpr_phone }}</td>
                                <td>{{ $item->kpr_occupation }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->namaAgen }}</td>
                                <td>{{ $item->bank_umum_name }}</td>
                                <td>{{ $item->bank_umum_email }}</td>
                                <td>{{ $item->bank_bpr_name }}</td>
                                <td>{{ $item->bank_bpr_email }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td><a href="{{route('admin.pengajuan.kpr.detail', ['id' => $item->id])}}"
                                        class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <h6>Input response bank</h6>
            <input type="file" id="upload" class="form-control" accept=".xlsx, .xls" />
            <div id="responseKprBank"></div>
            <button id="downloadExcel" class="btn btn-success">Download Excel</button>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>