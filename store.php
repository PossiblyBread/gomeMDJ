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
        <!-- Add an Increment Section for the products -->
        <!-- Products Grid Section -->
        <section class="product-grid">
            <!-- Product Cards dynamically generated from database -->
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                <div class="image-container" onclick="openImageModal('<?php echo htmlspecialchars($row['images']); ?>')">
                    <img src="<?php echo htmlspecialchars($row['images']); ?>" alt="<?php echo htmlspecialchars($row['p_brand'] . ' ' . $row['p_model']); ?>">
                </div>
                    <div class="product-description"> <!-- Changed to lowercase -->
                        <h2>Item Details</h2>
                        <div class="basic-info">
                            <p><strong>Brand and Model:</strong> <?php echo htmlspecialchars($row['p_brand']) . ' ' . htmlspecialchars($row['p_model']); ?></p>
                            <p><strong>Year:</strong> <?php echo htmlspecialchars($row['p_year']); ?></p>
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($row['p_type']); ?></p>
                        </div>
                    </div>
                    <!-- Modal for Enlarged Image -->
                    <div id="image-modal" class="image-modal" onclick="closeImageModal()">
                        <span class="modal-overlay"></span>
                        <img id="enlarged-image" src="" alt="Enlarged Image" style="max-width: 100%; max-height: 90vh; margin: auto; display: block;">
                    </div>

                    <button class="more-details-btn" onclick="openPopup('<?php echo $row['id']; ?>')">More Details</button>
                    <!-- Popup for More Details -->
                    <div class="popup" id="details-popup-<?php echo $row['id']; ?>">
                        <div class="popup-content">
                            <h3 class="popup-title">More Details</h3>
                            
                            <div class="details-section">
                                <p><h4><strong>Brand and Model:</strong></h4> <?php echo htmlspecialchars($row['p_brand']) . ' ' . htmlspecialchars($row['p_model']); ?></p>
                                <p><h4><strong>Year:</strong></h4> <?php echo htmlspecialchars($row['p_year']); ?></p>
                                <p><h4><strong>Type:</strong></h4> <?php echo htmlspecialchars($row['p_type']); ?></p>
                            </div>

                            <div class="details-section">
                                <h4>Dimensions and Weight</h4>
                                <p><strong>Frame Size:</strong> <?php echo htmlspecialchars($row['p_frame_size']); ?></p>
                                <p><strong>Wheel Size:</strong> <?php echo htmlspecialchars($row['p_wheel_size']); ?></p>
                                <p><strong>Weight:</strong> <?php echo htmlspecialchars($row['p_weight']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Motor and Performance</h4>
                                <p><strong>Motor Type:</strong> <?php echo htmlspecialchars($row['p_motor_type']); ?></p>
                                <p><strong>Motor Power:</strong> <?php echo htmlspecialchars($row['p_motor_power']); ?></p>
                                <p><strong>Top Speed:</strong> <?php echo htmlspecialchars($row['p_top_speed']); ?></p>
                                <p><strong>Pedal Assist Levels:</strong> <?php echo htmlspecialchars($row['p_pedal_assist_levels']); ?></p>
                                <p><strong>Throttle:</strong> <?php echo htmlspecialchars($row['p_throttle']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Battery</h4>
                                <p><strong>Battery Type:</strong> <?php echo htmlspecialchars($row['p_battery_type']); ?></p>
                                <p><strong>Battery Capacity:</strong> <?php echo htmlspecialchars($row['p_battery_capacity']); ?></p>
                                <p><strong>Range:</strong> <?php echo htmlspecialchars($row['p_range']); ?></p>
                                <p><strong>Charge Time:</strong> <?php echo htmlspecialchars($row['p_charge_time']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Drivetrain and Components</h4>
                                <p><strong>Gears:</strong> <?php echo htmlspecialchars($row['p_gears']); ?></p>
                                <p><strong>Brakes:</strong> <?php echo htmlspecialchars($row['p_brakes']); ?></p>
                                <p><strong>Suspension:</strong> <?php echo htmlspecialchars($row['p_suspension']); ?></p>
                                <p><strong>Tires:</strong> <?php echo htmlspecialchars($row['p_tires']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Frame and Construction</h4>
                                <p><strong>Frame Material:</strong> <?php echo htmlspecialchars($row['p_frame_material']); ?></p>
                                <p><strong>Fork:</strong> <?php echo htmlspecialchars($row['p_fork']); ?></p>
                                <p><strong>Handlebars:</strong> <?php echo htmlspecialchars($row['p_handlebars']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Electronics and Controls</h4>
                                <p><strong>Display:</strong> <?php echo htmlspecialchars($row['p_display']); ?></p>
                                <p><strong>Lighting:</strong> <?php echo htmlspecialchars($row['p_lighting']); ?></p>
                                <p><strong>Connectivity:</strong> <?php echo htmlspecialchars($row['p_connectivity']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Safety and Convenience Features</h4>
                                <p><strong>Fenders:</strong> <?php echo htmlspecialchars($row['p_fenders']); ?></p>
                                <p><strong>Rack:</strong> <?php echo htmlspecialchars($row['p_rack']); ?></p>
                                <p><strong>Kickstand:</strong> <?php echo htmlspecialchars($row['p_kickstand']); ?></p>
                                <p><strong>Lock:</strong> <?php echo htmlspecialchars($row['p_lock']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Accessories and Additional Features</h4>
                                <p><strong>Accessories:</strong> <?php echo htmlspecialchars($row['p_accessories']); ?></p>
                                <p><strong>Warranty:</strong> <?php echo htmlspecialchars($row['p_warranty']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Technical Specifications</h4>
                                <p><strong>Torque:</strong> <?php echo htmlspecialchars($row['p_torque']); ?></p>
                                <p><strong>Max Rider Weight:</strong> <?php echo htmlspecialchars($row['p_max_rider_weight']); ?></p>
                                <p><strong>Water Resistance:</strong> <?php echo htmlspecialchars($row['p_water_resistance']); ?></p>
                            </div>
                        
                            <div class="details-section">
                                <h4>Price</h4>
                                <p><strong>Base Price:</strong> <?php echo htmlspecialchars($row['p_base_price']); ?></p>
                                <p><strong>Optional Features:</strong> <?php echo htmlspecialchars($row['p_optional_features']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
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
    <script>
        function openPopup(id) {
            const popup = document.getElementById('details-popup-' + id);
            popup.style.display = 'block';

            // Add event listener to close the popup when clicking outside of it
            window.onclick = function(event) {
                if (event.target === popup) {
                    closePopup(id);
                }
            };
        }

        function closePopup(id) {
            const popup = document.getElementById('details-popup-' + id);
            popup.style.display = 'none';
            window.onclick = null; // Remove event listener
        }
            function openImageModal(imageSrc) {
            const modal = document.getElementById('image-modal');
            const enlargedImage = document.getElementById('enlarged-image');
            enlargedImage.src = imageSrc;
            modal.style.display = 'flex'; // Show the modal using flex
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            modal.style.display = 'none'; // Hide the modal
        }

    </script>
</body>
</html>
<style>
    .popup {
        display: none; /* Hide the modal by default */
        position: fixed;
        padding-top: 65px;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
    }

    .popup-content {
        position: relative;
        background-color: #fff;
        border-radius: 5%;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Width of the modal */
        max-width: 600px; /* Maximum width of the modal */
        max-height: 70vh; /* Maximum height of the modal */
        overflow-y: auto; /* Enable vertical scrolling */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    .popup-content h4 {
        font-size: 1.5em; /* Adjust the size as needed (e.g., 1.5em or 24px) */
        margin-bottom: 10px; /* Optional: adjust margin for spacing */
    }
    .image-modal {
        display: none; /* Hide modal by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8); /* Black background with opacity */
        justify-content: center;
        align-items: center;
    }

    .image-modal img {
        max-width: 100%; /* Allow the image to take up full width of the modal */
        max-height: 60vh; /* Keep the height within 90% of the viewport height */
        width: auto; /* Let the width adjust automatically */
        height: auto; /* Let the height adjust automatically */
        border-radius: 10px; /* Optional: rounded corners for the image */
    }


    /* Custom scrollbar styles */
    .popup-content::-webkit-scrollbar {
        width: 8px; /* Width of the scrollbar */
    }

    .popup-content::-webkit-scrollbar-track {
        background: transparent; /* Hide the track */
    }

    .popup-content::-webkit-scrollbar-thumb {
        background: #888; /* Gray color of the scrollbar thumb */
        border-radius: 4px; /* Rounded corners */
    }

    .popup-content::-webkit-scrollbar-thumb:hover {
        background: #555; /* Darker gray on hover */
    }

    .popup-content::-moz-scrollbar {
        width: 8px; /* Width of the scrollbar */
    }

    .popup-content::-moz-scrollbar-track {
        background: transparent; /* Hide the track */
    }

    .popup-content::-moz-scrollbar-thumb {
        background: #888; /* Gray color of the scrollbar thumb */
        border-radius: 4px; /* Rounded corners */
    }

    .popup-content::-moz-scrollbar-thumb:hover {
        background: #555; /* Darker gray on hover */
    }

    .details-section {
        margin: 10px 0; /* Margin between sections */
    }

    .popup-title {
        color: #333; /* Dark gray for title text */
    }
</style>