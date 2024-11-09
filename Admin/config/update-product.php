<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from update-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_POST['prod_serial_num'])) {
    // Get the product serial number from the form submission
    $prod_serial_num = $_POST['prod_serial_num'];

    // Retrieve the other product details from the form submission
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
    $u_availability = $_POST['u_availability'] = "";
    $productId = intval($_GET['id']); // Get the product ID from the URL

    // Start building the update query
    $sql = "UPDATE products_tb SET 
                p_model = '$p_model',
                p_wheels = '$p_wheels',
                p_motor_power = '$p_motor_power',
                p_battery = '$p_battery',
                p_max_speed = '$p_max_speed',
                p_range = '$p_range',
                p_max_load = '$p_max_load',
                p_charging_time = '$p_charging_time',
                p_other_features = '$p_other_features',
                p_price = '$p_price',
                p_variants = '$p_variants',
                u_availability = '$u_availability'";

    // Handle image upload if a new image is provided
    if (!empty($_FILES['images']['name'])) {
        $file_name = $_FILES['images']['name'];
        $tempname = $_FILES['images']['tmp_name'];
        $folder = '../../products_tb/' . $file_name; // Path for uploading
        $db_image_path = '../products_tb/' . $file_name; // Path for the database

        // Attempt to move the uploaded file
        if (move_uploaded_file($tempname, $folder)) {
            $sql .= ", images = '$db_image_path'"; // Add the image update to the SQL query
        } else {
            echo "Failed to upload the image.";
            exit;
        }
    }

    // Finalize the SQL query with the WHERE clause
    $sql .= " WHERE id = $productId"; // Update using the product ID

    // Execute the update query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        header("Location: ../Dashboard.php?msg=Update successful!");
    } else {
        echo "Failed to update the product: " . mysqli_error($conn);
    }
}
?>
