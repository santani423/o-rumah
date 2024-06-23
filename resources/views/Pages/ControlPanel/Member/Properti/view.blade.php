<x-Layout.Vertical.Master>
    @slot('body') 
    <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Default Tabs</h4>
                                            
            
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Home</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a>
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
                                                <div class="tab-pane active p-3" id="home" role="tabpanel">
                                                    <p class="font-14 mb-0">
                                                        Home
                                                    </p>
                                                </div>
                                                <div class="tab-pane p-3" id="profile" role="tabpanel">
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
                                                                            <td>{{ $ads['house_facility'] ?? 'Tidak tersedia' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Kondisi Prabotan</th>
                                                                            <td>{{ $ads['furniture_condition'] }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row" style="width: 200px">Fasilitas Perumahan</th>
                                                                            <td>{{ $ads['other_facility'] ?? 'Tidak tersedia' }}</td>
                                                                        </tr>
                                                                 </tbody>
                                                                 </table>
                                                         </div>
                                           
                                                <div class="tab-pane p-3" id="messages" role="tabpanel">
                                                    <p class="font-14 mb-0">
                                                        Etsy mixtape wayfarers, ethical wes anderson tofu before they
                                                        sold out mcsweeney's organic lomo retro fanny pack lo-fi
                                                        farm-to-table readymade. Messenger bag gentrify pitchfork
                                                        tattooed craft beer, iphone skateboard locavore carles etsy
                                                        salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                                                        Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                                                        mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                                        retro mlkshk vice blog. Scenester cred you probably haven't
                                                        heard of them, vinyl craft beer blog stumptown. Pitchfork
                                                        sustainable tofu synth chambray yr.
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