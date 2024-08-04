<div class="row">
    <div class="col-md-4">
        <div class="card rounded-0 border border-1">
            <div class="card-body text-center pr-2 pl-2">
                <p class="small">Total Properti</p>
                <h6 class="mt-0 font-18">{{ $totalProperties }}</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-0 border border-1">
            <div class="card-body text-center pr-2 pl-2">
                <p class="small">Terjual</p>
                <h6 class="mt-0 font-18">{{ $total_sold_properties }}</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-0 border border-1 pr-0 pl-0 mr-0 ml-0">
            <div class="card-body text-center">
                <p class="small">Tersewa</p>
                <h6 class="mt-0 font-18">{{ $total_rented_properties }}</h6>
            </div>
        </div>
    </div>
</div>
