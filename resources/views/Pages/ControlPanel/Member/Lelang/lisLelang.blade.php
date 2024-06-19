<x-Layout.Vertical.Master>
    @slot('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#exampleModalform2').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                var title = button.data('title');
                var area = button.data('area');
                var address = button.data('address');
                var ads_id = button.data('ads_id');
                var id_properti = button.data('id_properti');

                // Set the value of the input fields
                $('#ads_id').val(ads_id);
                $('#property_id').val(id_properti);
            });
        });
    </script>
    @endslot
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <a href="{{route('member.properti.create')}}" class="btn btn-turquoise">Pasang Iklan</a>
                </div>
                <h4 class="page-title">Lelang</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
            <div class="col-md-6 col-lg-6 col-xl-3 mb-3">

                <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                    :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                    linkTujuan="javascript:void(0)">
                    @slot('content')
                    @if(!$ads->lelang_ads)
                        <button type="button" class="btn btn-turquoise" data-toggle="modal" data-target="#exampleModalform2"
                            data-id="{{ $ads->id }}" data-title="{{ $ads->title }}" data-area="{{ $ads->area }}"
                            data-address="{{ $ads->address }}" data-id_properti="{{ $ads->id_properti }}"
                            data-ads_id="{{ $ads->ads_id }}">
                            Pasang Iklan
                        </button>
                    @else
                        <button type="button" class="btn btn-switch">Terpasang</button>
                    @endif
                    @endslot
                </x-Layout.Item.ProductItem>

            </div><!-- end col -->
        @endforeach
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalform2" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lanjut Pasang?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('member.lelang.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="property_id" id="property_id">
                    <input type="hidden" name="ads_id" id="ads_id">
                    <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="is_active" id="is_active" value="1">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-turquoise">Lanjut Pasang Iklan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>