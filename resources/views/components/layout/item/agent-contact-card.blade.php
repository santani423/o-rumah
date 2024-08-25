<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle"
                        src="{{ !empty($agent['image']) ? $agent['image'] : asset('zenter/horizontal/assets/images/users/avatar-6.jpg') }}"
                        alt="User Image" height="64" width="64">
                    <div class="media-body">
                        <h5 class="mt-0 font-18">{{$agent['name']}}</h5>
                        <p>Bergabung sejak {{$agent['joined_at']}}</p>
                    </div>
                </div>
                <div class="row">
                    <!-- Tombol Ajukan KPR dan Lelang -->
                    <div class="col-lg-12 mb-3">
                        @if ($btnKpr)
                        <a href="{{route('linkKpr', $ads->slug)}}" class="btn btn-success btn-block">
                            <i class="fa fa-bank"></i> Ajukan KPR
                        </a>
                        @endif
                        @if ($btnLelang)
                        <a href="{{ route('auction-link', ['slug' => $ads->slug, 'username' => $agent['username']]) }}"
                            class="btn btn-success btn-block">
                            Ajukan Lelang
                        </a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <!-- Tombol Telepon dan WhatsApp -->
                    @if($agent['phone'])
                    <div class="col-lg-6 mb-3">
                        <button class="btn btn-info btn-block" onclick="navigateTo('tel:{{$agent['phone']}}', {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'true' : 'false' }})">
                            <i class="mdi mdi-phone"></i> {{ $ads->type == 'food' || $ads->type == 'marchant' ? 'order' : 'Telepon' }}
                        </button>
                    </div>
                    @endif
                    @if($agent['wa_phone'])
                    @php
                    $wa_phone = (strpos($agent['wa_phone'], '08') === 0)
                    ? '+62' . substr($agent['wa_phone'], 1)
                    : $agent['wa_phone'];
                    @endphp
                    @if(config('app.setDevCheting') === true)

                    <div class="col-lg-12 mb-3">
                        <button class="btn btn-success btn-block" data-toggle="modal" @if(Auth::user()) data-target="#devChetingModal" @else data-target=".loginDanRegistrasi" @endif>
                            <i class="fa fa-warning"></i> Chat
                        </button>
                    </div>



                    @else
                    <div class="col-lg-12 mb-3">
                        <button class="btn btn-success btn-block"
                            onclick="navigateTo('https://wa.me/{{$wa_phone}}', {{ $ads->type == 'food' || $ads->type == 'marchant' || $ads->type == 'merchant' ? 'true' : 'false' }})">
                            {!! $ads->type == 'food' || $ads->type == 'marchant' || $ads->type == 'merchant' ? 'order' : '<i class="mdi mdi-whatsapp"></i> WhatsApp' !!}
                        </button>
                    </div>
                    @endif
                    @endif
                </div>

                <!-- Tombol Modal Jika setDevCheting true -->

            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->

<!-- Modal -->
@if(config('app.setDevCheting') === true)
<div class="modal fade" id="devChetingModal" tabindex="-1" role="dialog" aria-labelledby="devChetingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="devChetingModalLabel"> Chat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="chat-container">
                    <div class="chat-messages p-3" style="height: 400px; overflow-y: scroll; background-color: #f7f7f7; border: 1px solid #ddd;">
                        <!-- Chat Messages Placeholder -->
                    </div>
                    <div class="chat-input mt-3">
                        <form id="chatForm" class="d-flex align-items-center" enctype="multipart/form-data">
                            <!-- Image Input with Upload Icon -->
                            <div class="input-group-prepend">
                                <label for="chatImage" class="btn btn-secondary">
                                    <i class="fa fa-upload"></i>
                                </label>
                                <input type="file" id="chatImage" class="d-none" accept="image/*">
                            </div>
                            <!-- Hidden input for ads_id -->
                            <input type="hidden" id="adsId" value="{{ $ads->ads_id }}">
                            <!-- Text Input and Send Button -->
                            <input type="text" id="chatMessage" class="form-control ml-2" placeholder="Type your message...">
                            <div class="input-group-append">
                                <button class="btn btn-success ml-2" type="button" id="sendMessage">
                                    <span id="sendButtonText"><i class="fa fa-paper-plane"></i> Send</span>
                                    <span id="sendButtonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
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
    var userId = "{{ Auth::user()?->id }}"; // Get the authenticated user's ID
    var adsId = "{{ $ads->ads_id }}"; // Get the ads ID
    var isUserAtBottom = true; // Flag to determine if user is at the bottom of the chat container
    var intervalId;

    // Function to get current time in HH:MM AM/PM format
    function getCurrentTime() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12; // Convert 24-hour to 12-hour format
        return `${hours}:${minutes} ${ampm}`;
    }

    // Function to fetch chat messages and update the UI
    function fetchChatMessages() {
        fetch(`/chats?user_id=${userId}&ads_id=${adsId}`)
            .then(response => response.json())
            .then(data => {
                console.log('qwertydata', data);

                const chatMessages = document.querySelector('.chat-messages');
                chatMessages.innerHTML = ''; // Clear current chat messages
                data.forEach(chat => {
                    displayMessage(chat.message, chat.image, chat.sent_at, chat.user_id, chat.name, chat.profile);
                });

                // Scroll to the bottom only if the user is at the bottom
                if (isUserAtBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Handle Send Message
    document.getElementById('sendMessage').addEventListener('click', sendMessage);

    // Add event listener for Enter keypress
    document.getElementById('chatMessage').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault(); // Prevent the default behavior of Enter key
            sendMessage();
        }
    });

    function toggleSpinner(show) {
        const sendButtonSpinner = document.getElementById('sendButtonSpinner');
        const sendButtonText = document.getElementById('sendButtonText');

        if (show) {
            sendButtonSpinner.classList.remove('d-none');
            sendButtonText.classList.add('d-none');
        } else {
            sendButtonSpinner.classList.add('d-none');
            sendButtonText.classList.remove('d-none');
        }
    }

    // Function to handle sending the message
    // Function to handle sending the message
    function sendMessage() {
        var message = document.getElementById('chatMessage').value;
        var chatImage = document.getElementById('chatImage').files[0];
        var adsId = document.getElementById('adsId').value;

        if (message.trim() === '' && !chatImage) {
            return; // Don't send empty message if no image is attached
        }

        toggleSpinner(true); // Show spinner

        var formData = new FormData();
        formData.append('message', message);
        formData.append('ads_id', adsId); // Include the ads_id

        if (chatImage) {
            formData.append('image', chatImage); // Attach image if exists
        }

        fetch('/chats', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                displayMessage(data.message, data.image, getCurrentTime(), data.user_id, data.name, data.profile);
                document.getElementById('chatMessage').value = '';
                document.getElementById('chatImage').value = ''; // Reset file input
                document.getElementById('imagePreview').classList.add('d-none'); // Hide preview
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                toggleSpinner(false); // Hide spinner
            });
    }


    // Display Messages Function
    function displayMessage(message, image, time, chatId, name, profile) {
        var chatMessages = document.querySelector('.chat-messages');
        var newMessage = document.createElement('div');
        console.log('name',name);
        
        // Check if chatId is equal to the current user ID
        var isUserMessage = chatId == "{{ Auth::user()?->id }}";
        // Determine message position (left or right)
        newMessage.classList.add('message', isUserMessage ? 'text-right' : 'text-left');

        // Construct profile image URL
        var profileImage = profile ? `{{ route('home') }}${profile}` : `{{ route('home') }}/path/to/default-avatar.jpg`;

        console.log('profileImage', profileImage);

        // Only display message if it is not null or empty, otherwise leave it blank
        var messageContent = message ? `<p class="mb-0"><strong>${isUserMessage ? 'Anda' : name}:</strong> ${message}</p>` : '';

        newMessage.innerHTML = `
    <small class="text-muted d-block ${isUserMessage ? 'text-right' : 'text-left'}">${time}</small>
    <div class="d-flex align-items-start ${isUserMessage ? 'justify-content-end' : 'justify-content-start'} mb-3">
        ${!isUserMessage ? `<img src="${profileImage}" class="rounded-circle mr-2" height="50" width="50" alt="User">` : ''}
        <div class="${isUserMessage ? 'bg-success text-white' : 'bg-light text-dark'} rounded p-2">
            ${messageContent}   
            ${image ? `<img src="/storage/${image}" alt="Image" class="img-fluid mt-2">` : ''}
        </div>
        ${isUserMessage ? `<img src="${profileImage}" class="rounded-circle ml-2" height="50" width="50" alt="User">` : ''}
    </div>
    `;

        chatMessages.appendChild(newMessage);
    }



    // Image Preview Functionality
    document.getElementById('chatImage').addEventListener('change', function() {
        var chatImage = this.files[0];

        if (chatImage && chatImage.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none');
            };
            reader.readAsDataURL(chatImage);
        }
    });

    // Function to start fetching chat messages periodically
    function startFetching() {
        intervalId = setInterval(fetchChatMessages, 3000);
    }

    // Function to stop fetching chat messages
    function stopFetching() {
        clearInterval(intervalId);
    }

    // Auto-fetch chat messages every 3 seconds
    startFetching();

    // Scroll event listener to handle user scrolling
    document.querySelector('.chat-messages').addEventListener('scroll', function() {
        var chatMessages = document.querySelector('.chat-messages');
        var isScrolledToBottom = chatMessages.scrollHeight - chatMessages.scrollTop === chatMessages.clientHeight;

        // Update the flag and control fetching based on scroll position
        if (isScrolledToBottom) {
            isUserAtBottom = true;
            startFetching();
        } else {
            isUserAtBottom = false;
            stopFetching();
        }
    });

    // Auto-scroll to bottom when modal opens
    $('#devChetingModal').on('shown.bs.modal', function() {
        var chatMessages = document.querySelector('.chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    // Fetch All Chat Messages on Page Load
    fetchChatMessages();

    function navigateTo(url, isOrder = false) {
        if (isOrder) {
            $.ajax({
                url: '{{ route("order") }}',
                type: 'get',
                data: {
                    adsId: "{{$ads->ads_id}}"
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