<?php
session_start();
include "db_conn.php";

$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Assuming the CSS styles from the template -->
    <link rel="stylesheet" href="assets/products.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <?php
    include 'products_item.php';
    if (isset($image)) {
        $imagePath = getImagePath($image, $pageId);
    }
    ?>
    <?php include 'footer.php'; ?>
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
    <script src="js/script.js"></script>
    <script src="js/Otp_script.js"></script>
</body>

</html>