<?php
define('PROJECT_ROOT', dirname(__DIR__, 3)); // Adjust based on the relative path from upload-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_FILES['images'])) {
    // File upload variables
    $prod_serial_num = getNextProdSerialNum($conn);

    $file_name = $_FILES['images']['name'];
    $tempname = $_FILES['images']['tmp_name'];

    // Use the full path to save the image
    $folder = '../../../products_tb/' . $file_name; // Path for uploading
    // Store only a relative path for the database
    $db_image_path = '../products_tb/' . $file_name; // Path for the database

    $p_model = $_POST['p_model'];
    $p_wheels = $_POST['p_wheels'];
    $p_motor_power = $_POST['p_motor_power'];
    $p_battery = $_POST['p_battery'];
    $p_max_speed = $_POST['p_max_speed'];
    $p_range = $_POST['p_range'];
    $p_max_load = $_POST['p_max_load'];
    $p_charging_time = $_POST['p_charging_time'];
    $p_variants = $_POST['p_variants'];
    $p_other_features = $_POST['p_other_features'];
    $p_price = $_POST['p_price'];

    if (move_uploaded_file($tempname, $folder)) {
        // Insert file path into database
        $sql = "INSERT INTO products_tb (`id`, `prod_serial_num`, `images`, `p_model`, `p_wheels`, `p_motor_power`, 
                                        `p_battery`, `p_max_speed`, `p_range`, `p_max_load`, `p_charging_time`, 
                                        `p_other_features`, `p_price`, `p_variants`) 
                VALUES (NULL, '$prod_serial_num', '$db_image_path', '$p_model', '$p_wheels', '$p_motor_power', 
                            '$p_battery', '$p_max_speed', '$p_range', '$p_max_load', '$p_charging_time', 
                            '$p_other_features', '$p_price', '$p_variants')";

        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if ($result) {
            header("Location: ../../../Admin/Dashboard.php?msg=Success!");
        } else {
            echo "Failed to insert into the database: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload the image.";
    }
}

// Function to get the next product serial number
function getNextProdSerialNum($conn) {
    // SQL to get the maximum product serial number
    $sql = "SELECT MAX(prod_serial_num) AS max_serial FROM products_tb";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        // Increment by 1 if a max_serial exists, otherwise start at 1
        return $row['max_serial'] ? $row['max_serial'] + 1 : 10000;
    } else {
        die("Error retrieving product serial number: " . mysqli_error($conn));
    }
}
?>
