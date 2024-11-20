<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../db_conn.php";

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

// Initialize search filters
$serial_num = isset($_POST['serial_num']) ? $_POST['serial_num'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';

// Prepare base SQL query with filtering conditions
$sql = "SELECT serial_num, first_name, last_name, user_email, phone_num, t_status, description, date_time_created 
        FROM tickets 
        WHERE user_email = ?";

// Append filtering conditions if provided
$conditions = [];
$params = [$_SESSION['email']];

if ($serial_num) {
    $conditions[] = "serial_num LIKE ?";
    $params[] = "%$serial_num%";
}
if ($status) {
    $conditions[] = "t_status LIKE ?";
    $params[] = "%$status%";
}
if ($date_from) {
    $conditions[] = "date_time_created >= ?";
    $params[] = $date_from;
}
if ($date_to) {
    $conditions[] = "date_time_created <= ?";
    $params[] = $date_to;
}

if (count($conditions) > 0) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY date_time_created DESC";

// Prepare the query and bind parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tickets Status</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
    <?php include 'header.php'; ?> <!-- This includes the notification history section -->
    <?php include 'side-bar.php'; ?>
    <div id="overlay"></div>
    <br><br><br><br>
    <!-- Ticket Table Container -->
    <div class="ticket-table-container">
        <h2>Your Tickets</h2>
        <div class="ticket-search-header">
            <h2>
                <img src="../Images/Logo-dark.png" alt="Logo"> Search Your Tickets
            </h2>
            <form method="POST" action="">
                <div class="search-inputs">
                    <div class="input-group">
                        <label for="serial_num">Serial Number:</label>
                        <input type="text" name="serial_num" value="<?= htmlspecialchars($serial_num) ?>" />
                    </div>
                    <div class="input-group">
                        <label for="status">Status:</label>
                        <input type="text" name="status" value="<?= htmlspecialchars($status) ?>" />
                    </div>
                    <div class="input-group">
                        <label for="date_from">Date From:</label>
                        <input type="date" name="date_from" value="<?= htmlspecialchars($date_from) ?>" />
                    </div>
                    <div class="input-group">
                        <label for="date_to">Date To:</label>
                        <input type="date" name="date_to" value="<?= htmlspecialchars($date_to) ?>" />
                    </div>
                    <div class="input-group button-group">
                        <button type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Wrapper for Horizontal Scroll -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['serial_num']) ?></td>
                                <td><?= htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) ?></td>
                                <td><?= htmlspecialchars($row['user_email']) ?></td>
                                <td><?= htmlspecialchars($row['phone_num']) ?></td>
                                <td><?= htmlspecialchars($row['t_status']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= formatDateTime($row['date_time_created']) ?></td>
                                <td>
                                    <?php if ($row['t_status'] === 'Closed'): ?>
                                        <button class="feedback-btn" data-serial="<?= $row['serial_num'] ?>">Give Feedback</button>
                                    <?php else: ?>
                                        <span class="not-eligible">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No tickets found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Feedback Modal -->
    <div id="feedback-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>We Value Your Feedback</h2>
            <p>Please rate your experience with Ticket Serial <strong id="ticket-id"></strong></p>
            <form id="feedback-form" method="POST" action="submit_rating.php">
                <input type="hidden" name="serial_num" id="feedback-serial-num">
                <div class="rating">
                    <label>
                        <input type="radio" name="rating" value="1" required>
                        <i class="star" data-value="1">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="2">
                        <i class="star" data-value="2">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="3">
                        <i class="star" data-value="3">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="4">
                        <i class="star" data-value="4">&#9733;</i>
                    </label>
                    <label>
                        <input type="radio" name="rating" value="5">
                        <i class="star" data-value="5">&#9733;</i>
                    </label>
                </div>
                <!-- <textarea name="comments" placeholder="Leave a comment (optional)" rows="4"></textarea> -->
                <button type="submit" class="feedback-submit-btn">Submit Feedback</button>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
    <script src="../js/script.js"></script>
    <script>
        const modal = document.getElementById('feedback-modal');
            const closeBtn = document.querySelector('.close');
            const feedbackSerialNum = document.getElementById('feedback-serial-num');
            const ticketIdText = document.getElementById('ticket-id');

            document.querySelectorAll('.feedback-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const serial = button.getAttribute('data-serial');
                    feedbackSerialNum.value = serial;
                    ticketIdText.textContent = serial;
                    modal.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            window.addEventListener('click', event => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.rating .star');
            const ratingInputs = document.querySelectorAll('.rating input');

            stars.forEach((star, index) => {
                // Highlight stars on hover
                star.addEventListener('mouseover', () => {
                    highlightStars(index + 1);
                });

                // Reset highlight on mouse out
                star.addEventListener('mouseout', () => {
                    const selectedValue = getSelectedRating();
                    highlightStars(selectedValue);
                });

                // Set selected rating
                star.addEventListener('click', () => {
                    setRating(index + 1);
                });
            });

            // Highlight stars up to the given index
            function highlightStars(count) {
                stars.forEach((star, index) => {
                    if (index < count) {
                        star.style.color = '#f59e0b'; // Highlight color
                    } else {
                        star.style.color = '#ccc'; // Default color
                    }
                });
            }

            // Get the currently selected rating
            function getSelectedRating() {
                const selectedInput = Array.from(ratingInputs).find(input => input.checked);
                return selectedInput ? parseInt(selectedInput.value) : 0;
            }

            // Set the rating and ensure the corresponding input is checked
            function setRating(value) {
                ratingInputs.forEach((input, index) => {
                    input.checked = index + 1 === value;
                });
                highlightStars(value);
            }
        });

    </script>
</body>

</html>

<style>
    /* Global Styling */
    body {
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
        color: #333;
        background: linear-gradient(to top right, #a0d6e0 30%, #ecf6fe 70%);
        /* Stronger gradient */
    }

    /* Main Container */
    .ticket-table-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Main Title */
    .ticket-table-container>h2 {
        font-size: 2rem;
        color: #1e293b;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    /* Search Header */
    .ticket-search-header {
        background: #f8fafc;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }

    /* Header with Logo */
    .ticket-search-header h2 {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        color: #1e293b;
        font-size: 1.5rem;
    }

    .ticket-search-header h2 img {
        height: 40px;
        width: auto;
    }

    /* Search Form */
    .search-inputs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .input-group label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #475569;
    }

    .input-group input {
        padding: 0.875rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .input-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Button Styles */
    .button-group button {
        width: 100%;
        padding: 0.875rem;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .button-group button:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .button-group button:active {
        transform: translateY(0);
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    thead {
        background: #f8fafc;
    }

    th {
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }

    tbody tr {
        transition: background-color 0.15s ease;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    /* Status Column Styling */
    td:nth-child(5) {
        font-weight: 600;
    }

    /* Status Colors */
    .status-pending {
        color: #eab308;
    }

    .status-completed {
        color: #22c55e;
    }

    .status-processing {
        color: #3b82f6;
    }

    .status-cancelled {
        color: #ef4444;
    }

    /* Empty State */
    tr:only-child td {
        text-align: center;
        padding: 3rem;
        color: #64748b;
        font-style: italic;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .ticket-table-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .ticket-search-header {
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .ticket-table-container {
            margin: 0.5rem;
            padding: 1rem;
        }

        .ticket-search-header {
            padding: 1rem;
        }

        .ticket-search-header h2 {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .search-inputs {
            grid-template-columns: 1fr;
        }

        th,
        td {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        td:nth-child(6) {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
    .feedback-btn{
        padding: 10px 20px;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    /* Touch Device Optimizations */
    @media (hover: none) {

        .input-group input,
        .button-group button {
            font-size: 16px;
        }

        .button-group button:hover {
            transform: none;
        }
    }

    /* Loading State */
    .table-wrapper.loading {
        position: relative;
        min-height: 200px;
    }

    .table-wrapper.loading::after {
        content: "Loading...";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #64748b;
    }
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 40%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.3s ease;
    text-align: center;
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 1.5rem;
    color: #333;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover {
    color: red;
}

.rating input {
    display: none; /* Hide the radio buttons */
}

.rating .star {
    font-size: 2rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.3s ease;
}

.rating .star:hover,
.rating .star:hover ~ .star {
    color: #f59e0b; /* Hover color */
}

.rating input:checked ~ .star,
.rating .star[data-value]:hover ~ .star[data-value="1"] {
    color: #f59e0b; /* Selected color */
}


.rating input:checked ~ .star,
.rating label:hover ~ .star,
.rating label:hover .star {
    color: #f59e0b; /* Amber */
}

textarea {
    width: 90%;
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    resize: none;
}

.feedback-submit-btn {
    padding: 10px 20px;
    background-color: #3b82f6;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.feedback-submit-btn:hover {
    background-color: #2563eb;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(20%);
    }
    to {
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .modal-content {
        width: 60%;
        margin: 100px auto;
    }

    .rating .star {
        font-size: 1.5rem;
    }
}
@media (max-width: 500px) {
    .modal-content {
        width: 70%;
    }
}
</style>