<x-Layout.Horizontal.Master>


    @slot('js')
    <!-- Magnific popup -->
    <script src="{{asset('zenter/horizontal/assets/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('zenter/horizontal/assets/pages/lightbox.js')}}"></script>

    @endslot
    @slot('css')
    <!-- Magnific popup -->
    <!-- Magnific popup -->
    <link href="{{asset('zenter/horizontal/assets/plugins/magnific-popup/magnific-popup.css')}}" rel="stylesheet"
        type="text/css" />
    @endslot

    @slot('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <x-Layout.Item.RealEstatePhotoViewer :media="$media"></x-Layout.Item.RealEstatePhotoViewer>
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <x-Layout.Item.PropertyDetails :ads="$ads"></x-Layout.Item.PropertyDetails>

                        </div>
                        <div class="col-lg-4 mb-3">
                            <x-Layout.Item.AgentContactCard :agent="$agent" btnLelang="true"
                                :ads="$ads"></x-Layout.Item.AgentContactCard>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>


    @endslot
</x-Layout.Horizontal.Master>