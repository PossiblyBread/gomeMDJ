<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Chat Button -->
    <div class="chat-icon" id="chat-button">
        <svg fill="#000000" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 12v4l-5-4H0V0h16v12zm-2-2V2H2v8h12zm-2.5 0l2.5 2v-2h-2.5zM4 4h8v2H4V4z" fill-rule="evenodd"></path>
        </svg>
    </div>
    <!-- chat box -->
    <div class="chat-box" id="chat-box">
        <div class="chat-header">
            Chat
            <button class="chat-close" id="close-chat">✖</button>
        </div>
        <div class="chat-content">
            <p>Welcome to the chat!</p>
            <!-- You can add more chat functionality here -->
        </div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" placeholder="Type a message...">
            <button class="send-button">Send</button>
        </div>
    </div>
</body>
<script>
    // Chat box functionality
    const chatButton = document.getElementById('chat-button');
    const chatBox = document.getElementById('chat-box');
    const closeChatButton = document.getElementById('close-chat');
    let isChatOpen = false;

    // Toggle chat box when chat button is clicked
    chatButton.addEventListener('click', () => {
        chatBox.style.bottom = isChatOpen ? '-400px' : '20px'; // Show/hide chat box
        isChatOpen = !isChatOpen; // Toggle state
    });

    // Close chat box when close button is clicked
    closeChatButton.addEventListener('click', () => {
        chatBox.style.bottom = '-400px'; // Hide chat box
        isChatOpen = false; // Reset chat open state
    });

    // Handle logo and username clicks to open sidebar on narrow screens
    document.getElementById("logo").addEventListener("click", handleLogoClick);
    document.getElementById("user-name").addEventListener("click", handleNameTagClick);

    // Function to handle logo click
    function handleLogoClick() {
        if (window.innerWidth <= 768) { // Check if the screen is narrow
            openSidebar();
        }
    }
</script>
</html>
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
    bottom: -400px; /* Initially hidden */
    width: 320px;
    height: 400px;
    background-color: #f1f1f1;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transition: bottom 0.5s ease;
    display: flex;
    flex-direction: column; /* Align children vertically */
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

/* Chat Content */
.chat-content {
    padding: 15px;
    height: 230px; /* Fixed height for content */
    overflow-y: auto; /* Scrollable content */
    flex: 1; /* Allow content to take available space */
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
    padding: 10px 15px; /* Padding for the button */
    margin-left: 10px; /* Space between input and button */
    cursor: pointer; /* Change cursor on hover */
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

.chat-content {
    padding: 15px;
    height: 230px;
    overflow-y: auto;
    color: #2c3e50; /* Dark gray text */
}
</style>