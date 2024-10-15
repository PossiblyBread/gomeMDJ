<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$userFirstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userLastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

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
    </main>

    <?php include '../body/logged/footer.php'; ?>
    <script src="../js/script.js"></script> <!-- Modal script -->
</body>
</html>
<style>
    
/* support page content */
.support-section {
    padding: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.support-section h2 {
    font-size: 36px;
    margin-bottom: 20px;
    text-align: center;
}

.support-section p {
    font-size: 18px;
    text-align: justify;
}

.contact-info, .faq-section, .support-form-section {
    margin-top: 40px;
}

.faq-section h3, .support-form-section h3 {
    margin-bottom: 20px;
    font-size: 28px;
}

.faq-item h4 {
    font-size: 20px;
    margin-bottom: 10px;
}

.faq-item p {
    font-size: 16px;
    line-height: 1.6;
}

/* ticketing support part */

/* Modal Button */
.open-modal-btn {
    background-color: #666;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 1rem;
    margin: 20px;
}

.open-modal-btn:hover {
    background-color: #444;
}

/* Modal Background */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    padding: 10px;
}

/* Modal Content */
.modal-content {
    background-color: #fff;
    top: -25px;
    margin: 0 auto; /* Center horizontally */
    padding: 15px; /* Consistent padding */
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 80%;
    max-width: 450px; /* Control width */
    max-height: 85%; /* Adjusted to give more vertical space */
    height: auto; /* Allow auto height */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow-y: auto; /* Keeps the content scrollable if necessary */
}

/* Close (X) Button */
.close-modal-btn {
    position: absolute;
    top: -10px; /* Align with heading */
    right: 15px;
    background: #888; /* Background color for visibility */
    border: 2px solid #666; /* Border for better definition */
    border-radius: 50%; /* Make it circular */
    width: 30px; /* Size of the button */
    height: 30px; /* Size of the button */
    font-size: 1.5rem; /* Size of the 'X' */
    color: #fff; /* Text color */
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease; /* Smooth transitions */
    display: flex; /* Center the 'X' */
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
}

.close-modal-btn:hover {
    background: #666; /* Darker on hover */
    transform: scale(1.1); /* Slightly enlarge on hover */
}

/* Support Form Section */
.support-form-section {
    position: relative; /* Needed for absolute positioning of close button */
}

.support-form-section h3 {
    color: #333;
    margin-top: -25px; /* Removed margin for top alignment */
    margin-bottom: 25px; /* Adjust as needed */
    font-size: 1.5rem;
    display: inline-block; /* Keeps heading inline */
}

.form-group {
    margin-top: 5px; /* Adjust this value for form groups */
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    color: #555;
    margin-bottom: 5px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #eaeaea;
    color: #333;
    font-size: 1rem;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #888;
    outline: none;
}

/* Submit Button */
.submit-button {
    background-color: #888;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 1rem;
    display: inline-block; /* Ensures button behaves like a block-level element */
}

.submit-button:hover {
    background-color: #666;
}

/* Center Submit Button on Larger Screens */
@media (min-width: 1025px) {
    .form-group {
        text-align: center; /* Center the submit button */
    }

    .submit-button {
        font-size: 1.1rem;
        padding: 12px 20px;
        width: auto; /* Keep the button size appropriate */
    }
}

/* Result Section */
#result {
    margin-top: 15px;
    font-size: 14px;
    color: #333;
}

/* Media Queries for Responsiveness */

/* Mobile phones (portrait) */
@media (max-width: 460px) {
    .open-modal-btn {
        width: 90%;
        font-size: 1rem;
        padding: 12px 0;
        margin: 10px 0;
    }

    .modal-content {
        width: 75%;
        margin: 10% auto;
        padding: 30px;
        max-height: 85%; /* Height for mobile */
    }

    .support-form-section h3 {
        font-size: 1.25rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        font-size: 0.9rem;
    }

    .submit-button {
        width: 100%;
        font-size: 1rem;
        padding: 12px 0;
    }
}

/* Tablets and small laptops */
@media (min-width: 460px) and (max-width: 1024px) {
    .open-modal-btn {
        font-size: 1.1rem;
        padding: 12px 20px;
    }

    .modal-content {
        width: 85%;
        margin: 8% auto;
        padding: 20px;
        max-height: 85%; /* Adjusted for more space */
    }

    .support-form-section h3 {
        font-size: 1.5rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        font-size: 1rem;
    }

    .submit-button {
        font-size: 1rem;
        padding: 12px 15px;
    }
}

/* Larger screens (desktops) */
@media (min-width: 1025px) {
    .open-modal-btn {
        font-size: 1.2rem;
        padding: 12px 25px;
    }

    .modal-content {
        width: 60%;
        margin: 5% auto; /* Keep this for higher positioning */
        max-height: 85%; /* Allow more vertical space */
    }

    .support-form-section h3 {
        font-size: 1.75rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        font-size: 1.1rem;
    }

    .submit-button {
        font-size: 1.1rem;
        padding: 12px 20px;
    }
}

</style>