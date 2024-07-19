<style>
    .square-container {
        position: relative;
        width: 100%;
        padding-bottom: 100%; /* Membuat kontainer persegi dengan rasio 1:1 */
    }

    
    .square-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-item img {
        width: 100%;
        height: 80vh; /* Tinggi gambar menjadi 70% dari tinggi layar */
        object-fit: cover; /* Mengisi seluruh kontainer dengan gambar */
    }
    .carousel-inner {
        height: 50vw; /* Set tinggi elemen menjadi 50% dari lebar viewport */
    }
    .zoom-gallery {
        height: 50vw; /* Set tinggi elemen menjadi 50% dari lebar viewport */
    }

    
</style>

<div class="row">
    <div class="col-lg-6">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach($media as $key => $md)
                    <div class="carousel-item @if($key == 0) active @endif">
                        <img class="d-block img-fluid" src="{{ asset($md['url']) }}" alt="First slide" 
                        style="max-width: 800px; height: auto;">
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
                        <div class="col-3 col-sm-3 col-md-6 d-flex align-items-center justify-content-center">
                            <a class="mb-3 square-container" href="{{ asset($md['url']) }}" title="Project {{ $key + 1 }}">
                                <img src="{{ asset($md['url']) }}" alt="" class="img-fluid img-cover" />
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
