<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from update-promo.php to the root
define('UPLOAD_DIR', '/var/www/html/uploads/'); // Constant for the upload directory
include_once PROJECT_ROOT . "/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the promotion ID from the form
    $promo_id = $_POST['promo_id'];
    $p_name = $_POST['p_name'];
    $p_monthly = $_POST['p_monthly'];
    $p_year = $_POST['p_year'];
    $total_discount = $_POST['total_discount'];
    $base_price = $_POST['base_price'];

    // Variable to store image path
    $db_image_path = null;

    // Handle file upload
    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        // Use the same directory as the product uploads
        $fileName = basename($_FILES['p_image']['name']);
        $folder = UPLOAD_DIR . $fileName; // Path for uploading
        $db_image_path = '../uploads/' . $fileName; // Path to store in the database

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['p_image']['tmp_name'], $folder)) {
            // Handle the error if the file upload fails
            $error_msg = "Error uploading file.";
            error_log($error_msg, 3, PROJECT_ROOT . '/error.log');
            die($error_msg);
        }
    }

    // Prepare the update SQL statement
    $sql = "UPDATE promos_tb SET p_name = ?, p_monthly = ?, p_year = ?, base_price = ?, total_discount = ?, p_image = COALESCE(?, p_image) WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisi", $p_name, $p_monthly, $p_year, $base_price, $total_discount, $db_image_path, $promo_id);

    // Execute the statement
    try {
        if ($stmt->execute()) {
            header("Location: ../Dashboard.php?update_success=true");
            exit();
        } else {
            throw new Exception("Error updating promotion: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Log error and rollback any potential changes
        error_log($e->getMessage(), 3, PROJECT_ROOT . '/error.log');
        die("Error: " . $e->getMessage());
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>