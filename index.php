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
    <?php include 'chat.php'; ?>
    <?php include 'footer.php'; ?>
    
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
/* for the big banner */
hr {
    border: 1.3px solid #1b212f; 
    width: 100%; 
    margin: 20px auto; 
    border-radius: 15px;
}
.main-section {
    position: relative;
    background: linear-gradient(to bottom, rgba(0, 123, 255, 0.8), rgba(128, 128, 128, 0.5)); /* Bluish to gray gradient */
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
}

.bigName {
    position: relative;
    padding-left: 160px;
    color: white;
    margin-top: 50px;
}
.bigName hr{
    border: 1.75px solid #2c3e50; 
    width: 100%; 
    margin: 20px auto; 
    border-radius: 15px;
}

.big-text,
.sub-text {
    font-size: 142px; 
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
    font-size: 18px; 
    color: rgba(255, 255, 255, 0.8); 
    line-height: 1.6; 
}

.ebikeImage {
    margin-left: -150px;
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
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
    clip-path: polygon(9% 0, 13% 0, 0 46%, 0 33%);
    position: absolute; 
    top: 0; 
    left: 0;
}

.diagonal2 {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
    clip-path: polygon(11% 0, 17% 0, 6% 39%, 0 39%);
    position: absolute; 
    top: 0;
}

.diagonal3 {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
    clip-path: polygon(100% 52%, 100% 77%, 96% 100%, 91% 100%);
    position: absolute; 
    top: 50px; 
    left: 0;
}

.diagonal4 {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
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
    }
    .main-section {
        flex-direction: column;
        height: auto; 
    }

    .content-container {
        flex-direction: column; 
        align-items: center; 
    }

    .left-column, .right-column {
        flex: none; 
        width: 100%; 
        padding: 10px; 
        text-align: center; 
    }

    .bigName {
        padding-left: 0;
        margin-top: 20px;
    }

    .big-text, .sub-text {
        font-size: 50px;
    }

    .ebikeImage {
        width: 90%; 
        margin: 20px 0;
    }

    .inner-section {
        padding-left: 0;
    }

    .main-section h3 {
        margin-left: 0; 
    }
    
}
@media (max-width: 480px) {
    .big-text, .sub-text {
        font-size: 30px;
    }
    .bigName hr  {
        width: 50%;
    }
}

</style>

