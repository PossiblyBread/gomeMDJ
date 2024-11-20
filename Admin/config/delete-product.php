<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from upload-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    // Fetch images associated with the product
    $sql = "SELECT Images FROM products_img_id WHERE products_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // Delete files
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['Images'])) {
            $image_path = '../../uploads/' . basename($row['Images']);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }
    $stmt->close();
    $delete_sql = "DELETE FROM products_img_id WHERE Images = ? AND products_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    foreach ($images_to_delete as $image) {
        $delete_stmt->bind_param("si", $image, $product_id);
        $delete_stmt->execute();
    }
    $delete_stmt->close();
    $delete_sql = "DELETE FROM products_tb WHERE products_id = $product_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: ../Dashboard.php?msg=" . urlencode("Product deleted successfully!"));
        exit();
    } else {
        header("Location: ../Dashboard.php?error=" . urlencode("Error deleting product: " . mysqli_error($conn)));
        exit();
    }
    mysqli_close($conn);
} else {
    echo "No product ID provided.";
}
