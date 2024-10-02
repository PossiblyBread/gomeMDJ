<?php
include "db_conn.php";

// Handle form submission and file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {
    // Sanitize and retrieve form data
    $p_brand = mysqli_real_escape_string($conn, $_POST['p_brand']);
    $p_model = mysqli_real_escape_string($conn, $_POST['p_model']);
    $p_year = mysqli_real_escape_string($conn, $_POST['p_year']);
    $p_type = mysqli_real_escape_string($conn, $_POST['p_type']);
    $p_frame_size = mysqli_real_escape_string($conn, $_POST['p_frame_size']);
    $p_wheel_size = mysqli_real_escape_string($conn, $_POST['p_wheel_size']);
    $p_weight = mysqli_real_escape_string($conn, $_POST['p_weight']);
    $p_motor_type = mysqli_real_escape_string($conn, $_POST['p_motor_type']);
    $p_motor_power = mysqli_real_escape_string($conn, $_POST['p_motor_power']);
    $p_top_speed = mysqli_real_escape_string($conn, $_POST['p_top_speed']);
    $p_pedal_assist_levels = mysqli_real_escape_string($conn, $_POST['p_pedal_assist_levels']);
    $p_throttle = mysqli_real_escape_string($conn, $_POST['p_throttle']);
    $p_battery_type = mysqli_real_escape_string($conn, $_POST['p_battery_type']);
    $p_battery_capacity = mysqli_real_escape_string($conn, $_POST['p_battery_capacity']);
    $p_range = mysqli_real_escape_string($conn, $_POST['p_range']);
    $p_charge_time = mysqli_real_escape_string($conn, $_POST['p_charge_time']);
    $p_gears = mysqli_real_escape_string($conn, $_POST['p_gears']);
    $p_brakes = mysqli_real_escape_string($conn, $_POST['p_brakes']);
    $p_suspension = mysqli_real_escape_string($conn, $_POST['p_suspension']);
    $p_tires = mysqli_real_escape_string($conn, $_POST['p_tires']);
    $p_frame_material = mysqli_real_escape_string($conn, $_POST['p_frame_material']);
    $p_fork = mysqli_real_escape_string($conn, $_POST['p_fork']);
    $p_handlebars = mysqli_real_escape_string($conn, $_POST['p_handlebars']);
    $p_display = mysqli_real_escape_string($conn, $_POST['p_display']);
    $p_lighting = mysqli_real_escape_string($conn, $_POST['p_lighting']);
    $p_connectivity = mysqli_real_escape_string($conn, $_POST['p_connectivity']);
    $p_fenders = mysqli_real_escape_string($conn, $_POST['p_fenders']);
    $p_rack = mysqli_real_escape_string($conn, $_POST['p_rack']);
    $p_kickstand = mysqli_real_escape_string($conn, $_POST['p_kickstand']);
    $p_lock = mysqli_real_escape_string($conn, $_POST['p_lock']);
    $p_accessories = mysqli_real_escape_string($conn, $_POST['p_accessories']);
    $p_warranty = mysqli_real_escape_string($conn, $_POST['p_warranty']);
    $p_torque = mysqli_real_escape_string($conn, $_POST['p_torque']);
    $p_max_rider_weight = mysqli_real_escape_string($conn, $_POST['p_max_rider_weight']);
    $p_water_resistance = mysqli_real_escape_string($conn, $_POST['p_water_resistance']);
    $p_base_price = mysqli_real_escape_string($conn, $_POST['p_base-price']);
    $p_optional_features = mysqli_real_escape_string($conn, $_POST['p_optional_features']);
    
    // File upload variables
    $file_name = $_FILES['images']['name'];
    $tempname = $_FILES['images']['tmp_name'];
    $folder = 'products_tb/' . $file_name;
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($tempname, $folder)) {
        // Insert file path and form data into the database
        $sql = "INSERT INTO `products_tb` (`id`, `images`, `p_brand`, `p_model`, `p_year`, `p_type`, `p_frame_size`, `p_wheel_size`, 
                    `p_weight`, `p_motor_type`, `p_motor_power`, `p_top_speed`, `p_pedal_assist_levels`, 
                    `p_throttle`, `p_battery_type`, `p_battery_capacity`, `p_range`, `p_charge_time`, 
                    `p_gears`, `p_brakes`, `p_suspension`, `p_tires`, `p_frame_material`, `p_fork`, 
                    `p_handlebars`, `p_display`, `p_lighting`, `p_connectivity`, `p_fenders`, `p_rack`, 
                    `p_kickstand`, `p_lock`, `p_accessories`, `p_warranty`, `p_torque`, 
                    `p_max_rider_weight`, `p_water_resistance`, `p_base_price`, `p_optional_features`) 
                
                VALUES (NULL, '$folder', '$p_brand', '$p_model', '$p_year', '$p_type', '$p_frame_size', '$p_wheel_size', 
                    '$p_weight', '$p_motor_type', '$p_motor_power', '$p_top_speed', '$p_pedal_assist_levels', 
                    '$p_throttle', '$p_battery_type', '$p_battery_capacity', '$p_range', '$p_charge_time', 
                    '$p_gears', '$p_brakes', '$p_suspension', '$p_tires', '$p_frame_material', '$p_fork', 
                    '$p_handlebars', '$p_display', '$p_lighting', '$p_connectivity', '$p_fenders', '$p_rack', 
                    '$p_kickstand', '$p_lock', '$p_accessories', '$p_warranty', '$p_torque', 
                   '$p_max_rider_weight', '$p_water_resistance', '$p_base_price', '$p_optional_features')";
        $result = mysqli_query($conn, $sql);
        
        // Check if the query was successful
        if ($result) {
            header("Location: Admin/Dashboard.php?msg=Success!");
            exit(); // Ensure that no further code is executed after redirect
        } else {
            die("Failed to insert into the database: " . mysqli_error($conn));
        }
    } else {
        echo "Failed to upload the image.";
    }
}

// Query to select all records from the products_tb table
$sql_select = "SELECT * FROM products_tb";
$result = mysqli_query($conn, $sql_select);

// Check for query errors
if (!$result) {
    die("Error retrieving records: " . mysqli_error($conn));
}
?>