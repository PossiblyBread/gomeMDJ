<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); 
define('UPLOAD_DIR', '/var/www/html/uploads/'); //point directory to uploads
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_FILES['cover-image'])) {
    $required_fields = [
        'p_model',
        'p_wheels',
        'p_motor_power',
        'p_battery',
        'p_max_speed',
        'p_range',
        'p_max_load',
        'p_charging_time',
        'p_price'
    ];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            die("Error: {$field} is required");
        }
    }

    // Sanitize inputs
    $p_model = htmlspecialchars(trim($_POST['p_model']));
    $p_wheels = htmlspecialchars(trim($_POST['p_wheels']));
    $p_motor_power = htmlspecialchars(trim($_POST['p_motor_power']));
    $p_battery = htmlspecialchars(trim($_POST['p_battery']));
    $p_max_speed = htmlspecialchars(trim($_POST['p_max_speed']));
    $p_range = htmlspecialchars(trim($_POST['p_range']));
    $p_max_load = htmlspecialchars(trim($_POST['p_max_load']));
    $p_charging_time = htmlspecialchars(trim($_POST['p_charging_time']));
    $p_variants = htmlspecialchars(trim($_POST['p_variants']));
    $p_other_features = htmlspecialchars(trim($_POST['p_other_features']));
    $u_availability = htmlspecialchars(trim($_POST['u_availability']));
    $p_price = htmlspecialchars(trim($_POST['p_price']));
    $productId = intval($_GET['id']); 

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update products_tb
        $sql = "UPDATE products_tb SET 
                p_model = ?, p_wheels = ?, p_motor_power = ?,
                p_battery = ?, p_max_speed = ?, p_range = ?, 
                p_max_load = ?, p_charging_time = ?, p_variants = ?,
                p_other_features = ?, u_availability = ?, p_price = ?
                WHERE products_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssi",
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
            $u_availability,
            $p_price,
            $productId
        );

        if (!$stmt->execute()) {
            throw new Exception("Failed to update product details: " . $stmt->error);
        }
        $stmt->close();

        // Handle cover image update if provided
        if (isset($_FILES['cover-image']) && $_FILES['cover-image']['error'] === UPLOAD_ERR_OK) {
            $cover_tempname = $_FILES['cover-image']['tmp_name'];
            $cover_filename = $_FILES['cover-image']['name'];
            $cover_extension = strtolower(pathinfo($cover_filename, PATHINFO_EXTENSION));

            if (!in_array($cover_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                throw new Exception("Invalid cover image format. Allowed: jpg, jpeg, png, gif, webp.");
            }

            $cover_new_filename = 'COVER_' . $p_model . '_' . time() . '.' . $cover_extension;
            $cover_folder = UPLOAD_DIR . $cover_new_filename;

            // Delete old cover image
            $old_cover_sql = "SELECT Images FROM products_img_id WHERE products_id = ? AND image_type = 'cover'";
            $old_cover_stmt = $conn->prepare($old_cover_sql);
            $old_cover_stmt->bind_param("i", $productId);
            $old_cover_stmt->execute();
            $old_cover_result = $old_cover_stmt->get_result();

            if ($old_cover = $old_cover_result->fetch_assoc()) {
                $old_file = UPLOAD_DIR . $old_cover['Images'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $old_cover_stmt->close();

            if (!move_uploaded_file($cover_tempname, $cover_folder)) {
                throw new Exception("Failed to upload the cover image.");
            }

            $cover_sql = "INSERT INTO products_img_id (products_id, Images, image_type) 
                         VALUES (?, ?, 'cover') 
                         ON DUPLICATE KEY UPDATE Images = VALUES(Images)";
            $cover_stmt = $conn->prepare($cover_sql);
            $cover_stmt->bind_param("is", $productId, $cover_new_filename);

            if (!$cover_stmt->execute()) {
                throw new Exception("Failed to update cover image record: " . $cover_stmt->error);
            }
            $cover_stmt->close();
        }

        // Handle thumbnail images
        if (isset($_FILES['thumbnail-images']) && !empty($_FILES['thumbnail-images']['name'][0])) {
            foreach ($_FILES['thumbnail-images']['tmp_name'] as $key => $tempname) {
                if (empty($tempname)) continue;

                $file_name = $_FILES['thumbnail-images']['name'][$key];
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    throw new Exception("Invalid thumbnail image format. Allowed: jpg, jpeg, png, gif, webp.");
                }

                $new_filename = 'PROD_' . $p_model . '_' . time() . '_' . $key . '.' . $file_extension;
                $folder = UPLOAD_DIR . $new_filename;

                if (!move_uploaded_file($tempname, $folder)) {
                    throw new Exception("Failed to upload thumbnail image #" . ($key + 1));
                }

                $thumb_sql = "INSERT INTO products_img_id (products_id, Images, image_type) VALUES (?, ?, 'thumbnail')";
                $thumb_stmt = $conn->prepare($thumb_sql);
                $thumb_stmt->bind_param("is", $productId, $new_filename);

                if (!$thumb_stmt->execute()) {
                    throw new Exception("Failed to insert thumbnail image record: " . $thumb_stmt->error);
                }
                $thumb_stmt->close();
            }
        }

        $conn->commit();
        header("Location: ../Dashboard.php?update_success=true");
        exit();
    } catch (Exception $e) {
        $conn->rollback();

        // Log error
        error_log($e->getMessage(), 3, PROJECT_ROOT . '/error.log');
        die("Error: " . $e->getMessage());
    }
}
?>
