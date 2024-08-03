<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Data User</h4>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>WhatsApp Phone</th>
                                    <th>Email</th>
                                    @if(Auth::user()->type != 'food' && Auth::user()->type != 'merchant')
                                    <th>Properti</th> 
                                    @endif
                                    <th>Food</th>
                                    <th>Marchant</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->wa_phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    @if(Auth::user()->type != 'food' && Auth::user()->type != 'merchant')
                                    <td><a href="{{route('admin.nav.pengguna.properti',$user->id)}}" class="btn btn-success">
                                            Properti
                                        </a></td> 
                                        @endif
                                    <td><a href="{{route('admin.nav.pengguna.food',$user->id)}}" class="btn btn-success">
                                            Food
                                        </a></td>
                                    <td><a href="{{route('admin.nav.pengguna.marchant',$user->id)}}" class="btn btn-success">
                                            Marchant
                                        </a></td>
                                    <td><a href="{{route('admin.nav.pengguna.detail',$user->id)}}" class="btn btn-success">
                                            Detail
                                        </a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endslot
</x-Layout.Vertical.Master>