<?php
// Start the session
session_start();

include "../db_conn.php"; 

$it_support_query = "
    SELECT a.first_name, a.last_name, a.email, 
           (SELECT COUNT(*) FROM ticket_assigned t WHERE t.assigned_to_email = a.email) AS ticket_count 
    FROM accounts a 
    WHERE a.role = 'IT_Support'
";

$it_support_result = mysqli_query($conn, $it_support_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support Accounts</title>
    <link rel="stylesheet" href="styles.css"> <!-- Adjust to your CSS file -->
</head>
<body>



</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
