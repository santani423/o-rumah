<x-Layout.Vertical.Master>
    @slot('body')
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Limit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $adsType)
                                <tr>
                                    <td>{{ ++$key}}</td>
                                    <td>{{ $adsType->code }}</td>
                                    <td>{{ $adsType->slug }}</td>
                                    <td>{{ $adsType->type }}</td>
                                    <td>
                                        <form action="{{ route('admin.nav.ads.control-booster.update', $adsType->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="title" value="{{ $adsType->title }}" class="form-control">
                                    </td>
                                    <td>
                                            <input type="text" name="limit" value="{{ $adsType->limit }}" class="form-control">
                                    </td>
                                    <td>
                                            <button type="submit" class="btn btn-sm btn-success">Edit</button>
                                        </form>
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
