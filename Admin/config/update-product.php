<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from upload-product.php to the root
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
    $p_price = htmlspecialchars(trim($_POST['p_price']));
    $productId = intval($_GET['id']); // Get the product ID from the URL

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update products_tb
        $sql = "UPDATE products_tb SET 
                p_model = ?, p_wheels = ?, p_motor_power = ?,
                p_battery = ?, p_max_speed = ?, p_range = ?, 
                p_max_load = ?, p_charging_time = ?, p_variants = ?,
                p_other_features = ?, p_price = ?
                WHERE products_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssssi",
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
            $cover_extension = pathinfo($cover_filename, PATHINFO_EXTENSION);
            $cover_new_filename = 'COVER_' . $p_model . '_' . time() . '.' . $cover_extension;
            $cover_folder = '../../uploads/' . $cover_new_filename;

            // Delete old cover image
            $old_cover_sql = "SELECT Images FROM products_img_id WHERE products_id = ? AND image_type = 'cover'";
            $old_cover_stmt = $conn->prepare($old_cover_sql);
            $old_cover_stmt->bind_param("i", $productId);
            $old_cover_stmt->execute();
            $old_cover_result = $old_cover_stmt->get_result();

            if ($old_cover = $old_cover_result->fetch_assoc()) {
                $old_file = '../../uploads/' . $old_cover['Images'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $old_cover_stmt->close();

            if (!move_uploaded_file($cover_tempname, $cover_folder)) {
                throw new Exception("Failed to upload the cover image.");
            }

            // Update or insert cover image
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

        // Handle thumbnail images if provided
        if (isset($_FILES['thumbnail-images']) && !empty($_FILES['thumbnail-images']['name'][0])) {
            foreach ($_FILES['thumbnail-images']['tmp_name'] as $key => $tempname) {
                if (empty($tempname)) continue;

                $file_name = $_FILES['thumbnail-images']['name'][$key];
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_filename = 'PROD_' . $p_model . '_' . time() . '_' . $key . '.' . $file_extension;
                $folder = '../../uploads/' . $new_filename;

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

        // Handle removed images
        if (isset($_POST['removed_images'])) {
            $removed_images = $_POST['removed_images'];

            // Prepare delete statement once
            $delete_sql = "DELETE FROM products_img_id WHERE Images = ? AND products_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);

            // Build arrays for bulk file deletion
            $files_to_delete = [];
            $images_to_delete = [];
            foreach ($removed_images as $image) {
                $image_path = '../../uploads/' . basename($image);
                if (file_exists($image_path)) {
                    $files_to_delete[] = $image_path;
                }
                $images_to_delete[] = basename($image);
            }

            // Bulk delete files
            array_map('unlink', $files_to_delete);

            // Bulk delete from database
            foreach ($images_to_delete as $image) {
                $delete_stmt->bind_param("si", $image, $productId);
                $delete_stmt->execute();
            }

            $delete_stmt->close();
        }

        $conn->commit();
        header("Location: ../Dashboard.php?msg=" . urlencode("Product updated successfully!"));
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
