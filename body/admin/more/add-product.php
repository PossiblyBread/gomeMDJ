
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center; 
            align-items: flex-start; 
            height: 100vh;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7; 
        }
        h3 {
            margin-bottom: 20px;
            color: #333; 
        }
        .ap-container {
            display: flex; 
            max-width: 900px; 
            width: 100%; 
        }
        .ap-form {
            flex-grow: 1; 
            margin-right: 20px; 
        }
        .ap-tabs {
            display: flex;
            flex-direction: column; 
            margin-top: 20px; /* Space between form and tabs */
        }
        .ap-tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #ccc; 
            border: 1px solid #aaa; 
            border-radius: 5px 5px 0 0; 
            margin-bottom: 5px; 
            color: #333; 
        }
        .ap-tab.active {
            background-color: #eee; 
            border-bottom: none; 
            font-weight: bold; 
        }
        .ap-tab-content {
            display: none; 
            border: 1px solid #aaa; 
            border-radius: 0 0 5px 5px; 
            padding: 20px; 
            background-color: #fff; 
            width: 100%; 
            max-width: 600px; 
        }
        .ap-tab-content.active {
            display: block; 
        }
        .ap-label {
            margin-top: 10px;
            display: block; 
            color: #555; 
        }
        .ap-input, .ap-select, .ap-textarea {
            width: calc(100% - 22px); 
            padding: 10px; 
            margin-top: 5px;
            border: 1px solid #aaa; 
            border-radius: 4px; 
            box-sizing: border-box; 
            color: #333; 
        }
        .ap-file-upload-container {
            display: flex;
            align-items: center; /* Align items vertically */
            margin-top: 10px;
        }

        .ap-image-preview {
            margin-left: 10px; /* Space between button and image */
            margin-top: 11px;
            width: 60px; 
            height: 60px; 
            object-fit: cover; 
            border-radius: 8px; 
        }
        .ap-file-upload {
            position: relative;
            display: inline-block;
            width: 60px; 
            height: 60px; 
            background-color: #ccc; 
            border-radius: 8px; 
            overflow: hidden;
            cursor: pointer;
            margin-top: 10px;
            margin-left: 0; 
        }
        .ap-file-upload input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            position: absolute; 
            z-index: 2; 
        }
        .ap-file-upload svg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 35px; 
            height: 35px; 
            stroke: #000; 
            fill: none; 
            z-index: 1; 
            pointer-events: none; 
        }
        .ap-button {
            background-color: #555; 
            color: white; 
            padding: 10px 15px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            margin-top: 15px; 
            width: 100%; 
            font-size: 16px; 
        }
        .ap-button:hover {
            background-color: #333; 
        }
    </style>
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.ap-tab-content');
            tabContents.forEach(content => content.classList.remove('active'));

            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.ap-tab');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Show the selected tab content and set it as active
            document.getElementById(tabName).classList.add('active');
            document.querySelector(`.ap-tab[data-tab="${tabName}"]`).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Show the first tab by default
            showTab('general-info');
        });
        document.addEventListener('DOMContentLoaded', () => {
            // Show the first tab by default
            showTab('general-info');

            const fileInput = document.getElementById('images');
            const preview = document.getElementById('image-preview');

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block'; // Show the image preview
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</head>
<body>
<h3>Upload a New Product</h3>
    <div class="ap-container">
        <form class="ap-form" action="../body/admin/config/upload-product.php" method="POST" enctype="multipart/form-data">
            <div id="general-info" class="ap-tab-content">
                <label class="ap-label" for="p_model">Product Model:</label>
                <input class="ap-input" type="text" name="p_model" id="p_model" placeholder="e.g., Model X1" required>

                <label class="ap-label" for="p_price">Base Price (in USD):</label>
                <input class="ap-input" type="text" name="p_price" id="p_price" placeholder="e.g., 1200" required>
                
                <label class="ap-label" for="images">Product Image:</label>
                <div class="ap-file-upload-container">
                    <div class="ap-file-upload">
                        <input type="file" name="images" id="images" accept="image/*" required />
                        <svg width="256px" height="256px" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="1.104"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M13 4H8.8C7.11984 4 6.27976 4 5.63803 4.32698C5.07354 4.6146 4.6146 5.07354 4.32698 5.63803C4 6.27976 4 7.11984 4 8.8V15.2C4 16.8802 4 17.7202 4.32698 18.362C4.6146 18.9265 5.07354 19.3854 5.63803 19.673C6.27976 20 7.11984 20 8.8 20H15.2C16.8802 20 17.7202 20 18.362 19.673C18.9265 19.3854 19.3854 18.9265 19.673 18.362C20 17.7202 20 16.8802 20 15.2V11" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M4 16L8.29289 11.7071C8.68342 11.3166 9.31658 11.3166 9.70711 11.7071L13 15M13 15L15.7929 12.2071C16.1834 11.8166 16.8166 11.8166 17.2071 12.2071L20 15M13 15L15.25 17.25" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M18 8V3M18 3L16 5M18 3L20 5" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </div>
                    <img id="image-preview" class="ap-image-preview" src="" alt="Image Preview" style="display:none;" />
                </div>
            </div>

            <div id="specifications" class="ap-tab-content">
                <label class="ap-label" for="p_wheels">Wheel Count:</label>
                <select class="ap-select" name="p_wheels" id="p_wheels" required>
                    <option value="" disabled selected>Select wheel count</option>
                    <option value="2 wheels">2 Wheels</option>
                    <option value="3 wheels">3 Wheels</option>
                    <option value="4 wheels">4 Wheels</option>
                </select>

                <label class="ap-label" for="p_motor_power">Motor Power:</label>
                <input class="ap-input" type="text" name="p_motor_power" id="p_motor_power" placeholder="e.g., 650W" required>

                <label class="ap-label" for="p_battery">Battery:</label>
                <input class="ap-input" type="text" name="p_battery" id="p_battery" placeholder="e.g., 48V20AH" required>

                <label class="ap-label" for="p_max_speed">Max Speed:</label>
                <input class="ap-input" type="text" name="p_max_speed" id="p_max_speed" placeholder="e.g., 30 km/h" required>

                <label class="ap-label" for="p_range">Range (in km):</label>
                <input class="ap-input" type="text" name="p_range" id="p_range" placeholder="e.g., 80 km" required>

                <label class="ap-label" for="p_max_load">Max Rider Weight (in kg):</label>
                <input class="ap-input" type="text" name="p_max_load" id="p_max_load" placeholder="e.g., 120 kg" required>

                <label class="ap-label" for="p_charging_time">Charging Time:</label>
                <input class="ap-input" type="text" name="p_charging_time" id="p_charging_time" placeholder="e.g., 4 hours" required>

            </div>

            <div id="other-features" class="ap-tab-content">
                <label class="ap-label" for="p_variants">Variants (if any):</label>
                <input class="ap-input" type="text" name="p_variants" id="p_variants" placeholder="e.g., Red, Blue">

                <label class="ap-label" for="p_other_features">Other Features:</label>
                <textarea class="ap-textarea" name="p_other_features" id="p_other_features" placeholder="e.g., Bluetooth, GPS tracking"></textarea>
            </div>

            <div class="ap-button-container">
                <button class="ap-button" type="submit">Upload Product</button>
            </div>
        </form>

        <div class="ap-tabs">
            <div class="ap-tab" data-tab="general-info" onclick="showTab('general-info')">General Info</div>
            <div class="ap-tab" data-tab="specifications" onclick="showTab('specifications')">Specifications</div>
            <div class="ap-tab" data-tab="other-features" onclick="showTab('other-features')">Other Features</div>
        </div>
    </div>
</body>
</html>
