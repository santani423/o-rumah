<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        Setting Plan
                    </h4>


                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $key => $pln)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$pln->name}}</td>
                                    <td>
                                        <input type="number" class="form-control" value="">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" value="">
                                    </td>
                                    <td></td>
                                </tr>
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