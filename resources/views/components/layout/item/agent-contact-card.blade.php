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
                            <button class="btn btn-info btn-block" onclick="navigateTo('tel:{{$agent['phone']}}', {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'true' : 'false' }})">
                                <i class="mdi mdi-phone"></i> {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'order' : 'Telepon' }}
                            </button>
                        </div>
                    @endif
                    <!-- Tombol WhatsApp -->
                    @if($agent['wa_phone'])
                        @php 
                            $wa_phone = (strpos($agent['wa_phone'], '08') === 0) 
                                        ? '+62' . substr($agent['wa_phone'], 1) 
                                        : $agent['wa_phone'];
                        @endphp
                        <div class="col-lg-6 mb-3">
                            <button class="btn btn-success btn-block" onclick="navigateTo('https://wa.me/{{$wa_phone}}', {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'true' : 'false' }})">
                                <i class="mdi mdi-whatsapp"></i> {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'order' : 'WhatsApp' }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->

<script>
    function navigateTo(url, isOrder = false) {
        if (isOrder) {
            $.ajax({
                url: '{{ route("order") }}', // Endpoint untuk order, pastikan route nama sesuai
                type: 'get',
                data: {
                    // Tambahkan data yang diperlukan untuk permintaan order
                    adsId : "{{$ads->ads_id}}"
                },
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function(data) {
                    // console.log(data);
                    // alert('Order placed successfully! croot');
                    window.location.href = url;
                    // Uncomment if you need conditional alerts based on response data
                    // if (data.success) {
                    //     alert('Order placed successfully!');
                    // } else {
                    //     alert('Order failed. Please try again.');
                    // }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again--.');
                }
            });
        } else {
            window.location.href = url;
        }
    }
</script>

