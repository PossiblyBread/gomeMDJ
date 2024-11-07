<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming you have stored the user's email in the session when they log in
$currentUserEmail = $_SESSION['email']; // Get the current session's email

// Modify the SQL query to order by date_time_created in descending order
$sql = "SELECT serial_num, first_name, last_name, user_email, phone_num, t_status, description, date_time_created FROM tickets WHERE user_email = ? ORDER BY date_time_created DESC";
$stmt = $conn->prepare($sql); // Prepare statement
$stmt->bind_param("s", $currentUserEmail); // Bind the current user email
$stmt->execute(); // Execute the prepared statement
$notif_result = $stmt->get_result(); // Get the result set from the executed statement

function formatDateTime($dateTime) {
    $date = new DateTime($dateTime);
    return $date->format('F j, Y h:i A'); // Format: Month Day, Year HH:MM AM/PM
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        .notif-box {
            background-color: #f9f9f9; /* Light background */
            color: #333; /* Dark text color */
            padding: 7px;
            border-radius: 8px;
            border: 1px solid #ccc; /* Lighter border */
            max-width: 600px;
            overflow-y: auto;
            margin: 20px auto;
            max-height: 400px;
        }
        .Notif-content {
            padding: 5px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }

        .Notif-content:hover {
            background-color: #cfcccc; /* Darker background color on hover */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); /* Optional: Add a subtle shadow */
            border-radius: 8px; /* Round corners on hover */
        }
        .Notif-content:last-child {
            border-bottom: none;
        }

        /* Modal styling */
        .notification-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .notification-modal-content {
            border: 2px solid #333; /* Dark border */
            background: linear-gradient(to top left, #b1f4fc, #ffffff); /* Diagonal gradient from bottom right to top left */
            padding: 20px;
            border-radius: 8px;
            width: 70%;
            color: #333; /* Dark text color */
            min-width: 400px;
            margin-right: 1000px;
        }

        @media (max-width: 768px) {
            .notification-modal-content {
                margin-right: 0; /* Reset margin on mobile */
                width: 90%; /* Optional: make the width more responsive */
                min-width: auto; /* Optional: remove min-width for smaller screens */
            }
        }
        .close-btn {
            background-color: #333;
            color: #fff;
            width: 10px; 
            height: 10px;
            padding: 5px;
            cursor: pointer;
            border-radius: 50%;
            float: right;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="notif-box">
        <section>
            <?php if ($notif_result->num_rows > 0): ?> <!-- Check if there are notifications -->
                <?php while($notif_row = $notif_result->fetch_assoc()): ?> <!-- Fetch each notification row -->
                    <div class="Notif-content" onclick="showModal('<?php echo htmlspecialchars(json_encode($notif_row)); ?>')"> <!-- Pass the row data to modal -->
                        <p>You have submitted a ticket at <?php echo formatDateTime($notif_row['date_time_created']); ?>, your serial number is <?php echo htmlspecialchars($notif_row['serial_num']);?>.</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No notifications available.</p>
            <?php endif; ?>
        </section>
    </div>

    <!-- Modal Structure -->
    <div id="notification-modal" class="notification-modal">
        <div class="notification-modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h3>Ticket Details</h3><hr>
            <p><strong>Serial Num:</strong> <span id="modal-serial"></span></p>
            <p><strong>Name:</strong> <span id="modal-name"></span></p>
            <p><strong>Email:</strong> <span id="modal-email"></span></p>
            <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
            <p><strong>Status:</strong> <span id="modal-status"></span></p>
            <p><strong>Description:</strong> <span id="modal-description"></span></p>
            <p><strong>Date Created:</strong> <span id="modal-date"></span></p>
        </div>
    </div>

    <script>
        function showModal(rowData) {
            const data = JSON.parse(rowData);
            document.getElementById('modal-serial').innerText = data.serial_num || 'N/A';
            document.getElementById('modal-name').innerText = `${data.first_name || ''} ${data.last_name || ''}`.trim();
            document.getElementById('modal-email').innerText = data.user_email || 'N/A';
            document.getElementById('modal-phone').innerText = data.phone_num || 'N/A';
            document.getElementById('modal-status').innerText = data.t_status || 'N/A';
            document.getElementById('modal-description').innerText = data.description || 'N/A';
            document.getElementById('modal-date').innerText = data.date_time_created || 'N/A';
            document.getElementById('notification-modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('notification-modal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('notification-modal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
