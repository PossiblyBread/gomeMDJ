<?php
include("../config/update-product.php");

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // Get the product ID from the URL

    // Fetch product details from the database
    $sql = "SELECT p.*, GROUP_CONCAT(pi.Images) AS all_images, GROUP_CONCAT(pi.image_type) AS image_types
            FROM products_tb p 
            LEFT JOIN products_img_id pi ON p.products_id = pi.products_id
            WHERE p.products_id = $productId"; // Retrieve the specific product with image
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error fetching product details: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result); // Fetch the product details
    } else {
        die("Product not found.");
    }
} else {
    die("No product ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <main id="edit-product-main">
        <a href="../Dashboard.php" class="toggle-button back-btn" style="text-decoration: none;">
            <span class="button-text">Back</span>
            <span class="button-icon">←</span>
        </a>
        <div class="ap-container">
            <h3 class="section-title">Edit Product</h3>
            <br>
            <div class="ap-tabs" role="tablist" aria-label="Product Information Tabs">
                <div class="ap-tab active" data-tab="general-info" role="tab" aria-selected="true" tabindex="0">General Info</div>
                <div class="ap-tab" data-tab="specifications" role="tab" aria-selected="false" tabindex="-1">Specifications</div>
                <div class="ap-tab" data-tab="other-features" role="tab" aria-selected="false" tabindex="-1">Other Features</div>
            </div>

            <form class="ap-form" action="../config/update-product.php?id=<?php echo $product['products_id']; ?>" method="POST" enctype="multipart/form-data">
                <!-- General Info Tab -->
                <div id="general-info" class="ap-tab-content active">
                    <label class="ap-label tooltip" for="p_model">Product Model<span class="required-asterisk">*</span>
                        <span class="tooltiptext">* Enter the model name</span>
                    </label>
                    <input class="ap-input" type="text" name="p_model" id="p_model" value="<?php echo htmlspecialchars($product['p_model']); ?>" required>

                    <label class="ap-label tooltip" for="p_price">Base Price (PHP)<span class="required-asterisk">*</span>
                        <span class="tooltiptext">Enter the base price</span>
                    </label>
                    <input class="ap-input" type="number" name="p_price" id="p_price" value="<?php echo htmlspecialchars($product['p_price']); ?>" required min="0" step="0.01">

                    <label class="ap-label tooltip" for="cover-image">Update Cover Image
                        <span class="tooltiptext">Upload a new main product image</span>
                    </label>
                    <div class="file-input-wrapper">
                        <button type="button" class="file-input-button" onclick="document.getElementById('cover-image').click();">Choose New Cover Image</button>
                        <input type="file" name="cover-image" id="cover-image" accept="image/*" onchange="handleCoverImageChange(event)">
                    </div>
                    <div class="cover-image-container">
                        <?php
                        if ($product['all_images']) {
                            $images = explode(',', $product['all_images']);
                            $types = explode(',', $product['image_types']);
                            foreach ($images as $index => $image) {
                                if ($types[$index] === 'cover') {
                                    echo '<div class="ap-image-preview-wrapper" data-image-type="cover">';
                                    echo '<img id="cover-preview" class="cover-preview" src="../../uploads/' . $image . '" alt="Product Cover Image">';
                                    echo '<button type="button" class="remove-image-btn" data-image="' . $image . '" onclick="handleCoverImageRemove(event)">×</button>';
                                    echo '<input type="hidden" name="existing_cover" value="' . $image . '">';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <label class="ap-label tooltip" for="thumbnail-images">Update Additional Images
                        <span class="tooltiptext">Upload new additional product images</span>
                    </label>
                    <div class="file-input-wrapper">
                        <button type="button" class="file-input-button" onclick="document.getElementById('thumbnail-images').click();">Choose New Additional Images</button>
                        <input type="file" name="thumbnail-images[]" id="thumbnail-images" accept="image/*" multiple onchange="handleThumbnailChange(event)">
                    </div>
                    <div id="thumbnails-container" class="thumbnails-container">
                        <?php
                        if ($product['all_images']) {
                            $images = explode(',', $product['all_images']);
                            $types = explode(',', $product['image_types']);
                            foreach ($images as $index => $image) {
                                if ($types[$index] === 'thumbnail') {
                                    echo '<div class="ap-image-preview-wrapper" data-image-type="thumbnail">';
                                    echo '<img src="../../uploads/' . $image . '" class="ap-image-preview" alt="Thumbnail">';
                                    echo '<button type="button" class="remove-image-btn" data-image="' . $image . '" onclick="handleThumbnailRemove(event)">×</button>';
                                    echo '<input type="hidden" name="existing_thumbnails[]" value="' . $image . '">';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="nav-button next-button" onclick="nextTab('general-info', 'specifications')">Next</button>
                    </div>
                </div>
                <!-- Specifications Tab -->
                <div id="specifications" class="ap-tab-content">
                    <div class="specifications-grid">
                        <div>
                            <label class="ap-label tooltip" for="p_wheels">Wheel Count<span class="required-asterisk">*</span></label>
                            <select class="ap-select" name="p_wheels" id="p_wheels" required>
                                <option value="" disabled>Select wheel count</option>
                                <option value="2 wheels" <?php echo ($product['p_wheels'] == '2 wheels') ? 'selected' : ''; ?>>2 Wheels</option>
                                <option value="3 wheels" <?php echo ($product['p_wheels'] == '3 wheels') ? 'selected' : ''; ?>>3 Wheels</option>
                                <option value="4 wheels" <?php echo ($product['p_wheels'] == '4 wheels') ? 'selected' : ''; ?>>4 Wheels</option>
                            </select>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_motor_power">Motor Power<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_motor_power" id="p_motor_power" value="<?php echo htmlspecialchars($product['p_motor_power']); ?>" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_battery">Battery<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_battery" id="p_battery" value="<?php echo htmlspecialchars($product['p_battery']); ?>" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_max_speed">Max Speed<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_max_speed" id="p_max_speed" value="<?php echo htmlspecialchars($product['p_max_speed']); ?>" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_range">Range (km)<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="number" name="p_range" id="p_range" value="<?php echo htmlspecialchars($product['p_range']); ?>" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_max_load">Max Load (kg)<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="number" name="p_max_load" id="p_max_load" value="<?php echo htmlspecialchars($product['p_max_load']); ?>" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_charging_time">Charging Time<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_charging_time" id="p_charging_time" value="<?php echo htmlspecialchars($product['p_charging_time']); ?>" required>
                        </div>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="nav-button prev-button" onclick="prevTab('specifications', 'general-info')">Previous</button>
                        <button type="button" class="nav-button next-button" onclick="nextTab('specifications', 'other-features')">Next</button>
                    </div>
                </div>

                <!-- Other Features Tab -->
                <div id="other-features" class="ap-tab-content">
                    <label class="ap-label tooltip" for="p_variants">Variants</label>
                    <input class="ap-input" type="text" name="p_variants" id="p_variants" value="<?php echo htmlspecialchars($product['p_variants']); ?>" placeholder="e.g., Red, Blue">

                    <label class="ap-label tooltip" for="p_other_features">Other Features</label>
                    <textarea class="ap-textarea" name="p_other_features" id="p_other_features" rows="4"><?php echo htmlspecialchars($product['p_other_features']); ?></textarea>

                    <label class="ap-label tooltip" for="p_availability">Availability<span class="required-asterisk">*</span></label>
                    <select class="ap-select" name="p_availability" id="p_availability" required>
                        <option value="" disabled>Select availability</option>
                        <option value="Available" <?php echo ($product['u_availability'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                        <option value="Unavailable" <?php echo ($product['u_availability'] == 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                        <option value="Out of Stock" <?php echo ($product['u_availability'] == 'Out of Stock') ? 'selected' : ''; ?>>Out of Stock</option>
                        <option value="Coming Soon!" <?php echo ($product['u_availability'] == 'Coming Soon!') ? 'selected' : ''; ?>>Coming Soon!</option>
                    </select>

                    <div class="navigation-buttons">
                        <button type="button" class="nav-button prev-button" onclick="prevTab('other-features', 'specifications')">Previous</button>
                        <button type="button" class="nav-button" onclick="showConfirmationModal(event)">Update Product</button>
                    </div>
                </div>
            </form>

            <!-- Confirmation Modal -->
            <div id="confirmation-modal" class="modal" role="dialog" aria-hidden="true">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h4>Confirm Product Update</h4>
                    <p>Are you sure you want to update this product?</p>
                    <div id="confirmation-summary"></div>
                    <div class="modal-footer">
                        <button class="ap-button" onclick="confirmSubmission()">Confirm</button>
                        <button class="ap-button" onclick="closeModal()" style="background-color: #95a5a6;">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showTab('general-info');

            const tabs = document.querySelectorAll('.ap-tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    showTab(tab.getAttribute('data-tab'));
                });
            });

            // Initialize arrays to track images
            window.removedImages = [];
            window.currentCoverImage = document.querySelector('[data-image-type="cover"] input[name="existing_cover"]')?.value;
        });

        // Handle cover image changes
        function handleCoverImageChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Store current cover image for removal if exists
            const currentCover = document.querySelector('[data-image-type="cover"] input[name="existing_cover"]')?.value;
            if (currentCover) {
                window.removedImages.push(currentCover);
            }

            // Update preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.querySelector('.cover-image-container');
                container.innerHTML = `
                    <div class="ap-image-preview-wrapper" data-image-type="cover">
                        <img id="cover-preview" class="cover-preview" src="${e.target.result}" alt="New Cover Image">
                        <button type="button" class="remove-image-btn" onclick="handleCoverImageRemove(event)">×</button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }

        // Handle cover image removal
        function handleCoverImageRemove(event) {
            event.preventDefault();
            const wrapper = event.target.closest('.ap-image-preview-wrapper');
            const image = wrapper.querySelector('input[name="existing_cover"]')?.value;

            if (image) {
                window.removedImages.push(image);

                // Add hidden input to track removed image
                const removedInput = document.createElement('input');
                removedInput.type = 'hidden';
                removedInput.name = 'removed_images[]';
                removedInput.value = image;
                document.querySelector('.ap-form').appendChild(removedInput);
            }

            wrapper.remove();
            document.getElementById('cover-image').value = ''; // Reset file input
        }

        // Handle thumbnail changes
        function handleThumbnailChange(event) {
            const files = Array.from(event.target.files);
            const container = document.getElementById('thumbnails-container');

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'ap-image-preview-wrapper';
                    wrapper.setAttribute('data-image-type', 'thumbnail');
                    wrapper.innerHTML = `
                        <img src="${e.target.result}" class="ap-image-preview" alt="New Thumbnail">
                        <button type="button" class="remove-image-btn" onclick="handleThumbnailRemove(event)">×</button>
                    `;
                    container.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        // Handle thumbnail removal
        function handleThumbnailRemove(event) {
            event.preventDefault();
            const wrapper = event.target.closest('.ap-image-preview-wrapper');
            const image = wrapper.querySelector('input[name="existing_thumbnails[]"]')?.value;

            if (image) {
                window.removedImages.push(image);

                // Add hidden input to track removed image
                const removedInput = document.createElement('input');
                removedInput.type = 'hidden';
                removedInput.name = 'removed_images[]';
                removedInput.value = image;
                document.querySelector('.ap-form').appendChild(removedInput);
            }

            wrapper.remove();
        }

        function showTab(tabName) {
            const tabContents = document.querySelectorAll('.ap-tab-content');
            tabContents.forEach(content => content.classList.remove('active'));

            const tabs = document.querySelectorAll('.ap-tab');
            tabs.forEach(tab => tab.classList.remove('active'));

            document.getElementById(tabName).classList.add('active');
            document.querySelector(`.ap-tab[data-tab="${tabName}"]`).classList.add('active');
        }

        const uploadButton = document.querySelector('.nav-button[onclick="showConfirmationModal(event)"]');
        if (uploadButton) {
            uploadButton.addEventListener('click', showConfirmationModal);
        }

        function showConfirmationModal(event) {
            event.preventDefault();
            ConfirmationSummary();
            const modal = document.getElementById('confirmation-modal');
            if (modal) {
                modal.style.display = "block";
            } else {
                console.error('Modal element not found');
            }
        }

        function ConfirmationSummary() {
            const summary = document.getElementById('confirmation-summary');
            const model = document.getElementById('p_model').value;
            const price = document.getElementById('p_price').value;
            const wheels = document.getElementById('p_wheels').value;
            const motorPower = document.getElementById('p_motor_power').value;
            const battery = document.getElementById('p_battery').value;
            const maxSpeed = document.getElementById('p_max_speed').value;
            const range = document.getElementById('p_range').value;
            const maxLoad = document.getElementById('p_max_load').value;
            const chargingTime = document.getElementById('p_charging_time').value;
            const variants = document.getElementById('p_variants').value;
            const otherFeatures = document.getElementById('p_other_features').value;

            const coverPreview = document.getElementById('cover-preview')?.src;
            const thumbnailsContainer = document.getElementById('thumbnails-container');
            const thumbnailImages = thumbnailsContainer.querySelectorAll('img');
            let thumbnailsHTML = '';
            thumbnailImages.forEach(img => {
                thumbnailsHTML += `<img src="${img.src}" class="ap-image-preview" alt="Thumbnail Preview" style="width: 50px; height: 50px; margin: 5px;">`;
            });

            summary.innerHTML = `
                    <div class="product-summary fade-in" style="max-width: 800px; max-height: 500px; overflow-y: auto;">
                        <h4 class="summary-title" style="font-size: 1.4rem;">Product Summary</h4>
                        <div class="summary-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Model</span>
                                <span class="value">${model}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Price</span>
                                <span class="value highlight">PHP ${price}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Wheel Count</span>
                                <span class="value">${wheels}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Motor Power</span>
                                <span class="value">${motorPower}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Max Speed</span>
                                <span class="value">${maxSpeed}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Range</span>
                                <span class="value">${range} km</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Max Load</span>
                                <span class="value">${maxLoad} kg</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Charging Time</span>
                                <span class="value">${chargingTime}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Variants</span>
                                <span class="value">${variants}</span>
                            </div>
                            <div class="summary-item features" data-aos="fade-up">
                                <span class="label">Other Features</span>
                                <span class="value">${otherFeatures}</span>
                            </div>
                        </div>
                    </div>
                `;
        }

        function closeModal() {
            const modal = document.getElementById('confirmation-modal');
            modal.style.display = "none";
        }

        function confirmSubmission() {
            if (!window.removedImages) {
                window.removedImages = [];
            }

            if (window.removedImages.length > 0) {
                window.removedImages.forEach(image => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'removed_images[]';
                    input.value = image;
                    document.querySelector('.ap-form').appendChild(input);
                });
            }

            closeModal();
            document.querySelector('.ap-form').submit();
        }

        function nextTab(currentTab, nextTab) {
            document.getElementById(currentTab).classList.remove('active');
            document.getElementById(nextTab).classList.add('active');
            document.querySelector(`.ap-tab[data-tab="${currentTab}"]`).classList.remove('active');
            document.querySelector(`.ap-tab[data-tab="${nextTab}"]`).classList.add('active');
        }

        function prevTab(currentTab, prevTab) {
            document.getElementById(currentTab).classList.remove('active');
            document.getElementById(prevTab).classList.add('active');
            document.querySelector(`.ap-tab[data-tab="${currentTab}"]`).classList.remove('active');
            document.querySelector(`.ap-tab[data-tab="${prevTab}"]`).classList.add('active');
        }
    </script>
</body>

</html>
<style>
    :root {
        --primary-color: #4a90e2;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --background-color: #f5f6fa;
        --text-color: #2c3e50;
        --border-radius: 8px;
        --transition: all 0.3s ease;
        --font-size-base: 16px;
        --font-size-large: 1.25rem;
        --font-weight-medium: 500;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        --box-shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.15);
        --modal-background: rgba(0, 0, 0, 0.7);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: var(--background-color);
        color: var(--text-color);
        display: flex;
        align-items: center;
        padding: 20px;
        transition: background-color var(--transition), color var(--transition);
    }

    main {
        width: 100%;

    }

    .section-title {
        color: #2c3e50;
        font-size: 1.8em;
        margin-bottom: 20px;
        font-weight: 600;
        text-align: center;
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: calc(var(--font-size-large) * 0.9);
            margin-bottom: 15px;
        }
    }

    @media (max-width: 480px) {
        .section-title {
            font-size: calc(var(--font-size-large) * 0.8);
            margin-bottom: 10px;
        }
    }


    .toggle-button {
        display: static;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 10px;
        left: 10px;
        gap: 8px;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        z-index: 9999;
    }

    .add-product-btn {
        background-color: #4CAF50;
        color: white;
    }

    .back-btn {
        background-color: #6c757d;
        color: white;
    }

    .ap-container {
        background: #ffffff;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: transform var(--transition), box-shadow var(--transition);
        width: 100%;
        max-width: auto;
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .ap-tabs {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #ddd;
        position: sticky;
        top: 0;
        background: #ffffff;
        z-index: 1;
    }

    .ap-tab {
        cursor: pointer;
        padding: 10px 20px;
        border: none;
        border-radius: var(--border-radius);
        transition: background-color var(--transition), color var(--transition), transform var(--transition);
        background-color: transparent;
        font-weight: var(--font-weight-medium);
        position: relative;
        box-shadow: none;
        outline: none;
        font-size: 1rem;
    }

    .ap-tab:hover {
        color: var(--primary-color);
        transform: scale(1.05);
    }

    .ap-tab.active {
        border-bottom: 3px solid var(--primary-color);
        color: var(--primary-color);
        transform: scale(1.05);
    }

    .ap-tab-content {
        display: none;
        animation: fadeIn 0.5s ease-in-out;
    }

    .ap-tab-content.active {
        display: block;
    }

    .ap-button-container {
        text-align: center;
        margin-top: 20px;
    }

    .ap-button {
        background-color: var(--primary-color);
        color: #ffffff;
        border: none;
        padding: 12px 30px;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: background-color var(--transition), transform var(--transition), box-shadow var(--transition);
        font-size: 1rem;
        font-weight: var(--font-weight-medium);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .ap-button:hover {
        background-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: var(--modal-background);
        animation: fadeIn 0.5s ease-in-out;
    }

    .modal-content {
        background-color: #ffffff;
        margin: 80px auto;
        padding: 30px;
        border: 2px solid var(--primary-color);
        border-radius: var(--border-radius);
        width: 90%;
        max-width: 600px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.5s ease-in-out;
        position: relative;
        overflow-y: hidden;
        /* Disable vertical scrollbar */
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        transition: color var(--transition);
    }

    .close:hover,
    .close:focus {
        color: #000000;
        text-decoration: none;
    }

    .ap-image-preview-wrapper {
        position: relative;
        display: inline-block;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: transform var(--transition), box-shadow var(--transition);
    }

    .ap-image-preview-wrapper:hover {
        transform: scale(1.05);
        box-shadow: var(--box-shadow-hover);
    }

    .ap-image-preview {
        display: block;
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .remove-image-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(231, 76, 60, 0.8);
        color: #ffffff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color var(--transition), transform var(--transition);
    }

    .remove-image-btn:hover {
        background-color: #c0392b;
        transform: scale(1.2);
    }

    .ap-file-upload-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        margin-top: 10px;
    }

    .ap-file-upload {
        width: 100%;
        max-width: 400px;
    }

    label.ap-label {
        margin-top: 15px;
        margin-bottom: 5px;
        font-weight: 500;
        display: block;
    }

    input.ap-input,
    select.ap-select,
    textarea.ap-textarea {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: var(--border-radius);
        font-size: var(--font-size-base);
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    input.ap-input:focus,
    select.ap-select:focus,
    textarea.ap-textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        outline: none;
    }

    .navigation-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .nav-button {
        background: none;
        border: none;
        color: var(--primary-color);
        font-weight: 500;
        cursor: pointer;
        font-size: 1rem;
        transition: color var(--transition), transform var(--transition);
    }

    .nav-button:hover {
        color: var(--accent-color);
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .ap-container {
            flex-direction: column;
            align-items: stretch;
        }

        .ap-tabs {
            flex-wrap: wrap;
            justify-content: space-between;
        }
    }

    @media (max-width: 600px) {
        .ap-tabs {
            flex-direction: column;
            align-items: flex-start;
        }

        .ap-tab {
            width: 100%;
            text-align: left;
        }

        .ap-image-preview {
            width: 80px;
            height: 80px;
        }
    }

    /* Keyframes for animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Tooltip styles */
    .tooltip {
        position: relative;
        display: inline-block;
        cursor: help;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 200px;
        background-color: var(--secondary-color);
        color: #fff;
        text-align: left;
        border-radius: var(--border-radius);
        padding: 10px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -100px;
        opacity: 0;
        transition: opacity var(--transition);
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    .required-asterisk {
        color: var(--accent-color);
        margin-right: 5px;
        position: relative;
        cursor: help;
    }

    .required-asterisk::after {
        content: 'required';
        position: absolute;
        left: 0;
        bottom: 100%;
        background-color: var(--secondary-color);
        color: #fff;
        padding: 5px;
        border-radius: var(--border-radius);
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s;
        transform: translateY(-5px);
        pointer-events: none;
        font-size: 0.75rem;
    }

    .required-asterisk:hover::after {
        opacity: 1;
        transform: translateY(0);
    }

    /* New styles for cover and thumbnail images */
    .cover-image-container {
        margin: 20px 0;
        text-align: center;
    }

    .cover-preview {
        max-width: 300px;
        max-height: 300px;
        object-fit: contain;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .thumbnails-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin: 20px 0;
    }

    /* Two-column layout for specifications */
    .specifications-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 20px 0;
    }

    @media (max-width: 768px) {
        .specifications-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Custom file input styling */
    .file-input-wrapper {
        position: relative;
        display: inline-block;
    }

    .file-input-button {
        display: inline-block;
        padding: 10px 20px;
        background: var(--primary-color);
        color: white;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: background-color var(--transition);
        border: none;
        font-size: 1rem;
    }

    .file-input-button:hover {
        background: var(--accent-color);
    }

    input[type="file"] {
        display: none;
        /* Hide the actual file input */
    }

    .input-error {
        border: 2px solid var(--accent-color);
        /* Highlight with accent color */
        background-color: #ffe6e6;
        /* Light red background for visibility */
    }
</style>