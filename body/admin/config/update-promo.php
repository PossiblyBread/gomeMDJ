<?php
define('PROJECT_ROOT', dirname(__DIR__, 3)); // Adjust based on the relative path from upload-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the promotion ID from the form
    $promo_id = $_POST['promo_id'];
    $p_name = $_POST['p_name'];
    $p_monthly = $_POST['p_monthly'];
    $p_year = $_POST['p_year'];

    // Variable to store image path
    $db_image_path = null;

    // Handle file upload
    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        // Use the same directory as the product uploads
        $fileName = basename($_FILES['p_image']['name']);
        $folder = '../../../products_tb/' . $fileName; // Path for uploading
        $db_image_path = '../products_tb/' . $fileName; // Path to store in the database

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['p_image']['tmp_name'], $folder)) {
            // Handle the error if the file upload fails
            die("Error uploading file.");
        }
    }

    // Prepare the update SQL statement
    $sql = "UPDATE promos_tb SET p_name = ?, p_monthly = ?, p_year = ?, p_image = COALESCE(?, p_image) WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $p_name, $p_monthly, $p_year, $db_image_path, $promo_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../../../Admin/Dashboard.php?msg=Success!");
    } else {
        echo "Error updating promotion: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
