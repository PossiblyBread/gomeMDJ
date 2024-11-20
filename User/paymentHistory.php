<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); 
    exit("Access denied");
}

include "../db_conn.php";

// Retrieve user's first and last names from session (if available)
$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

// User ID and serial number for validation and querying
$id = $_SESSION['id'];  // User ID stored in session
$validation_status = '';

// Fetch the user's validation status from the accounts table
$sql_validation = "SELECT `validation`, `serial_num` FROM `accounts` WHERE `id` = '$id'";
$validation_result = mysqli_query($conn, $sql_validation);
if ($validation_result) {
    $row = mysqli_fetch_assoc($validation_result);
    $validation_status = $row['validation'];  // Get validation status
    $serial_num = $row['serial_num'];        // Get the serial number associated with the user
} else {
    die("Error fetching validation status.");
}

// Determine the sort order and column
$sort_order = 'ASC'; // Default sort order
$sort_column = 'date_time_paid'; // Default column to sort by

if (isset($_GET['sort_column']) && isset($_GET['sort_order'])) {
    $sort_column = $_GET['sort_column'];
    $sort_order = $_GET['sort_order'] === 'ASC' ? 'ASC' : 'DESC';
}

// Using prepared statements for the payment history query with sorting by selected column
$stmt = $conn->prepare("SELECT `receipt_num`, `serial_num`, `full_name`, `phone_num`, `email`, 
                                `p_model`, `p_price`, `downpayment`, `remaining_balance`, `monthly_installment_price`, 
                                `total_price`, `date_time_paid`, `amount_paid`, `overdue_penalty` 
                        FROM `ledger_tb` 
                        WHERE `serial_num` = ? 
                        ORDER BY $sort_column $sort_order");  // Dynamic sort column and order
$stmt->bind_param('s', $serial_num);  // Bind the serial_num as a parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $payment_history = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    die("Error fetching payment history.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <br><br><br><br>
    <!-- Payment History Section -->
    <?php if ($validation_status === "Validated"): ?>
        <section class="payment-history">
            <h3>Payment History</h3>
            <?php if (!empty($payment_history)): ?>
                <!-- Sort Buttons -->
                <div class="sort-buttons">
                    <a href="?sort_column=date_time_paid&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Date</a>
                    <a href="?sort_column=receipt_num&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Sort by Receipt Number</a>
                    <!-- You can add more sorting links for other columns here -->
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>  <!-- Row number column -->
                            <th>Receipt No</th>
                            <th>Model</th>
                            <th>Price</th>
                            <th>Downpayment</th>
                            <th>Remaining Balance</th>
                            <th>Monthly Installment</th>
                            <th>Date Paid</th>
                            <th>Amount Paid</th>
                            <th>Overdue Penalty</th>
                            <th>Total Paid Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row_number = 1; // Initialize row number ?>
                        <?php foreach ($payment_history as $payment): ?>
                            <tr>
                                <td><?php echo $row_number++; ?></td>  <!-- Display row number -->
                                <td><?php echo htmlspecialchars($payment['receipt_num']); ?></td>
                                <td><?php echo htmlspecialchars($payment['p_model']); ?></td>
                                <td><?php echo htmlspecialchars($payment['p_price']); ?></td>
                                <td><?php echo htmlspecialchars($payment['downpayment']); ?></td>
                                <td><?php echo htmlspecialchars($payment['remaining_balance']); ?></td>
                                <td><?php echo htmlspecialchars($payment['monthly_installment_price']); ?></td>
                                <td>
                                    <?php 
                                        try {
                                            $dateTime = new DateTime($payment['date_time_paid']);
                                            echo $dateTime->format('F d, Y h:i A');
                                        } catch (Exception $e) {
                                            echo "Invalid date format";
                                        }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($payment['amount_paid']); ?></td>
                                <td><?php echo htmlspecialchars($payment['overdue_penalty']); ?></td>
                                <td><?php echo htmlspecialchars($payment['total_price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No payment history available.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>
    
    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
    <script src="../js/script.js"></script>
</body>
</html>

<style>
/* Style for the Sort Buttons */
body{
    background-color: #CBDCEB;
}
.sort-buttons {
    margin-bottom: 20px;
    text-align: right;
}
.sort-buttons a {
    margin: 0 10px;
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
}
.sort-buttons a:hover {
    color: #2c3e50;
}

/* Payment History */
.payment-history {
    background-color: #f9f9f9;
    padding: 20px;
    margin-top: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 70%; /* Default width */
    margin-left: auto;
    margin-right: auto;
    overflow-x: auto; /* Allow horizontal scrolling on smaller screens */
    margin-bottom: 20px;
}

.payment-history h3 {
    color: #2c3e50;
    text-align: center;
}

.payment-history table {
    width: 100%; /* Ensure the table takes up 100% of its container width */
    border-collapse: collapse;
}

.payment-history th, .payment-history td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}
.payment-history th {
    text-align: center;
    color: black;
}
</style>
