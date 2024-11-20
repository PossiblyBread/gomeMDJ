<?php
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
$currentUserEmail = $_SESSION['email']; // Get the current session's email

// Fetch tickets ordered by creation date in descending order
$sql = "SELECT serial_num, first_name, last_name, user_email, phone_num, t_status, description, date_time_created FROM tickets WHERE user_email = ? ORDER BY date_time_created DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUserEmail);
$stmt->execute();
$notif_result = $stmt->get_result();

function formatDateTime($dateTime) {
    $date = new DateTime($dateTime);
    return $date->format('F j, Y h:i A');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification History</title>
    
</head>
<body>
    <div class="notif-box">
        <section>
            <?php if ($notif_result->num_rows > 0): ?>
                <?php while($notif_row = $notif_result->fetch_assoc()): ?>
                    <div class="Notif-content" onclick="showModal('<?php echo htmlspecialchars($notif_row['serial_num']); ?>')">
                        <div class="notif-text">
                            <p>You have submitted a ticket at <?php echo formatDateTime($notif_row['date_time_created']); ?>, your serial number is <?php echo htmlspecialchars($notif_row['serial_num']);?>.</p>
                        </div>
                        <div class="history-btn-column">
                            <button class="history-btn" onclick="showActionModal(event, '<?php echo htmlspecialchars($notif_row['serial_num']); ?>')">View</button>
                        </div>
                    </div>
                    <!-- Modal for ticket details -->
                    <div id="modal-<?php echo htmlspecialchars($notif_row['serial_num']); ?>" class="notification-modal">
                        <div class="notification-modal-content">
                            <span class="close-btn" onclick="closeModal('<?php echo htmlspecialchars($notif_row['serial_num']); ?>')">×</span>
                            <h3>Ticket Details</h3><hr>
                            <p><strong>Serial Num:</strong> <?php echo htmlspecialchars($notif_row['serial_num']); ?></p>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($notif_row['first_name']) . ' ' . htmlspecialchars($notif_row['last_name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($notif_row['user_email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($notif_row['phone_num']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($notif_row['t_status']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($notif_row['description']); ?></p>
                            <p><strong>Date Created:</strong> <?php echo formatDateTime($notif_row['date_time_created']); ?></p>
                        </div>
                    </div>
                    <!-- Action Modal for updates history -->
                    <div id="action-modal-<?php echo htmlspecialchars($notif_row['serial_num']); ?>" class="action-modal">
                        <div class="action-modal-content">
                            <span class="close-btn" onclick="closeActionModal('<?php echo htmlspecialchars($notif_row['serial_num']); ?>')">×</span>
                            <h3>Ticket History</h3><hr>
                            <p>History of updates for ticket serial number: <?php echo htmlspecialchars($notif_row['serial_num']); ?></p>
                            <ul class="update-list">
                                <?php
                                // Fetch updates from tickets_updates table for the current serial_num
                                $updateSql = "SELECT t_status, date_time_updated FROM tickets_updates WHERE serial_num = ? ORDER BY date_time_updated DESC";
                                $updateStmt = $conn->prepare($updateSql);
                                $updateStmt->bind_param("s", $notif_row['serial_num']);
                                $updateStmt->execute();
                                $updateResult = $updateStmt->get_result();
                                
                                // Loop through and display each update
                                if ($updateResult->num_rows > 0):
                                    while($updateRow = $updateResult->fetch_assoc()):
                                ?>
                                    <li class="update-item">
                                        <strong>Status:</strong> <?php echo htmlspecialchars($updateRow['t_status']); ?><br>
                                        <strong>Updated On:</strong> <?php echo formatDateTime($updateRow['date_time_updated']); ?>
                                    </li>
                                <?php 
                                    endwhile;
                                else: 
                                ?>
                                    <li class="update-item">No updates available for this ticket.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No notifications available.</p>
            <?php endif; ?>
        </section>
    </div>

    <script>
        function showModal(serialNum) {
            const modal = document.getElementById('modal-' + serialNum);
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeModal(serialNum) {
            const modal = document.getElementById('modal-' + serialNum);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function showActionModal(event, serialNum) {
            event.stopPropagation();
            const modal = document.getElementById('action-modal-' + serialNum);
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeActionModal(serialNum) {
            const modal = document.getElementById('action-modal-' + serialNum);
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
<style>
/* General notification box and modals */
.notif-box {
    background-color: #f9f9f9;
    color: #333;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    max-width: 600px;
    overflow-y: auto;
    margin: 20px auto;
    max-height: 400px;
}

.Notif-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border-bottom: 1px solid #e0e0e0;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.Notif-content:hover {
    background-color: #cfcccc;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
}

.Notif-content:last-child {
    border-bottom: none;
}

.notif-text {
    flex: 1;
}

.history-btn-column {
    display: flex;
    justify-content: center;
    align-items: center;
}

.history-btn {
    background-color: #333;
    color: #fff;
    padding: 5px 10px;
    margin-left: 7px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9em;
    transition: background-color 0.3s ease;
}

.history-btn:hover {
    background-color: #555;
}

/* Modal styling */
.notification-modal, .action-modal {
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

/* Ensure modal content doesn't overflow horizontally */
.notification-modal-content, .action-modal-content {
    position: relative;
    border: 2px solid #333;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    width: 450px;
    max-width: 600px;
    max-height: 500px;
    overflow-y: auto; 
    color: #333;
    margin-top: 100px;
    transform: translateX(-50%);
    box-sizing: border-box;
    overflow-x: hidden;
}

/* Modal content responsiveness for mobile */
@media (max-width: 768px) {
    .notification-modal-content, .action-modal-content {
        width: 400px;
        max-width: 90%;
        margin-top: 20px; /* Adjust margin-top for mobile */
        margin-right: 0;
        transform: translateX(0);  /* Adjust modal position */
    }

    /* Close button for mobile adjustments */
    .close-btn {
        font-size: 1.5em;
        top: 15px;
        right: 15px;
    }
}

/* Close button styling */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #333;
    color: #fff;
    width: 20px;
    height: 20px;
    padding: 0;
    cursor: pointer;
    border-radius: 50%;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Update list styling */
.update-list {
    list-style-type: none;
    padding: 0;
}

.update-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.update-item:last-child {
    border-bottom: none;
}

/* Additional modal elements */
h3 {
    font-size: 1.4em;
    color: #333;
    font-weight: bold;
}

hr {
    margin: 10px 0;
    border: 1px solid #ddd;
}

p {
    margin: 5px 0;
    font-size: 1em;
}

</style>