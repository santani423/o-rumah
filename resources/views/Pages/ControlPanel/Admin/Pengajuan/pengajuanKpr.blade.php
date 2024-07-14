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
                            <th >Tanggal</th>
                            <th class="pr-1">Kode KPR</th> 
                            <th class="pr-2">Nama Agen</th> 
                            <th class="pr-2">Nama</th>
                            <th class="pr-2">Email</th>
                            <th class="pr-1">Telepon</th>
                            <th class="pr-2">Nama Bank Umum</th>
                            <th class="pr-2">Email Bank Umum</th>
                            <th class="pr-2">Nama Bank BPR</th>
                            <th class="pr-2">Email Bank BPR</th>  
                            <th class="pr-2">Status</th>
                            <th class="pr-2">Proses</th>
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
                            proses: obj["Status"],
                            status: obj["Proses"],  
                        },
                        success: function (response) {
                            console.log(response);
                            var statusClass = response.error ? 'warning' : 'success';
                            const dataTable = `
                                <tr class="table-${statusClass}"> 
                                    <td>${obj["Tanggal"]}</td>
                                    <th class="pr-1">${obj["Kode KPR"]}</th> 
                                    <th class="pr-2">${obj["Nama Agent"]}</th> 
                                    <th class="pr-2">${obj["Nama Pengajuan"]}</th>
                                    <th class="pr-2">${obj["Email"]}</th>
                                    <th class="pr-1">${obj["No HP Visitor"]}</th>
                                    <th class="pr-2">${obj["Nama Bank"]}</th>
                                    <th class="pr-2">${obj["Email PIC Bank"]}</th>
                                    <th class="pr-2">${obj["Bank BPR"]}</th>
                                    <th class="pr-2">${obj["Email PIC Bank BPR"]}</th> 
                                    <th class="pr-2">${obj["Status"]}</th> 
                                    <th class="pr-2">${obj["Proses"]}</th>  
                                </tr>`;
                            $('#bodyResponse').append(dataTable);
                            // if (!response.error) {
                            //     $.ajax({
                            //         url: `{{route('admin.email.responseBackPengajuanKpr')}}`,
                            //         type: 'GET',
                            //         data: {
                            //             kpr_id: response.kpr_id,
                            //         },
                            //         success: function (rsp) {
                            //             console.log('tes fun email', rsp);
                            //         },
                            //         error: function () {
                            //             $('#results').html('Error: Tidak dapat mengambil data');
                            //         }
                            //     });
                            // }
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
                        "Tanggal": row.find('td').eq(1).text(),
                        "Kode KPR": row.find('td').eq(2).text(),
                        "Nama Agent": row.find('td').eq(3).text(),
                        "Nama Pengajuan": row.find('td').eq(4).text(),
                        "Email": row.find('td').eq(5).text(),  
                        "No HP Visitor": row.find('td').eq(6).text(),  
                        "Nama Bank": row.find('td').eq(7).text(),  
                        "Email PIC Bank": row.find('td').eq(8).text(),  
                        "Bank BPR": row.find('td').eq(9).text(),  
                        "Email PIC Bank BPR": row.find('td').eq(10).text(),  
                        "Status":null,  
                        "Proses":null,  
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
                            <th >Tanggal</th>
                            <th class="pr-1">Kode KPR</th>
                            <!-- <th class="pr-1">Ads ID</th>
                            <th class="pr-1">User ID</th>
                            <th class="pr-1">Bank ID</th>
                            <th class="pr-1">Bank BPR ID</th>
                            <th class="pr-1">Job ID</th> -->
                            <th class="pr-2">Nama Agen</th> 
                            <th class="pr-2">Nama</th>
                            <th class="pr-2">Email</th>
                            <th class="pr-1">Telepon</th>
                            <th class="pr-2">Nama Bank Umum</th>
                            <th class="pr-2">Email Bank Umum</th>
                            <th class="pr-2">Nama Bank BPR</th>
                            <th class="pr-2">Email Bank BPR</th>
                            <!-- <th class="pr-2">Pekerjaan</th> -->
                            <th class="pr-1">Status</th>
                            <th class="pr-2">Dibuat Pada</th>
                            <th class="pr-2">Diperbarui Pada</th>
                            <th class="pr-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kpr as $item)
                            <tr>
                                <td><input type="checkbox" name="selectRow" class="selectRow"></td>
                                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                                <td>{{ $item->uuid }}</td>
                                <!-- <td>{{ $item->ads_id }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->bank_id }}</td>
                                <td>{{ $item->bank_bpr_id }}</td>
                                <td>{{ $item->job_id }}</td> -->
                                <td>{{ $item->namaAgen }}</td>
                                <td>{{ $item->kpr_name }}</td>
                                <td>{{ $item->kpr_email }}</td>
                                <td>{{ $item->kpr_phone }}</td>
                                <td>{{ $item->bank_umum_name }}</td>
                                <td>{{ $item->bank_umum_email }}</td>
                                <td>{{ $item->bank_bpr_name }}</td>
                                <td>{{ $item->bank_bpr_email }}</td>
                                <!-- <td>{{ $item->kpr_occupation }}</td> -->
                                <td>{{ $item->status }}</td>
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