
<div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="tab-container mb-1">
                    <div class="tab active" id="jual-tab" onclick="showTab('jual')">Beli</div>
                    <div class="tab " id="sewa-tab" onclick="showTab('sewa')">Sewa</div>
                </div>
            </div>
        </div>


        <!-- Search Bar -->
        <div class="search-bar d-flex align-items-center">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="propertyTypeDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-home mr-2"></i>Tipe Properti
                </button>
                <div class="dropdown-menu" aria-labelledby="propertyTypeDropdown">
                    @foreach($tipeProperti as $tipe)
                        <p class="dropdown-item"   onclick="selectPropertyType(`{{ $tipe->name }}`)">{{ $tipe->name }}</p>
                    @endforeach
                </div>
            </div>
            
            <div class="location-input flex-grow-1 ml-3">
        <i class="fas fa-map-marker-alt mr-2 text-warning"></i>
        <input type="text" class="form-control border-0"
               placeholder="Lokasi, keyword, area" oninput="showSampleLocations(this.value)" id="searchLok">
        <div id="sampleLocations" class="mt-2"></div>
        </div>
            <button class="btn btn-success ml-3"  onclick="searchLocation()">
                <i class="fas fa-search"></i>
            </button>
            
        </div>