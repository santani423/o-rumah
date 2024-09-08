 
        
@foreach($adsLists as $ads)
    <div class="col-md-6 col-lg-6 col-xl-3 mb-3">

        <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
            :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->alamat"
            :linkTujuan="route('property-detail', $ads->slug)" :label="$ads->booster_slug">
            @slot('content')
          
                <div class="card-link d-flex align-items-center mr-3">
                @if (floor($ads->distance) > 0)  <i class="bi bi-geo-alt-fill"></i>
                    <span class="ml-2"> {{ floor($ads->distance) }}  Km </span>@else <br>  @endif
                </div>
            @endslot
        </x-Layout.Item.ProductItem>
        
    </div> 
    @endforeach

@if($adsLists->isEmpty())
    <!-- <h3 style="color:white">Property tidak ditemukan</h3> -->
@endif
