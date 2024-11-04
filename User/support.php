<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : ''; 
$userPhoneNum = isset($_SESSION['phone_num']) ? $_SESSION['phone_num'] : ''; 

include "../db_conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - My Website</title>
    <link rel="stylesheet" href="../styles/styles.css">  <!-- Assuming the CSS styles from the template -->
</head>
<body>
    <?php include '../body/logged/header.php'; ?>
    <?php include '../body/logged/side-bar.php'; ?>
  
    <div id="overlay"></div>
    <br><br> <br> 
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
        </section>

        <!-- Button to open the modal -->
         <br>
        <button class="support-ticket-button" id="openModalButton">Submit a Ticket</button>
    </main>

    <!-- The Modal -->
    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalButton">&times;</span>
            <?php include '../body/logged/ticket-form.php'; ?>
        </div>
    </div>

    <?php include '../body/logged/footer.php'; ?>
    <script>
        // Get modal element
        const modal = document.getElementById('ticketModal');

        // Get open modal button
        const openModalButton = document.getElementById('openModalButton');

        // Get close button
        const closeModalButton = document.getElementById('closeModalButton');

        // Listen for open click
        openModalButton.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        // Listen for close click
        closeModalButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Listen for outside click
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
<style>
     /* Button styles */
     .support-ticket-button {
        background-color: #6c757d; /* Gray color */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
        margin: 0 0 40px 60px;
    }

    .support-ticket-button:hover {
        background-color: #5a6268; /* Darker gray on hover */
    }
    .modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */
    }

    .modal-content {
        background-color: white;
        margin: 40px auto; /* 200px from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 20px;
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 500px;
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