<x-Layout.Vertical.Master>
    @slot('body')
    <div class="d-flex justify-content-center">
        <!-- Profile Card -->
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="card">
                <img class="card-img-top img-fluid" src="{{ asset(Auth::user()->image) }}" alt="User Banner" />
                <div class="card-body">
                    <div class="card-avatar">
                        <a class="card-thumbnail card-inner" href="#">
                            <img class="rounded-circle img-thumbnail img-fluid" src="{{ asset(Auth::user()->image) }}" height="64" width="64" alt="{{ $user->name }}" />
                        </a>
                    </div>
                    <h6 class="card-title">{{ $user->name }}</h6>
                    <p class="font-12">{{ $user->bio }}</p>
                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $user->username }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ $user->phone }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-mobile-alt"></i>
                        <span>{{ $user->wa_phone }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Email Verified: {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Not Verified' }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $user->address }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Timezone: {{ $user->timezone }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Type: {{ ucfirst($user->type) }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-toggle-on"></i>
                        <span>Status: {{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-ban"></i>
                        <span>Blocked: {{ $user->is_blocked ? 'Yes' : 'No' }}</span>
                    </div>
                    <h6 class="font-14 mt-0">Referral Code</h6>
                    <div class="d-flex align-items-center">
                        <p class="font-12 mb-0" id="referralCode">{{ $kodeRefer->code ?? 'SAMPLE-CODE-123' }}</p>
                        <button class="btn btn-link" onclick="copyToClipboard('referralCode')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <p class="font-12 mb-0" id="referralLink">{{ route('referral', $kodeRefer->code) }}</p>
                        <button class="btn btn-link" onclick="copyToClipboard('referralLink')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <!-- QR Code -->
                    <div class="d-flex justify-content-center mt-3">
                        <div id="qrCodeContainer"></div>
                    </div>
                    <!-- QR Code Download Button -->
                    <div class="d-flex justify-content-center mt-3">
                        <a id="downloadQRCode" class="btn btn-primary">Download QR Code</a>
                    </div>
                    <!-- Edit Button -->
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('member.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <!-- Company Card -->
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="card">
                <img class="card-img-top img-fluid" src="{{ asset(Auth::user()->company_image) }}" alt="Company Banner" />
                <div class="card-body">
                    <div class="card-avatar">
                        <a class="card-thumbnail card-inner" href="#">
                            <img class="rounded-circle img-thumbnail img-fluid" src="{{ asset(Auth::user()->company_image) }}" height="64" width="64" alt="{{ $user->company_name }}" />
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
                    <!-- Edit Button -->
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('member.profile.edit') }}" class="btn btn-primary">Edit Company</a>
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

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
    @endslot

    @slot('js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function copyToClipboard(elementId) {
            var text = document.getElementById(elementId).textContent;
            navigator.clipboard.writeText(text).then(function() {
                alert('Copied to clipboard: ' + text);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        // Generate QR Code with Logo
        function generateQRCode() {
            var referralLink = document.getElementById('referralLink').textContent;
            var qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.innerHTML = ''; // Clear previous QR code

            var qrCode = new QRCode(qrCodeContainer, {
                text: referralLink,
                width: 200,
                height: 200,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            setTimeout(function() {
                var qrCanvas = qrCodeContainer.querySelector('canvas');
                var ctx = qrCanvas.getContext('2d');
                var img = new Image();
                img.src = '{{ asset('path/to/logo.png') }}'; // Path to your logo image
                img.onload = function() {
                    var logoSize = 40;
                    ctx.drawImage(img, (qrCanvas.width / 2) - (logoSize / 2), (qrCanvas.height / 2) - (logoSize / 2), logoSize, logoSize);

                    // Download QR Code
                    var downloadButton = document.getElementById('downloadQRCode');
                    downloadButton.href = qrCanvas.toDataURL('image/png');
                    downloadButton.download = 'referral_qr_code.png';
                };
            }, 500);
        }

        // Call generateQRCode on page load
        document.addEventListener('DOMContentLoaded', function() {
            generateQRCode();
        });
    </script>
    @endslot
</x-Layout.Vertical.Master>
