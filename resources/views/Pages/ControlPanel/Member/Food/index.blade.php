<x-Layout.Vertical.Master>
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <a href="{{route('member.food.create-listing')}}" class="btn btn-turquoise">Pasang Iklan</a>
                </div>
                <h4 class="page-title">Food</h4>
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

    

        @foreach($food as $ads)
            <div class="col-6 col-md-6 col-lg-6 col-xl-3 mb-3">
                <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk"
                    :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address"
                    :linkTujuan="route('listing.control-panel.view.property', ['slug' => $ads->slug])">
                </x-Layout.Item.ProductItem>
                @if($ads->is_active)
                <button class="btn btn-turquoise" data-toggle="modal" data-target="#confirmModal" data-ads-id="{{ $ads->ads_id }}" data-is-active="{{ $ads->is_active }}"> Aktifkan</button>
                @else
                <button class="btn btn-danger" data-toggle="modal" data-target="#confirmModal" data-ads-id="{{ $ads->ads_id }}" data-is-active="{{ $ads->is_active }}">Non Aktifkan</button>
                @endif 
            </div><!-- end col -->
        @endforeach
    </div>
      <!-- Modal -->
      <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pengaturan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmForm" method="POST" action="{{ route('listing.toggle') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="ads_id" id="ads_id" value="">
                        <p>Apakah Anda yakin ingin mengubah status item ini?</p>
                        <div id="descPenguranganPoin" style="display: none;">
                            <x-Item.Balach.DescPenguranganPoin code='ABC010'/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-turquoise">Ya, Ubah Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endslot
    @slot('js')
    <script>
        $('#confirmModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var adsId = button.data('ads-id');
            var isActive = button.data('is-active'); // Get is_active value
            var modal = $(this);
            modal.find('.modal-body #ads_id').val(adsId);

            

            if (isActive === 0) {
                modal.find('.modal-body #descPenguranganPoin').show();
            } else {
                modal.find('.modal-body #descPenguranganPoin').hide();
            }
        });
    </script>
    @endslot
</x-Layout.Vertical.Master>