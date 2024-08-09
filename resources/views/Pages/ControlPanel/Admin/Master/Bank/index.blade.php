<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Data Bank</h4>

                    <!-- Make the table responsive -->
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Bank</th>
                                    <th>Kode</th>
                                    <th>Tipe</th>
                                    <th>Nama Alias</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>Tipe Kantor</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Gambar</th>
                                    <th>Detail</th>
                                    <th>Status Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($bank as $key => $bk)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $bk->bank }}</td>
                                    <td>{{ $bk->code }}</td>
                                    <td>{{ $bk->type }}</td>
                                    <td>{{ $bk->alias_name }}</td>
                                    <td>{{ $bk->address }}</td>
                                    <td>{{ $bk->city }}</td>
                                    <td>{{ $bk->province }}</td>
                                    <td>{{ $bk->office_type }}</td>
                                    <td>{{ $bk->email }}</td>
                                    <td>{{ $bk->phone }}</td>
                                    <td>
                                        @if ($bk->image)
                                        <img src="{{ asset('storage/' . $bk->image) }}" alt="Bank Image" style="width: 50px; height: 50px;">
                                        @else
                                        <span>No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $bk->details }}</td>
                                    <td>{{ $bk->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <a href="{{ route('admin.nav.bank.edit', $bk->id) }}" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endslot
</x-Layout.Vertical.Master>