<x-Layout.Horizontal.Master>
    @slot('body')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Update Password</h3>
                    <div id="response-alert" class="alert" style="display:none;" role="alert"></div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('password.change.update', $passwordChanges) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Masukkan password baru Anda">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required placeholder="Masukkan konfirmasi password Anda">
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Horizontal.Master>