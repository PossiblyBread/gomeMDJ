<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../db_conn.php";

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

// Fetch products from the database
$sql = "SELECT * FROM products_tb"; // Adjust this query as needed
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Error retrieving products: " . mysqli_error($conn));
}

$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/products.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <?php include '../products_item.php'; ?>
    <script>
        window.embeddedChatbotConfig = {
            chatbotId: "e8_c510p3vG8EPF2g33Vw",
            domain: "www.chatbase.co"
        }
    </script>
    <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="e8_c510p3vG8EPF2g33Vw"
        domain="www.chatbase.co"
        defer>
    </script>

    <?php include 'footer.php'; ?>

    <script src="../js/script.js"></script>
</body>

</html>