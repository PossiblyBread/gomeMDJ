<?php
session_start();
include "db_conn.php";

// Fetch products from the database
$sql = "SELECT * FROM products_tb"; 
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error retrieving products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="styles/styles.css"> <!-- Assuming the CSS styles from the template -->
    <style>
        /* Store css */
        /* Filter Section */
        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(to right, #add8e6 0%, #5c848a 100%);
            border-bottom: 1px solid #ccc;
            border-radius: 15px;
        }

        .filter-section h2 {
            margin: 0;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-bar select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Products Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 40px;
        }
        /* Button Styles */
        .viewMore-button {
            background-color: #5c848a; /* Main button color */
            color: white; /* Text color */
            padding: 10px 20px; /* Vertical and horizontal padding */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            font-size: 16px; /* Font size */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition */
            text-align: center; /* Center text */
        }

        /* Hover Effect */
        .viewMore-button:hover {
            background-color: #3a585c; /* Darker shade for hover */
            transform: translateY(-2px); /* Lift effect */
        }

        /* Optional: Active Effect */
        .viewMore-button:active {
            transform: translateY(1px); /* Pressed effect */
            background-color: #2a3a3b; /* Even darker shade when pressed */
        }

        /* Media query for mobile view */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
                padding: 0;
                padding-top: 20px;
            }
            /* Hide item details and price on mobile */
            .mobile-hide {
                display: none;
            }
            .viewMore-button {
                padding: 8px 12px; 
                font-size: 14px;
            }
        }

        .product-card {
            background-color: white;
            padding: 20px;
            padding-top: 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            /* transition: transform 0.3s ease, box-shadow 0.3s ease;*/
        }

        .product-card:hover {
            transform: translateY(-5px) scale(1.05); 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
        }

        /* Disable hover effects when modal is open */
        .modal-open .product-card:hover {
            transform: none; /* Disable hover effect when modal is open */
            box-shadow: none; /* Disable shadow when modal is open */
        }
        
        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 15px 0 10px;
            font-size: 20px;
        }

        .product-card .short-description {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .popup {
            display: none;
            position: fixed;
            padding-top: 65px;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            position: relative;
            background-color: #fff;
            border-radius: 5%;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            max-height: 70vh;
            overflow-y: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .image-modal img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 10px;
        }

        .details-section {
            margin: 10px 0;
        }

        .popup-title {
            color: #333;
        }

        /* Disable hover effects when modal is open */
        .modal-open .product-card:hover {
            transform: none; /* Disable hover effect when modal is open */
            box-shadow: none; /* Disable shadow when modal is open */
        }
    </style>
</head>

<body>
    <?php include 'body/header.php'; ?>
    <?php include 'body/side-bar.php'; ?>

    <div id="overlay"></div>
    <main>
        <section class="filter-section">
            <h2>Products Available</h2>
            <div class="filter-bar">
                <label for="filter">Filter By:</label>
                <select id="filter" onchange="filterProducts()">
                    <option value="all">All Types</option>
                    <option value="2 wheels">Bikes</option>
                    <option value="3 wheels">Trikes</option>
                    <option value="4 wheels">Quad Bikes</option>
                </select>
            </div>
        </section>

        <section class="product-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card" data-wheels="<?php echo htmlspecialchars($row['p_wheels']); ?>">
                    <div class="image-container" onclick="openImageModal('gomeMDJ2/<?php echo htmlspecialchars($row['images']); ?>')">
                        <img src="gomeMDJ2/<?php echo htmlspecialchars($row['images']); ?>" alt="Product Image">
                    </div>
                    <div class="product-description">
                        <h2 class="mobile-hide">Item Details</h2>
                        <div class="basic-info">
                            <p><strong>Model:</strong> <?php echo htmlspecialchars($row['p_model'])?></p>
                            <p class="mobile-hide"><strong>Price:</strong> <?php echo htmlspecialchars($row['p_price'])?></p>
                        </div>
                    </div>

                    <button class="viewMore-button" onclick="openPopup('<?php echo $row['id']; ?>')">More Details</button>
                    <!-- Popup for More Details -->
                    <div class="popup" id="details-popup-<?php echo $row['id']; ?>">
                        <div class="popup-content">
                            <h3 class="popup-title">More Details</h3>

                            <div class="details-section">
                                <p><strong>Model:</strong> <?php echo htmlspecialchars($row['p_model'])?></p>
                                <p><strong>Price:</strong> <?php echo htmlspecialchars($row['p_price'])?></p>
                            </div>

                            <div class="details-section">
                                <h4>Specifications</h4>
                                <p><strong>Wheel Count:</strong> <?php echo htmlspecialchars($row['p_wheels']); ?></p>
                                <p><strong>Max Weight Load:</strong> <?php echo htmlspecialchars($row['p_range']); ?></p>
                                <p><strong>Motor Power:</strong> <?php echo htmlspecialchars($row['p_motor_power']); ?></p>
                                <p><strong>Battery Capacity:</strong> <?php echo htmlspecialchars($row['p_battery']); ?></p>
                                <p><strong>Max Speed:</strong> <?php echo htmlspecialchars($row['p_max_speed']); ?></p>
                                <p><strong>Range:</strong> <?php echo htmlspecialchars($row['p_range']); ?></p>
                                <p><strong>Charging Time:</strong> <?php echo htmlspecialchars($row['p_charging_time']); ?></p>
                            </div>

                            <div class="details-section">
                                <h4>Others</h4>
                                <p><strong>Color Variants:</strong> <?php echo htmlspecialchars($row['p_variants']); ?></p>
                                <p><strong>Other Features:</strong> <?php echo htmlspecialchars($row['p_other_features']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>

        <!-- Modal for Enlarged Image -->
        <div id="image-modal" class="image-modal" style="display: none;" onclick="closeImageModal()">
            <span class="modal-overlay"></span>
            <img id="enlarged-image" src="" alt="Enlarged Image" style="max-width: 100%; max-height: 90vh; margin: auto; display: block;">
        </div>
    </main>
    <?php include 'body/footer.php'; ?>

    <script src="js/script.js"></script>
    <script>
        function openPopup(id) {
            const popup = document.getElementById('details-popup-' + id);
            popup.style.display = 'block';
            document.body.classList.add('modal-open'); // Add class to body

            window.onclick = function(event) {
                if (event.target === popup) {
                    closePopup(id);
                }
            };
        }

        function closePopup(id) {
            const popup = document.getElementById('details-popup-' + id);
            popup.style.display = 'none';
            document.body.classList.remove('modal-open'); // Remove class from body
            window.onclick = null; // Remove event listener
        }

        function openImageModal(imageSrc) {
            const modal = document.getElementById('image-modal');
            const enlargedImage = document.getElementById('enlarged-image');
            enlargedImage.src = imageSrc; // Set the source of the enlarged image
            modal.style.display = 'flex'; // Show the modal using flex
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            modal.style.display = 'none'; // Hide the modal
        }

        function filterProducts() {
            const filterValue = document.getElementById('filter').value;
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const wheelsCount = card.getAttribute('data-wheels');
                if (filterValue === 'all' || wheelsCount === filterValue) {
                    card.style.display = 'block'; // Show the product card
                } else {
                    card.style.display = 'none'; // Hide the product card
                }
            });
        }
    </script>
</body>

</html>
