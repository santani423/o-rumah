<div class="col-md-9">
    @foreach ($subKategori as $suk) 
        <div class="checkbox my-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="subkategori[]" value="{{$suk->id}}"
                    id="subkategori{{$suk->id}}" data-parsley-multiple="groups" data-parsley-mincheck="2" />
                <label class="custom-control-label" for="subkategori{{$suk->id}}">{{$suk->nama}}</label>
            </div>
        </div>
    @endforeach
</div>