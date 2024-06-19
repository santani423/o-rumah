<x-Layout.Vertical.Master>
    @slot('body')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h1>Edit Bank</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.nav.bank.update', $bank->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Existing fields -->
                    <div class="form-group">
                        <label for="bank">Nama Bank</label>
                        <input type="text" class="form-control @error('bank') is-invalid @enderror" id="bank"
                            name="bank" value="{{ old('bank', $bank->bank) }}">
                        @error('bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="code">Kode</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                            name="code" value="{{ old('code', $bank->code) }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Tipe</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                            name="type" value="{{ old('type', $bank->type) }}">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alias_name">Nama Alias</label>
                        <input type="text" class="form-control @error('alias_name') is-invalid @enderror"
                            id="alias_name" name="alias_name" value="{{ old('alias_name', $bank->alias_name) }}">
                        @error('alias_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $bank->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select name="province" id="province"
                            class="form-control @error('province') is-invalid @enderror">
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov->name }}" {{ old('province', $bank->province) == $prov->name ? 'selected' : '' }}>
                                    {{ $prov->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">Kota</label>
                        <select name="city" id="city" class="form-control @error('city') is-invalid @enderror">
                            @foreach ($cities as $city)
                                <option value="{{ $city->name }}" {{ old('city', $bank->city) == $city->name ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="office_type">Tipe Kantor</label>
                        <input type="text" class="form-control @error('office_type') is-invalid @enderror"
                            id="office_type" name="office_type" value="{{ old('office_type', $bank->office_type) }}">
                        @error('office_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $bank->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', $bank->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="details">Detail</label>
                        <input type="text" class="form-control @error('details') is-invalid @enderror" id="details"
                            name="details" value="{{ old('details', $bank->details) }}">
                        @error('details')
                            <div the="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">Aktif</label>
                        <select class="form-control @error('is_active') is-invalid @enderror" id="is_active"
                            name="is_active">
                            <option value="1" {{ old('is_active', $bank->is_active) == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('is_active', $bank->is_active) == 0 ? 'selected' : '' }}>Tidak
                            </option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> <!-- New Email Fields -->
                    <div class="form-group">
                        <label for="email_kpr">Email KPR</label>
                        <input type="email" class="form-control @error('email_kpr') is-invalid @enderror" id="email_kpr"
                            name="email_kpr" value="{{ old('email_kpr', $emailKpr) }}">
                        @error('email_kpr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_lelang">Email Lelang</label>
                        <input type="email" class="form-control @error('email_lelang') is-invalid @enderror"
                            id="email_lelang" name="email_lelang" value="{{ old('email_lelang', $emailLelang) }}">
                        @error('email_lelang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_lainnya">Email Lainnya</label>
                        <input type="email" class="form-control @error('email_lainnya') is-invalid @enderror"
                            id="email_lainnya" name="email_lainnya" value="{{ old('email_lainnya', $emaillainnya) }}">
                        @error('email_lainnya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Bank</button>
                </form>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>