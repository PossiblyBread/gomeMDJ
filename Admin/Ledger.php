<?php
session_start();
include "../db_conn.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403); 
    exit("Access denied");
}

$message = "";
$autofillData = null;
$results = null;

// Handle search functionality
if (isset($_POST['search_receipt']) && !empty($_POST['search_term'])) {
    $search_term = $_POST['search_term'];

    // Exclude overdue_penalty from the SELECT statement
    $sql = "SELECT receipt_num, serial_num, full_name, phone_num, email, p_model, p_price, downpayment, 
                   remaining_balance, monthly_installment_price, total_price, amount_paid 
            FROM ledger_tb 
            WHERE receipt_num = ? 
            ORDER BY date_time_paid DESC 
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $autofillData = $result->fetch_assoc();

        // Fetch all records for the same serial number
        $serial_num = $autofillData['serial_num'];
        $sql = "SELECT * FROM ledger_tb WHERE serial_num = ? ORDER BY date_time_paid DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $serial_num);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $message = "No matching record found for Receipt Number";
    }

    $stmt->close();
}

// Handle search functionality (search by serial_num)
if (isset($_POST['search_serial_num']) && !empty($_POST['search_term'])) {
    $search_term = $_POST['search_term'];

    // Prepare SQL query to search by serial_num exactly (remove LIKE and %)
    $sql = "SELECT * FROM `ledger_tb` WHERE `serial_num` = ? ORDER BY date_time_paid DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search_term);  // Bind only the serial number to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $results = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all matching records
    } else {
        $message = "No matching records found";
    }

    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_data'])) {
    $receipt_num = $_POST['receipt_num'];
    $serial_num = $_POST['serial_num'];
    $full_name = $_POST['full_name'];
    $phone_num = $_POST['phone_num'];
    $email = $_POST['email'];
    $p_model = $_POST['p_model'];
    $p_price = $_POST['p_price'];
    $downpayment = $_POST['downpayment'];
    $remaining_balance = $_POST['remaining_balance'];
    $monthly_installment_price = $_POST['monthly_installment_price'];
    $total_paid = $_POST['total_price'];
    $amount_paid = $_POST['amount_paid'];
    $overdue_penalty = $_POST['overdue_penalty'];

    // Get the initial remaining balance and convert to float
    $remaining_balance = (float)$_POST['remaining_balance'];
    $amount_paid = (float)$amount_paid;
    $overdue_penalty = (float)$overdue_penalty;
    $total_paid = (float)$total_paid;

    // Add overdue penalty if any
    if ($overdue_penalty > 0) {
        $remaining_balance += $overdue_penalty;
        // Deduct overdue penalty from amount paid
        $amount_paid = max(0, $amount_paid - $overdue_penalty);
    }

    // If there's a remaining balance and payment is being made
    if ($remaining_balance > 0 && $amount_paid > 0) {
        if ($amount_paid > $remaining_balance) {
            // Payment exceeds remaining balance
            $total_paid += $remaining_balance;
            $remaining_balance = 0;
        } else {
            // Normal payment
            $total_paid += $amount_paid;
            $remaining_balance -= $amount_paid;
        }
    } else if ($remaining_balance <= 0) {
        // No remaining balance
        $remaining_balance = 0;
        $amount_paid = 0;
    }

    $sql = "INSERT INTO ledger_tb (receipt_num, serial_num, full_name, phone_num, email, p_model, p_price, downpayment, 
            remaining_balance, monthly_installment_price, total_price, amount_paid, overdue_penalty)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Cast numeric values to appropriate types
    $p_price = (float)$p_price;
    $downpayment = (float)$downpayment;
    $remaining_balance = (float)$remaining_balance;
    $monthly_installment_price = (float)$monthly_installment_price;
    $total_paid = (float)$total_paid;
    $amount_paid = (float)$amount_paid;
    $overdue_penalty = (float)$overdue_penalty;

    $stmt->bind_param(
        "ssssssddddddd",
        $receipt_num,
        $serial_num,
        $full_name,
        $phone_num,
        $email,
        $p_model,
        $p_price,
        $downpayment,
        $remaining_balance,
        $monthly_installment_price,
        $total_paid,
        $amount_paid,
        $overdue_penalty
    );

    if ($stmt->execute()) {
        $message = "New record created successfully!";

        // Fetch updated records for the same serial number
        $sql = "SELECT * FROM ledger_tb WHERE serial_num = ? ORDER BY date_time_paid DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $serial_num);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = $result->fetch_all(MYSQLI_ASSOC);
        
        // Redirect after successful submission to prevent resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert and View Payment Information</title>
</head>

<body>

    <?php include 'side-nav.php'; ?>

    <div class="container">
        <div class="form-container" id="payment-form">
            <div>
                <h2>Search Payment Information</h2>
                <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                <form method="post" action="">
                    <label for="search_term">Search Order Number:</label>
                    <input type="text" id="search_term" name="search_term" placeholder="Enter Receipt Number">
                    <button type="submit" name="search_receipt">Search</button>
                </form>
            </div>
            <h2>Enter Payment Information</h2>
            <form method="post" action="">
                <label for="receipt_num">Order Number:</label>
                <input readonly type="text" id="receipt_num" name="receipt_num"
                    value="<?php echo isset($autofillData) ? $autofillData['receipt_num'] : ''; ?>" required readonly>

                <label for="serial_num">Serial Number:</label>
                <input type="text" id="serial_num" name="serial_num"
                    value="<?php echo isset($autofillData) ? $autofillData['serial_num'] : ''; ?>" required readonly>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name"
                    value="<?php echo isset($autofillData) ? $autofillData['full_name'] : ''; ?>" required readonly>

                <label for="phone_num">Phone Number:</label>
                <input type="text" id="phone_num" name="phone_num"
                    value="<?php echo isset($autofillData) ? $autofillData['phone_num'] : ''; ?>" required readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                    value="<?php echo isset($autofillData) ? $autofillData['email'] : ''; ?>" readonly>

                <label for="p_model">Product Model:</label>
                <input type="text" id="p_model" name="p_model"
                    value="<?php echo isset($autofillData) ? $autofillData['p_model'] : ''; ?>" readonly>

                <label for="p_price">Product Price:</label>
                <input type="number" step="0.01" id="p_price" name="p_price"
                    value="<?php echo isset($autofillData) ? $autofillData['p_price'] : ''; ?>" required readonly>

                <label for="downpayment">Downpayment:</label>
                <input type="number" step="0.01" id="downpayment" name="downpayment"
                    value="<?php echo isset($autofillData) ? $autofillData['downpayment'] : ''; ?>" required readonly>

                <label for="remaining_balance">Remaining Balance:</label>
                <input type="number" step="0.01" id="remaining_balance" name="remaining_balance"
                    value="<?php echo isset($autofillData) ? $autofillData['remaining_balance'] : ''; ?>" required readonly>

                <label for="monthly_installment_price">Monthly Installment Price:</label>
                <input type="number" step="0.01" id="monthly_installment_price" name="monthly_installment_price"
                    value="<?php echo isset($autofillData) ? $autofillData['monthly_installment_price'] : ''; ?>" readonly>

                <label for="amount_paid">Amount Paid:</label>
                <input type="number" step="0.01" id="amount_paid" name="amount_paid" value="0" required>

                <label for="overdue_penalty">Overdue Penalty:</label>
                <input type="number" step="0.01" id="overdue_penalty" name="overdue_penalty" value="0">

                <label for="total_price">Total Paid Amount:</label>
                <input type="number" step="0.01" id="total_price" name="total_price"
                    value="<?php echo isset($autofillData) ? $autofillData['total_price'] : ''; ?>" required readonly>

                <button type="submit" name="insert_data">Submit</button>
            </form>
        </div>

        <div class="form-container" id="ledger-table">
            <h2>View Payment Records</h2>
            <div>
                <h2>Search For User Payment History</h2>
                <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                <form method="post" action="">
                    <label for="search_term">Search by Serial Number:</label>
                    <input type="text" id="search_term" name="search_term" placeholder="Enter Serial Number">
                    <button type="submit" name="search_serial_num">Search</button>
                </form>
            </div>
            <?php if (!empty($results)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Date Paid</th>
                            <th>Serial Number</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Product Model</th>
                            <th>Product Price</th>
                            <th>Downpayment</th>
                            <th>Remaining Balance</th>
                            <th>Monthly Installment Price</th>
                            <th>Amount Paid</th>
                            <th>Overdue Penalty</th>
                            <th>Total Paid Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo $row['receipt_num']; ?></td>
                                <td>
                                    <?php
                                    $dateTime = new DateTime($row['date_time_paid']);
                                    echo $dateTime->format('m-d-Y h:i A');
                                    ?>
                                </td>
                                <td><?php echo $row['serial_num']; ?></td>
                                <td><?php echo $row['full_name']; ?></td>
                                <td><?php echo $row['phone_num']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['p_model']; ?></td>
                                <td><?php echo '₱' . $row['p_price']; ?></td>
                                <td><?php echo '₱' . $row['downpayment']; ?></td>
                                <td><?php echo '₱' . $row['remaining_balance']; ?></td>
                                <td><?php echo '₱' . $row['monthly_installment_price']; ?></td>
                                <td><?php echo '₱' . $row['amount_paid']; ?></td>
                                <td><?php echo '₱' . $row['overdue_penalty']; ?></td>
                                <td><?php echo '₱' . $row['total_price']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Search for an Account using Serial Number.</p>
            <?php endif; ?>
        </div>

    </div>

</body>

</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background: #f0f5f9;
    }

    .container {
        display: flex;
        justify-content: space-between;
        margin-left: 170px;
        gap: 20px;
    }

    .form-container {
        margin-top: 20px;
        width: 450px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Adding a bit of space between the form containers */
    #ledger-table {
        width: 100%;
        margin-right: 20px;
    }

    .form-container h2 {
        text-align: center;
    }

    /* Center form contents */
    .form-container form {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center align form elements */
    }

    label {
        margin-top: 10px;
        display: block;
        text-align: center;
        /* Center label text */
    }

    input,
    textarea {
        width: 250px;
        padding: 8px;
        margin: 5px 0 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
        /* Center input text */
    }

    button {
        background-color: #78bddf;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        width: 100%;
        /* Make button span full width */
        max-width: 250px;
        /* Restrict max width */
    }

    button:hover {
        background-color: #29779f;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #eaeaea;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            align-items: center;
        }

        .form-container {
            width: 100%;
            margin-bottom: 20px;
            /* Add space between sections */
        }
    }

    .required-asterisk {
        color: red;
        margin-left: 5px;
    }
</style>