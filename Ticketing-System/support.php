<?php
session_start(); // Start the session
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For the PHP AJAX request
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $phone_num = $data['phone_num'];
        $serial_num = 100;  // Assuming a fixed serial number
        $type = $data['type'];
        $description = $data['description'];
        $t_status = "new";
        $escalation_stage = "P1";

        // Insert into database
        $sql = "INSERT INTO `tickets`(`id`, `first_name`, `last_name`, `phone_num`, `serial_num`,
                                `type`, `description`, `t_status`, `escalation_stage`) 
                VALUES (NULL, '$first_name', '$last_name', '$phone_num', '$serial_num', 
                        '$type', '$description', '$t_status', '$escalation_stage')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Return success message
            echo json_encode(["success" => true, "message" => "Ticket submitted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed: " . mysqli_error($conn)]);
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - My Website</title>
    <link rel="stylesheet" href="../styles/styles.css"> <!-- Assuming the CSS styles from the template -->
</head>
<body>
    
    <?php include '../body/header.php'; ?>
    <?php include '../body/side-bar.php'; ?>
  

    <div id="overlay"></div>

    <!-- Main Content Section -->
    <main>
        <section class="support-section">
            <h2>How Can We Help You?</h2>
            <p>If you have any questions or need assistance, please don’t hesitate to reach out to us. We're here to help!</p>

            <!-- Contact Info -->
            <div class="contact-info">
                <h3>Contact Information</h3>
                <p><strong>Email:</strong> support@example.com</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Working Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</p>
            </div>

            <!-- FAQ Section -->
            <div class="faq-section">
                <h3>Frequently Asked Questions</h3>
                <div class="faq-item">
                    <h4>1. How can I track my order?</h4>
                    <p>You can track your order by visiting our tracking page and entering your order number.</p>
                </div>
                <div class="faq-item">
                    <h4>2. What is your return policy?</h4>
                    <p>We accept returns within 30 days of purchase. Please visit our returns page for more information.</p>
                </div>
                <div class="faq-item">
                    <h4>3. How do I contact customer support?</h4>
                    <p>You can reach our support team by using the contact form below, sending an email to support@example.com, or calling us at +123 456 7890.</p>
                </div>
            </div>

            <!-- Button to open the modal -->
            <?php if (isset($_SESSION['id'])): ?>
                <button id="open-support-modal-btn" class="open-modal-btn">Send Ticket</button>
            <?php else: ?>
            <?php endif; ?>

            <!-- Modal Structure -->
            <div id="support-modal" class="modal">
                <div class="modal-content">
                    <div class="support-form-section">
                        <h3>Submit a Support Request</h3>
                        <!-- Close Button (X) -->
                        <button id="close-modal-btn" class="close-modal-btn">&times;</button>
                        <form id="ticket-form">
                            <!-- Hidden field for Web3Forms access key -->
                            <input type="hidden" name="access_key" value="5bfb0bbd-0f6f-4e30-89c6-86e8cdfe0c6f">

                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>

                            <div class="form-group">
                                <label for="phone_num">Phone Number</label>
                                <input type="text" id="phone_num" name="phone_num" required>
                            </div>

                            <div class="form-group">
                                <label for="type">Ticket Type</label>
                                <select id="type" name="type" required>
                                    <option value="Technical">Technical</option>
                                    <option value="Mechanical">Mechanical</option>
                                    <option value="Billing">Billing</option>
                                    <option value="Assist_Req">Assistance Request</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" required></textarea>
                            </div>

                            <button class="submit-button" type="submit">Submit Ticket</button>
                        </form>
                        <div id="result"></div> <!-- Result display -->
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../body/footer.php'; ?>

    <script src="../scripts/modal.js"></script> <!-- Modal script -->
    <script>
        // JavaScript for the modal
        const modal = document.getElementById("support-modal");
        const openModalBtn = document.getElementById("open-support-modal-btn");
        const closeModalBtn = document.getElementById("close-modal-btn");

        // Open modal function
        openModalBtn.addEventListener("click", function () {
            modal.style.display = "block";
        });

        // Close modal function
        closeModalBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });

        // Close modal when clicking outside of it
        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        // Submit form via AJAX
        const ticketForm = document.getElementById("ticket-form");
        const resultDisplay = document.getElementById("result");

        ticketForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(ticketForm);

            // Send AJAX request
            fetch("support.php", {
                method: "POST",
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDisplay.textContent = data.message; // Show success message
                    ticketForm.reset(); // Reset form fields
                } else {
                    resultDisplay.textContent = "Error: " + data.message; // Show error message
                }
            })
            .catch(error => {
                resultDisplay.textContent = "An error occurred: " + error.message;
            });
        });
    </script>
</body>
</html>
