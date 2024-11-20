<?php
define('PROJECT_ROOT', dirname(__DIR__, 2)); // Adjust based on the relative path from upload-product.php to the root
include_once PROJECT_ROOT . "/db_conn.php";

if (isset($_POST['search_value']) || isset($_POST['product_search']) || isset($_POST['fetch_all_products'])) {
    header('Content-Type: application/json');

    // Search for account
    if (isset($_POST['search_value'])) {
        $searchValue = $_POST['search_value'];
        $stmt = $conn->prepare("SELECT serial_num, first_name, last_name, email, phone_num FROM accounts WHERE email = ? OR serial_num = ?");
        $stmt->bind_param('ss', $searchValue, $searchValue);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $account = $result->fetch_assoc();
            echo json_encode(['success' => true, 'type' => 'account', 'data' => $account]);
        } else {
            echo json_encode(['success' => false, 'type' => 'account']);
        }
        $stmt->close();
        exit;
    }

    // Fetch all products for dropdown
    if (isset($_POST['fetch_all_products'])) {
        $sql = "SELECT p.prod_serial_num, p.p_model, pi.Images, p.p_price 
                FROM products_tb p
                LEFT JOIN products_img_id pi ON p.products_id = pi.products_id 
                WHERE pi.image_type = 'cover'";
        $result = $conn->query($sql);
        if ($result) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(['success' => true, 'type' => 'product', 'data' => $products]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error fetching products.']);
        }
        exit;
    }

    // Fetch product details based on the selected model
    if (isset($_POST['product_search'])) {
        $productModel = $_POST['product_search'];
        $sql = "SELECT p.prod_serial_num, pi.Images, p.p_model, p.p_price 
                FROM products_tb p
                LEFT JOIN products_img_id pi ON p.products_id = pi.products_id 
                WHERE pi.image_type = 'cover' AND p.p_model LIKE CONCAT('%', ?, '%')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $productModel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(['success' => true, 'type' => 'product', 'data' => $products]);
        } else {
            echo json_encode(['success' => false, 'type' => 'product']);
        }
        $stmt->close();
        exit;
    }
}
