<?php
    include "../db_conn.php";
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <nav class="right-navbar">
        <ul>
                <li><a href="Dashboard.php">Dashboard</a></li>
                <li><a href="admin_view.php" data-modal="home-modal">Home</a></li>
                <li><a href="Ledger.php">Ledger</a></li>
                <li><a href="upload_product.php">Add new Product</a></li>
                <li><a href="order_entry.php">Create new Order</a></li>
                <li><a href="Account_Manager.php">User Account Data</a></li>
                <li><a href="" data-modal="tickets-modal" data-url="itsupport.php">Tickets</a></li>
                <li><a href="" data-modal="logout-modal">Log Out</a></li>
            </ul>
        </nav>
        <!-- VVV product description VVV -->
        <form action="../db_conn.php" method="post" class="product-form" id="productForm" enctype="multipart/form-data">
            <!-- for image -->
            <div class="file-upload">
                <h4>Upload Image</h4>
                <input type="file" name="images" class="form-control" accept=".jpeg, .jpg, .png" title="Upload Image" id="images" required />
            </div>
            <h4>Basic Info</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Brand:</label>
                <input type="text" class="form-control" name="p_brand" id="p_brand" placeholder="Brand">
                <small class="hint">Manufacturer and model name.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Model:</label>
                <input type="text" class="form-control" name="p_model" id="p_model" placeholder="Model">
                <small class="hint">Manufacturer and model name.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Year:</label>
                <input type="text" class="form-control" name="p_year" id="p_year" placeholder="Year">
                <small class="hint">Year of manufacture.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Type:</label>
                <input type="text" class="form-control" name="p_type" id="p_type" placeholder="Type">
                <small class="hint">Mountain bike, road bike, city/commuter bike, folding bike, etc.</small>
            </div>
            <h4>Dimensions and Weight</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Frame Size:</label>
                <input type="text" class="form-control" name="p_frame_size" id="p_frame_size" placeholder="Frame Size">
                <small class="hint">Suitable rider height or frame measurements (e.g., small, medium, large).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Wheel Size:</label>
                <input type="text" class="form-control" name="p_wheel_size" id="p_wheel_size" placeholder="Wheel Size">
                <small class="hint">Diameter of the wheels (e.g., 26", 27.5", 29").</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Weight:</label>
                <input type="text" class="form-control" name="p_weight" id="p_weight" placeholder="Weight">
                <small class="hint">Total weight of the e-bike including battery.</small>
            </div>
            <h4>Motor and Performance</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Motor Type:</label>
                <input type="text" class="form-control" name="p_motor_type" id="p_motor_type" placeholder="Motor Type">
                <small class="hint">Hub motor, mid-drive motor.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Motor Power:</label>
                <input type="text" class="form-control" name="p_motor_power" id="p_motor_power" placeholder="Motor Power">
                <small class="hint">Rated power in watts (e.g., 250W, 500W, 750W).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Top Speed:</label>
                <input type="text" class="form-control" name="p_top_speed" id="p_top_speed" placeholder="Top Speed">
                <small class="hint">Maximum assisted speed (e.g., 20 mph, 28 mph).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Pedal Assist Levels:</label>
                <input type="text" class="form-control" name="p_pedal_assist_levels" id="p_pedal_assist_levels" placeholder="Pedal Assist Levels">
                <small class="hint">Number of assistance levels (e.g., 3, 5).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Throttle:</label>
                <input type="text" class="form-control" name="p_throttle" id="p_throttle" placeholder="Throttle">
                <small class="hint">Whether it has a throttle and its type (e.g., thumb, twist).</small>
            </div>
            <h4>Battery</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Battery Type:</label>
                <input type="text" class="form-control" name="p_battery_type" id="p_battery_type" placeholder="Battery Type">
                <small class="hint">Lithium-ion, etc.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Battery Capacity:</label>
                <input type="text" class="form-control" name="p_battery_capacity" id="p_battery_capacity" placeholder="Battery Capacity">
                <small class="hint">Measured in watt-hours (Wh) or ampere-hours (Ah).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Range:</label>
                <input type="text" class="form-control" name="p_range" id="p_range" placeholder="Range">
                <small class="hint">Estimated range per charge (e.g., 30-50 miles).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Charge Time:</label>
                <input type="text" class="form-control" name="p_charge_time" id="p_charge_time" placeholder="Charge Time">
                <small class="hint">Time required to fully charge the battery.</small>
            </div>
            <h4>Drivetrain and Components</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Gears:</label>
                <input type="text" class="form-control" name="p_gears" id="p_gears" placeholder="Gears">
                <small class="hint">Number and type of gears (e.g., Shimano 7-speed).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Brakes:</label>
                <input type="text" class="form-control" name="p_brakes" id="p_brakes" placeholder="Brakes">
                <small class="hint">Type of brakes (e.g., mechanical disc, hydraulic disc).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Suspension:</label>
                <input type="text" class="form-control" name="p_suspension" id="p_suspension" placeholder="Suspension">
                <small class="hint">Front suspension, full suspension, or rigid.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Tires:</label>
                <input type="text" class="form-control" name="p_tires" id="p_tires" placeholder="Tires">
                <small class="hint">Type and size of tires (e.g., 27.5"x2.4" mountain tires).</small>
            </div>
            <h4>Frame and Construction</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Frame Material:</label>
                <input type="text" class="form-control" name="p_frame_material" id="p_frame_material" placeholder="Frame Material">
                <small class="hint">Aluminum, carbon fiber, steel, etc.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Fork:</label>
                <input type="text" class="form-control" name="p_fork" id="p_fork" placeholder="Fork">
                <small class="hint">Type and material of the fork (e.g., aluminum suspension fork).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Handlebars:</label>
                <input type="text" class="form-control" name="p_handlebars" id="p_handlebars" placeholder="Handlebars">
                <small class="hint">Type (e.g., flat, drop, riser) and material.</small>
            </div>
            <h4>Electronics and Controls</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Display:</label>
                <input type="text" class="form-control" name="p_display" id="p_display" placeholder="Display">
                <small class="hint">Type and features of the display (e.g., LCD, LED).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Lighting:</label>
                <input type="text" class="form-control" name="p_lighting" id="p_lighting" placeholder="Lighting">
                <small class="hint">Integrated front and rear lights, reflectors.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Connectivity:</label>
                <input type="text" class="form-control" name="p_connectivity" id="p_connectivity" placeholder="Connectivity">
                <small class="hint">Bluetooth, app compatibility for tracking and adjustments.</small>
            </div>
            <h4>Safety and Convenience Features</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Fenders:</label>
                <input type="text" class="form-control" name="p_fenders" id="p_fenders" placeholder="Fenders">
                <small class="hint">Front and rear fenders for protection.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Rack:</label>
                <input type="text" class="form-control" name="p_rack" id="p_rack" placeholder="Rack">
                <small class="hint">Rear rack for carrying cargo.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Kickstand:</label>
                <input type="text" class="form-control" name="p_kickstand" id="p_kickstand" placeholder="Kickstand">
                <small class="hint">Type and placement.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Lock:</label>
                <input type="text" class="form-control" name="p_lock" id="p_lock" placeholder="Lock">
                <small class="hint">Built-in lock or lock compatibility.</small>
            </div>
            <h4>Accessories and Additional Features</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Accessories:</label>
                <input type="text" class="form-control" name="p_accessories" id="p_accessories" placeholder="Accessories">
                <small class="hint">Bells, mirrors, bottle holders, etc.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Warranty:</label>
                <input type="text" class="form-control" name="p_warranty" id="p_warranty" placeholder="Warranty">
                <small class="hint">Information on the e-bike’s warranty.</small>
            </div>
            <h4>Technical Specifications</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Torque:</label>
                <input type="text" class="form-control" name="p_torque" id="p_torque" placeholder="Torque">
                <small class="hint">Motor torque in Newton-meters (Nm).</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Max Rider Weight:</label>
                <input type="text" class="form-control" name="p_max_rider_weight" id="p_max_rider_weight" placeholder="Max Rider Weight">
                <small class="hint">Maximum load capacity.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Water Resistance:</label>
                <input type="text" class="form-control" name="p_water_resistance" id="p_water_resistance" placeholder="Water Resistance">
                <small class="hint">IP rating for water and dust resistance.</small>
            </div>
            <h4>Price</h4>
            <div class="form-group">
                <label class="prodct-desc-label">Base Price:</label>
                <input type="text" class="form-control" name="p_base_price" id="p_base_price" placeholder="Base Price">
                <small class="hint">Starting price of the e-bike.</small>
            </div>
            <div class="form-group">
                <label class="prodct-desc-label">Optional Features:</label>
                <input type="text" class="form-control" name="p_optional_features" id="p_optional_features" placeholder="Optional Features">
                <small class="hint">Prices for add-ons and accessories.</small>
            </div>
            <button type="submit" class="btn btn-success" name="Update-Product">Update</button>
            <a href="Dashboard.php" class="cancel-button">Cancel</a>
        </form>
    </body>
</html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 20px;
    }

    .product-form {
        background-color: white;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px; /* Set max width to make page smaller */
        margin: auto; /* Center the form */
    }
    
    .right-navbar {
        position: fixed;
        top: 0;
        right: 0;
        height: 100%;
        width: 250px;
        background-color: #333;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 20px;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
    }

    .right-navbar ul {
        list-style-type: none;
        padding: 0;
        margin-top: 50px;
        width: 100%;
    }

    .right-navbar a {
        display: block;
        color: #fff;
        text-decoration: none;
        padding: 15px;
        transition: background-color 0.3s ease;
    }

    .right-navbar a:hover {
        background-color: #555;
    }

    h4 {
        margin-top: 20px;
        color: #007bff;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .prodct-desc-label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    .hint {
        color: #6c757d;
        font-size: 0.875em;
        margin-top: 3px;
    }

    .btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        margin-top: 10px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #218838;
    }

    .cancel-button {
        display: inline-block;
        margin-top: 10px;
        text-decoration: none;
        color: #dc3545;
    }

    .cancel-button:hover {
        text-decoration: underline;
    }
</style>