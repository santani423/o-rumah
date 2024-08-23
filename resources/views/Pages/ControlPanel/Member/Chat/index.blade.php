<x-Layout.Vertical.Master title="Chat">
    @slot('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Group Chats</h4>
                </div>
                <div class="card-body">
                    @if($groupChats->isEmpty())
                        <p class="text-center">No group chats available.</p>
                    @else
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Ads ID</th>
                                    <th>Message</th>
                                    <th>Image</th>
                                    <th>Sent At</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupChats as $chat)
                                    <tr>
                                        <td>{{ $chat->id }}</td>
                                        <td>{{ $chat->user_id }}</td>
                                        <td>{{ $chat->ads_id }}</td>
                                        <td>{{ $chat->message }}</td>
                                        <td>
                                            @if($chat->image)
                                                <img src="{{ asset('storage/' . $chat->image) }}" alt="Image" width="50">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($chat->sent_at)->format('Y-m-d H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($chat->created_at)->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <!-- Button to trigger the modal -->
                    <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#devChetingModal">
                        <i class="fa fa-warning"></i> Development Mode
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal fade" id="devChetingModal" tabindex="-1" role="dialog" aria-labelledby="devChetingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="devChetingModalLabel">Development Mode - Chat</h5>
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
                        <form id="chatForm" class="d-flex align-items-center">
                            <!-- Image Input with Upload Icon -->
                            <div class="input-group-prepend">
                                <label for="chatImage" class="btn btn-secondary">
                                    <i class="fa fa-upload"></i>
                                </label>
                                <input type="file" id="chatImage" class="d-none" accept="image/*">
                            </div>
                            <!-- Hidden input for ads_id -->
                            <input type="hidden" id="adsId" value="1335">
                            <!-- Text Input and Send Button -->
                            <input type="text" id="chatMessage" class="form-control ml-2" placeholder="Type your message...">
                            <div class="input-group-append">
                                <button class="btn btn-success ml-2" type="button" id="sendMessage">Send</button>
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
    @endslot

    @slot('js')
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

        // Handle Send Message
        document.getElementById('sendMessage').addEventListener('click', function() {
            var message = document.getElementById('chatMessage').value;
            var chatImage = document.getElementById('chatImage').files[0];
            var adsId = document.getElementById('adsId').value;

            var formData = new FormData();
            formData.append('message', message);
            formData.append('ads_id', adsId); // Include the ads_id
            if (chatImage) {
                formData.append('image', chatImage);
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
                console.log('data', data);

                // Display sent message in UI
                displayMessage(data.message, data.image, getCurrentTime(), data.user_id);
                document.getElementById('chatMessage').value = '';
                document.getElementById('chatImage').value = '';
                document.getElementById('imagePreview').classList.add('d-none');
            })
            .catch(error => console.error('Error:', error));
        });

        // Display Messages Function
        function displayMessage(message, image, time, chatId) {
            var chatMessages = document.querySelector('.chat-messages');
            var newMessage = document.createElement('div');

            // Check if chatId matches the authenticated user's ID
            var isUserMessage = chatId == "{{ Auth::user()->id }}";
            console.log('isUserMessage auth', "{{ Auth::user()->id }}")
            console.log('isUserMessage chatId', chatId)

            // Determine the message position (left or right)
            newMessage.classList.add('message', isUserMessage ? 'text-right' : 'text-left');

            newMessage.innerHTML = `
                <small class="text-muted d-block ${isUserMessage ? 'text-right' : 'text-left'}">${time}</small>
                <div class="d-flex align-items-start ${isUserMessage ? 'justify-content-end' : 'justify-content-start'} mb-3">
                    ${!isUserMessage ? '<img src="https://via.placeholder.com/40" class="rounded-circle mr-2" alt="User">' : ''}
                    <div class="${isUserMessage ? 'bg-success text-white' : 'bg-light text-dark'} rounded p-2">
                        <p class="mb-0"><strong>${isUserMessage ? 'You' : 'Lawan Bicara'}:</strong> ${message}</p>
                        ${image ? `<img src="/storage/${image}" alt="Image" class="img-fluid mt-2">` : ''}
                    </div>
                    ${isUserMessage ? '<img src="https://via.placeholder.com/40" class="rounded-circle ml-2" alt="User">' : ''}
                </div>
            `;
            chatMessages.appendChild(newMessage);

            // Automatically scroll to the bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
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

        // var userId = "{{ Auth::user()->id }}"; // Get the authenticated user's ID
        var userId = "177"; // Get the authenticated user's ID
        var adsId = "1335"; // Placeholder for the ads ID

        // Fetch All Chat Messages on Page Load
        fetch(`/chats?user_id=${userId}&ads_id=${adsId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(chat => {
                    displayMessage(chat.message, chat.image, chat.sent_at, chat.user_id);
                });

                // Automatically scroll to the bottom after messages are loaded
                var chatMessages = document.querySelector('.chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight;

                document.getElementById('chatMessage').value = '';
                document.getElementById('chatImage').value = '';
                document.getElementById('imagePreview').classList.add('d-none');
            })
            .catch(error => console.error('Error:', error));

        // Auto-scroll to the bottom when the modal is opened
        $('#devChetingModal').on('shown.bs.modal', function() {
            var chatMessages = document.querySelector('.chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        function navigateTo(url, isOrder = false) {
            if (isOrder) {
                $.ajax({
                    url: '{{ route("order") }}',
                    type: 'get',
                    data: {
                        adsId: ""
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
    @endslot
</x-Layout.Vertical.Master>
