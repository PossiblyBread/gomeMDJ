<?php
session_start();
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
    <?php include '../body/logged/header.php'; ?>
    <?php include '../body/logged/side-bar.php'; ?>
    <div id="overlay"></div>

    <!-- Main Content Section -->
    <main>
        <section class="hero">
            <h2>Welcome to Our Website, <?= htmlspecialchars($userFirstName) ?>!</h2>
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
    <?php include '../body/logged/chat.php'; ?>
   
    <!-- Footer Section -->
    <?php include '../body/logged/footer.php'; ?>

    <script src="../js/script.js"></script>
    <script src="../js/main_content.js"></script>
</body>
</html>
