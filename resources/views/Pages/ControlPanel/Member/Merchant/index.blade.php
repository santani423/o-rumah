<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <a href="{{route('member.merchants.create-listing')}}" class="btn btn-turquoise">Pasang Iklan</a>
                </div>
                <h4 class="page-title">Merchants</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h6 class="card-header mt-0">Data Iklan</h6>
                <div class="card-body">
                    <h4 class="card-title font-20 mt-0">Special title treatment</h4>

                </div>
            </div>
        </div>
    </div>
    <div class="row">

        @foreach($merchant as $ads)
            <div class="col-md-6 col-lg-6 col-xl-3 mb-3">
                <form action="{{route('listing.toggle', ['id' => $ads->ads_id])}}" method="post">
                    <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                        :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address" :price="$ads->price"
                        :linkTujuan="route('omerchant-detail', $ads->slug)">
                        @slot('content')
                        @method('PUT')
                        @csrf
                        @if ($ads->is_active)
                            <button type="submit" class="btn btn-success">Aktif</button>
                        @else 
                            <button type="submit" class="btn btn-danger">Non Aktif</button>
                        @endif
                        @endslot
                    </x-Layout.Item.ProductItem>
                </form>
            </div>
        @endforeach

    </div>
    @endslot
</x-Layout.Vertical.Master>