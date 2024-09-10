@if($url)
<div class="col-lg-4">
    <a href="{{ $url }}" class="text-decoration-none" style="color: inherit;"   data-name="{{$user['name']}}"
        data-joinedat="{{$user['joined_at']}}" data-companyname="{{$user['company_name']}}">
@else
<div class="col-lg-4" data-toggle="modal" data-target="#{{$dataTarget}}" data-name="{{$user['name']}}"
    data-joinedat="{{$user['joined_at']}}" data-companyname="{{$user['company_name']}}">
@endif
        <div class="card rounded-0">
            <div class="card-body">
                <div class="media">
                    <img class="d-flex mr-3 rounded-circle" src="{{$user['image']}}" onerror="this.onerror=null;this.src=`{{asset('assets/default.png')}}`" alt="Generic placeholder image" height="64" width="64" />
                    <div class="media-body">
                        <h5 class="mt-0 font-18">
                            {{$user['name']}}
                        </h5>
                        <p>{{$user['joined_at']}}</p>
                    </div>
                </div>

                <!-- Jika ingin menambahkan kolom lain di dalam, harus ada row baru ok -->
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <div class="media">
                                    <img class="d-flex mr-3 rounded-circle" src="{{$user['company_image']}}" onerror="this.onerror=null;this.src=`{{asset('assets/default.png')}}`"
                                        alt="Generic placeholder image" height="64" width="64" />
                                    <div class="media-body">
                                        <h5 class="mt-0 font-18 text-center">
                                            {{$user['company_name']}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{$content}}
            </div>
        </div>

@if($url)
    </a>
@endif
</div>
