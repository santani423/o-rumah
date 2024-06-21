<a href="{{ $linkTujuan }}" style="text-decoration: none; color: inherit;">
    <div class="card">
        <img class="card-img-top img-fluid" src="{{$image}}" alt="Card image cap" style="width: 100%; height: 200px;" onerror="this.onerror=null;this.src=`{{asset('assets/default.png')}}`">
        <div class="card-body">
            <h4 class="card-title font-20 mt-0 text-truncate d-block" style="max-width: 100%;">{{$title}}</h4>
            <h4 class="card-title font-20 mt-0 text-primary">{{$price}}</h4>
            <p class="card-text text-truncate d-block">{{$address}}</p>
        </div>
        @if($area)
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-truncate d-block">{{$area}}</li>
            </ul>
        @endif
        
        <div class="card-body d-flex justify-content-start p-2">
        <a href="javascript:void(0)" class="card-link d-flex align-items-center mr-2">
            <img src="{{asset('assets/icons/bed.png')}}" class="mr-1" alt="">{{ $jk ?? 0 }}
        </a>
        <a href="javascript:void(0)" class="card-link d-flex align-items-center mr-2">
            <img src="{{asset('assets/icons/tub.png')}}" class="mr-1" alt="">{{ $jkm ?? 0 }}
        </a>
        <a href="javascript:void(0)" class="card-link d-flex align-items-center mr-2">
            LT {{ $lt ?? 0 }}
        </a>
        <a href="javascript:void(0)" class="card-link d-flex align-items-center">
            LB {{ $lb ?? 0 }}
        </a>
    </div>
       
        <div class="card-link d-flex align-items-center mr-2">
        <i class="bi bi-geo-alt-fill"></i><span class="mt-3 mr-3">{{$content}}</span>
        </div>
    </div>
</a>
