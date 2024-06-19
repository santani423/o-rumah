<a href="{{ $linkTujuan }}" style="text-decoration: none; color: inherit;">
    <div class="card">
        <img class="card-img-top img-fluid" src="{{$image}}" alt="Card image cap" style="width: 100%; height: 200px;">
        <div class="card-body">
            <h4 class="card-title font-20 mt-0 ">{{$title}}</h4>
            <h4 class="card-title font-20 mt-0 text-primary">{{$price}}</h4>
            <p class="card-text">{{$address}}</p>
        </div>
        @if($area)
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{$area}}</li>
            </ul>
        @endif
        @if($jk || $jkm || $lb)
            <div class="card-body" style="display: flex; justify-content: flex-start;">
                @if($jk) <a href="javascript:void(0)" class="card-link"><img src="{{asset('assets/icons/bed.png')}}"
                class="mr-1" alt="">{{$jk}}</a>@endif
                @if($jkm) <a href="javascript:void(0)" class="card-link"><img src="{{asset('assets/icons/tub.png')}}"
                class="mr-1" alt="">{{$jkm}}</a>@endif
                @if($lb) <a href="javascript:void(0)" class="card-link">LB {{$lb}}</a>@endif
            </div>
        @endif
        {{$content}}
    </div>
</a>