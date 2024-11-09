<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : ''; 
$userPhoneNum = isset($_SESSION['phone_num']) ? $_SESSION['phone_num'] : ''; 

include "../db_conn.php";

// Check if the user is logged in and their session exists
if (!isset($_SESSION['id'])) {
    die("Access denied. Please log in first.");
}

$id = $_SESSION['id'];  // User ID from the session
$validation_status = '';

// Fetch validation status from the database
$sql = "SELECT validation FROM `accounts` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $validation_status = $row['validation'];  // Get validation status
} else {
    die("Error fetching user data.");
}
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
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>
  
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
                    <h4>1. What is an e-bike?</h4>
                    <p>An e-bike, or electric bike, is a bicycle equipped with an electric motor to assist with pedaling. It combines the features of a regular bike with electric power, allowing you to ride longer distances with less effort.</p>
                </div>
                <div class="faq-item">
                    <h4>2. Are e-bikes allowed on the roads in the Philippines?</h4>
                    <p>Yes, e-bikes are allowed on roads in the Philippines. However, regulations vary, so we recommend following local traffic laws and using bike lanes where possible. Some cities may have specific rules about speed limits and road access for e-bikes.</p>
                </div>
                <div class="faq-item">
                    <h4>3. Do I need a license or registration for my e-bike?</h4>
                    <p>The Land Transportation Office (LTO) in the Philippines may require registration and a valid driver’s license for certain types of e-bikes, especially those with higher power or speeds. We recommend checking with the LTO or your local government unit for specific requirements.</p>
                </div>
                <div class="faq-item">
                    <h4>4. How long does the battery of an e-bike last?</h4>
                    <p>The battery life depends on the model, usage, and terrain. On average, a full charge can last between 30 to 60 kilometers. Battery lifespan may range from 2-5 years with proper care.</p>
                </div>
                <div class="faq-item">
                    <h4>5. How much time does it take to charge an e-bike?</h4>
                    <p>Charging times vary, but most e-bike batteries take around 4-6 hours for a full charge. Some models offer faster-charging options.</p>
                </div>
                <div class="faq-item">
                    <h4>6. Where can I charge my e-bike?</h4>
                    <p>You can charge your e-bike at any standard power outlet, such as those found at home or in public charging stations. Just bring along your charger and plug it in when needed!</p>
                </div>
                <div class="faq-item">
                    <h4>7. What’s the cost of an e-bike in the Philippines?</h4>
                    <p>E-bike prices vary based on model, features, and brand. Typically, e-bikes in the Philippines range from PHP 20,000 to PHP 70,000 or more. Check our <a href="products.php">products</a> page for the latest pricing.</p>
                </div>
                <div class="faq-item">
                    <h4>8. Do you offer financing or installment plans?</h4>
                    <p>Yes, we offer financing options for select e-bike models. Payment terms may vary based on your chosen model and payment plan. Please contact our sales team for details on available installment plans.</p>
                </div>
                <div class="faq-item">
                    <h4>9. How can I purchase an e-bike from your website?</h4>
                    <p>To purchase, select your preferred model from our catalog, add it to your cart, and proceed to checkout. We offer various payment options, including credit card, debit card, and bank transfer.</p>
                </div>
                <div class="faq-item">
                    <h4>10. Do you offer repairs and maintenance services?</h4>
                    <p>Yes, we have authorized service centers and technicians across the Philippines to assist with repairs and maintenance. Contact our support team to schedule a service.</p>
                </div>
                <div class="faq-item">
                    <h4>11. Can I test-ride an e-bike before buying?</h4>
                    <p>Yes, test rides are available at select showrooms. Please check with our customer service to find a test-ride location near you.</p>
                </div>
            </div>
        </section>

        <!-- Button to open the modal -->
         <br>
         <?php if ($validation_status === "Validated"): ?>
        <br>
            <button class="support-ticket-button" id="openModalButton">Submit a Ticket</button>
        <?php endif; ?>

    </main>

    <!-- The Modal -->
    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalButton">&times;</span>
            <?php include 'ticket-form.php'; ?>
        </div>
    </div>
    <script>
        window.embeddedChatbotConfig = {
            chatbotId: "e8_c510p3vG8EPF2g33Vw",
            domain: "www.chatbase.co"
        }
    </script>
    <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="e8_c510p3vG8EPF2g33Vw"
        domain="www.chatbase.co"
        defer>
    </script>

    </script>
    <?php include 'footer.php'; ?>
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
    /* start for style faqs section */
    .faq-item a {
        color: #007BFF;
        font-weight: bold;
        position: relative;
        transition: color 0.3s ease, text-shadow 0.3s ease; 
    }

    .faq-item a:hover {
        text-decoration-color: #00b3b3;
        text-decoration-thickness: 2px; 
    }

    .faq-item a:after {
        content: '';
        position: absolute;
        bottom: -2px; 
        left: 0;
        width: 100%;
        height: 2px; 
        background-color: #00b3b3;
        transform: scaleX(0); 
        transform-origin: bottom right; 
        transition: transform 0.3s ease-out; 
    }

    .faq-item a:hover:after {
        transform: scaleX(1); 
        transform-origin: bottom left; 
    }

    /* Indent for paragraphs inside .faq-item */
    .faq-item p {
        text-indent: 40px; 
        line-height: 1.6; 
    }
    /* end css for faqs */

    /* start style for ticket button*/
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
        background-color: #5a6268;  
    }
    .modal {
        display: none; 
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); 
    }

    .modal-content {
        background-color: white;
        margin: 40px auto; 
        padding: 20px;
        border: 1px solid #888;
        border-radius: 20px;
        width: 80%; 
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