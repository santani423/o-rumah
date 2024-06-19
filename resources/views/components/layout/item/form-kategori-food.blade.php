<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">
                    Kategori
                </h4>
                <div class="row">


                    @foreach ($kategori as $ktg)

                        <div class="col-md-4">
                            <div class="general-label">
                                <div class="form-group row">
                                    <label class="col-md-3 my-2 control-label">{{$ktg->nama}}</label>

                                    <x-Layout.Item.FormSubKategori :kategori="$ktg">
                                    </x-Layout.Item.FormSubKategori>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>