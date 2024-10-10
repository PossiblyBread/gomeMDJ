<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

include "../db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDJ</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/main_content.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <h1 class="logo" id="logo">gomeMDJ</h1>
                <nav class="nav-links">
                    <a href="Home.php">Home</a>
                    <a href="Account.php">Account</a>
                    <a href="../about.php">About</a>
                    <a href="../store.php">Store</a>
                    <a href="../Ticketing-System/support.php">Support</a>
                </nav>
            </div>
            <div class="header-right">
                <span class="user-name" id="user-name">
                    <?php echo htmlspecialchars($userFirstName . ' ' . $userLastName); ?>
                </span>
                <div class="profile-icon" id="profile-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z" />
                    </svg>
                </div>
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <aside class="side-nav" id="side-nav">
        <!-- Profile Icon at the Top -->
        <div class="profile-container">
            <div class="profile-icon" id="sidebar-profile-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z" />
                </svg>
            </div>
            <span class="user-name" id="user-name">
                <?php echo htmlspecialchars($userFirstName . ' ' . $userLastName); ?>
            </span>
        </div>
        <a href="Home.php">Home</a>
        <a href="Account.php">Account</a>
        <a href="../about.php">About</a>
        <a href="../store.php">Store</a>
        <a href="../Ticketing-System/support.php">Support</a>
        <a href="../logout.php">Logout</a>
    </aside>
    <div id="overlay"></div>

    <!-- Main Content Section -->
    <main>
        <section class="hero">
            <h2>Welcome to Our Website!</h2>
            <p>Explore amazing products and services. Our store offers the best deals, and our support team is always here to help you.</p>
            <button class="learn-more-btn">Learn More</button>
        </section>

        <section class="features">
            <div class="feature-item">
                <h3>Feature One</h3>
                <p>This feature offers you amazing benefits and top-notch services.</p>
            </div>
            <div class="feature-item">
                <h3>Feature Two</h3>
                <p>Our second feature provides excellent support and solutions to your problems.</p>
            </div>
            <div class="feature-item">
                <h3>Feature Three</h3>
                <p>Feature three is designed for convenience, making everything easy and accessible.</p>
            </div>
        </section>
        <hr>
        <!-- <svg fill="#ffe342" height="256px" width="256px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-51.2 -51.2 614.41 614.41" xml:space="preserve" transform="matrix(1, 0, 0, 1, 0, 0)" stroke="#ffe342" stroke-width="0.005120100000000001"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#d10000" stroke-width="40.9608"> <g> <g> <circle cx="307.205" cy="298.674" r="17.067"></circle> </g> </g> <g> <g> <circle cx="213.338" cy="204.807" r="17.067"></circle> </g> </g> <g> <g> <path d="M510.025,301.746l-38.11-45.739l38.11-45.739c2.125-2.543,2.577-6.084,1.178-9.079c-1.408-2.995-4.42-4.915-7.731-4.915 H391.403l-7.484-52.403c-0.597-4.207-4.198-7.33-8.448-7.33h-65.178c-10.052-8.38-48.828-40.687-48.828-40.687 c-3.166-2.645-7.757-2.645-10.923,0l-48.828,40.687h-65.178c-4.25,0-7.842,3.123-8.448,7.322l-7.484,52.412H8.538 c-3.311,0-6.323,1.92-7.731,4.915c-1.408,3.004-0.947,6.545,1.178,9.079l38.11,45.739l-38.11,45.739 c-2.125,2.543-2.577,6.084-1.178,9.079c1.408,3.004,4.42,4.915,7.731,4.915h112.068c2.278,15.915,7.492,52.412,7.492,52.412 c0.597,4.207,4.198,7.322,8.439,7.322h65.178l48.828,40.687c1.587,1.323,3.524,1.98,5.461,1.98s3.883-0.657,5.461-1.98 l48.819-40.687c13.261,0,65.203,0.034,65.186,0c4.25,0,7.842-3.123,8.448-7.322c0,0,5.214-36.497,7.492-52.412h112.06 c3.311,0,6.323-1.92,7.731-4.915C512.611,307.821,512.15,304.28,510.025,301.746z M78.785,261.468l31.002,37.205H26.757 l31.002-37.205c2.637-3.166,2.637-7.765,0-10.923L26.757,213.34h83.029l-31.002,37.205 C76.148,253.711,76.148,258.311,78.785,261.468z M213.338,170.674c18.825,0,34.133,15.309,34.133,34.133 s-15.309,34.133-34.133,34.133c-18.825,0-34.133-15.309-34.133-34.133S194.522,170.674,213.338,170.674z M193.771,330.307 c-1.664,1.673-3.849,2.5-6.033,2.5c-2.185,0-4.369-0.836-6.033-2.5c-3.337-3.337-3.337-8.73,0-12.066l136.533-136.533 c3.337-3.337,8.73-3.337,12.066,0s3.337,8.73,0,12.066L193.771,330.307z M307.205,332.807c-18.825,0-34.133-15.309-34.133-34.133 s15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133S326.029,332.807,307.205,332.807z M402.223,298.674l31.002-37.205 c2.637-3.166,2.637-7.765,0-10.923l-31.002-37.205h83.029l-31.002,37.205c-2.637,3.166-2.637,7.765,0,10.923l31.002,37.205 H402.223z"></path> </g> </g> </g><g id="SVGRepo_iconCarrier"> <g> <g> <circle cx="307.205" cy="298.674" r="17.067"></circle> </g> </g> <g> <g> <circle cx="213.338" cy="204.807" r="17.067"></circle> </g> </g> <g> <g> <path d="M510.025,301.746l-38.11-45.739l38.11-45.739c2.125-2.543,2.577-6.084,1.178-9.079c-1.408-2.995-4.42-4.915-7.731-4.915 H391.403l-7.484-52.403c-0.597-4.207-4.198-7.33-8.448-7.33h-65.178c-10.052-8.38-48.828-40.687-48.828-40.687 c-3.166-2.645-7.757-2.645-10.923,0l-48.828,40.687h-65.178c-4.25,0-7.842,3.123-8.448,7.322l-7.484,52.412H8.538 c-3.311,0-6.323,1.92-7.731,4.915c-1.408,3.004-0.947,6.545,1.178,9.079l38.11,45.739l-38.11,45.739 c-2.125,2.543-2.577,6.084-1.178,9.079c1.408,3.004,4.42,4.915,7.731,4.915h112.068c2.278,15.915,7.492,52.412,7.492,52.412 c0.597,4.207,4.198,7.322,8.439,7.322h65.178l48.828,40.687c1.587,1.323,3.524,1.98,5.461,1.98s3.883-0.657,5.461-1.98 l48.819-40.687c13.261,0,65.203,0.034,65.186,0c4.25,0,7.842-3.123,8.448-7.322c0,0,5.214-36.497,7.492-52.412h112.06 c3.311,0,6.323-1.92,7.731-4.915C512.611,307.821,512.15,304.28,510.025,301.746z M78.785,261.468l31.002,37.205H26.757 l31.002-37.205c2.637-3.166,2.637-7.765,0-10.923L26.757,213.34h83.029l-31.002,37.205 C76.148,253.711,76.148,258.311,78.785,261.468z M213.338,170.674c18.825,0,34.133,15.309,34.133,34.133 s-15.309,34.133-34.133,34.133c-18.825,0-34.133-15.309-34.133-34.133S194.522,170.674,213.338,170.674z M193.771,330.307 c-1.664,1.673-3.849,2.5-6.033,2.5c-2.185,0-4.369-0.836-6.033-2.5c-3.337-3.337-3.337-8.73,0-12.066l136.533-136.533 c3.337-3.337,8.73-3.337,12.066,0s3.337,8.73,0,12.066L193.771,330.307z M307.205,332.807c-18.825,0-34.133-15.309-34.133-34.133 s15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133S326.029,332.807,307.205,332.807z M402.223,298.674l31.002-37.205 c2.637-3.166,2.637-7.765,0-10.923l-31.002-37.205h83.029l-31.002,37.205c-2.637,3.166-2.637,7.765,0,10.923l31.002,37.205 H402.223z"></path> </g> </g> </g></svg> -->

        <!-- Carousel Section -->
        <section class="carousel-box">
            <h3>Our Highlights</h3>
            <div class="carousel-container">
                <div class="carousel-grid">
                    <div class="carousel-item active">
                        <img src="../Images/cat-in-box-dead.png" alt="Highlight 1">
                        <p>Highlight Item One</p>
                    </div>
                    <div class="carousel-item">
                        <img src="../Images/cat-in-box.png" alt="Highlight 2">
                        <p>Highlight Item Two</p>
                    </div>
                    <div class="carousel-item">
                        <img src="../Images/cat-in-box-dead.png" alt="Highlight 3">
                        <p>Highlight Item Three</p>
                    </div>
                    <div class="carousel-item">
                        <img src="../Images/cat-in-box.png" alt="Highlight 4">
                        <p>Highlight Item Four</p>
                    </div>
                    <div class="carousel-item">
                        <img src="../Images/cat-in-box-dead.png" alt="Highlight 5">
                        <p>Highlight Item Five</p>
                    </div>
                </div>
            </div>
            <button class="carousel-prev">❮</button>
            <button class="carousel-next">❯</button>
        </section>
    </main>
    <!-- Chat Button -->
    <div class="chat-icon" id="chat-icon-button">
        <svg fill="#000000" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 12v4l-5-4H0V0h16v12zm-2-2V2H2v8h12zm-2.5 0l2.5 2v-2h-2.5zM4 4h8v2H4V4z" fill-rule="evenodd"></path>
        </svg>
    </div>
    <!-- Chat Box -->
    <div class="chat-window" id="chat-window">
        <div class="chat-header">
            Chat
            <button class="chat-close-btn" id="chat-close-button">✖</button>
        </div>
        <div class="chat-messages">
            <p>Welcome to the chat!</p>
            <!-- You can add more chat functionality here -->
        </div>
        <div class="chat-input-area">
            <input type="text" class="chat-input-field" placeholder="Type a message...">
            <button class="send-message-btn">Send</button>
        </div>
    </div>
    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Quick Links</h4>
                <a href="support.php">FAQs</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
            <div class="footer-section">
                <h4>Contact Info</h4>
                <p>Email: contact@example.com</p>
                <p>Phone: +123 456 7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
            <a href="#" class="back-to-top">Back to Top</a>
        </div>
    </footer>
    <script src="../js/script.js"></script>
    <script src="../js/main_content.js"></script>
    <script>
        // Home script
        document.addEventListener('DOMContentLoaded', function() {
            const userNameElement = document.getElementById('user-name');
            const profileIconElement = document.getElementById('profile-icon');
            const dropdownMenuElement = document.getElementById('dropdown-menu');

            // Function to toggle dropdown visibility
            function toggleDropdown() {
                console.log('Toggle dropdown triggered'); // Debug log
                if (window.innerWidth > 768) {
                    if (dropdownMenuElement.classList.contains('open')) {
                        dropdownMenuElement.classList.remove('open');
                        setTimeout(() => {
                            dropdownMenuElement.style.display = 'none'; // Hide after animation
                        }, 300);
                    } else {
                        dropdownMenuElement.style.display = 'block'; // Show immediately
                        setTimeout(() => {
                            dropdownMenuElement.classList.add('open');
                        }, 10);
                    }
                }
            }
            // Click events for both the username and profile icon
            userNameElement.addEventListener('click', toggleDropdown);
            profileIconElement.addEventListener('click', toggleDropdown);

            // Close dropdown if clicking outside of it
            document.addEventListener('click', function(event) {
                if (!dropdownMenuElement.contains(event.target) && !userNameElement.contains(event.target) && !profileIconElement.contains(event.target)) {
                    dropdownMenuElement.classList.remove('open');
                    setTimeout(() => {
                        dropdownMenuElement.style.display = 'none';
                    }, 300);
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userNameElement = document.getElementById('user-name');
            const dropdownMenuElement = document.getElementById('dropdown-menu');

            // Sidebar Elements
            const sideNav = document.getElementById('side-nav');
            const overlay = document.getElementById('overlay');

            // Function to open/close sidebar
            function toggleSidebar() {
                if (sideNav.style.width === "250px") {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            // Click event for username to toggle sidebar only on narrow screens
            function handleUserNameClick(event) {
                event.stopPropagation(); // Prevent event bubbling to document click
                toggleSidebar();
            }

            // Overlay click event to close the sidebar
            overlay.addEventListener('click', function() {
                closeSidebar();
            });

            // Function to open the sidebar
            function openSidebar() {
                sideNav.style.width = "250px"; // Adjusted to full width
                overlay.style.display = "block"; // Show overlay when sidebar opens
            }

            // Function to close the sidebar
            function closeSidebar() {
                sideNav.style.width = "0";
                overlay.style.display = "none"; // Hide overlay when sidebar closes
            }

            // Check window size and add click event listener accordingly
            function checkScreenSize() {
                if (window.innerWidth < 768) {
                    userNameElement.addEventListener('click', handleUserNameClick);
                } else {
                    userNameElement.removeEventListener('click', handleUserNameClick);
                    closeSidebar(); // Close sidebar on wider screens
                    overlay.style.display = "none"; // Hide overlay
                }
            }

            // Initial check
            checkScreenSize();

            // Check on resize
            window.addEventListener("resize", checkScreenSize);
        });
    </script>
    <script>
        // Chat box functionality
        const chatIconButton = document.getElementById('chat-icon-button');
        const chatWindow = document.getElementById('chat-window');
        const chatCloseButton = document.getElementById('chat-close-button');
        let isChatWindowOpen = false;

        // Toggle chat window when chat icon button is clicked
        chatIconButton.addEventListener('click', () => {
            toggleChatWindow();
        });

        // Close chat window when close button is clicked
        chatCloseButton.addEventListener('click', () => {
            closeChatWindow();
        });

        // Handle logo and username clicks to open sidebar on narrow screens
        document.getElementById("logo").addEventListener("click", handleLogoClick);
        document.getElementById("user-name").addEventListener("click", handleNameTagClick);

        // Function to toggle the chat window visibility
        function toggleChatWindow() {
            chatWindow.style.bottom = isChatWindowOpen ? '-400px' : '20px'; // Show/hide chat window
            isChatWindowOpen = !isChatWindowOpen; // Toggle state
        }

        // Function to close the chat window
        function closeChatWindow() {
            chatWindow.style.bottom = '-400px'; // Hide chat window
            isChatWindowOpen = false; // Reset chat open state
        }

        // Function to handle logo click
        function handleLogoClick() {
            if (window.innerWidth <= 768) { // Check if the screen is narrow
                openSidebar();
            }
        }

        // Function to handle user name click (you might want to implement this function)
        function handleNameTagClick() {
            // Add your logic to open sidebar or any other functionality here
        }

        // You can define the openSidebar function if needed
        function openSidebar() {
            // Your code to open the sidebar
        }
    </script>
</body>

</html>

<style>
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        /* Initially hidden */
        z-index: 1000;
        /* Ensure it's above other elements */
    }

    /* Other sidebar styles */
    .side-nav {
        height: 100%;
        width: 0;
        /* Initially hidden */
        position: fixed;
        top: 0;
        right: 0;
        background-color: #333;
        overflow-x: hidden;
        transition: 0.5s;
        /* Smooth transition */
        padding-top: 20px;
        /* Adjusted for spacing */
        z-index: 1001;
        /* Ensure it's above the overlay */
    }

    /* Profile Icon in Sidebar */
    #sidebar-profile-icon {
        cursor: pointer;
        font-size: 32px;
        /* Adjusted size */
        color: white;
        margin: 20px;
        /* Margin for spacing */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Sidebar links */
    .side-nav a {
        display: block;
        padding: 15px 20px;
        color: white;
        font-size: 18px;
    }

    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Semi-transparent */
        display: none;
        /* Hidden by default */
        z-index: 1000;
        /* Just below the sidebar */
    }

    @media (max-width: 768px) {
        .side-nav {
            width: 0;
            /* Hide sidebar by default */
        }
    }

    /* Chat Toggle Button */
    .chat-toggle-icon {
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

    .chat-toggle-icon-svg {
        fill: white;
        /* White icon */
        width: 30px;
        height: 30px;
    }

    .chat-toggle-icon:hover {
        background-color: #95a5a6;
        /* Lighter gray on hover */
    }

    /* Chat Window */
    .chat-window {
        position: fixed;
        right: 20px;
        bottom: -400px;
        /* Initially hidden */
        width: 320px;
        height: 400px;
        background-color: #f1f1f1;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: bottom 0.5s ease;
        display: flex;
        flex-direction: column;
        /* Align children vertically */
    }

    /* Chat Button */
    .chat-toggle-icon {
        /* Changed from .chat-icon */
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

    .chat-toggle-icon svg {
        /* Changed from .chat-icon */
        fill: white;
        /* White icon */
        width: 30px;
        height: 30px;
    }

    .chat-toggle-icon:hover {
        /* Changed from .chat-icon */
        background-color: #95a5a6;
        /* Lighter gray on hover */
    }

    /* Chat Button */
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

    /* Chat Window */
    .chat-window {
        position: fixed;
        right: 20px;
        bottom: -400px;
        /* Initially hidden */
        width: 320px;
        height: 400px;
        background-color: #f1f1f1;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: bottom 0.5s ease;
        display: flex;
        flex-direction: column;
        /* Align children vertically */
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

    /* Chat Messages */
    .chat-messages {
        padding: 15px;
        height: 230px;
        /* Fixed height for content */
        overflow-y: auto;
        /* Scrollable content */
        flex: 1;
        /* Allow content to take available space */
    }

    /* Chat Input Area */
    .chat-input-area {
        display: flex;
        /* Align input and button side by side */
        padding: 10px;
        /* Add some padding */
    }

    /* Chat Input Field */
    .chat-input-field {
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

    /* Send Message Button */
    .send-message-btn {
        background-color: #666;
        /* Grayscale color */
        color: white;
        /* Text color */
        border: none;
        /* No border */
        border-radius: 5px;
        /* Rounded corners */
        padding: 10px 15px;
        /* Padding for the button */
        margin-left: 10px;
        /* Space between input and button */
        cursor: pointer;
        /* Change cursor on hover */
    }

    /* Close Button in Chat Header */
    .chat-close-btn {
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

    .chat-close-btn:hover {
        background-color: #2c3e50;
        /* Darker gray on hover */
    }

    .chat-messages {
        padding: 15px;
        height: 230px;
        overflow-y: auto;
        color: #2c3e50;
        /* Dark gray text */
    }
</style>