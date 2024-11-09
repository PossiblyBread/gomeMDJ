<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../db_conn.php";

// Check if the user is logged in and validated
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Assuming user email is stored in session

// Query to check the validation status of the user
$sql = "SELECT validation FROM accounts WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->store_result();

// Variable to store validation status
$isValidated = false;

$stmt->close();

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDJ</title>
    <link rel="stylesheet" href="../styles/styles2.css">
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <?php include 'greetings.php'; ?>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <br><br>
    <br><br>
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
                    <img src=../Images/ebikeModel.png class="ebikeImage">
                </div>
            </div>
        </div>
    </section>
    <main>
    <!-- ai chat-bot -->
    <section class="features"> 
            <p>Promos</p>
            <?php include 'displayPromo.php'; ?>
        </section>
    </main>
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

    </script>
    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
    <script src="../js/script.js"></script>
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
    height: 500px;
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
    width: 430px; 
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
