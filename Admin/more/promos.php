<?php
// Database connection
define('PROJECT_ROOT', dirname(__DIR__, 2));
include_once PROJECT_ROOT . "/db_conn.php";

// Fetch promotion data
$sql = "SELECT id, p_name, p_image, p_monthly, p_year, total_discount, base_price FROM promos_tb";
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
            color: black;
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* carousel style */
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
            width: 80%;
            margin: auto;
        }

        /* promos items */
        .promo-box {
            background-color: transparent;
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
            border: 1px solid #ccc;
        }

        .promo-box img {
            object-fit: cover;
            width: 100%;
            height: auto;
            border-radius: 10px;
            background-color: transparent;
            cursor: pointer;
        }

        .carousel-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
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
            border-radius: 50%;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 10100;
        }

        /* promo modal */
        .promoModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, #b2ebf2, #e0e0e0);
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            z-index: 10200;
            width: 400px;
            border-radius: 8px;
            color: black;
        }

        .promoModal h2 {
            margin: 0 0 15px;
            color: #333;
            text-align: center;
        }

        .promoModal label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        .promoModal input[type="text"],
        .promoModal input[type="file"] {
            width: calc(100% - 10px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .promoModal .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: calc(40% - 5px);
            margin-left: 5px;
        }

        .promoModal .close-modal {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: calc(40% - 5px);
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <div class="promos-header">Promos</div>

    <div class="carousel-container">
        <div class="carousel">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="promo-box">
                        <img src="<?php echo htmlspecialchars($row['p_image']); ?>" alt="<?php echo htmlspecialchars($row['p_name']); ?>" class="promo-img" data-id="<?php echo $row['id']; ?>" data-name="<?php echo htmlspecialchars($row['p_name']); ?>" data-monthly="<?php echo htmlspecialchars($row['p_monthly']); ?>" data-year="<?php echo htmlspecialchars($row['p_year']); ?>" data-base-price="<?php echo htmlspecialchars($row['base_price']); ?>" data-total-discount="<?php echo htmlspecialchars($row['total_discount']); ?>">
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

    <div id="overlay" class="overlay"></div>

    <div id="editPromoModal" class="promoModal">
        <h2>Edit Promotion</h2>
        <form id="editPromoForm" action="config/update-promo.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="promo_id" name="promo_id">
            <label for="p_name">Model Name:</label>
            <input type="text" id="p_name" name="p_name" required>

            <label for="base_price">Base Price:</label>
            <input type="text" id="base_price" name="base_price" pattern="^\d+(\.\d{1,2})?$" title="Only numbers with 2 decimal numbers are allowed." required>

            <label for="p_monthly">Monthly:</label>
            <input type="text" id="p_monthly" name="p_monthly" pattern="^\d+(\.\d{1,2})?$" title="Only numbers with 2 decimal numbers are allowed." required>

            <label for="p_year">Months:</label>
            <input type="text" id="p_year" name="p_year" pattern="^\d+$" title="Please enter a valid whole number for the year." required>

            <label for="total_discount">Total Discount:</label>
            <input type="text" id="total_discount" name="total_discount" pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid discount amount (up to two decimal places)." required>

            <label for="p_image">Update Image:</label>
            <input type="file" id="p_image" name="p_image" accept="image/png*">

            <button type="submit" class="button">Update Promotion</button>
            <button type="button" class="close-modal" onclick="closeEditModal()">Close</button>
        </form>
    </div>

    <script>
        const overlay = document.getElementById('overlay');
        const promoImages = document.querySelectorAll('.promo-box img');
        const editPromoModal = document.getElementById('editPromoModal');
        const promoIdInput = document.getElementById('promo_id');
        const promoNameInput = document.getElementById('p_name');
        const promoMonthlyInput = document.getElementById('p_monthly');
        const promoYearInput = document.getElementById('p_year');
        const promoBasePriceInput = document.getElementById('base_price');
        const promoTotalDiscountInput = document.getElementById('total_discount');

        promoImages.forEach(img => {
            img.addEventListener('click', () => {
                promoIdInput.value = img.getAttribute('data-id');
                promoNameInput.value = img.getAttribute('data-name');
                promoMonthlyInput.value = img.getAttribute('data-monthly');
                promoYearInput.value = img.getAttribute('data-year');
                promoBasePriceInput.value = img.getAttribute('data-base-price');
                promoTotalDiscountInput.value = img.getAttribute('data-total-discount');

                // Show the modal and overlay
                editPromoModal.style.display = 'block';
                overlay.style.display = 'block'; // Show the overlay
            });
        });

        function closeEditModal() {
            editPromoModal.style.display = 'none';
            overlay.style.display = 'none'; // Hide the overlay when closing the modal
        }

        // Carousel functionality
        const promoCarousel = document.querySelector('.carousel');
        const promoPrevBtn = document.getElementById('promoPrevBtn');
        const promoNextBtn = document.getElementById('promoNextBtn');

        const promoTotalSlides = <?php echo $result->num_rows; ?>;
        const promoVisibleSlides = 3; // You can adjust this based on your layout

        let promoCurrentSlide = 0;

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