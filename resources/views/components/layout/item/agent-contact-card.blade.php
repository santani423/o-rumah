<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle"
                        src="{{ !empty($agent['image']) ? $agent['image'] : asset('zenter/horizontal/assets/images/users/avatar-6.jpg') }}"
                        alt=" " height="64" width="64" style="border-radius: 50%;">
                    <div class="media-body">
                        <h5 class="mt-0 font-18">{{$agent['name']}}</h5>
                        <p>Bergabung sejak {{$agent['joined_at']}}</p>
                    </div>
                </div>
                <div class="row">
                    <!-- Tombol Ajukan KPR -->
                    <div class="col-lg-12 mb-3">
                        @if ($btnKpr)
                            <a href="{{route('linkKpr', $ads->slug)}}" class="btn btn-primary btn-block">
                                <i class="fa fa-bank"></i> Ajukan KPR
                            </a>
                        @endif 
                        @if ($btnLelang)
                            <a href="{{ route('auction-link', ['slug' => $ads->slug, 'username' => $agent['username']]) }}"
                                class="btn btn-primary btn-block">
                                Ajukan Lelang
                            </a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <!-- Tombol Telepon -->
                    @if($agent['phone'])
                        <div class="col-lg-6 mb-3">
                            <button class="btn btn-info btn-block" onclick="navigateTo('tel:{{$agent['phone']}}', {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'true' : 'false' }})">
                                <i class="mdi mdi-phone"></i> {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'order' : 'Telepon' }}
                            </button>
                        </div>
                    @endif
                    <!-- Tombol WhatsApp -->
                    @if($agent['wa_phone'])
                        @php 
                            $wa_phone = (strpos($agent['wa_phone'], '08') === 0) 
                                        ? '+62' . substr($agent['wa_phone'], 1) 
                                        : $agent['wa_phone'];
                        @endphp
                        <div class="col-lg-6 mb-3">
                            <button class="btn btn-success btn-block" 
                                    onclick="navigateTo('https://wa.me/{{$wa_phone}}', {{ $ads->type == 'food' || $ads->type == 'marchant' || $ads->type == 'merchant'  ? 'true' : 'false' }})">
                                {!! $ads->type == 'food' || $ads->type == 'marchant' || $ads->type == 'merchant' ? 'order' : '<i class="mdi mdi-whatsapp"></i> WhatsApp' !!}
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Tombol Modal Jika setDevCheting true -->
                @if(config('app.setDevCheting') === true)
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#devChetingModal">
                                <i class="fa fa-warning"></i> Development Mode
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->
<!-- Modal -->
@if(config('app.setDevCheting') === true)
<div class="modal fade" id="devChetingModal" tabindex="-1" role="dialog" aria-labelledby="devChetingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"> <!-- modal-lg untuk ukuran lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="devChetingModalLabel">Development Mode - Chat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Chat Layout -->
                <div class="chat-container">
                    <div class="chat-messages p-3" style="height: 400px; overflow-y: scroll; background-color: #f7f7f7; border: 1px solid #ddd;">
                        <!-- Sample Chat Messages -->
                        <div class="message">
                            <small class="text-muted d-block text-left">12:30 PM</small> <!-- Time above the message -->
                            <div class="d-flex align-items-start mb-3">
                                <img src="https://via.placeholder.com/40" class="rounded-circle mr-2" alt="User">
                                <div class="bg-light rounded p-2">
                                    <p class="mb-0"><strong>User 1:</strong> Hi, how are you?</p>
                                    <img src="https://via.placeholder.com/150" alt="Image" class="img-fluid mt-2">
                                </div>
                            </div>
                        </div>
                        <div class="message text-right">
                            <small class="text-muted d-block text-right">12:31 PM</small> <!-- Time above the message -->
                            <div class="d-flex align-items-start justify-content-end mb-3">
                                <div class="bg-primary text-white rounded p-2">
                                    <p class="mb-0"><strong>You:</strong> I'm good! How about you?</p>
                                    <img src="https://via.placeholder.com/150" alt="Image" class="img-fluid mt-2">
                                </div>
                                <img src="https://via.placeholder.com/40" class="rounded-circle ml-2" alt="User">
                            </div>
                        </div>
                        <!-- Add more messages as needed -->
                    </div>
                    <div class="chat-input mt-3">
                        <form id="chatForm" class="d-flex align-items-center">
                            <!-- Image Input with Upload Icon -->
                            <div class="input-group-prepend">
                                <label for="chatImage" class="btn btn-secondary">
                                    <i class="fa fa-upload"></i>
                                </label>
                                <input type="file" id="chatImage" class="d-none" accept="image/*">
                            </div>
                            <!-- Text Input and Send Button -->
                            <input type="text" id="chatMessage" class="form-control ml-2" placeholder="Type your message...">
                            <div class="input-group-append">
                                <button class="btn btn-primary ml-2" type="button" id="sendMessage">Send</button>
                            </div>
                        </form>
                    </div>
                    <div class="preview mt-3">
                        <img id="imagePreview" src="#" alt="Preview Image" class="img-fluid d-none" style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // Function to get current time in HH:MM AM/PM format
    function getCurrentTime() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12; // Convert 24-hour to 12-hour format
        return `${hours}:${minutes} ${ampm}`;
    }

    document.getElementById('sendMessage').addEventListener('click', function () {
        var message = document.getElementById('chatMessage').value;
        var time = getCurrentTime();

        if (message.trim() !== '') {
            var chatMessages = document.querySelector('.chat-messages');
            var newMessage = document.createElement('div');
            newMessage.classList.add('message', 'text-right');
            newMessage.innerHTML = `
                <small class="text-muted d-block text-right">${time}</small> <!-- Time above the message -->
                <div class="d-flex align-items-start justify-content-end mb-3">
                    <div class="bg-primary text-white rounded p-2">
                        <p class="mb-0"><strong>You:</strong> ${message}</p>
                    </div>
                    <img src="https://via.placeholder.com/40" class="rounded-circle ml-2" alt="User">
                </div>
            `;

            chatMessages.appendChild(newMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight; // Auto scroll to the bottom

            // Clear input
            document.getElementById('chatMessage').value = '';
        }
    });

    document.getElementById('chatImage').addEventListener('change', function () {
        var chatImage = this.files[0];
        var time = getCurrentTime();

        if (chatImage && chatImage.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Display the image preview
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none');

                // Optionally, add the image to the chat
                var chatMessages = document.querySelector('.chat-messages');
                var newMessage = document.createElement('div');
                newMessage.classList.add('message', 'text-right');
                newMessage.innerHTML = `
                    <small class="text-muted d-block text-right">${time}</small> <!-- Time above the message -->
                    <div class="d-flex align-items-start justify-content-end mb-3">
                        <div class="bg-primary text-white rounded p-2">
                            <p class="mb-0"><strong>You:</strong> Sent an image</p>
                            <img src="${e.target.result}" alt="Image" class="img-fluid mt-2">
                        </div>
                        <img src="https://via.placeholder.com/40" class="rounded-circle ml-2" alt="User">
                    </div>
                `;

                chatMessages.appendChild(newMessage);
                chatMessages.scrollTop = chatMessages.scrollHeight; // Auto scroll to the bottom

                // Clear input
                document.getElementById('chatImage').value = '';
                imagePreview.classList.add('d-none'); // Hide preview after sending
            };
            reader.readAsDataURL(chatImage);
        }
    });
</script>





<script>
    function navigateTo(url, isOrder = false) {
        if (isOrder) {
            $.ajax({
                url: '{{ route("order") }}', // Endpoint untuk order, pastikan route nama sesuai
                type: 'get',
                data: {
                    // Tambahkan data yang diperlukan untuk permintaan order
                    adsId : "{{$ads->ads_id}}"
                },
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                success: function(data) {
                    window.location.href = url;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        } else {
            window.location.href = url;
        }
    }
</script>
