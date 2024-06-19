<x-Layout.Vertical.Master>
    @slot('body')
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h1>Create Bank</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.nav.bank.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Existing fields -->
                    <div class="form-group">
                        <label for="bank">Bank Name</label>
                        <input type="text" class="form-control @error('bank') is-invalid @enderror" id="bank"
                            name="bank" value="{{ old('bank') }}">
                        @error('bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                            name="code" value="{{ old('code') }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                            name="type" value="{{ old('type') }}">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alias_name">Alias Name</label>
                        <input type="text" class="form-control @error('alias_name') is-invalid @enderror"
                            id="alias_name" name="alias_name" value="{{ old('alias_name') }}">
                        @error('alias_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="province">Province</label>
                        <select name="province" id="province"
                            class="form-control @error('province') is-invalid @enderror">
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov->name }}" {{ old('province') == $prov->name ? 'selected' : '' }}>
                                    {{ $prov->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="citie">City</label>
                        <select name="citie" id="citie" class="form-control @error('city') is-invalid @enderror">
                            @foreach ($cities as $cite)
                                <option value="{{ $cite->name }}" {{ old('citie') == $cite->name ? 'selected' : '' }}>
                                    {{ $cite->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="office_type">Office Type</label>
                        <input type="text" class="form-control @error('office_type') is-invalid @enderror"
                            id="office_type" name="office_type" value="{{ old('office_type') }}">
                        @error('office_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="details">Details</label>
                        <input type="text" class="form-control @error('details') is-invalid @enderror" id="details"
                            name="details" value="{{ old('details') }}">
                        @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">Is Active</label>
                        <select class="form-control @error('is_active') is-invalid @enderror" id="is_active"
                            name="is_active">
                            <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Email Fields -->
                    <div class="form-group">
                        <label for="email_kpr">Email KPR</label>
                        <input type="email" class="form-control @error('email_kpr') is-invalid @enderror" id="email_kpr"
                            name="email_kpr" value="{{ old('email_kpr') }}">
                        @error('email_kpr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_lelang">Email Lelang</label>
                        <input type="email" class="form-control @error('email_lelang') is-invalid @enderror"
                            id="email_lelang" name="email_lelang" value="{{ old('email_lelang') }}">
                        @error('email_lelang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_lainnya">Email Lainnya</label>
                        <input type="email" class="form-control @error('email_lainnya') is-invalid @enderror"
                            id="email_lainnya" name="email_lainnya" value="{{ old('email_lainnya') }}">
                        @error('email_lainnya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Bank</button>
                </form>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>