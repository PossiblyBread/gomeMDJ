<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from delete-product.php to the root
define('UPLOAD_DIR', '/var/www/html/uploads/'); // path uploads 
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Fetch images associated with the product
        $sql = "SELECT Images FROM products_img_id WHERE products_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Delete files
        $images_to_delete = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['Images'])) {
                $image_path = UPLOAD_DIR . basename($row['Images']);
                if (file_exists($image_path)) {
                    unlink($image_path); // Delete the file
                }
                $images_to_delete[] = $row['Images'];
            }
        }
        $stmt->close();

        // Delete images from the database
        $delete_sql = "DELETE FROM products_img_id WHERE Images = ? AND products_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        foreach ($images_to_delete as $image) {
            $delete_stmt->bind_param("si", $image, $product_id);
            if (!$delete_stmt->execute()) {
                throw new Exception("Failed to delete image record: " . $delete_stmt->error);
            }
        }
        $delete_stmt->close();

        // Delete product record from the database
        $delete_sql = "DELETE FROM products_tb WHERE products_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $product_id);
        if (!$delete_stmt->execute()) {
            throw new Exception("Failed to delete product: " . $delete_stmt->error);
        }
        $delete_stmt->close();

        // Commit the transaction
        $conn->commit();
        header("Location: ../Dashboard.php?delete_success=true");
        exit();

    } catch (Exception $e) {
        // Rollback transaction if error occurs
        $conn->rollback();

        // Log the error to a file
        error_log($e->getMessage(), 3, PROJECT_ROOT . '/error.log');

        // Redirect to dashboard with an error message
        header("Location: ../Dashboard.php?error=" . urlencode("Error: " . $e->getMessage()));
        exit();
    } finally {
        $conn->close();
    }

} else {
    echo "No product ID provided.";
}
?>