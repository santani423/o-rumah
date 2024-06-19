<div class="card">
    <div class="card-body">
        <h4 class="card-title font-20 mt-0">Tentang Properti</h4>
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label for="housing_name">Nama Komplek</label>
                    <input type="text" class="form-control" id="housing_name" name="housing_name"
                        placeholder="Masukkan Nama Komplek" value="{{ old('housing_name') }}">
                    @error('housing_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cluster_name">Nama Cluster</label>
                    <input type="text" class="form-control" id="cluster_name" name="cluster_name"
                        placeholder="Masukkan Nama Cluster" value="{{ old('cluster_name') }}">
                    @error('cluster_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lt">Luas Tanah</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="lt" name="lt"
                                    placeholder="Masukkan Luas Tanah (dalam meter persegi)" value="{{ old('lt') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">m²</span>
                                </div>
                            </div>
                            @error('lt')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="formLuasBangunan">
                        <div class="form-group">
                            <label for="lb">Luas Bangunan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="lb" name="lb"
                                    placeholder="Masukkan Luas Bangunan (dalam meter persegi)" value="{{ old('lb') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">m²</span>
                                </div>
                            </div>
                            @error('lb')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group" id="formTahunDibangun">
                    <label for="year_built">Tahun Di Bangun</label>
                    <input type="number" class="form-control" id="year_built" name="year_built"
                        placeholder="Masukkan Tahun Dibangun" value="{{ old('year_built') }}" max="{{ date('Y') }}">
                    @error('year_built')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" id="formDayaListrik">

                    <label for="dl">Daya Listrik</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="dl" name="dl" placeholder="Masukkan Daya Listrik"
                            value="{{ old('dl') }}">
                        <div class="input-group-append">
                            <span class="input-group-text">Watt</span>
                        </div>
                    </div>
                    @error('dl')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="form-group">

                    <label for="certificate">Tipe Sertifikat</label>
                    <div class="input-group">
                        @foreach ($certificate as $key => $ctf)


                            <div class="checkbox my-2 mr-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="certificate{{$key}}"
                                        name="certificate" value="{{$ctf}}" data-parsley-multiple="groups"
                                        data-parsley-mincheck="2" @if(old('certificate') == $ctf) checked @endif>
                                    <label class="custom-control-label" for="certificate{{$key}}">{{$ctf}}</label>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>

                <div class="form-group" id="kamarTidurGroup">
                    <div class="row">
                        <!-- Kamar Tidur -->
                        <div class="col-md-4">
                            <label for="jk">Kamar Tidur</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-decrement btn-outline-secondary" type="button">-</button>
                                </div>
                                <input type="number" class="form-control" id="jk" name="jk"
                                    placeholder="Jumlah Kamar Tidur" value="{{ old('jk') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-increment btn-outline-secondary" type="button">+</button>
                                </div>
                            </div>
                            @error('jk')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Kamar Mandi -->
                        <div class="col-md-4">
                            <label for="jkm">Kamar Mandi</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-decrement btn-outline-secondary" type="button">-</button>
                                </div>
                                <input type="number" class="form-control" id="jkm" name="jkm"
                                    placeholder="Jumlah Kamar Mandi" value="{{ old('jkm') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-increment btn-outline-secondary" type="button">+</button>
                                </div>
                            </div>
                            @error('jkm')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Jumlah Lantai -->
                        <div class="col-md-4">
                            <label for="jl">Jumlah Lantai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-decrement btn-outline-secondary" type="button">-</button>
                                </div>
                                <input type="number" class="form-control" id="jl" name="jl" placeholder="Jumlah Lantai"
                                    value="{{ old('jl') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-increment btn-outline-secondary" type="button">+</button>
                                </div>
                            </div>
                            @error('jl')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group" id="formfasilitas">

                    <label for="house_facility">Fasilitas </label>
                    <div class="input-group">
                        @foreach ($house_facility as $key => $ctf)


                            <div class="checkbox my-2 mr-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="house_facility{{$key}}"
                                        name="house_facility[]" value="{{$ctf}}" data-parsley-multiple="groups"
                                        data-parsley-mincheck="2" @if(old('house_facility') == $ctf) checked @endif>
                                    <label class="custom-control-label" for="house_facility{{$key}}">{{$ctf}}</label>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
                <div class="form-group row" id="formKondisiPrabotan">
                    <div class="col-md-12">
                        <label class="control-label">Kondisi Perabotan</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-check-inline my-1"
                            style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="furniture_condition" name="furniture_condition"
                                    class="custom-control-input" value="Furnished"
                                    @if(old('furniture_condition') == 'Furnished') checked @endif>
                                <label class="custom-control-label" for="furniture_condition">Furnished</label>
                            </div>
                        </div>

                        <div class="form-check-inline my-1"
                            style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="furniture_condition2" name="furniture_condition"
                                    class="custom-control-input" value="Semi-Furnished"
                                    @if(old('furniture_condition') == 'Semi-Furnished') checked @endif>
                                <label class="custom-control-label" for="furniture_condition2">Semi-Furnished</label>
                            </div>
                        </div>
                        <div class="form-check-inline my-1"
                            style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="furniture_condition3" name="furniture_condition"
                                    class="custom-control-input" value="Unfurnished"
                                    @if(old('furniture_condition') == 'Unfurnished') checked @endif>
                                <label class="custom-control-label" for="furniture_condition3">Unfurnished</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>