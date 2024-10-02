<?php
session_start();
include "config/home_config.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - My Website</title>
    <link rel="stylesheet" href="styles/styles.css"> <!-- Assuming the CSS styles from the template -->
</head>
<body>
    <header>
        <div class="top-nav">
            <h1>Logo & Name</h1>
            <div class="menu-toggle" id="menu-toggle">&#9776;</div>
            <div class="top-nav-btn">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="store.php">Store</a>
                <a href="Ticketing-System/support.php">Support</a>
                <div class="profile-icon" id="profile-icon">
                    <!-- SVG Profile Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>
    
    <aside class="side-nav" id="side-nav">
        <div class="profile-icon" id="sidebar-profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            </svg>
        </div>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="store.php">Store</a>
        <a href="Ticketing-System/support.php">Support</a>
    </aside>
    
    <div id="overlay"></div>

    <!-- Main Content Section -->
    <main>
        <!-- Filter Section -->
        <section class="filter-section">
            <h2>Products Available</h2>
            <div class="filter-bar">
                <label for="filter">Filter By:</label>
                <select id="filter">
                    <option value="all">All</option>
                    <option value="category1">Category 1</option>
                    <option value="category2">Category 2</option>
                </select>
            </div>
        </section>

        <!-- Products Grid Section -->
        <section class="product-grid">
            <!-- Product Cards with Show More button -->
            <div class="product-card">
                <img src="product1.jpg" alt="Product 1">
                <h3>Product 1</h3>
                <p class="short-description">This is a brief description of product 1.</p>
                <button class="show-more-btn" onclick="toggleDetails(this)">Show More</button>
                <div class="long-description">
                    <p>This is a more detailed description of Product 1. It includes information about the features, materials, and specifications of the product. Ideal for showcasing why this product stands out.</p>
                </div>
            </div>
            <div class="product-card">
                <img src="product2.jpg" alt="Product 2">
                <h3>Product 2</h3>
                <p class="short-description">This is a brief description of product 2.</p>
                <button class="show-more-btn" onclick="toggleDetails(this)">Show More</button>
                <div class="long-description">
                    <p>This is a more detailed description of Product 2. It covers unique aspects, usage instructions, and additional features of the product.</p>
                </div>
            </div>
            <div class="product-card">
                <img src="product3.jpg" alt="Product 3">
                <h3>Product 3</h3>
                <p class="short-description">This is a brief description of product 3.</p>
                <button class="show-more-btn" onclick="toggleDetails(this)">Show More</button>
                <div class="long-description">
                    <p>Product 3 comes with a detailed description that elaborates on its benefits, components, and potential uses for customers.</p>
                </div>
            </div>
            <div class="product-card">
                <img src="product4.jpg" alt="Product 4">
                <h3>Product 4</h3>
                <p class="short-description">This is a brief description of product 4.</p>
                <button class="show-more-btn" onclick="toggleDetails(this)">Show More</button>
                <div class="long-description">
                    <p>This product's extended description highlights key selling points and user experiences to guide potential buyers.</p>
                </div>
            </div>
        </section>
    </main>
    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <h2>Login</h2>
            <form id="login-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Quick Links</h4>
                <a href="#">FAQs</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
            <div class="footer-section">
                <h4>Contact Info</h4>
                <p>Email: contact@example.com</p>
                <p>Phone: +123 456 7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
            <a href="#" class="back-to-top">Back to Top</a>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>
