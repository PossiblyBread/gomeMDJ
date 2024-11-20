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
    <link rel="stylesheet" href="../assets/styles.css">

    
</head>

<body>
    <?php include 'greetings.php'; ?>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <br><br><br><br>
    <section class="main-section">
        <div class="hero-banner">
            <div class="text-section">
                <img src="../Images/Logo-dark.png" alt="MDJ E-Bike Logo">
                <h1>MDJ E-BIKE</h1>
                <h2>Your Gateway to the E-Bike Experience</h2>
                <p>Explore our platform designed to connect you with top E-Bike retailers. Engage, inquire, and learn about the latest models, all in one place.</p>
                <h3>Start Your Ride</h3>
                <hr>
            </div>
            <div class="e-bike-images">
                <div class="image-border-wrapper">
                    <img src="../Images/blue-etrike.png" alt="E-Bike Model 1">
                    <img src="../Images/lightblue-etrike.png" alt="E-Bike Model 2">
                    <img src="../Images/red-quadbike.png" alt="E-Bike Model 3">
                </div>
            </div>
        </div>
    </section>

    <main>
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

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
    <script src="../js/script.js"></script>
    
</body>

</html>
<style>

/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f5f5f5;
}
/* Hero Banner */
.hero-banner {
    background: linear-gradient(to bottom, #78BDDF, #cce7f0);
    color: #333;
    display: flex;
    justify-content: space-between;
    padding: 40px 20px;
    align-items: center;
    position: relative;
    width: 100%;
}

.hero-banner .text-section {
    width: 65%;
    /* Set to 65% */
}

.hero-banner h1 {
    font-size: 130px;
    font-weight: bold;
    color: #00334d;
}

.hero-banner h2 {
    font-size: 24px;
    letter-spacing: 2px;
    color: #00334d;
    margin-left: 40px;
    margin-top: 10px;
    display: inline-block;
    padding: 5px 20px;
    text-align: center;
    position: relative;
    z-index: 1;
}

.hero-banner h2::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, #78BDDF, #cce7f0);
    border-radius: 10px;
    transform: skew(-40deg);
    z-index: -1;
}

.hero-banner p {
    font-size: 18px;
    color: #00334d;
    margin-top: 20px;
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}

.text-section hr {
    border: none;
    border-top: 4px solid white;
    width: 100%;
    margin-left: auto;
    margin-top: 10px;
}

.hero-banner a {
    display: inline-block;
    margin-top: 20px;
    font-size: 18px;
    color: #00334d;
    text-decoration: none;
    font-weight: bold;
    padding-bottom: 5px;
    border-bottom: 2px solid #00334d;
}

.hero-banner img {
    width: 60px;
    height: auto;
    border-radius: 10px;
}

/* Styling for each image inside the image container */
.e-bike-images img {
    width: 300px;
    height: auto;
    border: 20px solid transparent;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: absolute;
    border-radius: 30%;
    z-index: 1;
}

/* Image Section positioned to the right */
.e-bike-images {
    margin-top: 10px;
    margin-right: 350px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    z-index: 2;
}

/* Positioning each image in a triangular form */
.e-bike-images img:nth-child(1) {
    top: 0;
    left: -200px;
}

.e-bike-images img:nth-child(2) {
    top: 30px;
    left: 0;
}

.e-bike-images img:nth-child(3) {
    top: 170px;
    right: -150px;
}

/* promos section design */
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
/* Mobile view styles */
@media (max-width: 1150px) {
    .hero-banner {
        flex-direction: column;
        padding: 40px;
        text-align: center;
    }

    .hero-banner .text-section {
        width: 100%;
        margin-bottom: 20px;
    }

    .hero-banner h1 {
        font-size: 60px;
    }

    .hero-banner h2 {
        font-size: 18px;
        margin-left: 0;
        margin-top: 10px;
    }

    .hero-banner p {
        font-size: 16px;
    }

    /* Adjust the positioning of each image in a row */
    .e-bike-images img:nth-child(1),
    .e-bike-images img:nth-child(2),
    .e-bike-images img:nth-child(3) {
        display: none;
    }
}

</style>