<x-Layout.Vertical.Master>
    @slot('body')
    <div class="d-flex justify-content-center">
        <!-- Profile Card -->
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="card">
                <img class="card-img-top img-fluid" src="{{asset(Auth::user()->image)}}" alt="User Banner" />
                <div class="card-body">
                    <div class="card-avatar">
                        <a class="card-thumbnail card-inner" href="#">
                            <img class="rounded-circle img-thumbnail img-fluid" src="{{asset(Auth::user()->image)}}" height="64" width="64" alt="{{ $user->name }}" />
                        </a>
                    </div>
                    <h6 class="card-title">{{ $user->name }}</h6>
                    <p class="font-12">{{ $user->bio }}</p>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ $user->phone }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $user->address }}</span>
                    </div>
                    <h6 class="font-14 mt-0">Referral Code</h6>
                    <p class="font-12">{{ $user->referral_code ?? 'SAMPLE-CODE-123' }}</p>
                    <!-- QR Code Sample -->
                    <div class="d-flex justify-content-center mt-3">
                        <img src="https://via.placeholder.com/100x100?text=QR+Code" alt="QR Code" class="img-fluid qr-code-sample">
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <!-- Company Card -->
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="card">
                <img class="card-img-top img-fluid" src="{{asset(Auth::user()->company_image)}}" alt="Company Banner" />
                <div class="card-body">
                    <div class="card-avatar">
                        <a class="card-thumbnail card-inner" href="#">
                            <img class="rounded-circle img-thumbnail img-fluid" src="{{asset(Auth::user()->company_image)}}" height="64" width="64" alt="{{ $user->company_name }}" />
                        </a>
                    </div>
                    <h6 class="card-title">{{ $user->company_name }}</h6>
                    <p class="font-12">{{ $user->company_description }}</p>
                    <div class="info-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $user->company_name }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-university"></i>
                        <span>{{ $user->bank_name }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-credit-card"></i>
                        <span>{{ $user->bank_number }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    @endslot

    @slot('css')
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-avatar {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .card-thumbnail img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .card-title {
            text-align: center;
            font-size: 22px;
            margin: 0;
            color: #333;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-top: 10px;
            color: #444;
        }

        .info-item i {
            margin-right: 8px;
            font-size: 18px;
            color: #666;
        }

        .info-item span {
            font-size: 15px;
            font-weight: 500;
        }

        .font-12 {
            font-size: 13px;
            color: #555;
            font-style: italic;
        }

        .font-14 {
            font-size: 16px;
            margin-top: 15px;
            font-weight: bold;
            color: #007bff;
            text-transform: uppercase;
        }

        .qr-code-sample {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
    </style>
    @endslot

    @slot('js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @endslot
</x-Layout.Vertical.Master>
