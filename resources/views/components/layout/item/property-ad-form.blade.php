<style>
    .char-count {
        margin-top: 5px;
        color: #555;
    }
</style>
<div class="card">
    <div class="card-body">
        <h4 class="card-title font-20 mt-0">Deskripsi Iklan</h4>
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label for="judulIklan">Judul Iklan</label>
                    <input type="text" class="form-control" id="judulIklan" name="title"
                        placeholder="Masukkan Judul Iklan" value="{{ old('title', $ads['title'] ?? '') }}">
                    <!-- Menampilkan error untuk judul iklan -->
                    <div id="cektitle"></div>
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="deskripsiIklan">Deskripsi Iklan</label>
                    <textarea id="elm1" name="description"
                        onkeyup="updateCharCount()">{!! old('description', $ads['description'] ?? '') !!}</textarea>
                    <!-- <div id="charCount" class="char-count">0 karakter</div> -->
                    <!-- Menampilkan error untuk deskripsi iklan -->
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" class="form-control" id="harga" name="price" placeholder="Masukkan Harga"
                        onkeyup="formatRupiah(this, 'Rp. ')" value="{{ old('price', 'Rp. '.number_format($ads['price'], 0) ?? '') }}">
                    <!-- Menampilkan error untuk harga -->
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- <div class="form-group">
                    <label for="harga">Tipe Bayar</label><br>
                    <div class="form-check-inline my-1"
                        style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="typeBayar1 " name="typeBayar" value="harian"
                                class="custom-control-input">
                            <label class="custom-control-label" for="typeBayar1 ">Harian</label>
                        </div>
                    </div>
                    <div class="form-check-inline my-1"
                        style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="typeBayar1 " name="typeBayar" value="mingguan"
                                class="custom-control-input">
                            <label class="custom-control-label" for="typeBayar1 ">Mingguan</label>
                        </div>
                    </div>
                    <div class="form-check-inline my-1"
                        style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="typeBayar1 " name="typeBayar" value="bulanan"
                                class="custom-control-input">
                            <label class="custom-control-label" for="typeBayar1 ">Bulanan</label>
                        </div>
                    </div>
                    <div class="form-check-inline my-1"
                        style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="typeBayar1 " name="typeBayar" value="tahunan"
                                class="custom-control-input">
                            <label class="custom-control-label" for="typeBayar1 ">Tahunan</label>
                        </div>
                    </div>


                </div> -->

            </div>
        </div>
    </div>
</div>