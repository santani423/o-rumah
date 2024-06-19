<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        Hoverable rows
                    </h4>
                    <div class="text-right"><a href="{{route('admin.nav.bank.add')}}" class="btn btn-primary">Tambah
                            Bank</a>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-hover">
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
                                @foreach ($bank as $bk)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{$bk->bank}}</td>
                                        <td>{{$bk->code}}</td>
                                        <td>{{$bk->type}}</td>
                                        <td>{{$bk->alias_name}}</td>
                                        <td>{{$bk->address}}</td>
                                        <td>{{$bk->city}}</td>
                                        <td>{{$bk->province}}</td>
                                        <td>{{$bk->office_type}}</td>
                                        <td>{{$bk->email}}</td>
                                        <td>{{$bk->phone}}</td>
                                        <td>{{$bk->image}}</td>
                                        <td>{{$bk->details}}</td>
                                        <td>{{$bk->is_active}}</td>
                                        <td><a href="{{route('admin.nav.bank.edit', $bk->id)}}"
                                                class="btn btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    @endslot
</x-Layout.Vertical.Master>