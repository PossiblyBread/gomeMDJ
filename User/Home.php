<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../db_conn.php";

$sql = "SELECT id, p_name, p_image, p_monthly, p_year FROM promos_tb"; // Include the ID for each promotion
$result = $conn->query($sql);

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
    <?php include '../body/logged/greetings.php'; ?>
    <?php include '../body/logged/header.php'; ?>
    <?php include '../body/logged/side-bar.php'; ?>
    <div id="overlay"></div>
    <br><br>
    <!-- Main Content Section -->
    <main>
        <!-- <section class="hero">
            <h2>Welcome to Our Website!</h2>
            <p>Explore amazing products and services. Our store offers the best deals, and our support team is always here to help you.</p>
            <button onclick="window.location.href='about.php'" class="learn-more-btn">Learn More</button>
        </section> -->

        <section class="features">
            <p>Promos</p>
            <?php include 'displayPromo.php'; ?>
        </section>
    </main>

    <!-- Chat Button -->
    <?php include '../body/logged/chat.php'; ?>

    <!-- Footer Section -->
    <?php include '../body/logged/footer.php'; ?>
    <script src="../js/script.js"></script>
    <script src="../js/main_content.js"></script>
</body>
</html>
<style>
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
</style>
