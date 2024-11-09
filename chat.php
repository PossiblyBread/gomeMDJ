<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Bike Chat</title>
</head>

<body>
    <!-- Chat Button -->
    <div class="chat-icon" id="chat-button">
        <svg fill="#000000" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 12v4l-5-4H0V0h16v12zm-2-2V2H2v8h12zm-2.5 0l2.5 2v-2h-2.5zM4 4h8v2H4V4z" fill-rule="evenodd"></path>
        </svg>
    </div>
    <!-- Chat Box -->
    <div class="chat-box" id="chat-box">
        <div class="chat-header">
            E-Bike Chat
            <button class="chat-close" id="close-chat">✖</button>
        </div>
        <div class="chat-content" id="chat-content"></div>
        <div class="quick-replies" id="quick-replies"></div>
        <div class="userInput-container">
            <input type="text" class="userInput" id="userInput" placeholder="Welcome to MDJ chatbot">
            <button class="send-button" id="send-button">Send</button>
        </div>
    </div>

    <script>
        const chatButton = document.getElementById('chat-button');
        const chatBox = document.getElementById('chat-box');
        const closeChatButton = document.getElementById('close-chat');
        const sendButton = document.getElementById('send-button');
        const chatInput = document.getElementById('userInput');
        const chatContent = document.getElementById('chat-content');
        const quickRepliesContainer = document.getElementById('quick-replies');
        let isChatOpen = false;
        let responses = {}; // To store responses from JSON

        // Fetch responses from JSON file
        fetch('responses-guest.json')
            .then(response => response.json())
            .then(data => {
                responses = data.responses; // Store responses in the variable
            })
            .catch(error => console.error('Error fetching the JSON file:', error));

        // Toggle chat box visibility
        chatButton.addEventListener('click', () => {
            chatBox.style.bottom = isChatOpen ? '-400px' : '20px';
            isChatOpen = !isChatOpen;

            // When chat opens, show initial quick replies
            if (isChatOpen) {
                displayQuickReplies([{
                        text: 'Hi',
                        value: 'greetings'
                    },
                    {
                        text: 'Hello',
                        value: 'greetings'
                    }
                ]);
            }
        });
        // Close chat box
        closeChatButton.addEventListener('click', () => {
            chatBox.style.bottom = '-400px';
            isChatOpen = false;

            // Reset chat content when closed
            chatContent.innerHTML = ''; // Clear chat content
            quickRepliesContainer.innerHTML = ''; 
            chatInput.value = '';
        });


        // Append messages to chat content
        function appendMessage(message, sender) {
            const messageElement = document.createElement('p');
            messageElement.textContent = message;
            messageElement.className = sender; // Add class based on sender
            chatContent.appendChild(messageElement);
            chatContent.scrollTop = chatContent.scrollHeight; // Scroll to bottom
        }

        // Function to display quick replies
        function displayQuickReplies(replies) {
            quickRepliesContainer.innerHTML = ''; // Clear previous replies
            replies.forEach(reply => {
                const button = document.createElement('button');
                button.className = 'quick-reply';
                button.textContent = reply.text;
                button.addEventListener('click', () => {
                    sendMessage(reply.value); // Send the predefined question
                });
                quickRepliesContainer.appendChild(button);
            });
        }

        // Handle send button click
        function sendMessage(userMessage) {
            if (userMessage) {
                appendMessage(userMessage, 'user');
                chatInput.value = ''; // Clear input

                // Simulate bot response based on user input
                let botResponse = getBotResponse(userMessage);

                // Simulate a delay for response
                setTimeout(() => {
                    appendMessage(botResponse.text, 'bot'); // Auto-response
                    displayQuickReplies(botResponse.quickReplies); // Show next questions
                }, 1000);
            }
        }

        sendButton.addEventListener('click', () => {
            const userMessage = chatInput.value.trim();
            sendMessage(userMessage);
        });

        // Handle Enter key press
        chatInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent default action (new line)
                const userMessage = chatInput.value.trim();
                sendMessage(userMessage); // Send message
            }
        });

        // Function to get bot response from JSON data
        function getBotResponse(userMessage) {
            return responses[userMessage.toLowerCase()] || {
                text: "I'm sorry, I didn't understand that.",
                quickReplies: []
            };
        }
    </script>

    <style>
        /* start for chat icon */
        .chat-icon {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 60px;
            height: 60px;
            background-color: #7f8c8d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .chat-icon svg {
            fill: white;
            width: 30px;
            height: 30px;
        }

        .chat-icon:hover {
            background-color: #95a5a6;
        }
        /* end for chat icon */
        /* start for chat box */
        .chat-box {
            position: fixed;
            right: 20px;
            bottom: 20px;
            height: 400px;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: bottom 0.5s ease;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: #666;
            padding: 10px;
            color: white;
            font-size: 18px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            position: relative;
        }

        .chat-close {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
        }

        .chat-close:hover {
            background-color: #2c3e50;
        }

        .chat-content {
            padding: 15px;
            height: 230px;
            overflow-y: auto;
            flex: 1;
            color: #2c3e50;
        }
        /* user and chatbot conversation design */
        .user {
            text-align: right;
            color: black;
            background-color: lightblue;
            border-radius: 5px;
            padding: 5px;
        }

        .bot {
            text-align: left;
            color: black;
            background-color: lightgoldenrodyellow;
            border-radius: 5px;
            padding: 5px;
        }
        /* end  */
        .userInput-container {
            display: flex;
            padding: 10px;
        }

        .userInput {
            flex: 1;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        .send-button {
            background-color: #666;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            margin-left: 10px;
        }

        .send-button:hover {
            background-color: #555;
        }
        /* end for chatbox */
        /* quick reply style */
        .quick-replies {
            padding: 10px;
            display: flex;
            flex-wrap: nowrap; 
            gap: 10px;
            overflow-x: auto; 
            overflow-y: hidden; 
            white-space: nowrap; 
            max-width: 100%; 
        }

        .quick-reply {
            background-color: #e7e7e7;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            white-space: nowrap; 
        }

        .quick-reply:hover {
            background-color: #dcdcdc;
        }
        /* end for quick reply */
    </style>
</body>
</html>