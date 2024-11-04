<?php
// Database connection
define('PROJECT_ROOT', dirname(__DIR__, 3));
include_once PROJECT_ROOT . "/db_conn.php";

// Fetch promotion data
$sql = "SELECT id, p_name, p_image, p_monthly, p_year FROM promos_tb"; // Include the ID for each promotion
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promos</title>
    <style>
        .promos-header {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 10px;
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
            grid-template-columns: repeat(6, calc(33.33% - 40px));
            gap: 40px;
            transition: transform 0.5s ease-in-out;
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
            margin-bottom: 10px;
            z-index: 900;
            border-radius: 15px;
            align-items: center;
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
            margin-left: -40px;
            width: 70%;
            display: flex;
            justify-content: space-between;
            z-index: 1000;
        }
        .carousel-controls button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .curtain1, .curtain2 {
            position: relative;
            background: linear-gradient(to right, rgba(125, 125, 125, 1), rgba(125, 125, 125, 0.85));
            height: 100%;
            width: 600px;
            z-index: 950;
            float: left;
        }
        .curtain2 {
            background: linear-gradient(to left, rgba(125, 125, 125, 1), rgba(125, 125, 125, 0.85));
            float: right;
            width: 575px;
            padding-left: 10px;
        }
        .promoModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f9f9f9; /* Light background for the modal */
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* More pronounced shadow */
            z-index: 1000;
            width: 400px; /* Increased width for better spacing */
            border-radius: 8px; /* Rounded corners */
        }
        .promoModal h2 {
            margin: 0 0 15px;
            color: #333; 
            text-align: center; 
        }
        .promoModal label {
            display: block; /* Labels occupy the full width */
            margin: 10px 0 5px; /* Space above and below labels */
            font-weight: bold; /* Bold labels for emphasis */
            color: #333;
        }
        .promoModal input[type="text"],
        .promoModal input[type="file"] {
            width: calc(100% - 10px); /* Full width inputs with padding */
            padding: 8px; /* Padding for input fields */
            border: 1px solid #ccc; /* Light border for inputs */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 15px; /* Space below inputs */
        }

        .promoModal .button {
            background-color: #4CAF50; /* Green background for buttons */
            color: white; /* White text for better contrast */
            border: none; /* No border */
            padding: 10px 15px; /* Padding for buttons */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: calc(40% - 5px); /* Button width adjustment */
            margin-left: 5px; /* Space between buttons */
        }

        .promoModal .close-modal {
            background-color: #333; /* Green background for buttons */
            color: white; /* White text for better contrast */
            border: none; /* No border */
            padding: 10px 15px; /* Padding for buttons */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: calc(40% - 5px); /* Button width adjustment */
            margin-right: 5px; /* Space between buttons */
        }

    </style>
</head>
<body>
    <div class="promos-header">Promos</div>
    
    <div class="carousel-container">
        <div class="curtain1"></div>
        <div class="carousel">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="promo-box">
                        <img src="<?php echo htmlspecialchars($row['p_image']); ?>" alt="<?php echo htmlspecialchars($row['p_name']); ?>" class="promo-img">
                        <button class="promo-box-modal-button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo htmlspecialchars($row['p_name']); ?>" data-monthly="<?php echo htmlspecialchars($row['p_monthly']); ?>" data-year="<?php echo htmlspecialchars($row['p_year']); ?>">Edit Promo</button>
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

    <div id="editPromoModal" class="promoModal">
        <h2>Edit Promotion</h2>
        <form id="editPromoForm" action="../body/admin/config/update-promo.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="promo_id" name="promo_id"> <!-- Hidden field for promo ID -->
            <label for="p_name">Model Name:</label>
            <input type="text" id="p_name" name="p_name" required>

            <label for="p_monthly">Monthly:</label>
            <input type="text" id="p_monthly" name="p_monthly" required>

            <label for="p_year">Year:</label>
            <input type="text" id="p_year" name="p_year" required>

            <label for="p_image">Update Image:</label>
            <input type="file" id="p_image" name="p_image" accept="image/*">

            <button type="submit" class="button">Update Promotion</button>
            <button type="button" class="close-modal" onclick="closeEditModal()">Close</button>
        </form>
    </div>


    <script>
        const promoModalButtons = document.querySelectorAll('.promo-box-modal-button');
        const editPromoModal = document.getElementById('editPromoModal');
        const promoIdInput = document.getElementById('promo_id');
        const promoNameInput = document.getElementById('p_name');
        const promoMonthlyInput = document.getElementById('p_monthly');
        const promoYearInput = document.getElementById('p_year');

        promoModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                promoIdInput.value = button.getAttribute('data-id');
                promoNameInput.value = button.getAttribute('data-name');
                promoMonthlyInput.value = button.getAttribute('data-monthly');
                promoYearInput.value = button.getAttribute('data-year');
                
                // Show the modal
                editPromoModal.style.display = 'block';
            });
        });

        function closeEditModal() {
            editPromoModal.style.display = 'none'; // Hide the modal
        }

        // Carousel functionality
        const promoCarousel = document.querySelector('.carousel');
        const promoPrevBtn = document.getElementById('promoPrevBtn');
        const promoNextBtn = document.getElementById('promoNextBtn');
        let promoCurrentSlide = 0;
        const promoTotalSlides = <?php echo $result->num_rows; ?>; // Total slides based on the result
        const promoVisibleSlides = 3; // Number of boxes visible at once

        promoNextBtn.addEventListener('click', () => {
            if (promoCurrentSlide < promoTotalSlides - promoVisibleSlides) {
                promoCurrentSlide++;
                promoCarousel.style.transform = `translateX(-${promoCurrentSlide * (100 / promoVisibleSlides)}%)`;
            }
        });

        promoPrevBtn.addEventListener('click', () => {
            if (promoCurrentSlide > 0) {
                promoCurrentSlide--;
                promoCarousel.style.transform = `translateX(-${promoCurrentSlide * (100 / promoVisibleSlides)}%)`;
            }
        });
    </script>

</body>
</html>
