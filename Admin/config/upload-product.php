<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from upload-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_FILES['cover-image'])) {
    // File upload variables
    $prod_serial_num = getNextProdSerialNum($conn);

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
    $u_availability = 'Available'; // Default availability status

    // Start transaction
    $conn->begin_transaction();

    try {
        // First insert into products_tb
        $sql = "INSERT INTO products_tb (prod_serial_num, p_model, p_wheels, p_motor_power, 
                                       p_battery, p_max_speed, p_range, p_max_load, p_charging_time,
                                       p_variants, p_other_features, p_price, u_availability) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "issssssssssss",
            $prod_serial_num,
            $p_model,
            $p_wheels,
            $p_motor_power,
            $p_battery,
            $p_max_speed,
            $p_range,
            $p_max_load,
            $p_charging_time,
            $p_variants,
            $p_other_features,
            $p_price,
            $u_availability
        );

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert product data: " . $stmt->error);
        }

        $product_id = $conn->insert_id;
        $stmt->close();

        // Handle cover image upload
        $cover_tempname = $_FILES['cover-image']['tmp_name'];
        $cover_filename = $_FILES['cover-image']['name'];
        $cover_extension = pathinfo($cover_filename, PATHINFO_EXTENSION);
        $cover_new_filename = 'COVER_' . $p_model . '_' . $prod_serial_num . '_' . time() . '.' . $cover_extension;
        $cover_folder = '../../uploads/' . $cover_new_filename;
        $cover_db_image_path = $cover_new_filename;

        if (!move_uploaded_file($cover_tempname, $cover_folder)) {
            throw new Exception("Failed to upload the cover image.");
        }

        // Insert cover image into products_img_id
        $cover_img_sql = "INSERT INTO products_img_id (products_id, Images, image_type) VALUES (?, ?, 'cover')";
        $cover_img_stmt = $conn->prepare($cover_img_sql);
        $cover_img_stmt->bind_param("is", $product_id, $cover_db_image_path);

        if (!$cover_img_stmt->execute()) {
            throw new Exception("Failed to insert cover image data: " . $cover_img_stmt->error);
        }

        $cover_img_stmt->close();

        // Handle additional image uploads if any thumbnails were uploaded
        if (!empty($_FILES['thumbnail-images']['name'][0])) {
            foreach ($_FILES['thumbnail-images']['tmp_name'] as $key => $tempname) {
                if (empty($tempname)) continue;

                $file_name = $_FILES['thumbnail-images']['name'][$key];
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_filename = 'PROD_' . $p_model . '_' . time() . '_' . $key . '.' . $file_extension;
                $folder = '../../uploads/' . $new_filename;
                $db_image_path = $new_filename;

                if (!move_uploaded_file($tempname, $folder)) {
                    throw new Exception("Failed to upload thumbnail image #" . ($key + 1));
                }

                // Insert each image into products_img_id
                $img_sql = "INSERT INTO products_img_id (products_id, Images, image_type) VALUES (?, ?, 'thumbnail')";
                $img_stmt = $conn->prepare($img_sql);
                $img_stmt->bind_param("is", $product_id, $db_image_path);

                if (!$img_stmt->execute()) {
                    throw new Exception("Failed to insert thumbnail image data: " . $img_stmt->error);
                }

                $img_stmt->close();
            }
        }

        $conn->commit();
        header("Location: ../Dashboard.php?msg=Success!");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on any error
        $conn->rollback();

        // Delete uploaded files if they exist
        if (isset($cover_folder) && file_exists($cover_folder)) {
            unlink($cover_folder);
        }

        if (!empty($_FILES['thumbnail-images']['name'][0])) {
            foreach ($_FILES['thumbnail-images']['tmp_name'] as $key => $tempname) {
                $file_name = $_FILES['thumbnail-images']['name'][$key];
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_filename = 'PROD_' . $p_model . '_' . time() . '_' . $key . '.' . $file_extension;
                $folder = '../../uploads/' . $new_filename;
                if (file_exists($folder)) {
                    unlink($folder);
                }
            }
        }

        // Return error response
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
} else {
    // Invalid request
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing files']);
    exit;
}

// Function to get the next product serial number
function getNextProdSerialNum($conn)
{
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
