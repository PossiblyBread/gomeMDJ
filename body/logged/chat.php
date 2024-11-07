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
        <div class="userInput-container">
            <input type="text" class="userInput" id="userInput" placeholder="Type a message...">
            <button class="send-button" id="send-button">Send</button>
        </div>
        <div class="quick-replies" id="quick-replies"></div>
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
        let responsesFile1 = {}; // To store responses from first JSON file
        let responsesFile2 = {}; // To store responses from second JSON file

        // Fetch responses from the first JSON file
        fetch('../body/logged/responses.json')
            .then(response => response.json())
            .then(data => {
                responsesFile1 = data.responses; // Store responses in the variable
            })
            .catch(error => console.error('Error fetching the first JSON file:', error));

        // Fetch responses from the second JSON file
        fetch('../body/responses.json')
            .then(response => response.json())
            .then(data => {
                responsesFile2 = data.responses; // Store responses in the variable
            })
            .catch(error => console.error('Error fetching the second JSON file:', error));

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

        // Function to get bot response from both JSON files
        function getBotResponse(userMessage) {
            const lowerCaseMessage = userMessage.toLowerCase();

            // Check for response in both files (responsesFile1 and responsesFile2)
            const responseFile1 = responsesFile1[lowerCaseMessage];
            const responseFile2 = responsesFile2[lowerCaseMessage];

            if (responseFile1) {
                return responseFile1;
            } else if (responseFile2) {
                return responseFile2;
            } else {
                return {
                    text: "I'm sorry, I didn't understand that.",
                    quickReplies: []
                };
            }
        }
    </script>
</body>
</html>
    <style>
        /* Chat Button */
        .chat-icon {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 60px;
            height: 60px;
            background-color: #7f8c8d;
            /* Gray */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .chat-icon svg {
            fill: white;
            /* White icon */
            width: 30px;
            height: 30px;
        }

        .chat-icon:hover {
            background-color: #95a5a6;
            /* Lighter gray on hover */
        }

        /* Chat Box */
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

        /* Chat Header */
        .chat-header {
            background-color: #666;
            /* Grayscale color */
            padding: 10px;
            color: white;
            font-size: 18px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            position: relative;
            /* To position the close button */
        }

        /* Close Button in Chat Header */
        .chat-close {
            background: none;
            /* No background */
            border: none;
            /* No border */
            color: white;
            /* White color */
            font-size: 18px;
            /* Font size */
            cursor: pointer;
            /* Pointer cursor */
            position: absolute;
            /* Position it in the header */
            right: 10px;
            /* Align to the right */
            top: 10px;
            /* Align to the top */
        }


        .chat-close:hover {
            background-color: #2c3e50;
            /* Darker gray on hover */
        }

        /* Chat Content */
        .chat-content {
            padding: 15px;
            height: 230px;
            /* Fixed height for content */
            overflow-y: auto;
            /* Scrollable content */
            flex: 1;
            /* Allow content to take available space */
            color: #2c3e50;
            /* Dark gray text */
        }

        /* User and Bot Message Styles */
        .user {
            text-align: right;
            color: blue;
            /* User messages in blue */
        }

        .bot {
            text-align: left;
            color: green;
            /* Bot messages in green */
        }

        /* Chat Input Container */
        .userInput-container {
            display: flex;
            /* Align input and button side by side */
            padding: 10px;
            /* Add some padding */
        }

        /* Chat Input */
        .userInput {
            flex: 1;
            /* Allow the input to grow */
            padding: 10px;
            /* Add some padding */
            border: 1px solid #aaa;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 14px;
            /* Font size */
            color: #333;
            /* Text color */
        }

        /* Send Button */
        .send-button {
            background-color: #666;
            /* Grayscale color */
            color: white;
            /* Text color */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            padding: 10px 15px;
            /* Padding */
            cursor: pointer;
            /* Pointer cursor */
            margin-left: 10px;
            /* Space between input and button */
        }

        .send-button:hover {
            background-color: #555;
            /* Darker gray on hover */
        }

        /* Quick Replies */
        .quick-replies {
            padding: 10px;
            /* Padding for replies */
            display: flex;
            /* Display buttons inline */
            flex-wrap: wrap;
            /* Allow wrapping of buttons */
            gap: 10px;
            /* Space between buttons */
        }

        .quick-reply {
            background-color: #e7e7e7;
            /* Light gray */
            border: none;
            /* No border */
            padding: 8px 12px;
            /* Padding */
            border-radius: 5px;
            /* Rounded corners */
            cursor: pointer;
            /* Pointer cursor */
        }

        .quick-reply:hover {
            background-color: #dcdcdc;
            /* Darker gray on hover */
        }
    </style>