<x-Layout.Vertical.Master title="Wilayah Kerja">
    @slot('body')
  
    <!-- <h1>Daftar Wilayah Kerja</h1> -->
    <a href="{{route('listing.control-panel.wilayah-kerja.create')}}" class="btn btn-success mt-3">Tambah Wilayah Kerja</a>

    <!-- Card Wrapper -->
    <div class="card mt-3">
        <div class="card-header">
            Daftar Wilayah Kerja
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama District</th>
                        <th>Area</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($wilayahKerjas as $key => $wilayahKerja)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $wilayahKerja->district_name }}</td>
                        <td>{{ $wilayahKerja->area }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End of Card Wrapper -->
 
    @endslot
</x-Layout.Vertical.Master>
