<div class="col-12">
    <h4 class="text-white">Rekomendasi Sesuai Pencarianmu</h4>
</div>
@foreach($adsLists as $ads)
                <div class="col-md-6 col-lg-6 col-xl-3 mb-3">

                    <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->kawasan" :jk="$ads->jk"
                        :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :type="$ads->type" :lt="$ads->lt" :address="$ads->address"
                        :linkTujuan="route('omerchant-detail', $ads->slug)">
                        @if (floor($ads->distance) > 0)
                <div class="card-link d-flex align-items-center mr-3">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span class="ml-2">{{ floor($ads->distance) }} Km</span>
                </div>
            @endif
            @slot('content')
          
          <div class="card-link d-flex align-items-center mr-3">
          @if (floor($ads->distance) > 0)  <i class="bi bi-geo-alt-fill"></i>
              <span class="ml-2"> {{ floor($ads->distance) }}  Km </span>@else <br>  @endif
          </div>
    
      @endslot
                    </x-Layout.Item.ProductItem>

                </div><!-- end col -->
        @endforeach