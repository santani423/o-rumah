<x-Layout.Vertical.Master title="Plan">
    @slot('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">

                <h4 class="page-title">Plan</h4>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        @foreach ($plans as $pln)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">



                        <div class="media">
                            <!-- Menggunakan asset secara dinamis berdasarkan data user jika tersedia -->
                            <img class="d-flex mr-3 rounded-circle"
                                src="{{ asset($pln->avatar ?? 'zenter/vertical/assets/images/users/avatar-6.jpg') }}"
                                alt="Avatar" height="64" />
                            <div class="media-body">
                                <h5 class="mt-0 font-18">
                                    {{ $pln->name }}
                                </h5>
                                <p>{{ $pln->description }}</p>
                                <div class="d-flex justify-content-between align-items-center" style="align-items: center;">
                                    <!-- Menampilkan harga dengan format mata uang -->
                                    <p class="mb-0">{{ number_format($pln->price, 2) }}</p>
                                    <a href="{{route('member.plans.paymentMessage', $pln->slug)}}"
                                        class="btn btn-turquoise">Pesan</a>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endslot
</x-Layout.Vertical.Master>