<x-Layout.Vertical.Master title="Listing">
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                @if(Auth::user()->type == 'agen' || Auth::user()->type == 'agent' || Auth::user()->type == 'notaris' || Auth::user()->type == 'lbh')
                <div class="btn-group float-right">
                    <a href="{{ route('member.properti.create') }}" class="btn btn-turquoise">Pasang Iklan</a>
                </div>
                @endif
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @if (session('status'))
    <div class="alert {{ session('alert-class') }}">
        {{ session('status') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($titipAds->isNotEmpty())
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h6 class="card-header mt-0">Permintaan Titip Iklan</h6>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Owner</th>
                                <th>Ads</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($titipAds as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $row['owner']['name'] }}</td>
                                <td>{{ $row['ads']['title'] }}</td>
                                <td>{{ $row['status'] }}</td>
                                <td>
                                    <div class="d-inline-block">
                                        <form action="{{ route('titip-ads.put', $row->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approval">
                                            <button class="btn btn-turquoise btn-sm">Terima</button>
                                        </form>
                                        <form action="{{ route('titip-ads.put', $row->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="reject">
                                            <button class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        @foreach($properties as $ads)
        <div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-3">
            <x-Layout.Item.ProductItem :image="$ads->image" :title="$ads->title" :area="$ads->area" :jk="$ads->jk" :price="$ads->price" :jkm="$ads->jkm" :lb="$ads->lb" :lt="$ads->lt" :address="$ads->address" :label="$ads->user_lelang_properties_id ? 'Lelang' : ''" :linkTujuan="$ads->user_lelang_properties_id ? '#' : route('listing.control-panel.view.property', ['slug' => $ads->slug])">
            </x-Layout.Item.ProductItem>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        @if($ads->is_active)
                        <button class="btn btn-turquoise m-2" data-toggle="modal" data-target="#confirmModal" data-ads-id="{{ $ads->ads_id }}" data-is-active="{{ $ads->is_active }}" data-user_lelang_properties_id="{{ $ads->user_lelang_properties_id }}">Aktifkan</button>
                        @else
                        <button class="btn btn-danger m-2" data-toggle="modal" data-target="#confirmModal" data-ads-id="{{ $ads->ads_id }}" data-is-active="{{ $ads->is_active }}" data-user_lelang_properties_id="{{ $ads->user_lelang_properties_id }}">Non Aktifkan</button>
                        @endif
                        <div class="form-group m-2 w-100">
                            <label class="mb-2 pb-1">Booster</label>
                            <select name="booster" class="form-control w-100 booster-select" data-ads-id="{{ $ads->ads_id }}">
                                <option value="0" data-title="Pilih Booster" selected="selected">Pilih Booster</option>
                                @foreach($bosterAdsType as $bat)
                                <option value="{{ $bat->id }}" data-title="{{ $bat->title }}">{{ $bat->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
        @endforeach
    </div>

    <!-- Modal untuk konfirmasi pengaturan status -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pengaturan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmForm" method="POST" action="{{ route('ads.toggleStatus') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="ads_id" id="ads_id" value="">
                        <input type="hidden" name="user_lelang_properties_id" id="user_lelang_properties_id" value="">
                        <p>Apakah Anda yakin ingin mengubah status item ini?</p>
                        <div id="descPenguranganPoin" style="display: none;">
                            <x-Item.Balach.DescPenguranganPoin code='ABC010' />
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

    <!-- Modal untuk konfirmasi pemilihan booster -->
    <div class="modal fade" id="boosterModal" tabindex="-1" role="dialog" aria-labelledby="boosterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="boosterModalLabel">Konfirmasi Pemilihan Booster</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="boosterForm" method="POST" action="{{ route('boosterAds.storeListing') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="ads_id" id="booster_ads_id" value="">
                        <input type="hidden" name="booster_id" id="booster_id" value="">
                        <p>Apakah Anda yakin ingin memilih booster <span id="booster_title"></span> untuk iklan Anda?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-turquoise">Ya, Pilih Booster</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endslot

    @slot('js')
    <script>
        $('#confirmModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var adsId = button.data('ads-id');
            var isActive = button.data('is-active');
            var userLelangPropertiesId = button.data('user_lelang_properties_id');
            var modal = $(this);
            modal.find('.modal-body #ads_id').val(adsId);
            modal.find('.modal-body #user_lelang_properties_id').val(userLelangPropertiesId);

            if (isActive === 0) {
                modal.find('.modal-body #descPenguranganPoin').show();
            } else {
                modal.find('.modal-body #descPenguranganPoin').hide();
            }
        });

        $('.booster-select').change(function(event) {
            var select = $(event.target);
            var adsId = select.data('ads-id');
            var boosterId = select.val();
            var boosterTitle = select.find('option:selected').data('title');
            if (boosterId !== "0") {
                var modal = $('#boosterModal');
                modal.find('.modal-body #booster_ads_id').val(adsId);
                modal.find('.modal-body #booster_id').val(boosterId);
                modal.find('.modal-body #booster_title').text(boosterTitle);
                modal.modal('show');
            }
        });
    </script>
    @endslot
</x-Layout.Vertical.Master>
