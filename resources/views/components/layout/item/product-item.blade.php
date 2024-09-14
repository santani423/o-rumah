<!-- Pastikan untuk menyertakan Font Awesome di dalam HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .square-container {
        position: relative;
        width: 100%;
        padding-bottom: 100%; /* Membuat kontainer persegi dengan rasio 1:1 */
    }

    .square-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .label-top-right {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: green;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 5px;
    }

    .viewers-info {
        display: flex;
        align-items: center;
        font-size: 12px;
        color: #6c757d; /* Warna teks abu-abu */
    }

    .viewers-info i {
        margin-right: 5px;
    }
</style>

<a href="{{ $linkTujuan }}" style="text-decoration: none; color: inherit;">
    <div class="card">
        <div class="square-container">
            <img class="card-img-top img-fluid" src="{{$image}}" alt="Card image cap" 
                 onerror="this.onerror=null;this.src=`{{asset('assets/default.png')}}`">
            @if($label)
                <div class="label-top-right">{{$label}}</div>
            @endif 
        </div>
        <div class="card-body">
            <h4 class="card-title font-20 mt-0 text-truncate d-block" style="max-width: 100%;">{{$title}}</h4>
            <h4 class="card-title font-20 mt-0 text-primary">{{$price}} </h4>
            <p class="card-text text-truncate d-block">
                @if($address){{$address}}@else <br> @endif
            </p>
            <!-- Tambahkan keterangan jumlah orang yang melihat dengan icon -->
            <div class="viewers-info">
                <i class="fas fa-eye"></i> <!-- Icon mata dari Font Awesome -->
                <span>{{$totalViews}} orang telah melihat</span>
            </div>
        </div>
 
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-truncate d-block"> 
                @if($area){{$area}} @else - @endif
            </li>
        </ul>

        @if($type == 'property')
        <div class="card-body d-flex justify-content-start p-2">
            <a href="javascript:void(0)" class="card-link d-flex align-items-center mr-2 text-truncate">
                <img src="{{asset('assets/icons/bed.png')}}" class="mr-1" alt="">{{ $jk ?? 0 }}
            </a>
            <a href="javascript:void(0)" class="card-link d-flex align-items-center mr-2 text-truncate">
                <img src="{{asset('assets/icons/tub.png')}}" class="mr-1" alt="">{{ $jkm ?? 0 }}
            </a>
            <a href="javascript:void(0)" class="card-link d-flex align-items-center mr-2 text-truncate">
                LT {{ $lt ?? 0 }}
            </a>
            <a href="javascript:void(0)" class="card-link d-flex align-items-center text-truncate">
                LB {{ $lb ?? 0 }}
            </a>
        </div>
        @endif
        {{ $content }}
    </div>
</a>
