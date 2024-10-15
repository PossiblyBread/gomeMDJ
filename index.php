<?php
session_start();
include "db_conn.php";
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
    <?php include 'body/header.php'; ?>
    <?php include 'body/side-bar.php'; ?>
    
    <div id="overlay"></div>

    <!-- Main Content Section -->
    <!-- additional content needed -->
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

    <?php include 'body/chat.php'; ?>

    <!-- Registration Modal -->
    <!-- May need additional items such as password confirmation -->
    <div id="register-modal">
        <div class="register-modal-content">
            <span class="register-close" onclick="document.getElementById('register-modal').style.display='none'"></span>
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
    <?php include 'body/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>