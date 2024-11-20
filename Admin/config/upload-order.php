<?php
include 'get-info.php'; // Adjust the path to your database connection file

// Check if all required POST variables are set
if (isset($_POST['serial_num'], $_POST['full_name'], $_POST['email'], $_POST['phone_num'], $_POST['product_id'], 
    $_POST['p_model'], $_POST['p_price'], $_POST['amount_paid'], $_POST['downpayment'], $_POST['remaining_balance'], $_POST['monthly_installment_price'])) {

    // Sanitize the POST data
    $serialNum = mysqli_real_escape_string($conn, $_POST['serial_num']);
    $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($conn, $_POST['phone_num']);
    $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
    $pModel = mysqli_real_escape_string($conn, $_POST['p_model']);
    $pPrice = mysqli_real_escape_string($conn, $_POST['p_price']);
    $amountPaid = mysqli_real_escape_string($conn, $_POST['amount_paid']);
    $downPayment = mysqli_real_escape_string($conn, $_POST['downpayment']);
    $remainingBalance = mysqli_real_escape_string($conn, $_POST['remaining_balance']);
    $monthlyPayment = mysqli_real_escape_string($conn, $_POST['monthly_installment_price']);

    // Generate a receipt number (assuming you have a function like this)
    $receiptNum = generateReceiptNumber($conn);

    // Prepare the SQL query to insert the data
    $insertQuery = "
        INSERT INTO ledger_tb 
        (receipt_num, serial_num, full_name, phone_num, email, p_model, p_price, amount_paid, downpayment, remaining_balance, monthly_installment_price) 
        VALUES ('$receiptNum', '$serialNum', '$fullName', '$phoneNum', '$email', '$pModel', '$pPrice', '$amountPaid', '$downPayment', '$remainingBalance', '$monthlyPayment')
    ";

    // Execute the query
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: ../order_entry.php?msg=Success!");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Required POST fields are missing!";
}

// Function to generate a new receipt number (you may customize this based on your needs)
function generateReceiptNumber($conn) {
    $sql = "SELECT receipt_num FROM ledger_tb ORDER BY receipt_num DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $lastReceiptNum = $row['receipt_num'];

        // If the table is empty, start from R-10000
        if ($lastReceiptNum === NULL) {
            return "R-10001";
        }

        $lastNumber = (int) substr($lastReceiptNum, 2);

        $newReceiptNum = "R-" . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        return $newReceiptNum;
    } else {
        die("Error retrieving last receipt number: " . mysqli_error($conn));
    }
}
?>
