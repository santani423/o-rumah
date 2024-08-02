<x-Layout.Vertical.Master>
    @slot('body')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>User Details</h2>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px;">
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                            <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone }}</li>
                            <li class="list-group-item"><strong>WhatsApp Phone:</strong> {{ $user->wa_phone }}</li>
                            <li class="list-group-item"><strong>Address:</strong> {{ $user->address }}</li>
                            <li class="list-group-item"><strong>Type:</strong> {{ $user->type }}</li>
                            <li class="list-group-item"><strong>Active Status:</strong> 
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </li>
                        </ul>

                        <div class="text-center mt-4">
                            <form action="{{ route('admin.users.toggleActive', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $user->is_active ? 'btn-success' : 'btn-danger' }}">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>
