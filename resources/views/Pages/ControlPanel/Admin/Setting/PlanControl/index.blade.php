<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        Setting Plan
                    </h4>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Klik</th>
                                <th>Nilai</th>
                                <th>Description</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $pln)
                                <form action="{{route('admin.nav.ads.control-panel.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$pln->id}}">
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$pln->code}}</td>
                                        <td>{{$pln->title}}</td>
                                        <td>
                                            <input type="number" name="klik" class="form-control" value="{{$pln->klik}}">
                                        </td>
                                        <td>
                                            <input type="number" name="nilai" class="form-control" value="{{$pln->nilai}}">
                                        </td>
                                        <td>
                                            <input type="text" name="description" class="form-control"
                                                value="{{$pln->description}}">
                                        </td>
                                        <td>
                                            <button class="btn btn-primary">Simpan</button>
                                        </td>
                                    </tr>
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    @endslot
</x-Layout.Vertical.Master>