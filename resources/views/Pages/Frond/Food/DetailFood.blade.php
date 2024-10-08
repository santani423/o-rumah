<x-Layout.Horizontal.Master>


    @slot('css')
    <style></style>
    @endslot
    @slot('js')
    <!-- Magnific popup -->
    <script src="{{asset('zenter/horizontal/assets/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('zenter/horizontal/assets/pages/lightbox.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shareButton = document.querySelector('.btn-instagram.share-button');
            if (shareButton) {
                shareButton.addEventListener('click', function() {
                    const url = window.location.href;
                    navigator.clipboard.writeText(url).then(() => {
                        alert('URL telah disalin!');
                    }).catch(err => {
                        console.error('Gagal menyalin URL: ', err);
                    });
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButton = document.getElementById('likeButton');
            likeButton.addEventListener('click', function() {
                const addId = '{{$ads->ads_id}}'; // Pastikan ini adalah ID iklan yang benar
                const agentId = "{{$agent['id']}}"; // Pastikan ini adalah ID agen yang benar
                const type = '{{$typeFood}}'; // Pastikan ini adalah tipe yang benar
                $.ajax({
                    url: "{{ route('ad.like') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // Menambahkan CSRF token
                        addId: addId,
                        agentId: agentId,
                        type: type
                    },
                    success: function(response) {
                        // console.log(response);
                        document.getElementById('like-count').innerText = response.countLike;
                        if (response.like) {
                            likeButton.innerHTML = '<i class="mdi mdi-heart"></i> Di Favoritkan';
                        } else {
                            likeButton.innerHTML = '<i class="mdi mdi-heart-outline"></i> Favoritkan';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal melakukan aksi:', error);
                    }
                });
            });
        });
    </script>
    @endslot
    @slot('css')
    <link href="{{asset('zenter/horizontal/assets/plugins/magnific-popup/magnific-popup.css')}}" rel="stylesheet"
        type="text/css" />
    @endslot

    @slot('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <button type="button" id="likeButton"
                            class="btn btn-secondary m-b-10 m-l-10 waves-effect waves-light">
                            @if(Auth::user())
                            @if($like)
                            <i class="mdi mdi-heart"></i> Di Favoritkan
                            @else
                            <i class="mdi mdi-heart-outline"></i> Favoritkan
                            @endif
                            @endif
                        </button>
                        <button type="button"
                            class="btn btn-secondary m-b-10 m-l-10 waves-effect waves-light btn-instagram share-button">
                            <i class="ion-android-share"></i> Share
                        </button>
                    </div>
                    <x-Layout.Item.RealEstatePhotoViewer :media="$media"></x-Layout.Item.RealEstatePhotoViewer>
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <x-Layout.Item.FoodDetails :ads="$ads"></x-Layout.Item.FoodDetails>

                        </div>
                        <div class="col-lg-4 mb-3">
                            <x-Layout.Item.AgentContactCard :agent="$agent"
                                :ads="$ads"></x-Layout.Item.AgentContactCard>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>


    @endslot
</x-Layout.Horizontal.Master>