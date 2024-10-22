<!-- redo the database -->
<?php
include "../db_conn.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Product</title>
    <style>
        .tab-container {
            display: flex;
        }
        .tab-buttons {
            display: flex;
            flex-direction: column;
            margin-right: 20px; /* Space between buttons and content */
        }
        .tab-button {
            padding: 10px 15px;
            background-color: #444;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 5px; /* Space between buttons */
            transition: background-color 0.3s ease;
            width: 150px; /* Set a fixed width for buttons */
        }
        .tab-button:hover {
            background-color: #666;
        }
        .tab {
            display: none;
            flex: 1; /* Allow tab content to take remaining space */
        }
        .tab.active {
            display: block;
        }
        .up-prod-product-form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
        }
        .file-upload, .up-prod-form-group {
            margin-bottom: 15px;
        }
        .prodct-desc-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .up-prod-form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .up-prod-form-control:focus {
            border-color: #888;
            outline: none;
            background-color: #fff;
        }
        .hint {
            font-size: 0.9em;
            color: #777;
        }
        .up-prod-btn {
            background-color: #444;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .up-prod-btn:hover {
            background-color: #666;
        }
        .cancel-button {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #444;
            border: 1px solid #444;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .cancel-button:hover {
            background-color: #444;
            color: white;
        }
        .file-upload input[type="file"] {
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php include '../body/IT/side-nav.php'; ?>

    <form action="../db_conn.php" method="post" class="up-prod-product-form" id="productForm" enctype="multipart/form-data">
        <div class="tab-container">
            <div class="tab-buttons">
                <button type="button" class="tab-button" onclick="showTab('tab1')">Upload Image</button>
                <button type="button" class="tab-button" onclick="showTab('tab2')">Basic Info</button>
                <button type="button" class="tab-button" onclick="showTab('tab3')">Dimensions and Weight</button>
                <button type="button" class="tab-button" onclick="showTab('tab4')">Motor and Performance</button>
                <button type="button" class="tab-button" onclick="showTab('tab5')">Battery</button>
                <button type="button" class="tab-button" onclick="showTab('tab6')">Drivetrain</button>
                <button type="button" class="tab-button" onclick="showTab('tab7')">Frame</button>
                <button type="button" class="tab-button" onclick="showTab('tab8')">Electronics</button>
                <button type="button" class="tab-button" onclick="showTab('tab9')">Safety Features</button>
                <button type="button" class="tab-button" onclick="showTab('tab10')">Accessories</button>
                <button type="button" class="tab-button" onclick="showTab('tab11')">Technical Specs</button>
                <button type="button" class="tab-button" onclick="showTab('tab12')">Price</button>
            </div>

            <div class="tab active" id="tab1">
                <h4>Upload Image</h4>
                <div class="file-upload">
                    <input type="file" name="images" class="up-prod-form-control" accept=".png" title="Upload Image" id="images" required />
                </div>
            </div>

            <div class="tab" id="tab2">
                <h4>Basic Info</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Brand:</label>
                    <input type="text" class="up-prod-form-control" name="p_brand" id="p_brand" placeholder="Brand">
                    <small class="hint">Manufacturer and model name.</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Model:</label>
                    <input type="text" class="up-prod-form-control" name="p_model" id="p_model" placeholder="Model">
                    <small class="hint">Manufacturer and model name.</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Year:</label>
                    <input type="text" class="up-prod-form-control" name="p_year" id="p_year" placeholder="Year">
                    <small class="hint">Year of manufacture.</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Type:</label>
                    <input type="text" class="up-prod-form-control" name="p_type" id="p_type" placeholder="Type">
                    <small class="hint">Mountain bike, road bike, city/commuter bike, folding bike, etc.</small>
                </div>
            </div>

            <div class="tab" id="tab3">
                <h4>Dimensions and Weight</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Frame Size:</label>
                    <input type="text" class="up-prod-form-control" name="p_frame_size" id="p_frame_size" placeholder="Frame Size">
                    <small class="hint">Suitable rider height or frame measurements (e.g., small, medium, large).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Wheel Size:</label>
                    <input type="text" class="up-prod-form-control" name="p_wheel_size" id="p_wheel_size" placeholder="Wheel Size">
                    <small class="hint">Diameter of the wheels (e.g., 26", 27.5", 29").</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Weight:</label>
                    <input type="text" class="up-prod-form-control" name="p_weight" id="p_weight" placeholder="Weight">
                    <small class="hint">Total weight of the e-bike including battery.</small>
                </div>
            </div>

            <div class="tab" id="tab4">
                <h4>Motor and Performance</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Motor Type:</label>
                    <input type="text" class="up-prod-form-control" name="p_motor_type" id="p_motor_type" placeholder="Motor Type">
                    <small class="hint">Hub motor, mid-drive motor.</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Motor Power:</label>
                    <input type="text" class="up-prod-form-control" name="p_motor_power" id="p_motor_power" placeholder="Motor Power">
                    <small class="hint">Rated power in watts (e.g., 250W, 500W, 750W).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Top Speed:</label>
                    <input type="text" class="up-prod-form-control" name="p_top_speed" id="p_top_speed" placeholder="Top Speed">
                    <small class="hint">Maximum assisted speed (e.g., 20 mph, 28 mph).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Pedal Assist Levels:</label>
                    <input type="text" class="up-prod-form-control" name="p_pedal_assist_levels" id="p_pedal_assist_levels" placeholder="Pedal Assist Levels">
                    <small class="hint">Number of levels of pedal assistance.</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Throttle:</label>
                    <input type="text" class="up-prod-form-control" name="p_throttle" id="p_throttle" placeholder="Throttle">
                    <small class="hint">Type of throttle (e.g., twist, thumb). If no throttle, specify 'none'.</small>
                </div>
            </div>

            <div class="tab" id="tab5">
                <h4>Battery</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Battery Type:</label>
                    <input type="text" class="up-prod-form-control" name="p_battery_type" id="p_battery_type" placeholder="Battery Type">
                    <small class="hint">Type of battery (e.g., lithium-ion, lithium-polymer).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Battery Capacity:</label>
                    <input type="text" class="up-prod-form-control" name="p_battery_capacity" id="p_battery_capacity" placeholder="Battery Capacity">
                    <small class="hint">Capacity in amp-hours (Ah) or watt-hours (Wh).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Charging Time:</label>
                    <input type="text" class="up-prod-form-control" name="p_charging_time" id="p_charging_time" placeholder="Charging Time">
                    <small class="hint">Time taken to fully charge the battery.</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Range:</label>
                    <input type="text" class="up-prod-form-control" name="p_range" id="p_range" placeholder="Range">
                    <small class="hint">Distance the bike can travel on a full charge.</small>
                </div>
            </div>

            <div class="tab" id="tab7">
                <h4>Frame</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Frame Material:</label>
                    <input type="text" class="up-prod-form-control" name="p_frame_material" id="p_frame_material" placeholder="Frame Material">
                    <small class="hint">Material used for the frame (e.g., aluminum, steel, carbon fiber).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Color:</label>
                    <input type="text" class="up-prod-form-control" name="p_color" id="p_color" placeholder="Color">
                    <small class="hint">Color of the frame.</small>
                </div>
            </div>

            <div class="tab" id="tab8">
                <h4>Electronics</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Display:</label>
                    <input type="text" class="up-prod-form-control" name="p_display" id="p_display" placeholder="Display">
                    <small class="hint">Type of display (e.g., LCD, LED).</small>
                </div>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Smart Features:</label>
                    <input type="text" class="up-prod-form-control" name="p_smart_features" id="p_smart_features" placeholder="Smart Features">
                    <small class="hint">Features like Bluetooth connectivity, GPS tracking, etc.</small>
                </div>
            </div>

            <div class="tab" id="tab10">
                <h4>Accessories</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Included Accessories:</label>
                    <input type="text" class="up-prod-form-control" name="p_accessories" id="p_accessories" placeholder="Included Accessories">
                    <small class="hint">Accessories included with the purchase.</small>
                </div>
            </div>

            <div class="tab" id="tab11">
                <h4>Technical Specs</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Technical Specifications:</label>
                    <textarea class="up-prod-form-control" name="p_technical_specs" id="p_technical_specs" rows="5" placeholder="Technical Specifications"></textarea>
                    <small class="hint">Additional technical specifications or features.</small>
                </div>
            </div>

            <div class="tab" id="tab12">
                <h4>Price</h4>
                <div class="up-prod-form-group">
                    <label class="prodct-desc-label">Price:</label>
                    <input type="text" class="up-prod-form-control" name="p_price" id="p_price" placeholder="Price">
                    <small class="hint">Retail price of the product.</small>
                </div>
            </div>
        </div>

        <button type="submit" class="up-prod-btn" name="add_product">Upload Product</button>
        <a href="../body/admin/products.php" class="cancel-button">Cancel</a>
    </form>

    <script>
        function showTab(tabId) {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
        }

        // Show the first tab by default
        showTab('tab1');
    </script>
</body>
</html>
