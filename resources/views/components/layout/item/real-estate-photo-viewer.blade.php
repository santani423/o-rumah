<div class="row">
    <div class="col-lg-6">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach($media as $key => $md)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <img class="d-block img-fluid" src="{{ asset($md['url']) }}" alt="First slide"
                            style="width: 100%; height: 100%;">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-lg-6 mt-3">
        <div class="zoom-gallery">
            <div class="row">
                @foreach($media as $key => $md)
                    @if ($key < 4)
                        <div class="col-3 col-sm-3 col-md-6">
                            <a class="float-left mb-3" href="{{ asset($md['url']) }}" title="Project {{ ++$key }}">
                                <img src="{{ asset($md['url']) }}" alt="" width="275" height="183"
                                    style="width: 275px; height: auto;" class="img-fluid" />
                            </a>
                        </div>
                    @else
                        <a href="{{ asset($md['url']) }}" title="Project {{ $key }}"></a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>