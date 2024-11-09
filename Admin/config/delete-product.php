<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from delete-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // Get the product ID from the URL

    // Delete product from database
    $sql = "DELETE FROM products_tb WHERE id = $productId";

    if (mysqli_query($conn, $sql)) {
        // Optionally delete the product image from the server
        // $imagePath = '../products_tb/' . $productId; // Assuming you have stored the image path in a variable
        // unlink($imagePath); // This line will delete the file from the server
        
        header("Location: ../Dashboard.php?msg=Product deleted successfully!");
        exit;
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "No product ID provided.";
}
?>
