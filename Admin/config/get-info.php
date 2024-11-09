<?php
include '../db_conn.php';

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
        $result = $conn->query("SELECT prod_serial_num, p_model, images, p_price FROM products_tb");
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
        $stmt = $conn->prepare("SELECT prod_serial_num, images, p_model, p_price FROM products_tb WHERE p_model LIKE CONCAT('%', ?, '%')");
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
?>
