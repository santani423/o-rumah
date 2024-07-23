<x-Layout.Vertical.Master>
    @slot('css')
    <link href="{{asset('zenter/vertical/assets/plugins/magnific-popup/magnific-popup.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('zenter/vertical/assets/plugins/dropzone/dist/dropzone.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('zenter/vertical/assets/plugins/dropify/css/dropify.min.css')}}" rel="stylesheet" />
    @endslot
    @slot('js')
    <!-- Magnific popup -->
    <script src="{{asset('zenter/vertical/assets/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/lightbox.js')}}"></script>

    <!-- Dropzone js -->
    <script src="{{asset('zenter/vertical/assets/plugins/dropzone/dist/dropzone.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/plugins/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('zenter/vertical/assets/pages/upload.init.js')}}"></script>

    @endslot
    @slot('body')
    <div class="row">
    <div class="col-md-6">
            <div class="card card-body">
                <h3 class="card-title font-20 mt-0">
                    Detail Pengajuan Lelang
                </h3>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pengajuanLelang->kpr_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pengajuanLelang->kpr_email }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $pengajuanLelang->kpr_phone }}</td>
                        </tr> 
                        <tr>
                            <th>Status</th>
                            <td>{{$pengajuanLelang->status }}</td>
                        </tr>
                        <tr>
                            <th>Agen</th>
                            <td>{{ $pengajuanLelang->namaAgen }}</td>
                        </tr>
                        <tr>
                            <th>Bank</th>
                            <td>{{ $pengajuanLelang->alias_name }}</td>
                        </tr>
                        <tr>
                            <th>Type Bank</th>
                            <td>{{ $pengajuanLelang->bank_type }}</td>
                        </tr>
                        <tr>
                            <th>Status KPR</th>
                            <td>{{$pengajuanLelang->status }}</td>
                        </tr>
                    </tbody>
                </table>
        



                <form action="{{route('admin.email.bank.lelang')}}" method="post">
                    @csrf
                   
                    <input type="hidden" name="lelang_id" value="{{$pengajuanLelang->id}}">
                    <button class="btn btn-turquoise">Kirm Email</button>
                </form> 
            </div>

            

        </div>
        <div class="col-md-6">
        <x-Layout.Item.ProductItem 
    :image="$pengajuanLelang->image" 
    :title="$pengajuanLelang->title" 
    :area="$pengajuanLelang->area" 
    :jk="$pengajuanLelang->jk"
    :jkm="$pengajuanLelang->jkm" 
    :lb="$pengajuanLelang->lb" 
    :lt="$pengajuanLelang->lt" 
    :address="$pengajuanLelang->address" 
    :price="$pengajuanLelang->price"
    link-tujuan="">
</x-Layout.Item.ProductItem>

            <x-Layout.Item.AgentContactCard :agent="$agent" :ads="$pengajuanLelang"></x-Layout.Item.AgentContactCard>
            <div class="card card-body">
            <h4 class="card-title">Dokumen</h4>
                <div class="row">
                    @foreach ([['image' => $pengajuanLelang->image_ktp, 'title' => 'KTP Suami Istri', 'filename' => 'KTP_Suami_Istri']] as $doc)
                        <div class="mb-2 mr-2 d-flex col-lg-6 flex-column align-items-center" style="width: 120px;">
                            <div class="popup-gallery d-flex flex-wrap">
                                <a href="{{ asset($doc['image']) }}" title="{{ $doc['title'] }}">
                                    <img src="{{ asset($doc['image']) }}" alt="{{ $doc['title'] }}" class="img-fluid">
                                </a>
                                <p>{{ $doc['title'] }}</p>

                            </div>
                            <a href="{{ asset($doc['image']) }}" class="btn btn-turquoise"
                                download="{{ $doc['filename'] }}">Download</a>
                        </div>
                    @endforeach
                </div>
                <!-- <a href="{{route('admin.pengajuan.kpr.downloadKprFiles', $pengajuanLelang->id)}}" class="btn btn-turquoise">Download
                    ZIP </a> -->
            </div>
            </div>
        </div>
    </div>
    @endslot
</x-Layout.Vertical.Master>