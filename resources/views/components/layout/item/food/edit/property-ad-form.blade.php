<style>
    .char-count {
        margin-top: 5px;
        color: #555;
    }
</style>

<div class="card">
    <div class="card-body">
        <h4 class="card-title font-20 mt-0">Edit Iklan</h4>
      
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="judulIklan">Judul Iklan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judulIklan" name="title"
                            placeholder="Masukkan Judul Iklan" value="{{ old('title', $ads['title'] ?? '') }}">
                        <!-- Menampilkan error untuk judul iklan -->
                        <div id="cektitle" class="text-danger"></div>
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deskripsiIklan">Deskripsi Iklan <span class="text-danger">*</span></label>
                        <textarea class="summernote" id="descriptionIklan" name="description"
                            onkeyup="updateCharCount()">{!! old('description', $ads['description'] ?? '') !!}</textarea>
                        <div id="cekDescription" class="text-danger"></div>
                        <!-- Menampilkan error untuk deskripsi iklan -->
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="harga" name="price" placeholder="Masukkan Harga"
                            onkeyup="formatRupiah(this, 'Rp. ')" 
                            value="{{ old('price', isset($ads['price']) ? 'Rp. ' . number_format($ads['price'], 0) : '') }}">
                        <!-- Menampilkan error untuk harga -->
                        <div id="cekPrice" class="text-danger"></div>
                        @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
       
    </div>
</div>

<script>
    function updateCharCount() {
        // Your character count logic here
    }

    function formatRupiah(input, prefix) {
        let number_string = input.value.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        input.value = prefix + rupiah;
    }
</script>
