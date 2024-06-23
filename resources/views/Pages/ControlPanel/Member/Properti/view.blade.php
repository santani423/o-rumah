<x-Layout.Vertical.Master>
    @slot('body') 
    <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Default Tabs</h4>
                                            @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

            
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link @if(!$navLink) active @endif" data-toggle="tab" href="#home" role="tab">Home</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link  @if($navLink == 'properti') active @endif" data-toggle="tab" href="#properti" role="tab">Tentang Properti</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Messages</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a>
                                                </li>
                                            </ul>
            
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane @if(!$navLink) active @endif p-3" id="home" role="tabpanel">
                                                    <p class="font-14 mb-0">
                                                        Home
                                                    </p>
                                                </div>
                                                <div class="tab-pane  @if($navLink == 'properti') active @endif p-3" id="properti" role="tabpanel">
                                                <table class="table">
                                                                
                                                                 <tbody> 
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Tipe Iklan</th>
                                                                            <td>{{ $ads['ads_type'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Tipe Properti</th>
                                                                            <td>{{ $ads['property_type'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Judul Iklan</th>
                                                                            <td>{{ $ads['title'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Harga</th>
                                                                            <td>{{ number_format($ads['price'], 2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Nama Komplek</th>
                                                                            <td>{{ $ads['housing_name'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Nama Cluster</th>
                                                                            <td>{{ $ads['cluster_name'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Luas Tanah</th>
                                                                            <td>{{ $ads['lt'] }} m²</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Luas Bangunan</th>
                                                                            <td>{{ $ads['lb'] }} m²</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Tahun Dibangun</th>
                                                                            <td>{{ $ads['year_built'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Tipe Sertifikat</th>
                                                                            <td>{{ $ads['certificate'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Kamar Tidur</th>
                                                                            <td>{{ $ads['jk'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Kamar Mandi</th>
                                                                            <td>{{ $ads['jkm'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Jumlah Lantai</th>
                                                                            <td>{{ $ads['dl'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Fasilitas</th>
                                                                            <td>
                                                                                @if (!empty($ads['house_facility']))
                                                                                    <ul>
                                                                                        @foreach (json_decode($ads['house_facility']) as $facility)
                                                                                            <li>{{ $facility }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    Tidak tersedia
                                                                                @endif
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Kondisi Prabotan</th>
                                                                            <td>{{ $ads['furniture_condition'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Fasilitas Perumahan</th>
                                                                            <td>@if (!empty($ads['other_facility']))
                                                                                    <ul>
                                                                                        @foreach (json_decode($ads['other_facility']) as $facility)
                                                                                            <li>{{ $facility }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    Tidak tersedia
                                                                                @endif</td>
                                                                        </tr>
                                                                 </tbody>
                                                                 </table>
                                                                 <a href="{{route('listing.control-panel.properti.edit.tentang-properti',$ads['slug'])}}"><button class="btn btn-primary">Edit</button></a>
                                                         </div>
                                           
                                                <div class="tab-pane p-3" id="messages" role="tabpanel">
                                                    <p class="font-14 mb-0">
                                                         
                                                    </p>
                                                </div>
                                                <div class="tab-pane p-3" id="settings" role="tabpanel">
                                                    <p class="font-14 mb-0">
                                                        Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                                        art party before they sold out master cleanse gluten-free squid
                                                        scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                                        art party locavore wolf cliche high life echo park Austin. Cred
                                                        vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                                        farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral,
                                                        mustache readymade thundercats keffiyeh craft beer marfa
                                                        ethical. Wolf salvia freegan, sartorial keffiyeh echo park
                                                        vegan.
                                                    </p>
                                                </div>
                                            </div>
            
                                        </div>
                                    </div>
                                </div>
            
                                
                            </div>
    @endslot
</x-Layout.Vertical.Master>