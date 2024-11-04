<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Request Form</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional: Link to your CSS file -->
    <style>
        /* Basic styles for modal */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ticket Request Form</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="serial_num">Ticket Serial Number:</label>
                <input type="text" id="serial_num" name="serial_num" required>
            </div>
            <div class="form-group">
                <label for="user_email">Your Email:</label>
                <input type="email" id="user_email" name="user_email" required>
            </div>
            <button type="submit">Submit Request</button>
        </form>

        <!-- Modal for displaying ticket details -->
        <div id="ticketModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Ticket Details</h3>
                <div id="ticketInfo"></div>
            </div>
        </div>

        <?php
        // Database connection
        include '../../db_conn.php'; // Ensure this points to your actual DB connection file

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $serial_num = $_POST['serial_num'];
            $user_email = $_POST['user_email'];

            // Prepare the SQL statement to search for the ticket
            $stmt = $conn->prepare("SELECT * FROM `tickets` WHERE `serial_num` = ? AND `user_email` = ?");
            $stmt->bind_param("ss", $serial_num, $user_email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if a ticket was found
            if ($result->num_rows > 0) {
                // Fetch the ticket details
                $ticketDetails = "";
                while ($row = $result->fetch_assoc()) {
                    $ticketDetails .= "<p><strong>First Name:</strong> " . htmlspecialchars($row['first_name']) . "</p>";
                    $ticketDetails .= "<p><strong>Last Name:</strong> " . htmlspecialchars($row['last_name']) . "</p>";
                    $ticketDetails .= "<p><strong>Email:</strong> " . htmlspecialchars($row['user_email']) . "</p>";
                    $ticketDetails .= "<p><strong>Phone Number:</strong> " . htmlspecialchars($row['phone_num']) . "</p>";
                    $ticketDetails .= "<p><strong>Type:</strong> " . htmlspecialchars($row['type']) . "</p>";
                    $ticketDetails .= "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                    $ticketDetails .= "<p><strong>Status:</strong> " . htmlspecialchars($row['t_status']) . "</p>";
                    $ticketDetails .= "<p><strong>Assigned To:</strong> " . htmlspecialchars($row['assigned_to']) . "</p>";
                    $ticketDetails .= "<p><strong>Priority:</strong> " . htmlspecialchars($row['priority']) . "</p>";
                    $ticketDetails .= "<p><strong>Severity:</strong> " . htmlspecialchars($row['severity']) . "</p>";
                    $ticketDetails .= "<p><strong>Escalation:</strong> " . htmlspecialchars($row['escalation']) . "</p>";
                }

                // Output ticket details to be displayed in the modal
                echo "<script>
                        document.getElementById('ticketInfo').innerHTML = '$ticketDetails';
                        var modal = document.getElementById('ticketModal');
                        modal.style.display = 'block';
                    </script>";
            } else {
                echo "<script>alert('No ticket found with the provided serial number and email.');</script>";
            }

            // Close the statement
            $stmt->close();
        }
        ?>
    </div>

    <script>
        // Modal script
        var modal = document.getElementById("ticketModal");
        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
