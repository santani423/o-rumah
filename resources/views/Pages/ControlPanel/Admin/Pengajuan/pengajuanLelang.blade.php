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
                            <th scope="col">Kode Lelang</th>
                            <th scope="col">Nama Agent</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Agency</th>
                            <th scope="col">Nama Pengajuan</th>
                            <th scope="col">No HP Visitor</th>
                            <th scope="col">Nama File</th>
                            <th scope="col">Proses</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead> 
                        <tbody id="bodyResposnse"></tbody>
                      </table>
                    </div>
                  `;
                $('#responseKprBank').html(tableHtml);
                jsonData.forEach(function (obj) {
                    console.log("Data Pengajuan:");
                    console.log("----------------------");
                    $.ajax({
                        url: `{{route('admin.pengajuan.kpr.upload.xlxs')}}`,
                        type: 'get',
                        data: {
                            tanggal: obj.Tanggal,
                            kodeLelang: obj["Kode Lelang"],
                            namaAgent: obj["Nama Agent"],
                            namaAgent: obj["No HP"],
                            namaAgent: obj["Agency"],
                            noVisitor: obj["Nama Pengajuan"],
                            fileKtp: obj["No Hp Visitor"],
                            status: obj.Status,
                            proses: obj.Proses,
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.error) {

                                var status = 'warning';
                            } else {
                                var status = 'success';

                            }
                            const dataTable = `<tr class="table-${status}">  
                                                <td >${obj["Kode KPR"]}</td>
                                                <td >${obj["Nama Pengajuan"]}</td>
                                                <td >${obj["No HP Visitor"]}</td>
                                                <td >${obj["Nama FIle KTP"]}</td>
                                                <td >${obj.Status}</td>
                                                <td >${obj.Proses}</td>
                                            </tr > `;
                            $('#bodyResposnse').append(dataTable);
                        },
                        error: function () {
                            $('#results').html('Error: Tidak dapat mengambil data');
                        }
                    });
                });



            };

            reader.readAsArrayBuffer(file);
        }

        $(document).on('click', '#downloadExcel', function () {
            const selectedRows = $('input[name="selectRow"]:checked').closest('tr');
            if (selectedRows.length > 0) {
                const selectedData = [];
                selectedRows.each(function () {
                    const row = $(this).closest('tr');
                    selectedData.push({
                        "Tanggal": row.find('td').eq(1).text(),
                        "Kode Lelang": row.find('td').eq(2).text(),
                        "Nama Agent": row.find('td').eq(3).text(),
                        "No HP ": row.find('td').eq(4).text(),
                        "Agency": row.find('td').eq(5).text(),
                        "Nama Pengajuan": row.find('td').eq(6).text(),
                        "No Hp Visitor  ": row.find('td').eq(7).text(),
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
                            <th>Tanggal</th>
                            <th>ID Lelang</th>
                            <th>Nama Agen</th>
                            <th>No HP</th>
                            <th>Agency</th>
                            <th>Nama Pengajuan</th>
                            <th>No HP VIsitor</th>  
                            <th>Proses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuanLelang as $lelang)
                            <tr>
                            <td><input type="checkbox" name="selectRow" class="selectRow"></td>
                            <td>{{ $lelang->created_at }}</td>
                                <td>{{ $lelang->uuid }}</td>
                                <td>{{ $lelang->namaAgen }}</td>
                                <td>{{ $lelang->wa_phone }}</td>
                                <td>{{ $lelang->company_name }}</td>
                                <td>{{ $lelang->kpr_name }}</td>
                                <td>{{ $lelang->kpr_phone }}</td> 
                                <td>{{ $lelang->status }}</td>
                                <td><a href="{{route('admin.pengajuan.lelang.detail', ['id' => $lelang->id])}}"
                                        class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <h6>Input response bank </h6>
            <input type="file" id="upload" class="form-control" accept=".xlsx, .xls" />
            <div id="responseKprBank"></div>
            <button id="downloadExcel" class="btn btn-success">Download Excel</button>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>