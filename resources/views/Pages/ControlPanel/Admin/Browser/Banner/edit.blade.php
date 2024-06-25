<x-Layout.Vertical.Master>
    @slot('body')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.nav.banner.updated', $banner->id) }}" method="POST" enctype="multipart/form-data"
                class="form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $banner->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi:</label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ $banner->description }}">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL:</label>
                    <input type="text" id="url" name="url" class="form-control" value="{{ $banner->url }}">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar:</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <img src="{{ $banner->image_url }}" alt="Current Image" class="mt-2" style="width: 150px;">
                </div>
                <div class="mb-3">
                    <label for="is_active" class="form-check-label">Aktif:</label>

                    <div class="checkbox my-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                data-parsley-multiple="groups" data-parsley-mincheck="2" {{ $banner->is_active ? 'checked' : '' }} />
                            <label class="custom-control-label" for="is_active"></label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="show_on" class="form-label">Tampilkan Pada:</label>
                    <select id="show_on" name="show_on" class="form-control">
                        <option value="homepage" {{ $banner->show_on == 'homepage' ? 'selected' : '' }}>Homepage</option>
                        <option value="food" {{ $banner->show_on == 'food' ? 'selected' : '' }}>Food</option>
                        <option value="marchent" {{ $banner->show_on == 'marchent' ? 'selected' : '' }}>Marchent</option>
                        <!-- Tambahkan opsi lain jika diperlukan -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Urutan:</label>
                    <input type="number" id="order" name="order" class="form-control" value="{{ $banner->order }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Perbarui Banner</button>
                </div>
            </form>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>
