<?php
session_start();
include "db_conn.php";

$sql = "SELECT id, p_name, p_image, p_monthly, p_year, total_discount, base_price FROM promos_tb"; // Include the ID for each promotion
$result = $conn->query($sql);
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

    <!-- Main Content Section -->
    <main>
        <section class="hero">
            <h2>Welcome to Our Website!</h2>
            <p>Explore amazing products and services. Our store offers the best deals, and our support team is always here to help you.</p>
            <button class="learn-more-btn">Learn More</button>
        </section>

        <section class="features">
            <div class="carousel-container">
                <div class="curtain1"></div>
                <div class="carousel">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="promo-box">
                                <img src="gomeMDJ2/<?php echo htmlspecialchars($row['p_image']); ?>" alt="<?php echo htmlspecialchars($row['p_name']); ?>" class="promo-img">
                                <p><strong>Model Name:</strong> <?php echo htmlspecialchars($row['p_name']); ?></p>
                                <p><strong>Monthly:</strong> <?php echo htmlspecialchars($row['p_monthly']); ?></p>
                                <p><strong>Year:</strong> <?php echo htmlspecialchars($row['p_year']); ?></p>
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
                <div class="curtain2"></div>
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
    <div id="register-modal">
        <div class="register-modal-content">
            <span class="register-close" onclick="document.getElementById('register-modal').style.display='none'">&times;</span>
            <form id="register-form" method="post" onsubmit="return validatePasswordAndEmail()">
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

