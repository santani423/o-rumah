<div class="col-12">
    <h4 class="text-white">Rekomendasi Sesuai Pencarianmu</h4>
</div>
@foreach($adsLists as $ads)
<div class="col-md-6 col-lg-6 col-xl-3 mb-3">

    <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
        :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
        :linkTujuan="route('omerchant-detail', $ads->slug)">
        @slot('content')
        <p>{{floor($ads->distance)}} KM</p>
        @endslot
    </x-Layout.Item.ProductItem>

</div>
@endforeach