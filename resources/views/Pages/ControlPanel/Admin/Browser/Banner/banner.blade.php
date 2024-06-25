<x-Layout.Vertical.Master>
    @slot('body')
    <div class="card">
        <div class="card-header">
            Banner

            <a href="{{route('admin.nav.banner.create')}}" class="btn btn-primary float-right">Tambah Banner</a>
        </div>
        <div class="card-body">
        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>URL</th>
                            <th>Gambar</th>
                            <th>Aktif</th>
                            <th>Tampilkan Pada</th>
                            <th>Urutan</th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $key => $banner)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $banner->name }}</td>
                                <td>{{ $banner->description }}</td>
                                <td>{{ $banner->url }}</td>
                                <td><img src="{{asset('storage/' . $banner->image) }}" alt="Banner Image"
                                        style="width: 100px;"></td>
                                <td>{{ $banner->is_active ? 'Ya' : 'Tidak' }}</td>
                                <td>{{ $banner->show_on }}</td>
                                <td>{{ $banner->order }}</td>
                                <td>
                                    <a href="{{route('admin.nav.banner.edit',$banner->id)}}" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>