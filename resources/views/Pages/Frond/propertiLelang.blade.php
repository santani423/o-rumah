<x-Layout.Horizontal.Master>


    @slot('body')

    <div class="row mt-5">
        <div class="col-12">
            <h4 class="">Rekomendasi Sesuai Pencarianmu</h4>
        </div>
        @foreach($adsLists as $ads)
            <div class="col-md-6 col-lg-6 col-xl-3 mb-3">

                <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                    :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                    :linkTujuan="route('auction-detail', ['slug' => $ads->slug, 'username' => $ads->username])">
                </x-Layout.Item.ProductItem>

            </div><!-- end col -->
        @endforeach

    </div>

    @endslot
</x-Layout.Horizontal.Master>