<x-Layout.Horizontal.Master>


    @slot('body')
    <div class="card">
        <div class="card-header">
            Daftar Properti
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Type</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favorits as $property)
                        <tr>
                            <td>{{ $property['title'] }}</td>
                            <td>{{ $property['slug'] }}</td>
                            <td>{{ $property['type'] }}</td>
                            <td><img src="{{ $property['image'] }}" alt="Image Properti" style="width: 100px;"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @endslot
</x-Layout.Horizontal.Master>