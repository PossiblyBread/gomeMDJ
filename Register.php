<?php
include "db_conn.php";

// For registering a new user
if (isset($_POST['Submit'])) {
    // Generate a new serial number
    $serial_num = getNextSerialNum($conn);
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $a_password = $_POST['a_password']; 
    $h_password = password_hash($a_password, PASSWORD_DEFAULT);
    $role = "user";
    $date_created = date('Y-m-d H:i:s'); 

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if the email already exists using a prepared statement
    $checkEmailQuery = "SELECT * FROM `accounts` WHERE `email` = ?";
    if ($stmt = $conn->prepare($checkEmailQuery)) {
        $stmt->bind_param("s", $email); // "s" indicates the type is string
        $stmt->execute();
        $emailResult = $stmt->get_result();

        if ($emailResult->num_rows > 0) {
            header("Location: index.php?msg=Email already in use!");
            exit;
        }

        // Close the statement
        $stmt->close();
    } else {
        // If prepare statement fails
        die("Error in preparing query: " . $conn->error);
    }

    // Insert the new user into the database using a prepared statement
    $sql = "INSERT INTO `accounts` (`serial_num`, `last_name`, `first_name`, `email`, `phone_num`, `h_password`, `role`, `date_created`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isssssss", $serial_num, $last_name, $first_name, $email, $phone_num, $h_password, $role, $date_created);

        if ($stmt->execute()) {
            // Start session and set session variables
            session_start();
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_email'] = $email;
            $_SESSION['msg'] = "Registration Complete";
            // Redirect first, then show the alert
            header("Location: index.php?register_success=true");
            exit;
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // If prepare statement fails
        die("Error in preparing query: " . $conn->error);
    }
}

function getNextSerialNum($conn) {
    // Query to get the next serial number
    $query = "SELECT MAX(serial_num) AS max_serial FROM accounts";
    if ($result = $conn->query($query)) {
        $row = $result->fetch_assoc();
        return isset($row['max_serial']) ? $row['max_serial'] + 1 : 10000;
    } else {
        die("Error fetching serial number: " . $conn->error);
    }
}
?>
