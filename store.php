<?php
session_start();
include "db_conn.php";

// Fetch products from the database
$sql = "SELECT * FROM products_tb"; // Adjust this query as needed
$result = mysqli_query($conn, $sql);

// Check if the query was successful
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
                <select id="filter">
                    <option value="all">All</option>
                    <option value="category1">Category 1</option>
                    <option value="category2">Category 2</option>
                </select>
            </div>
        </section>
        <section class="product-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                    <div class="image-container" onclick="openImageModal('<?php echo "You need to register first" ?>')">
                        <img src="gomeMDJ2/<?php echo htmlspecialchars($row['images']); ?>">
                    </div>
                    <div class="product-description"> 
                        <h2>Item Details</h2>
                        <div class="basic-info">
                            <p><strong>Model:</strong> <?php echo htmlspecialchars($row['p_model'])?></p>
                            <p><strong>Price:</strong> <?php echo htmlspecialchars($row['p_price'])?></p>
                        </div>
                    </div>
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
    </main>
    <?php include 'body/footer.php'; ?>

    <script src="js/script.js"></script>
    <script>
        function openPopup(id) {
            const popup = document.getElementById('details-popup-' + id);
            popup.style.display = 'block';

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
        display: none;
        /* Hide the modal by default */
        position: fixed;
        padding-top: 65px;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Black background with opacity */
    }

    .popup-content {
        position: relative;
        background-color: #fff;
        border-radius: 5%;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Width of the modal */
        max-width: 600px;
        /* Maximum width of the modal */
        max-height: 70vh;
        /* Maximum height of the modal */
        overflow-y: auto;
        /* Enable vertical scrolling */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .popup-content h4 {
        font-size: 1.5em;
        /* Adjust the size as needed (e.g., 1.5em or 24px) */
        margin-bottom: 10px;
        /* Optional: adjust margin for spacing */
    }

    .image-modal {
        display: none;
        /* Hide modal by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        /* Black background with opacity */
        justify-content: center;
        align-items: center;
    }

    .image-modal img {
        max-width: 100%;
        /* Allow the image to take up full width of the modal */
        max-height: 60vh;
        /* Keep the height within 90% of the viewport height */
        width: auto;
        /* Let the width adjust automatically */
        height: auto;
        /* Let the height adjust automatically */
        border-radius: 10px;
        /* Optional: rounded corners for the image */
    }


    /* Custom scrollbar styles */
    .popup-content::-webkit-scrollbar {
        width: 8px;
        /* Width of the scrollbar */
    }

    .popup-content::-webkit-scrollbar-track {
        background: transparent;
        /* Hide the track */
    }

    .popup-content::-webkit-scrollbar-thumb {
        background: #888;
        /* Gray color of the scrollbar thumb */
        border-radius: 4px;
        /* Rounded corners */
    }

    .popup-content::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Darker gray on hover */
    }

    .popup-content::-moz-scrollbar {
        width: 8px;
        /* Width of the scrollbar */
    }

    .popup-content::-moz-scrollbar-track {
        background: transparent;
        /* Hide the track */
    }

    .popup-content::-moz-scrollbar-thumb {
        background: #888;
        /* Gray color of the scrollbar thumb */
        border-radius: 4px;
        /* Rounded corners */
    }

    .popup-content::-moz-scrollbar-thumb:hover {
        background: #555;
        /* Darker gray on hover */
    }

    .details-section {
        margin: 10px 0;
        /* Margin between sections */
    }

    .popup-title {
        color: #333;
        /* Dark gray for title text */
    }
</style>