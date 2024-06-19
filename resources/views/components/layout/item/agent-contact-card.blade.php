<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle"
                        src="{{ !empty($agent['image']) ? $agent['image'] : asset('zenter/horizontal/assets/images/users/avatar-6.jpg') }}"
                        alt=" " height="64" width="64" style="border-radius: 50%;">
                    <div class="media-body">
                        <h5 class="mt-0 font-18">{{$agent['name']}}</h5>
                        <p>Bergabung sejak {{$agent['joined_at']}}</p>
                    </div>
                </div>
                <div class="row">
                    <!-- Tombol Ajukan KPR -->
                    <div class="col-lg-12 mb-3">
                        @if ($btnKpr)
                            <a href="{{route('linkKpr', $ads->slug)}}" class="btn btn-primary btn-block">
                                <i class="fa fa-bank"></i> Ajukan KPR
                            </a>
                        @endif 
                        @if ($btnLelang)
                            <a href="{{ route('auction-link', ['slug' => $ads->slug, 'username' => $agent['username']]) }}"
                                class="btn btn-primary btn-block">
                                Ajukan Lelang
                            </a>
                        @endif
                    </div>
                </div>
                <div class="row">

                    <!-- Tombol Telepon -->
                    @if($agent['phone'])
                        <div class="col-lg-6 mb-3">
                            <a href="tel:{{$agent['phone']}}" class="btn btn-info btn-block">
                                <i class="mdi mdi-phone"></i> Telepon
                            </a>
                        </div>
                    @endif
                    <!-- Tombol WhatsApp -->
                    @if($agent['wa_phone'])
                        <div class="col-lg-6 mb-3">
                            <a href="https://wa.me/{{$agent['wa_phone']}}" class="btn btn-success btn-block">
                                <i class="mdi mdi-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->