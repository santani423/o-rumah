<x-Layout.Vertical.Master>
    @slot('body')
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th> 
                            <th>Gambar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subKategoris as $index => $supKtg)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $supKtg->nama }}</td> 
                                <td><img src="@if($supKtg->gambar) {{asset($supKtg->gambar)}} @else {{asset('/assets/icons/homeIconbg6.png')}} @endif" alt="{{$supKtg->nama}}" style="width: 50px; height: 50px;"></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $supKtg->id }}">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($subKategoris as $supKtg)
            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $supKtg->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $supKtg->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $supKtg->id }}">Edit Sub Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.nav.subKategoriAds.update', $supKtg->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $supKtg->nama }}" required>
                                </div>
                                 
                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar">
                                    <img src="{{ asset('path/to/images/' . $supKtg->gambar) }}" alt="{{ $supKtg->nama }}" style="width: 50px; height: 50px; margin-top: 10px;">
                                </div>
                                <button type="submit" class="btn btn-success">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endslot
</x-Layout.Vertical.Master>
