<?php
session_start();
include "db_conn.php";

// Check if email and password are set
if (!isset($_POST['i_email']) || !isset($_POST['i_password'])) {
    header("Location: Guest.php");
    exit();
}

// Function to sanitize user input
function validate($data) {
    return htmlspecialchars(trim(stripslashes($data))); // Sanitize input to prevent XSS and whitespace issues
}

$i_email = validate($_POST['i_email']);
$i_password = validate($_POST['i_password']);

// Check for empty email or password
if (empty($i_email) || empty($i_password)) {
    header("Location: index.php?error=Email and password are required");
    exit();
}

// Prepare SQL statement to prevent SQL injection, selecting only necessary columns
$stmt = $conn->prepare("SELECT id, first_name, last_name, email, h_password, role FROM accounts WHERE email = ?");
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

// Bind parameters and execute
$stmt->bind_param("s", $i_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    // Verify the password using password_verify function
    if (password_verify($i_password, $row['h_password'])) {
        // Store user data in session variables
        $_SESSION['username'] = $row['first_name'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Redirect based on user role
        $redirectMap = [
            'Admin' => 'Admin/Dashboard.php',
            'IT_Support' => 'Manage_Ticket/Recieved_Ticket.php',
            'User' => 'User/Home.php'
        ];
        
        header("Location: " . ($redirectMap[$row['role']] ?? 'User/Home.php'));
        exit();
    } else {
        header("Location: index.php?error=Incorrect password");
        exit();
    }
} else {
    header("Location: index.php?error=User not found");
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
