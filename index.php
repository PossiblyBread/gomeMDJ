<?php
session_start();
include "config/home_config.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gomeMDJ</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <div class="top-nav">
            <h1>gomeMDJ</h1>
            <div class="menu-toggle" id="menu-toggle">&#9776;</div>
            <div class="top-nav-btn">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="store.php">Store</a>
                <a href="Ticketing-System/support.php">Support</a>
                <div class="profile-icon" id="profile-icon">
                    <!-- SVG Profile Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                    </svg>
                </div>
            </div>
            
        </div>
    </header>
    
    <aside class="side-nav" id="side-nav">
        <!-- Profile Icon at the Top -->
        <div class="profile-icon" id="sidebar-profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            </svg>
        </div>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="store.php">Store</a>
        <a href="Ticketing-System/support.php">Support</a>
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
        
    </main>
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

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="login-modal-content">
            <h2>Login</h2>
            <form id="login-form" action="Login.php" method="POST">
                <label for="username">Email:</label>
                <input type="text" id="username" name="i_email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="i_password" required>
                <button type="submit">Login</button>
            </form>
            <div class="register-prompt">
                <p>Don't have an account?</p>
                <button type="button" id="register-button" onclick="showRegisterModal()">Register</button>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="register-modal">
        <div class="register-modal-content">
            <span class="register-close" onclick="document.getElementById('register-modal').style.display='none'">&times;</span>
            <form id="register-form" method="post">
                <h2>Register</h2>
                <div>
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
                </div>
                <div>
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div>
                    <label for="phone_num">Phone Number:</label>
                    <input type="tel" name="phone_num" id="phone_num" placeholder="Phone Number" required>
                </div>
                <div>
                    <label for="a_password">Password:</label>
                    <input type="password" name="a_password" id="a_password" placeholder="Password" required>
                </div>
                <div>
                    <button type="submit" name="Submit">Register</button>
                    <button type="button" onclick="document.getElementById('register-modal').style.display='none';">Cancel</button>
                </div>
            </form>
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
    <script src="js/script.js"></script>
</body>
</html>
