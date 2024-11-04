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
        <section class="hero">
            <h2>Welcome to Our Website, <?= htmlspecialchars($userFirstName) ?>!</h2>
            <p>Explore amazing products and services. Our store offers the best deals, and our support team is always here to help you.</p>
            <button class="learn-more-btn">Learn More</button>
        </section>

        <section class="features">
            <div class="carousel-container">
                <div class="carousel">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="promo-box">
                                <img src="<?php echo htmlspecialchars($row['p_image']); ?>" alt="<?php echo htmlspecialchars($row['p_name']); ?>" class="promo-img">
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No promotions available.</p>
                    <?php endif; ?>
                </div>
                <div class="carousel-controls">
                    <button id="promoPrevBtn">❮</button>
                    <button id="promoNextBtn">❯</button>
                </div>
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
    <script>
        let currentIndex = 0;

        // Carousel functionality
        const promoCarousel = document.querySelector('.carousel');
        const promoPrevBtn = document.getElementById('promoPrevBtn');
        const promoNextBtn = document.getElementById('promoNextBtn');
        let promoCurrentSlide = 0;
        const promoTotalSlides = <?php echo $result->num_rows; ?>; // Total slides based on the result

        // Function to get the number of visible slides
        const getVisibleSlides = () => {
            return window.innerWidth <= 600 ? 1 : 3; // 1 visible slide on narrow screens, otherwise 3
        };

        // Define a variable for how much to move the slide on mobile
        const mobileSlideAmount = 109; // Adjust this value as needed

        promoNextBtn.addEventListener('click', () => {
            const promoVisibleSlides = getVisibleSlides(); // Get current visible slides
            if (promoCurrentSlide < promoTotalSlides - promoVisibleSlides) {
                promoCurrentSlide++;
                const slideAmount = window.innerWidth <= 600 ? mobileSlideAmount : (100 / promoVisibleSlides);
                promoCarousel.style.transform = `translateX(-${promoCurrentSlide * slideAmount}%)`;
            }
        });

        promoPrevBtn.addEventListener('click', () => {
            const promoVisibleSlides = getVisibleSlides(); // Get current visible slides
            if (promoCurrentSlide > 0) {
                promoCurrentSlide--;
                const slideAmount = window.innerWidth <= 600 ? mobileSlideAmount : (100 / promoVisibleSlides);
                promoCarousel.style.transform = `translateX(-${promoCurrentSlide * slideAmount}%)`;
            }
        });
        
    </script>

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

.carousel-container {
    position: relative;
    overflow: hidden;
    width: 100%;
    margin-top: 10px;
    display: flex;
    justify-content: center;
}
.carousel {
    display: grid;
    justify-content: flex-start;
    grid-template-columns: repeat(6, calc(33.33% - 40px)); /* Default to show 3 items */
    gap: 40px;
    transition: transform 0.5s ease-in-out;
}

@media (max-width: 600px) {
    .carousel {
        grid-template-columns: repeat(6, 100%); /* Show only 1 item on narrow screens */

    }
    .carousel-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }
}

.promo-box {
    background-color: #a6a6a6;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
    text-align: center;
    width: 100%;
    height: auto;
    margin-left: 20px;
    margin-bottom: 10px;
    z-index: 2;
    border-radius: 15px;
    align-items: center;
}
.promo-box p {
    font-size: 1rem; /* Adjust the size as needed */
    color: #333; /* Dark color for better readability */
    margin: 5px 0; /* Space between paragraphs */
}
.promo-box img {
    object-fit: cover;
    width: 50%;
    height: 100%;
    border-radius: 10px;
}
.carousel-controls {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 90%;
    display: flex;
    justify-content: space-between;
    z-index: 5;
}
.carousel-controls button {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}
</style>
