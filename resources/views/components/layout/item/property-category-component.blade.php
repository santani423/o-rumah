<div class="card">
    <div class="card-body">
        <h4 class="card-title font-20 mt-0">Kategori Properti</h4>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Tipe Iklan</label>
            </div>
            <div class="col-md-9">
                <div class="form-check-inline my-1" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="ads_type1" name="ads_type" value="Jual" class="custom-control-input"
                            {{ old('ads_type', $ads['ads_type'] ?? '') == 'Jual' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="ads_type1">Jual</label>
                    </div>
                </div>
                <div class="form-check-inline my-1" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="ads_type2" name="ads_type" value="Sewa" class="custom-control-input"
                            {{ old('ads_type', $ads['ads_type'] ?? '') == 'Sewa' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="ads_type2">Sewa</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="control-label">Tipe Properti</label>
            </div>
            <div class="col-md-9">
                @foreach ($propertyType as $key => $type)
                    <div class="form-check-inline my-1" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="property_type{{$key}}" name="property_type" value="{{$type}}"
                                class="custom-control-input"
                                {{ old('property_type', $ads['property_type'] ?? '') == $type ? 'checked' : '' }}>
                            <label class="custom-control-label" for="property_type{{$key}}">{{$type}}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
