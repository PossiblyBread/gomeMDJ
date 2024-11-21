<?php
session_start();

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
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Assuming the CSS styles from the template -->
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
                <p><strong>Email:</strong> support@gmail.com</p>
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Working Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</p>
                <?php if ($validation_status === "Validated"): ?>
                    <br><br>
                    <button class="support-ticket-button" id="openModalButton">Submit a Ticket</button>
                <?php endif; ?>
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

                <!-- Add more FAQ items as needed -->
            </div>
        </section>
        <!-- Button to open the modal -->
        <br>
    </main>
    <!-- The Modal -->
    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalButton">&times;</span>
            <?php include 'ticket-form.php'; ?>
        </div>
    </div>
    <!-- ai chat bot -->
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
    <script>
        // JavaScript to toggle the FAQ answers with arrow rotation
        document.querySelectorAll('.faq-item').forEach(item => {
            const question = item.querySelector('h4');
            const answer = item.querySelector('p');

            // Initially hide all answers
            answer.style.maxHeight = '0';

            // Toggle answer display and rotate arrow on question click
            question.addEventListener('click', () => {
                const isExpanded = answer.classList.contains('show');

                // Close any currently open answer
                document.querySelectorAll('.faq-item p').forEach(p => {
                    p.classList.remove('show');
                    p.style.maxHeight = '0';
                });
                document.querySelectorAll('.faq-item h4').forEach(h4 => {
                    h4.classList.remove('active');
                });

                // Toggle the clicked answer and rotate arrow
                if (!isExpanded) {
                    answer.classList.add('show');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    question.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
<style>
    /* Base Styles and Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Enhanced Support Section */
    .support-section {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 2.5rem;
        background: linear-gradient(to bottom right, #ffffff, #f8fafc);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        animation: fadeIn 0.6s ease-out;
    }

    .support-section h2 {
        font-size: clamp(2rem, 5vw, 2.5rem);
        color: #1e293b;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }

    .support-section h2::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: #2563eb;
        margin: 1rem auto;
        border-radius: 2px;
    }
    .support-section p {
        text-align: center;
    }
    /* Interactive Contact Info */
    .contact-info {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 16px;
        margin: 2rem 0;
        border: 1px solid rgba(37, 99, 235, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-info p {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .contact-info p:hover {
        background: #f8fafc;
    }

    /* Enhanced FAQ Section */
    .faq-item {
        background: #ffffff;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 1rem;
        overflow: hidden;
        border: 1px solid rgba(37, 99, 235, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .faq-item h4 {
        padding: 1.5rem;
        margin: 0;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #1e293b;
        font-weight: 600;
    }

    .faq-item h4::after {
        content: '↓';
        transition: transform 0.3s ease;
    }

    .faq-item h4.active::after {
        transform: rotate(180deg);
    }

    .faq-item p {
        padding: 0 1.5rem;
        margin: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8fafc;
    }

    .faq-item p.show {
        padding: 1.5rem;
        max-height: 500px;
    }

    /* Interactive Button */
    .support-ticket-button {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        transition: all 0.3s ease;
    }

    .support-ticket-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
    }

    /* Button styles */
    .support-ticket-button {
        background-color: #6c757d; /* Gray color */
        color: white;
        border: none;
        padding: 5px 10px;
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
        margin: auto auto; 
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

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .support-section {
            padding: 1.5rem;
            margin: 1rem;
        }

        .contact-info {
            padding: 1.5rem;
        }

        .faq-item h4 {
            padding: 1.25rem;
            font-size: 1.1rem;
        }

        .support-ticket-button {
            width: 100%;
            text-align: center;
        }
        .support-ticket-button {
            margin: auto;
        }
    }
    /* Stack elements on screens smaller than 650px */
    @media (max-width: 650px) {
        .contact-info  {
            flex-direction: column; 
            text-align: center;
        }
        .contact-info p {
            flex-direction: column; 
            text-align: center;
        }

        .contact-info p strong {
            order: -1; 
            margin-bottom: 5px; 
        }

        .contact-info p .contact-detail {
            font-weight: normal; 
        }
    }
    /* Touch Device Optimizations */
    @media (hover: none) {
        .contact-info:hover {
            transform: none;
        }
        .support-ticket-button:hover {
            transform: none;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
    }
</style>