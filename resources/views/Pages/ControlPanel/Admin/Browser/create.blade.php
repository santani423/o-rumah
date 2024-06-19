<x-Layout.Vertical.Master>
    @slot('body')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.nav.banner.store') }}" method="POST" enctype="multipart/form-data"
                class="form">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi:</label>
                    <input type="text" id="description" name="description" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL:</label>
                    <input type="text" id="url" name="url" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar:</label>
                    <input type="file" id="image" name="image" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="is_active" class="form-check-label">Aktif:</label>

                    <div class="checkbox my-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                data-parsley-multiple="groups" data-parsley-mincheck="2" />
                            <label class="custom-control-label" for="is_active"></label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="show_on" class="form-label">Tampilkan Pada:</label>
                    <select id="show_on" name="show_on" class="form-control">
                        <option value="homepage">Homepage</option>
                        <option value="food">Food</option>
                        <option value="marchent">Marchent</option>
                        <!-- Tambahkan opsi lain jika diperlukan -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Urutan:</label>
                    <input type="number" id="order" name="order" class="form-control">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Simpan Banner</button>
                </div>
            </form>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>