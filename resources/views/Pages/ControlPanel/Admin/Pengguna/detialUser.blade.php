<x-Layout.Vertical.Master>
    @slot('body')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header text-center">
                        <h2>Detail Pengguna</h2>
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
                            <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
                            <li class="list-group-item"><strong>Nama Pengguna:</strong> {{ $user->username }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                            <li class="list-group-item"><strong>Telepon:</strong> {{ $user->phone }}</li>
                            <li class="list-group-item"><strong>Telepon WhatsApp:</strong> {{ $user->wa_phone }}</li>
                            <li class="list-group-item"><strong>Alamat:</strong> {{ $user->address }}</li>
                            <li class="list-group-item"><strong>Tipe:</strong> {{ $user->type }}</li>
                            <li class="list-group-item"><strong>Status Aktif:</strong> 
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </li>
                        </ul>

                        <div class="text-center mt-4">
                            <form action="{{ route('admin.users.toggleActive', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $user->is_active ? 'btn-success' : 'btn-danger' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Pengguna
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- User Property Statistics Card -->
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Statistik Properti Pengguna</h3>
                    </div>
                    <div class="card-body">
                        @if ($UserPropertyStatistics)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Total Properti:</strong> {{ $UserPropertyStatistics->total_properties }}</li>
                                <li class="list-group-item"><strong>Properti Terjual/Tersewa:</strong> {{ $UserPropertyStatistics->sold_rented_properties }}</li>
                                <li class="list-group-item"><strong>Harga Rata-rata:</strong> Rp{{ number_format($UserPropertyStatistics->average_price, 2) }}</li>
                            </ul>

                            <!-- Form to Update Property Statistics -->
                            <form action="{{ route('admin.users.updateStatistics', $user->id) }}" method="POST" class="mt-4">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="total_properties">Total Properti</label>
                                    <input type="number" class="form-control" id="total_properties" name="total_properties" value="{{ $UserPropertyStatistics->total_properties }}">
                                </div>
                                <div class="form-group">
                                    <label for="sold_rented_properties">Properti Terjual/Tersewa</label>
                                    <input type="number" class="form-control" id="sold_rented_properties" name="sold_rented_properties" value="{{ $UserPropertyStatistics->sold_rented_properties }}">
                                </div>
                                <div class="form-group">
                                    <label for="average_price">Harga Rata-rata</label>
                                    <input type="number" step="0.01" class="form-control" id="average_price" name="average_price" value="{{ $UserPropertyStatistics->average_price }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Perbarui Statistik</button>
                            </form>
                        @else
                            <p class="text-center">Tidak ada statistik untuk pengguna ini.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>
