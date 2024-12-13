<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <div class="ap-container">
            <a href="../Dashboard.php" class="toggle-button back-btn" style="text-decoration: none;">
                <span class="button-text">Back</span>
                <span class="button-icon">←</span>
            </a>
            <h3 class="section-title">Upload a New Product</h3>
            <br>
            <div class="ap-tabs" role="tablist" aria-label="Product Information Tabs">
                <div class="ap-tab active" data-tab="general-info" role="tab" aria-selected="true" tabindex="0">General Info</div>
                <div class="ap-tab" data-tab="specifications" role="tab" aria-selected="false" tabindex="-1">Specifications</div>
                <div class="ap-tab" data-tab="other-features" role="tab" aria-selected="false" tabindex="-1">Other Features</div>
            </div>
            <form class="ap-form" method="POST" action="../config/upload-product.php" enctype="multipart/form-data" aria-labelledby="form-title">
                <div id="general-info" class="ap-tab-content active">
                    <label class="ap-label tooltip" for="p_model">Product Model<span class="required-asterisk">*</span>
                        <span class="tooltiptext">* Enter the model name</span>
                    </label>
                    <input class="ap-input" type="text" name="p_model" id="p_model" required>

                    <label class="ap-label tooltip" for="p_price">Base Price (PHP)<span class="required-asterisk">*</span>
                        <span class="tooltiptext">Enter the base price</span>
                    </label>
                    <input class="ap-input" type="number" name="p_price" id="p_price" required min="0" step="0.01">

                    <label class="ap-label tooltip" for="cover-image">Cover Image<span class="required-asterisk">*</span>
                        <span class="tooltiptext">Upload a main product image</span>
                    </label>
                    <div class="file-input-wrapper">
                        <button type="button" class="file-input-button" onclick="document.getElementById('cover-image').click();">Choose Cover Image</button>
                        <input type="file" name="cover-image" id="cover-image" accept="image/*" required style="display: none;">
                    </div>
                    <div class="cover-image-container">
                        <img id="cover-preview" class="cover-preview" style="display: none;">
                    </div>

                    <label class="ap-label tooltip" for="thumbnail-images">Additional Images
                        <span class="tooltiptext">Upload additional product images (optional)</span>
                    </label>
                    <div class="file-input-wrapper">
                        <button type="button" class="file-input-button" onclick="document.getElementById('thumbnail-images').click();">Choose Additional Images</button>
                        <input type="file" name="thumbnail-images[]" id="thumbnail-images" accept="image/*" multiple style="display: none;">
                    </div>
                    <div id="thumbnails-container" class="thumbnails-container"></div>

                    <div class="navigation-buttons">
                        <button type="button" class="nav-button next-button" data-next="specifications">Next</button>
                    </div>
                </div>

                <div id="specifications" class="ap-tab-content">
                    <div class="specifications-grid">
                        <div>
                            <label class="ap-label tooltip" for="p_wheels">Category<span class="required-asterisk">*</span></label>
                            <select class="ap-select" name="p_wheels" id="p_wheels" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="Bikes">Bikes</option>
                                <option value="Trikes">Trikes</option>
                                <option value="Quad Bikes">Quad Bikes</option>
                            </select>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_motor_power">Motor Power<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_motor_power" id="p_motor_power" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_battery">Battery<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_battery" id="p_battery" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_max_speed">Max Speed<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_max_speed" id="p_max_speed" required>
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_range">Range (km)<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="number" name="p_range" id="p_range" required min="0">
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_max_load">Max Load (kg)<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="number" name="p_max_load" id="p_max_load" required min="0">
                        </div>

                        <div>
                            <label class="ap-label tooltip" for="p_charging_time">Charging Time<span class="required-asterisk">*</span></label>
                            <input class="ap-input" type="text" name="p_charging_time" id="p_charging_time" required>
                        </div>
                    </div>

                    <div class="navigation-buttons">
                        <button type="button" class="nav-button prev-button" data-prev="general-info">Previous</button>
                        <button type="button" class="nav-button next-button" data-next="other-features">Next</button>
                    </div>
                </div>

                <div id="other-features" class="ap-tab-content">
                    <label class="ap-label tooltip" for="p_variants">Variants</label>
                    <input class="ap-input" type="text" name="p_variants" id="p_variants" placeholder="e.g., Red, Blue">

                    <label class="ap-label tooltip" for="p_other_features">Other Features</label>
                    <textarea class="ap-textarea" name="p_other_features" id="p_other_features" rows="4"></textarea>

                    <div class="navigation-buttons">
                        <button type="button" class="nav-button prev-button" data-prev="specifications">Previous</button>
                        <button type="button" class="nav-button" onclick="showConfirmationModal(event)">Upload Product</button>
                    </div>
                </div>
            </form>
            <!-- Confirmation Modal -->
            <div id="confirmation-modal" class="modal" role="dialog" aria-hidden="true">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h4>Confirm Product Upload</h4>
                    <p>Are you sure you want to upload this product?</p>
                    <div id="confirmation-summary"></div>
                    <br><!-- New div for product summary -->
                    <div class="modal-footer">
                        <button class="ap-button" onclick="confirmSubmission(document.querySelector('.ap-form'))">Confirm</button>
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

            // Cover image handling
            const coverInput = document.getElementById('cover-image');
            const coverPreview = document.getElementById('cover-preview');

            coverInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        coverPreview.src = e.target.result;
                        coverPreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Thumbnail images handling
            const thumbnailInput = document.getElementById('thumbnail-images');
            const thumbnailsContainer = document.getElementById('thumbnails-container');
            let thumbnailFiles = [];

            thumbnailInput.addEventListener('change', function(event) {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    if (file.type.startsWith('image/') && !thumbnailFiles.includes(file)) {
                        thumbnailFiles.push(file);
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const wrapper = document.createElement('div');
                            wrapper.classList.add('ap-image-preview-wrapper');

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('ap-image-preview');
                            img.alt = 'Thumbnail Preview';

                            const removeBtn = document.createElement('button');
                            removeBtn.classList.add('remove-image-btn');
                            removeBtn.innerHTML = '×';
                            removeBtn.addEventListener('click', () => {
                                thumbnailsContainer.removeChild(wrapper);
                                thumbnailFiles = thumbnailFiles.filter(f => f !== file);
                                updateThumbnailInput();
                            });

                            wrapper.appendChild(img);
                            wrapper.appendChild(removeBtn);
                            thumbnailsContainer.appendChild(wrapper);
                        }
                        reader.readAsDataURL(file);
                    }
                });
                updateThumbnailInput();
            });

            function updateThumbnailInput() {
                const dataTransfer = new DataTransfer();
                thumbnailFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                thumbnailInput.files = dataTransfer.files;
            }

            function showTab(tabName) {
                const tabContents = document.querySelectorAll('.ap-tab-content');
                tabContents.forEach(content => content.classList.remove('active'));

                const tabs = document.querySelectorAll('.ap-tab');
                tabs.forEach(tab => tab.classList.remove('active'));

                document.getElementById(tabName).classList.add('active');
                document.querySelector(`.ap-tab[data-tab="${tabName}"]`).classList.add('active');
            }

            // Navigation buttons
            const nextButtons = document.querySelectorAll('.next-button');
            const prevButtons = document.querySelectorAll('.prev-button');

            nextButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const nextTabId = button.getAttribute('data-next');
                    if (validateCurrentTab()) {
                        showTab(nextTabId);
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const prevTabId = button.getAttribute('data-prev');
                    showTab(prevTabId);
                });
            });

            function validateCurrentTab() {
                const activeTab = document.querySelector('.ap-tab-content.active');
                const requiredInputs = activeTab.querySelectorAll('input[required], select[required], textarea[required]');
                let allValid = true;

                requiredInputs.forEach(input => {
                    if (input.type === 'file') {
                        if (!input.files.length) {
                            input.classList.add('input-error');
                            input.setCustomValidity("Please choose a cover image.");
                            allValid = false;
                        } else {
                            input.classList.remove('input-error');
                            input.setCustomValidity("");
                        }
                    } else if (input.type === 'number') {
                        const value = parseFloat(input.value);
                        if (!input.value || value <= 0) {
                            input.classList.add('input-error');
                            input.setCustomValidity("Value must be greater than zero.");
                            allValid = false;
                        } else {
                            input.classList.remove('input-error');
                            input.setCustomValidity("");
                        }
                    } else {
                        if (!input.value.trim()) {
                            input.classList.add('input-error');
                            input.setCustomValidity("This field cannot be empty.");
                            allValid = false;
                        } else {
                            input.classList.remove('input-error');
                            input.setCustomValidity("");
                        }
                    }

                    // Add event listeners to clear validation errors
                    input.addEventListener('input', clearValidationError);
                    input.addEventListener('change', clearValidationError);
                });

                return allValid;
            }

            function clearValidationError(event) {
                const input = event.target;
                if (input.type === 'file' && input.files.length > 0) {
                    input.classList.remove('input-error');
                    input.setCustomValidity("");
                } else if (input.type !== 'file' && input.value.trim()) {
                    input.classList.remove('input-error');
                    input.setCustomValidity("");
                }
            }

            // Ensure the button to show the modal is correctly set up
            const uploadButton = document.querySelector('.nav-button[onclick="showConfirmationModal(event)"]');
            if (uploadButton) {
                uploadButton.addEventListener('click', showConfirmationModal);
            }

            function showConfirmationModal(event) {
                event.preventDefault();

                // Collect all required fields in the form
                const form = document.querySelector('.ap-form');
                const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');

                let allValid = true;

                requiredFields.forEach(field => {
                    if (field.type === 'file') {
                        if (!field.files.length) {
                            field.classList.add('input-error');
                            field.setCustomValidity("Please choose a file.");
                            allValid = false;
                            alert(`${field.previousElementSibling.innerText} is required.`);
                        } else {
                            field.classList.remove('input-error');
                            field.setCustomValidity("");
                        }
                    } else if (!field.value.trim()) {
                        field.classList.add('input-error');
                        field.setCustomValidity("This field cannot be empty.");
                        allValid = false;
                        alert(`${field.previousElementSibling.innerText} is required.`);
                    } else {
                        field.classList.remove('input-error');
                        field.setCustomValidity("");
                    }
                });

                if (!allValid) {
                    return; // Exit the function if any field is invalid
                }

                // Proceed to show the modal if all validations pass
                ConfirmationSummary(); // Call the function to populate the summary
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

                // Get cover image preview
                const coverPreview = document.getElementById('cover-preview').src;

                // Get thumbnail previews
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
                                <span class="label">Category</span>
                                <span class="value">${wheels}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Motor Power</span>
                                <span class="value">${motorPower}</span>
                            </div>
                            <div class="summary-item" data-aos="fade-up">
                                <span class="label">Battery</span>
                                <span class="value">${battery}</span>
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

                        <style>
                            .product-summary {
                                margin: 0 auto;
                                padding: 1rem;
                                background: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .summary-title {
                                font-size: 1.4rem;
                                color: #333;
                                text-align: center;
                                margin-bottom: 1rem;
                                font-weight: 600;
                                border-bottom: 1px solid #eee;
                                padding-bottom: 0.5rem;
                            }

                            .summary-grid {
                                display: grid;
                                gap: 1rem;
                                margin-bottom: 1rem;
                            }

                            .summary-item {
                                background: #f8f9fa;
                                padding: 0.75rem;
                                border-radius: 6px;
                                transition: transform 0.2s ease;
                            }

                            .summary-item:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                            }

                            .label {
                                display: block;
                                font-size: 0.8rem;
                                color: #666;
                                margin-bottom: 0.25rem;
                            }

                            .value {
                                display: block;
                                font-size: 1rem;
                                color: #333;
                                font-weight: 500;
                            }

                            .highlight {
                                color: #2c3e50;
                                font-weight: 600;
                            }

                            .image-section {
                                margin-top: 1rem;
                            }

                            .image-title {
                                font-size: 1.2rem;
                                color: #333;
                                margin-bottom: 0.5rem;
                            }

                            .cover-image-wrapper {
                                width: 100%;
                                max-width: 300px;
                                margin: 0 auto;
                                overflow: hidden;
                                border-radius: 6px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .cover-preview {
                                width: 100%;
                                height: auto;
                                transition: transform 0.2s ease;
                            }

                            .hover-zoom:hover {
                                transform: scale(1.02);
                            }

                            .thumbnails-grid {
                                display: grid;
                                grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
                                gap: 0.5rem;
                                margin-top: 0.5rem;
                            }

                            .ap-image-preview {
                                border-radius: 4px;
                                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                                transition: transform 0.2s ease;
                                cursor: pointer;
                            }

                            .ap-image-preview:hover {
                                transform: scale(1.05);
                            }

                            @media (max-width: 768px) {
                                .product-summary {
                                    padding: 0.75rem;
                                }

                                .summary-grid {
                                    grid-template-columns: 1fr;
                                }

                                .summary-title {
                                    font-size: 1.2rem;
                                }
                            }
                        </style>

                        <div class="image-section">
                            <h5 class="image-title">Cover Image</h5>
                            <div class="cover-image-wrapper" data-aos="zoom-in">
                                <img src="${coverPreview}" class="cover-preview hover-zoom" alt="Cover Image">
                            </div>
                            
                            <h5 class="image-title">Thumbnails</h5>
                            <div class="thumbnails-grid" data-aos="fade-up">
                                ${thumbnailsHTML}
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        function closeModal() {
            const modal = document.getElementById('confirmation-modal');
            modal.style.display = "none";
        }

        function confirmSubmission() {
            closeModal();
            document.querySelector('.ap-form').submit();
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

    .cover-image-container {
        margin: 20px 0;
        text-align: center;
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
        padding: 10px 20px 10px 20px;
        border-radius: 10px;
        background: #4a90e2;
        border: none;
        color: white;
        font-weight: 500;
        cursor: pointer;
        font-size: 1rem;
        transition: color var(--transition), transform var(--transition);
    }

    .nav-button:hover {
        background: skyblue;
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
        justify-content: center;
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
