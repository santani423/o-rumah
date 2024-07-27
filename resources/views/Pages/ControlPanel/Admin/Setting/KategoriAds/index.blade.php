<x-Layout.Vertical.Master>
    @slot('body')
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Gambar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>{{ $kategori->tipe }}</td>
                                <td><img src="{{ asset('path/to/images/' . $kategori->gambar) }}" alt="{{ $kategori->nama }}" style="width: 50px; height: 50px;"></td>
                                <td>
                                    <a href="{{route('admin.nav.subKategoriAds',$kategori->id)}}" class="btn btn-success">Sub Kategori</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endslot
</x-Layout.Vertical.Master>
