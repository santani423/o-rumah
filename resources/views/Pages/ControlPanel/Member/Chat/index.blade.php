<x-Layout.Vertical.Master title="Chat">
    @slot('body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> Chats</h4>
                </div>
                <div class="card-body">
                    @if($groupChats->isEmpty())
                    <p class="text-center">No group chats available.</p>
                    @else
                    <table class="table table-bordered table-hover">
                        <tbody>
                            @foreach($groupChats as $chat)
                            <tr class="chat-row" data-user-id="{{ $chat->user_id }}" data-ads-id="{{ $chat->ads_id }}">
                                <td><img src="{{ $chat->image_user }}" class="rounded-circle mr-2" height="50" width="50" alt="User"> <b>{{ $chat->name_user }}</b> </td>
                                 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
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
                            <form id="chatForm" class="d-flex align-items-center">
                                <!-- Image Input with Upload Icon -->
                                <div class="input-group-prepend">
                                    <label for="chatImage" class="btn btn-secondary">
                                        <i class="fa fa-upload"></i>
                                    </label>
                                    <input type="file" id="chatImage" class="d-none" accept="image/*">
                                </div>
                                <!-- Hidden input for ads_id -->
                                <input type="hidden" id="adsId" value="">
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
        let intervalId; // For interval to refresh chat messages

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
                    displayMessage(data.message, data.image, getCurrentTime(), data.user_id, data.name, data.profile);
                    document.getElementById('chatMessage').value = '';
                    document.getElementById('chatImage').value = '';
                    document.getElementById('imagePreview').classList.add('d-none');
                })
                .catch(error => console.error('Error:', error));
        });

        // Display Messages Function
        function displayMessage(message, image, time, chatId, name, profile) {
            var chatMessages = document.querySelector('.chat-messages');
            var newMessage = document.createElement('div');
            console.log('name', name);

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

        // Open Chat Modal and Fetch Messages
        document.querySelectorAll('.chat-row').forEach(row => {
            row.addEventListener('click', function() {
                var userId = this.getAttribute('data-user-id');
                var adsId = this.getAttribute('data-ads-id');

                // Set the adsId in hidden input
                document.getElementById('adsId').value = adsId;

                // Show the modal
                $('#devChetingModal').modal('show');

                // Fetch and display chat messages when the modal is opened
                function fetchMessages(scrollToBottom = false) {
                    fetch(`/chats?user_id=${userId}&ads_id=${adsId}`)
                        .then(response => response.json())
                        .then(data => {
                            const chatMessages = document.querySelector('.chat-messages');
                            chatMessages.innerHTML = ''; // Clear previous messages
                            data.forEach(chat => {
                                displayMessage(chat.message, chat.image, chat.sent_at, chat.user_id, chat.name, chat.profile);
                            });
                            if (scrollToBottom) {
                                chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to bottom
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Clear previous interval if any
                clearInterval(intervalId);

                // Set an interval to fetch messages every 3 seconds without scrolling
                intervalId = setInterval(() => fetchMessages(false), 3000);

                // Fetch messages initially when modal opens and scroll to bottom
                fetchMessages(true);
            });
        });
    </script>
    @endslot
</x-Layout.Vertical.Master>
