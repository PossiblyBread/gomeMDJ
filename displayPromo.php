<?php
include_once "db_conn.php";

// Fetch data from the database
$sql = "SELECT id, p_name, p_image, p_monthly, p_year, total_discount, base_price FROM promos_tb";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Image Carousel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .displayPromo-carousel {
            position: relative;
            max-width: 900px;
            margin: auto;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background: linear-gradient(to bottom right, #a2c2e0, #f0f4f8);
        }
        .promo-name {
            font-weight: bold; 
            font-size: 1.2em; 
            margin-top: 10px; 
        }
        .displayPromo-carousel-items {
            display: flex;
            transition: transform 0.5s ease;
        }

        .displayPromo-carousel-item {
            min-width: calc(33.33% - 60px);
            box-sizing: border-box;
            text-align: center;
            margin: 30px;
        }

        .displayPromo-carousel-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s ease; /* Add transition */
        }

        .displayPromo-carousel-item img:hover {
            transform: scale(1.05); /* Zoom in on hover */
        }


        .displayPromo-carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            padding: 10px;
            font-size: 24px;
            color: #333;
            z-index: 10;
        }

        .displayPromo-prev {
            left: 10px;
        }

        .displayPromo-next {
            right: 10px;
        }

        .displayPromo-carousel-button:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        .displayPromo-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .displayPromo-modal-content {
            padding-top: 40px;
            padding-bottom: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 50px auto; /* Adjusted margin for more vertical space */
            width: 70%; /* Increase width to 70% or set to a specific pixel value */
            max-width: 900px; /* Set a maximum width if desired */
            background: linear-gradient(to bottom right, #ffffff, #d0e3f0); /* Keep your gradient */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
        }


        .displayPromo-modal-image {
            max-width: 100%; /* Allow the image to take the full width of the modal */
            max-height: 500px; /* Set a maximum height to maintain aspect ratio and prevent overflow */
            margin-right: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }


        .displayPromo-modal-caption {
            color: #333; /* Dark text for better readability */
            font-size: 24px;
            margin-bottom: 20px;
        }

        .displayPromo-modal-details {
            color: #555; /* Slightly lighter text color for details */
            font-size: 18px;
            line-height: 1.5;
        }

        .displayPromo-close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        @media (max-width: 800px) {
            .displayPromo-carousel-item {
                min-width: 100%;
                margin: 0;
            }

            .displayPromo-modal-content {
                flex-direction: column;
                padding-top: 50px;
                width: 90%;
            }

            .displayPromo-modal-image {
                max-width: 80%;
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="displayPromo-carousel">
        <div class="displayPromo-carousel-items">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="displayPromo-carousel-item">
                        <img src="gomeMDJ2/<?= htmlspecialchars($row['p_image']) ?>" alt="<?= htmlspecialchars($row['p_name']) ?>" onclick="openPromoModal(this.src, '<?= htmlspecialchars($row['p_name']) ?>', '<?= htmlspecialchars($row['p_monthly']) ?>', '<?= htmlspecialchars($row['p_year']) ?>', '<?= htmlspecialchars($row['total_discount']) ?>', '<?= htmlspecialchars($row['base_price']) ?>')">
                        <p class="promo-name"><?= htmlspecialchars($row['p_name']) ?></p>
                    </div>
                    <?php
                }
            } else {
                ?>
                <p>No images found.</p>
                <?php
            }

            $conn->close();
            ?>
        </div>
        <button class="displayPromo-carousel-button displayPromo-prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="displayPromo-carousel-button displayPromo-next" onclick="changeSlide(1)">&#10095;</button>
    </div>

    <div id="myPromoModal" class="displayPromo-modal" onclick="closePromoModal(event)">
        <span class="displayPromo-close" onclick="closePromoModal(event)">&times;</span>
        <div class="displayPromo-modal-content">
            <img class="displayPromo-modal-image" id="promoModalImage" alt="Promo Image">
            <div>
                <div class="displayPromo-modal-caption" id="promoCaption"></div>
                <div class="displayPromo-modal-details" id="promoDetails"></div>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const items = document.querySelectorAll('.displayPromo-carousel-item');
        const totalSlides = items.length;

        function showSlide(index) {
            const maxIndex = totalSlides - (window.innerWidth < 800 ? 1 : 3);
            if (index < 0) {
                currentSlide = 0;
            } else if (index > maxIndex) {
                currentSlide = maxIndex;
            } else {
                currentSlide = index;
            }

            const visibleItems = window.innerWidth < 800 ? 1 : 3;
            const offset = -currentSlide * (100 / visibleItems);
            document.querySelector('.displayPromo-carousel-items').style.transform = `translateX(${offset}%)`;
        }

        function changeSlide(direction) {
            const newSlide = currentSlide + direction;
            const maxIndex = totalSlides - (window.innerWidth < 800 ? 1 : 3);

            if (newSlide >= 0 && newSlide <= maxIndex) {
                showSlide(newSlide);
            }
        }

        function openPromoModal(imageSrc, captionText, monthly, year, discount, basePrice) {
            const modal = document.getElementById("myPromoModal");
            const modalImage = document.getElementById("promoModalImage");
            const caption = document.getElementById("promoCaption");
            const details = document.getElementById("promoDetails");
            
            modal.style.display = "block";
            modalImage.src = imageSrc;
            caption.innerHTML = `<span class="promo-name">${captionText}</span>`;
            details.innerHTML = `
                <strong>Monthly:</strong> ${monthly}<br>
                <strong>Year:</strong> ${year}<br>
                <strong>Total Discount:</strong> ${discount}%<br>
                <strong>Base Price:</strong> PHP${basePrice}
            `;
        }

        function closePromoModal(event) {
            if (event.target === document.getElementById("myPromoModal") || event.target.classList.contains('displayPromo-close')) {
                document.getElementById("myPromoModal").style.display = "none";
            }
        }

        showSlide(currentSlide);
        window.addEventListener('resize', () => showSlide(currentSlide));
    </script>

</body>
</html>
