<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT-like Interface</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .chat-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .chat-box {
            height: 80vh;
            overflow-y: scroll;
            padding: 20px;
        }

        .chat-input-container {
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <div class="container chat-container">
        <div class="chat-box border">
            <!-- Sample messages -->
            <p><strong>User:</strong> Hello, ChatGPT!</p>
            <p><strong>ChatGPT:</strong> Hello, User! How can I assist you today?</p>
        </div>
        <div class="chat-input-container">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Type your message here..."
                    aria-label="Message input">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">Send</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            const $sendButton = $('.btn-primary');
            const $inputField = $('.form-control');
            const $chatBox = $('.chat-box');

            $sendButton.on('click', function() {
                const messageContent = $inputField.val();

                // If the message is empty, return
                if (!messageContent) return;

                // Append user message to chat box
                $chatBox.append(`<p><strong>User:</strong> ${messageContent}</p>`);

                // Send the content to the Laravel route
                $.ajax({
                    url: '{{ route('get_chat') }}',
                    method: 'POST',
                    data: {
                        message: messageContent
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Append the chatbot's response to the chat box
                        if (data && data.content) {
                            $chatBox.append(`<p><strong>ChatGPT:</strong> ${data.content}</p>`);

                            // Scroll to the bottom of the chat box to show the latest messages
                            $chatBox.scrollTop($chatBox[0].scrollHeight);
                        }

                        // Clear the input field
                        $inputField.val('');
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>
