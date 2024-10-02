<?php
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
        $t_status = "Pending";
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
    <header>
        <div class="top-nav">
            <h1>Logo & Name</h1>
            <div class="menu-toggle" id="menu-toggle">&#9776;</div>
            <div class="top-nav-btn">
                <a href="../index.php">Home</a>
                <a href="../about.php">About</a>
                <a href="../store.php">Store</a>
                <a href="support.php">Support</a>
                <div class="profile-icon" id="profile-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="white">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>
    
    <aside class="side-nav" id="side-nav">
        <div class="profile-icon" id="sidebar-profile-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="white">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
            </svg>
        </div>
        <a href="../index.php">Home</a>
        <a href="../about.php">About</a>
        <a href="../store.php">Store</a>
        <a href="support.php">Support</a>
    </aside>
    
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

            <!-- Support Form -->
            <div class="support-form-section">
                <h3>Submit a Support Request</h3>
                <form id="ticket-form">
                    <!-- Hidden field for Web3Forms access key -->
                    <input type="hidden" name="access_key" value="">

                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>

                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>

                    <label for="phone_num">Phone Number</label>
                    <input type="text" id="phone_num" name="phone_num" required>

                    <label for="type">Ticket Type</label>
                    <select id="type" name="type" required>
                        <option value="Technical">Technical</option>
                        <option value="Mechanical">Mechanical</option>
                        <option value="Billing">Billing</option>
                        <option value="Assist_Req">Assistance Request</option>
                    </select>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>

                    <button class="submit-button" type="submit">Submit Ticket</button>
                </form>
                <div id="result"></div> <!-- Result display -->
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Quick Links</h4>
                <a href="support.php">FAQs</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
            </div>
            <div class="footer-section">
                <h4>Contact Info</h4>
                <p>Email: contact@example.com</p>
                <p>Phone: +123 456 7890</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
            <a href="#" class="back-to-top">Back to Top</a>
        </div>
    </footer>
    <script src="../js/script.js"></script>
    <script>
        const form = document.getElementById('ticket-form'); // Corrected ID
        const result = document.getElementById('result');

        form.addEventListener('submit', function(e) {
            e.preventDefault();  // Prevent the default form submission
            const formData = new FormData(form);
            const jsonObject = Object.fromEntries(formData);
            const json = JSON.stringify(jsonObject);

            result.innerHTML = "Submitting, please wait...";

            // Send data to Web3Forms API
            fetch('https://api.web3forms.com/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: json
            })
            .then(async (response) => {
                let web3Json = await response.json();
                if (response.status === 200) {
                    result.innerHTML = "Form submitted to Web3Forms successfully!";
                } else {
                    result.innerHTML = "Web3Forms: " + web3Json.message;
                }
            })
            .catch(error => {
                result.innerHTML = "Web3Forms submission failed!";
                console.error(error);
            });

            fetch('send-data.php', {  // Ensure this path is correct
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: json
            })
            .then(async (response) => {
                const phpJson = await response.json();
                if (phpJson.success) {
                    result.innerHTML += "<br>Data also saved to the database successfully!";
                } else {
                    result.innerHTML += "<br>Database error: " + phpJson.message;
                }
            })
            .catch(error => {
                result.innerHTML += "<br>Failed to save data to the database.";
                console.error(error);
            });

            form.reset(); 
        });
    </script>


</body>
</html>
