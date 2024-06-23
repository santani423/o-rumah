<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <a href="{{route('member.properti.create')}}" class="btn btn-turquoise">Pasang Iklan</a>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h6 class="card-header mt-0">Data Iklan</h6>
                <div class="card-body">
                    <h4 class="card-title font-20 mt-0">Special title treatment</h4>

                </div>
            </div>
        </div>
    </div> -->
    <div class="row">


        @foreach($properties as $ads)
            <div class="col-6 col-md-6 col-lg-6 col-xl-3 mb-3">

                <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                    :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                    :linkTujuan="route('listing.control-panel.view.property', ['slug' => $ads->slug])">
                </x-Layout.Item.ProductItem>

            </div><!-- end col -->
        @endforeach
    </div>
    @endslot
</x-Layout.Vertical.Master>