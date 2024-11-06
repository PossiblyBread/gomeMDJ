<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
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
            Chat
            <button class="chat-close" id="close-chat">✖</button>
        </div>
        <div class="chat-content" id="chat-content"></div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="chat-input" placeholder="Type a message...">
            <button class="send-button" id="send-button">Send</button>
        </div>
        <div class="quick-replies" id="quick-replies"></div>
        <div class="ticket-form" id="ticket-form" style="display:none;">
            <input type="text" id="serial-number" placeholder="Enter your serial number...">
            <button id="check-status">Check Status</button>
        </div>
    </div>
    
    <script>
         const chatButton = document.getElementById('chat-button');
        const chatBox = document.getElementById('chat-box');
        const closeChatButton = document.getElementById('close-chat');
        const sendButton = document.getElementById('send-button');
        const chatInput = document.getElementById('chat-input');
        const chatContent = document.getElementById('chat-content');
        const quickRepliesContainer = document.getElementById('quick-replies');
        const ticketForm = document.getElementById('ticket-form');
        const serialNumberInput = document.getElementById('serial-number');
        const checkStatusButton = document.getElementById('check-status');
        let isChatOpen = false;
        // Toggle chat box visibility
        chatButton.addEventListener('click', () => {
            chatBox.style.bottom = isChatOpen ? '-400px' : '20px';
            isChatOpen = !isChatOpen;
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

        // Handle ticket status check
        checkStatusButton.addEventListener('click', () => {
            const serialNumber = serialNumberInput.value.trim();
            if (serialNumber) {
                // Here you would normally fetch the ticket status from a database or API
                const ticketStatus = getTicketStatus(serialNumber); // Simulated function
                appendMessage(`Status for ticket ${serialNumber}: ${ticketStatus}`, 'bot');
                ticketForm.style.display = 'none'; // Hide the form after checking
            }
        });


        // Assuming conversation.json is fetched and parsed beforehand
        const conversationData = {
            "greetings": [
                "Hello! How can I assist you with e-bikes today?",
                "Hi there! What do you need help with regarding e-bikes?"
            ],
            "batteryConcerns": [
                "Battery issues can be frustrating. Can you provide details about the problem you're experiencing?",
                "If you're having battery issues, it might be related to the charging process. What have you noticed?",
                "Let's troubleshoot your battery problem. Can you describe any symptoms you're seeing?"
            ],
            "maintenanceTips": [
                "Regular maintenance is key for e-bikes. Have you checked the brakes and tires recently?",
                "To keep your e-bike in top shape, make sure to clean the chain and lubricate it regularly.",
                "It's important to check the battery connections and inspect the wiring periodically. Have you done that?"
            ],
            "rangeQuestions": [
                "The range of your e-bike can vary based on usage. What specific model do you have?",
                "Are you asking about the distance you can travel on a single charge? That can depend on several factors.",
                "To help with your range concerns, could you tell me about your typical riding conditions?"
            ],
            "accessoriesInfo": [
                "There are various accessories available for e-bikes. Are you looking for something specific?",
                "Consider adding a rack or fenders for more functionality. What accessories are you interested in?",
                "E-bike accessories can enhance your riding experience. Have you checked our latest offerings?"
            ],
            "technicalSupport": [
                "Thank you for reaching out! For technical support, please describe the issue you're facing.",
                "To expedite assistance, please provide your e-bike model and details of the problem.",
                "Our technical support team is here to help! Please specify what you need assistance with."
            ],
            "purchaseAdvice": [
                "If you're considering purchasing an e-bike, I can help guide you. What features are important to you?",
                "Looking for e-bike recommendations? Tell me your budget and preferences.",
                "There are many great e-bikes available. What type of riding do you plan to do?"
            ],
            "warrantyInfo": [
                "Warranty information can vary by model. Can you tell me which e-bike you own?",
                "Most e-bikes come with a warranty covering specific parts. Do you need details on your model?",
                "If you have a warranty question, please provide your e-bike model and purchase date."
            ],
            "chargingGuidelines": [
                "Proper charging is essential for battery life. Are you using the recommended charger for your e-bike?",
                "Make sure to charge your e-bike in a cool, dry place. Have you checked your charging environment?",
                "To maximize battery life, avoid fully discharging it regularly. How often do you charge your e-bike?"
            ],
            "generalHelp": [
                "If you have any other questions about e-bikes, feel free to ask!",
                "Is there anything else I can assist you with regarding e-bikes?",
                "Don't hesitate to reach out if you have more inquiries about e-bikes!"
            ],
            "safetyTips": [
                "Wearing a helmet is crucial for safety. Do you have one that fits properly?",
                "Be sure to follow local traffic laws while riding your e-bike. Are you familiar with them?",
                "Riding defensively is key to safety. Do you have any concerns about riding in traffic?"
            ],
            "repairServices": [
                "If you need repairs, I can help locate a service center. What issue are you facing?",
                "For repair services, please provide your e-bike model and the nature of the problem.",
                "Do you need recommendations for e-bike repair services in your area?"
            ],
            "yes": [
                "Great! I'm glad I could assist you today. Is there anything else you need help with?\n\n Yes/No",
                "I'm here to help with any further questions. Please choose from the options below. \n\n (Tech Support, Battery Issues, etc.)"
            ],
            "noResponse": [
                "To submit a support ticket, <a href='ticketing.php'>click here</a>.<br><br>Fill in the necessary details. Our team will assist you shortly!<br><br> Thank you for using the e-bike support system."
            ],
            "ticketUpdates": [
                "You can check the status of your tickets. Please provide your ticket number for updates."
            ],
            "ticketNumber": [
                "Your ticket has been received by our support team. <br><br> 1st Ticket - under review.<br> 2nd Ticket - pending parts.<br> 3rd Ticket - resolved.<br><br> Thank you for using the e-bike support system. If you have further questions, feel free to ask!"
            ]
        };

        // Function to get bot response based on user input
        function getBotResponse(message) {
            const lowerCaseMessage = message.toLowerCase();
            let response = { text: "I do not quite understand. Can you please clarify?", quickReplies: [] };

            if (lowerCaseMessage.includes('hello') || lowerCaseMessage.includes('hi')) {
                response = {
                    text: conversationData.greetings[Math.floor(Math.random() * conversationData.greetings.length)],
                    quickReplies: [
                        { text: 'Battery Issues', value: 'batteryConcerns' },
                        { text: 'Maintenance Tips', value: 'maintenanceTips' },
                        { text: 'Technical Support', value: 'technicalSupport' },
                        { text: 'Purchase Advice', value: 'purchaseAdvice' }
                    ]
                };
            }else if (lowerCaseMessage.includes('ticket') || lowerCaseMessage.includes('update')) {
                response = {
                    text: conversationData.ticketUpdates[0],
                    quickReplies: []
                };
                ticketForm.style.display = 'block'; // Show the form for serial number input
            } else if (lowerCaseMessage.includes('battery')) {
                response = {
                    text: conversationData.batteryConcerns[Math.floor(Math.random() * conversationData.batteryConcerns.length)],
                    quickReplies: [
                        { text: 'Charging Guidelines', value: 'chargingGuidelines' },
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            } else if (lowerCaseMessage.includes('maintenance')) {
                response = {
                    text: conversationData.maintenanceTips[Math.floor(Math.random() * conversationData.maintenanceTips.length)],
                    quickReplies: [
                        { text: 'Repair Services', value: 'repairServices' },
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            } else if (lowerCaseMessage.includes('range')) {
                response = {
                    text: conversationData.rangeQuestions[Math.floor(Math.random() * conversationData.rangeQuestions.length)],
                    quickReplies: [
                        { text: 'Battery Issues', value: 'batteryConcerns' },
                        { text: 'Maintenance Tips', value: 'maintenanceTips' }
                    ]
                };
            } else if (lowerCaseMessage.includes('accessories')) {
                response = {
                    text: conversationData.accessoriesInfo[Math.floor(Math.random() * conversationData.accessoriesInfo.length)],
                    quickReplies: [
                        { text: 'Purchase Advice', value: 'purchaseAdvice' },
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            } else if (lowerCaseMessage.includes('technical')) {
                response = {
                    text: conversationData.technicalSupport[Math.floor(Math.random() * conversationData.technicalSupport.length)],
                    quickReplies: [
                        { text: 'General Help', value: 'generalHelp' },
                        { text: 'Warranty Information', value: 'warrantyInfo' }
                    ]
                };
            } else if (lowerCaseMessage.includes('warranty')) {
                response = {
                    text: conversationData.warrantyInfo[Math.floor(Math.random() * conversationData.warrantyInfo.length)],
                    quickReplies: [
                        { text: 'Technical Support', value: 'technicalSupport' },
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            } else if (lowerCaseMessage.includes('charging')) {
                response = {
                    text: conversationData.chargingGuidelines[Math.floor(Math.random() * conversationData.chargingGuidelines.length)],
                    quickReplies: [
                        { text: 'Battery Issues', value: 'batteryConcerns' },
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            } else if (lowerCaseMessage.includes('help')) {
                response = {
                    text: conversationData.generalHelp[Math.floor(Math.random() * conversationData.generalHelp.length)],
                    quickReplies: [
                        { text: 'Safety Tips', value: 'safetyTips' },
                        { text: 'Repair Services', value: 'repairServices' }
                    ]
                };
            } else if (lowerCaseMessage.includes('safety')) {
                response = {
                    text: conversationData.safetyTips[Math.floor(Math.random() * conversationData.safetyTips.length)],
                    quickReplies: [
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            } else if (lowerCaseMessage.includes('repair')) {
                response = {
                    text: conversationData.repairServices[Math.floor(Math.random() * conversationData.repairServices.length)],
                    quickReplies: [
                        { text: 'Technical Support', value: 'technicalSupport' },
                        { text: 'General Help', value: 'generalHelp' }
                    ]
                };
            }
            
            return response;
        }
        function getTicketStatus(serialNumber) {
            return new Promise((resolve, reject) => {
                // AJAX request to the PHP script
                fetch(`../body/logged/get_ticket_status.php?serialNumber=${serialNumber}`)
                    .then(response => response.json())
                    .then(data => {
                        // Check if the data was received successfully
                        if (data.status) {
                            resolve(data.status); // Return the ticket status
                        } else {
                            resolve("Ticket not found."); // Fallback message
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching ticket status:", error);
                        reject("An error occurred while retrieving the ticket status.");
                    });
            });
        }

        // Example usage
        getTicketStatus("12345").then(status => {
            console.log("Ticket Status:", status); // Display the status
        });

    </script>

    <style>
        /* Chat Button */
        .chat-icon {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 60px;
            height: 60px;
            background-color: #7f8c8d; /* Gray */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .chat-icon svg {
            fill: white; /* White icon */
            width: 30px;
            height: 30px;
        }

        .chat-icon:hover {
            background-color: #95a5a6; /* Lighter gray on hover */
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
            background-color: #666; /* Grayscale color */
            padding: 10px;
            color: white;
            font-size: 18px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            position: relative; /* To position the close button */
        }
        /* Close Button in Chat Header */
        .chat-close {
            background: none; /* No background */
            border: none; /* No border */
            color: white; /* White color */
            font-size: 18px; /* Font size */
            cursor: pointer; /* Pointer cursor */
            position: absolute; /* Position it in the header */
            right: 10px; /* Align to the right */
            top: 10px; /* Align to the top */
        }


        .chat-close:hover {
            background-color: #2c3e50; /* Darker gray on hover */
        }
        /* Chat Content */
        .chat-content {
            padding: 15px;
            height: 230px; /* Fixed height for content */
            overflow-y: auto; /* Scrollable content */
            flex: 1; /* Allow content to take available space */
            color: #2c3e50; /* Dark gray text */
        }

        /* User and Bot Message Styles */
        .user {
            text-align: right;
            color: blue; /* User messages in blue */
        }

        .bot {
            text-align: left;
            color: green; /* Bot messages in green */
        }

        /* Chat Input Container */
        .chat-input-container {
            display: flex; /* Align input and button side by side */
            padding: 10px; /* Add some padding */
        }

        /* Chat Input */
        .chat-input {
            flex: 1; /* Allow the input to grow */
            padding: 10px; /* Add some padding */
            border: 1px solid #aaa; /* Border color */
            border-radius: 5px; /* Rounded corners */
            font-size: 14px; /* Font size */
            color: #333; /* Text color */
        }

        /* Send Button */
        .send-button {
            background-color: #666; /* Grayscale color */
            color: white; /* Text color */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            padding: 10px 15px; /* Padding */
            cursor: pointer; /* Pointer cursor */
            margin-left: 10px; /* Space between input and button */
        }

        .send-button:hover {
            background-color: #555; /* Darker gray on hover */
        }

        /* Quick Replies */
        .quick-replies {
            padding: 10px; /* Padding for replies */
            display: flex; /* Display buttons inline */
            flex-wrap: wrap; /* Allow wrapping of buttons */
            gap: 10px; /* Space between buttons */
        }

        .quick-reply {
            background-color: #e7e7e7; /* Light gray */
            border: none; /* No border */
            padding: 8px 12px; /* Padding */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
        }

        .quick-reply:hover {
            background-color: #dcdcdc; /* Darker gray on hover */
        }
    </style>
</body>
</html>
