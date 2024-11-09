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
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    
    <div id="overlay"></div>
    <section class="main-section">
        <div class="diagonal1"></div>
        <div class="diagonal2"></div>
        <div class="diagonal3"></div>
        <div class="diagonal4"></div>
        
        <div class="content-container">
            <div class="left-column">
                <div class="top-text">Your Next</div>
            <div class="bigName">
                <div class="big-text">Ride Awaits</div>
                <hr>
            </div>
                <div class="inner-section">
                    <br>
                    <p>Your journey starts here. Explore, Inquire and connect
                        with trusted E-bike support tailored to your needs.</p>
                </div>
                <div class="inner-section">
                    <h3></h3>
                </div>
                <button class="Pre-Registered" id="register-button" onclick="showRegisterModal()">Pre-Registered</button>
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
        <div class="login-modal-content" id="login-form-content">
            <span class="login-close" onclick="document.getElementById('login-modal').style.display='none'">&times;</span>
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
        <!-- OTP Form -->
        <div class="modal-content" id="otp-form">
            
            <div class="form-container">
                <h2>Enter OTP</h2>
                
                <div class="message-container">
                    <div id="otp-status-message">Please check your email for the OTP code</div>
                </div>

                <form id="otp-verification-form">
                    <div class="form-group">
                        <label for="otp">Enter OTP:</label>
                        <input type="text" 
                               id="otp" 
                               name="otp" 
                               maxlength="6" 
                               pattern="\d{6}" 
                               required 
                               inputmode="numeric" 
                               placeholder="Enter 6-digit OTP">
                    </div>
                    
                    <div class="message-container">
                        <div id="otp-expiry-message">Time remaining: <span id="countdown">2:00</span></div>
                        <div id="otp-wait-message">Please wait, sending OTP...</div>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" id="verify-otp-btn" class="primary-btn">Verify OTP</button>
                        <button type="button" id="resend-otp-btn" class="secondary-btn" style="display: none;">Resend OTP</button>
                        <button type="button" class="back-btn" onclick="backToLoginForm()">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="register-modal">
        <div class="register-modal-content">
            <span class="register-close" action="Register.php" onclick="document.getElementById('register-modal').style.display='none'">&times;</span>
            <form id="register-form" action="Register.php" method="post" onsubmit="return validatePasswordAndEmail()">
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

    <?php include 'footer.php'; ?>
    <!-- ai chat bot -->
    <script>
        window.embeddedChatbotConfig = {
            chatbotId: "e8_c510p3vG8EPF2g33Vw",
            domain: "www.chatbase.co"
        }
    </script>
    <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="e8_c510p3vG8EPF2g33Vw"
        domain="www.chatbase.co"
        defer>
    </script>
    
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
    <script src="js/Otp_script.js"></script>
    
</body>
</html>

<style>
/* for the big banner */
hr {
    border: 1.3px solid #1b212f; 
    width: 100%; 
    margin: 20px auto; 
    border-radius: 15px;
}
.main-section {
    position: relative;
    background: linear-gradient(to bottom, #cff9ff, rgba(128, 128, 128, 0.2)); /* Bluish to gray gradient */
    height: 660px;
    overflow: hidden;
    display: flex;
}

.content-container {
    display: flex;
    width: 100%; 
}

.left-column {
    flex: 3; 
    padding: 20px;
    color: white; 
}

.right-column {
    flex: 2.5; 
    padding: 20px;
    color: white; 
}

.inner-section {
    margin-bottom: 20px; 
    padding-left: 160px;
    padding-right: 200px; 
}
.top-text {
    position: relative;
    padding-left: 190px;
    color: #1b212f;
    margin-top: 50px;
    font-weight: 900; 
    font-size: 35px;
}


.bigName {
    position: relative;
    padding-left: 180px;
    color: #1b212f;
    margin-top: 15px;
}
.bigName hr{
    border: 1.75px solid #2c3e50; 
    width: 100%; 
    margin: 10px auto; 
    border-radius: 15px;
}

.big-text{
    font-size: 100px; 
    font-style: italic; 
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); 
}

.sub-text {
    margin-top: -10px;
    padding-left: 25px;
}

.main-section h3 {
    font-size: 24px; 
    color: white; 
    margin-bottom: 10px;
    margin-left: 500px;
}

.inner-section p {
    font-size: 20px; 
    margin-left: 20px;
    margin-top: -10px;
    color: #1b212f; 
    line-height: 1.6; 
    font-weight: 650;
}
.Pre-Registered {
    margin-top: 10px;
    margin-left: 200px;
    padding: 20px;
    padding-left: 60px;
    padding-right: 60px;
    border-radius: 50px;
    background-color: #7dc4cc;
    color: aliceblue;
    font-size: 20px;
    font-weight: 500;
}

.ebikeImage {
    margin-left: -200px;
    margin-top: -50px;
    width: 550px; 
    height: auto;
}

.main-section h2 {
    font-size: 120px;
    color: white;
}
.diagonal1,
.diagonal2,
.diagonal3,
.diagonal4 {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0; 
}


.diagonal1 {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5),#214f73);
    clip-path: polygon(9% 0, 13% 0, 0 46%, 0 33%);
    position: absolute; 
    top: 0; 
    left: 0;
}

.diagonal2 {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), #214f73);
    clip-path: polygon(11% 0, 17% 0, 6% 39%, 0 39%);
    position: absolute; 
    top: 0;
}

.diagonal3 {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.5), #214f73);
    clip-path: polygon(100% 52%, 100% 77%, 96% 100%, 91% 100%);
    position: absolute; 
    top: 50px; 
    left: 0;
}

.diagonal4 {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.6), #214f73);
    clip-path: polygon(93% 61%, 100% 61%, 93% 100%, 86% 100%);
    position: absolute; 
    top: 50px; 
}
/* end for bigbanner section */
/* start for chat box design */
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
    text-align: center;
    margin: 40px 0; 
}

.features p {
    font-family: 'Arial', sans-serif;
    font-size: 24px;
    color: #2c3e50; 
    font-weight: bold;
    text-transform: uppercase; 
    letter-spacing: 1px; 
}

.features p::after {
    content: ""; 
    display: block;
    width: 50px; 
    height: 3px;
    background-color: #3498db; 
    margin: 10px auto; 
}
/* end for chatbox */
/* Media Queries for Mobile View */
@media (max-width: 768px) {
    .bigName hr {
        width: 70%; 
        margin: 0 auto;
    }

    .main-section {
        flex-direction: column;
        height: auto;
        align-items: center;
        text-align: center;
    }

    .content-container {
        flex-direction: column;
        align-items: center;
        padding: 0;
        margin: 0;
    }

    .left-column, .right-column {
        flex: none;
        width: 100%;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    .bigName {
        padding: 0;
        margin: 20px 0;
        text-align: center;
    }

    .big-text, .sub-text {
        font-size: 50px;
        text-align: center;
        margin: 0;
    }
    .inner-section p {
        width: 70%;
        margin: 0 auto;
        text-align: center;
    }
    .Pre-Registered {
        font-size: 16px;
        padding: 10px 25px;
        margin: 0 auto;
        display: block;
    }
    .ebikeImage {
        width: 90%;
        margin: 20px 0;
    }

    .inner-section {
        padding: 0;
        margin: 0;
    }

    .main-section h3 {
        margin: 0;
        font-size: 24px;
        text-align: center;
    }
    .top-text {
        color: #1b212f;
        font-weight: 600;
        font-size: 35px;
        margin: 50px auto 0;
        text-align: center;
        padding: 0;
    }
}

@media (max-width: 480px) {
    .big-text, .sub-text {
        font-size: 30px;
        margin: 0;
    }

    .bigName hr {
        width: 50%;
        font-size: 900;
        margin: 0 auto;
    }

    .main-section h2 {
        font-size: 60px;
        text-align: center;
        margin: 0;
    }

    .Pre-Registered {
        font-size: 16px;
        padding: 10px 25px;
        margin: 0 auto;
        display: block;
    }

    .ebikeImage {
        width: 100%;
        margin-top: 20px;
    }

    .top-text {
        color: #1b212f;
        font-weight: 600;
        font-size: 35px;
        margin: 50px auto 0;
        text-align: center;
        padding: 0;
    }
}
</style>

