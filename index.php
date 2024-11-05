<?php
session_start();
include "db_conn.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDJ</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'body/header.php'; ?>
    <?php include 'body/side-bar.php'; ?>
    
    <div id="overlay"></div>
        <section class="main-section">
            <div class="diagonal1"></div>
            <div class="diagonal2"></div>
            <div class="diagonal3"></div>
            <div class="diagonal4"></div>
            
            <div class="content-container">
                <div class="left-column">
                <div class="bigName">
                    <div class="big-text">MDJ</div>
                    <div class="sub-text">E-Bikes</div>
                    <hr>
                </div>

                    <div class="inner-section">
                        <br>
                        <p>"Elevate your ride with MDJ E-bikes."</p>
                    </div>
                    <div class="inner-section">
                        <h3>-MDJ</h3>
                    </div>
                </div>
                <div class="right-column">
                    <div class="inner-section">
                        <img src=Images/ebikeModel.png class="ebikeImage">
                    </div>
                </div>
            </div>
        </section>
    <!-- Main Content Section -->
    <main>
        <hr>
        <section class="features">
            <p>Promos</p>
            <?php include 'displayPromo.php'; ?>
        </section>
        <hr>
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
    <div id="register-modal">
        <div class="register-modal-content">
            <span class="register-close" onclick="document.getElementById('register-modal').style.display='none'">&times;</span>
            <form id="register-form" method="post" onsubmit="return validatePasswordAndEmail()">
                <h2>Register</h2>
                <div class="name-container">
                    <div class="name-field">
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
                    </div>
                    <div class="name-field">
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                    </div>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div>
                    <label for="phone_num">Phone Number:</label>
                    <input type="tel" name="phone_num" id="phone_num" placeholder="Phone Number" required pattern="\d{11}" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                <div>
                    <label for="a_password">Password:</label>
                    <input type="password" name="a_password" id="a_password" placeholder="Password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div>
                    <button type="submit" name="Submit">Register</button>
                    <button type="button" onclick="document.getElementById('register-modal').style.display='none';">Cancel</button>
                </div>
                <div id="error-message" style="color: red;"></div>
            </form>
        </div>
    </div>

    <?php include 'body/footer.php'; ?>
    
    <script>
        

        function validatePasswordAndEmail() {
            const password = document.getElementById('a_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const email = document.getElementById('email').value;
            const phoneNum = document.getElementById('phone_num').value; // Get the phone number input
            const errorMessage = document.getElementById('error-message');

            // Clear previous error message
            errorMessage.textContent = '';

            // Check if phone number length is 11
            if (phoneNum.length !== 11) {
                errorMessage.textContent = 'Phone number must be exactly 11 digits long!';
                return false; // Prevent form submission
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match!';
                return false; // Prevent form submission
            }

            // Check for minimum password length
            if (password.length < 8) {
                errorMessage.textContent += 'Password must be at least 8 characters long! ';
                return false; // Prevent form submission
            }

            // Check if email is valid and ends with @gmail.com
            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!emailPattern.test(email)) {
                errorMessage.textContent += 'Email must be a valid Gmail address (e.g., example@gmail.com)!';
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
    
    <script src="js/script.js"></script>
</body>
</html>

<style>
hr {
    border: 1px solid #ffff; /* Change color if needed */
    width: 100%; /* Default width */
    margin: 20px auto; /* Center the line and add spacing */
}
.main-section {
    position: relative;
    background: linear-gradient(to bottom, rgba(0, 123, 255, 0.8), rgba(128, 128, 128, 0.5)); /* Bluish to gray gradient */
    height: 660px;
    overflow: hidden;
    display: flex; /* Use flexbox for layout */
}

.content-container {
    display: flex;
    width: 100%; /* Make sure it takes full width */
}

.left-column {
    flex: 3; /* Adjust the proportion as needed */  
    padding: 20px;
    color: white; /* Text color */
}

.right-column {
    flex: 2.5; /* Adjust the proportion as needed */
    padding: 20px;
    color: white; /* Text color */
}

.inner-section {
    margin-bottom: 20px; /* Space between sections */
    padding-left: 160px; /* Match this to the padding of .bigName */
}

.bigName {
    position: relative;
    z-index: 10;
    padding-left: 160px;
    color: white;
    margin-top: 50px;
}

.big-text,
.sub-text {
    font-size: 142px; /* Similar size for both */
    font-style: italic; /* Italic style */
    font-weight: bold; /* Make both texts bold */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Shadow for depth */
}

.sub-text {
    margin-top: -10px;
    padding-left: 25px;
}

.main-section h3 {
    font-size: 24px; /* Font size for section titles */
    color: white; /* Ensure it's visible against the background */
    margin-bottom: 10px; /* Space below the title */
    margin-left: 500px;
}

.inner-section p {
    font-size: 18px; /* Font size for paragraph text */
    color: rgba(255, 255, 255, 0.8); /* Slightly lighter color for readability */
    line-height: 1.6; /* Improve line height for better readability */
}

.ebikeImage {
    margin-left: -150px;
    margin-top: -50px;
    width: 550px; /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
}

.main-section h2 {
    font-size: 120px; /* Adjust size as needed */
    color: white; /* Change color if needed */
}

.diagonal1,
.diagonal2,
.diagonal3,
.diagonal4 {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0; /* Ensure they are behind other content */
}

.diagonal1 {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
    clip-path: polygon(9% 0, 13% 0, 0 46%, 0 33%);
    position: absolute; /* Ensure positioning is relative to parent */
    top: 0; /* Position it in the top left */
    left: 0;
}

.diagonal2 {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
    clip-path: polygon(11% 0, 17% 0, 6% 39%, 0 39%);
    position: absolute; /* Ensure positioning is relative to parent */
    top: 0; /* Adjust position for overlap */
}

.diagonal3 {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
    clip-path: polygon(100% 52%, 100% 77%, 96% 100%, 91% 100%);
    position: absolute; /* Ensure positioning is relative to parent */
    top: 50px; /* Adjust this value to move it down */
    left: 0;
}

.diagonal4 {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
    clip-path: polygon(93% 61%, 100% 61%, 93% 100%, 86% 100%);
    position: absolute; /* Ensure positioning is relative to parent */
    top: 50px; /* Adjust this value to move it down */
}

.chat-box { 
    position: fixed;
    right: 20px; 
    bottom: -400px;
    height: 400px; 
    width: 320px; 
    background-color: #f1f1f1; 
    border-radius: 10px; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); 
    transition: bottom 0.5s ease; 
    display: flex; 
    flex-direction: column; 
    z-index: 1000; 
}

.features {
    text-align: center; /* Center the text */
    margin: 40px 0; /* Add vertical spacing */
}

.features p {
    font-family: 'Arial', sans-serif; /* Set font */
    font-size: 24px; /* Adjust font size */
    color: #2c3e50; /* Dark color for text */
    font-weight: bold; /* Make the text bold */
    text-transform: uppercase; /* Transform text to uppercase */
    letter-spacing: 1px; /* Add space between letters */
}

.features p::after {
    content: ""; /* Create a decorative line */
    display: block;
    width: 50px; /* Width of the line */
    height: 3px; /* Height of the line */
    background-color: #3498db; /* Line color */
    margin: 10px auto; /* Center the line and add spacing */
}

/* Media Queries for Mobile View */
@media (max-width: 768px) {
    hr {
        width: 70%; /* Reduce width on medium devices */
    }
    .main-section {
        flex-direction: column; /* Stack columns on top of each other */
        height: auto; /* Allow height to adjust automatically */
    }

    .content-container {
        flex-direction: column; /* Ensure content is vertical */
        align-items: center; /* Center align items */
    }

    .left-column, .right-column {
        flex: none; /* Reset flex property */
        width: 100%; /* Full width for each column */
        padding: 10px; /* Less padding on mobile */
        text-align: center; /* Center text */
    }

    .bigName {
        padding-left: 0; /* Remove left padding */
        margin-top: 20px; /* Adjust margin */
    }

    .big-text, .sub-text {
        font-size: 50px; /* Reduce font size for mobile */
    }

    .ebikeImage {
        width: 90%; /* Adjust image width */
        margin: 20px 0; /* Add margin for spacing */
    }

    .inner-section {
        padding-left: 0; /* Remove left padding */
    }

    .main-section h3 {
        margin-left: 0; /* Remove left margin */
    }
    
}

@media (max-width: 480px) {
    .big-text, .sub-text {
        font-size: 30px; /* Further reduce font size for smaller screens */
    }
    hr {
        width: 50%; /* Further reduce width on smaller devices */
    }
}

</style>

