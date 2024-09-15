<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Jumlah View dari Iklan</title>
    <!-- Include Bootstrap CSS (optional) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h1>Laporan Jumlah View dari Iklan</h1>

        <!-- Form untuk memilih range tanggal -->
        <form action="" method="GET">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="startDate">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="startDate" name="start_date" value="{{ request()->start_date }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="endDate">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="endDate" name="end_date" value="{{ request()->end_date }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <!-- Tabel Bootstrap untuk menampilkan jumlah view -->
        <h3 class="mt-4">Tabel Jumlah View Iklan</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chartData as $data)
                    <tr>
                        <td>{{ $data[0] }}</td> <!-- Tanggal -->
                        <td>{{ $data[1] }}</td> <!-- Jumlah View -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="chart_div" class="mt-4"></div>
    </div>

    <!-- Load Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['line', 'corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        // Convert PHP array to JSON and ensure it's properly formatted
        var chartData = @json($chartData);

        function drawChart() {
            var chartDiv = document.getElementById('chart_div');
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Tanggal');
            data.addColumn('number', 'Jumlah View');

            // Ensure chartData is an array and process it
            if (Array.isArray(chartData)) {
                chartData.forEach(function(row) {
                    // Convert string date to Date object
                    var dateParts = row[0].split('-'); // Split 'YYYY-MM-DD'
                    var year = parseInt(dateParts[0]);
                    var month = parseInt(dateParts[1]) - 1; // Google Charts months are 0-based
                    var day = parseInt(dateParts[2]);
                    data.addRow([new Date(year, month, day), row[1]]);
                });
            } else {
                console.error('Chart data is not in a valid format');
            }

            var materialOptions = {
                chart: {
                    title: 'Laporan Jumlah View Iklan'
                },
                width: '100%',
                height: 500,
                hAxis: {
                    format: 'dd MMM yyyy', // Format tanggal
                    title: 'Tanggal'
                },
                vAxis: {
                    title: 'Jumlah View'
                }
            };

            var materialChart = new google.charts.Line(chartDiv);
            materialChart.draw(data, materialOptions);
        }
    </script>

</body>
</html>
