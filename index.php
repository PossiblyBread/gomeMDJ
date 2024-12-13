<?php
session_start();
include "db_conn.php";

if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg'], ENT_QUOTES, 'UTF-8');
    echo '<script>
            alert("' . htmlspecialchars($_GET['msg']) . '");
            
            Swal.fire({
                position: "center",
                icon: "success",
                title: "' . $msg . '",
                showConfirmButton: false,
                timer: 1500
              });
          </script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDJ</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'side-bar.php'; ?>

    <div id="overlay"></div>
    <br><br><br>
    <section class="main-section">
        <div class="content-container">
            <div class="left-column">
                <div class="top-text">Your Next</div>
                <div class="bigName">
                    <div class="big-text">Ride Awaits</div>
                    <hr>
                </div>
                <div class="inner-section">
                    <br>
                    <p>Your journey starts here. Explore, Inquire and connect
                        with trusted E-bike support tailored to your needs.</p>
                </div>
                <div class="inner-section">
                    <h3></h3>
                </div>
                <button class="Pre-Registered" id="register-button" onclick="showRegisterModal()"><strong>Register  </strong></button>
            </div>
            <div class="right-column">
                <div class="inner-section">
                    <img src="Images/ebikeModel.png" class="ebikeImage">
                </div>
            </div>
        </div>
    </section>

    <!-- Success Modal for Register -->
    <div id="registerSuccessModal" class="resetPasswordModal">
        <div class="modal-content">
            <span class="close" id="closeRegisterSuccessModal">&times;</span>
            <strong>Registration Successful!</strong>
            <p>Your account has been created successfully.</p>
        </div>
    </div>

    <!-- Success Modal for Password Reset -->
    <div id="resetPasswordModal" class="resetPasswordModal">
        <div class="modal-content">
            <span class="close" id="closeResetPasswordModal">&times;</span>
            <strong>Success!</strong>
            <p>The link to reset your password has been sent to the email you have provided!</p>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="forgot-password-modal-error" class="resetPasswordModal">
        <div class="modal-content">
            <span class="close" id="closeErrorModal">&times;</span>
            <strong>Oops!</strong>
            <p>Make sure the email you have provided is correct or is registered in our website!</p>
        </div>
    </div>

    <!-- Main Content Section -->
    <main>
        <hr>
        <section class="features">
            <p>Promos</p>
            <?php include 'displayPromo.php'; ?>
        </section>
        <hr>
    </main>

    <!-- What's New Section Integration -->
    <section class="whats-new-section">
        <div class="whats-new-section-container">
            <div class="whats-new-section-left">
                <h2>What’s New?</h2>
                <p>Discover our latest updates and features available to enhance your experience. From new product launches to exciting offers, stay ahead!</p>
            </div>
            <div class="whats-new-section-right">
                <h2>New Features</h2>
                <p>Explore the new range of E-bikes with improved battery life and cutting-edge technology designed to give you the best ride. Check out our latest arrivals now!</p>
            </div>
        </div>
    </section>
    
    <?php include 'footer.php'; ?>
    
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/script.js"></script>
    <script src="js/Otp_script.js"></script>
    
    <script>
        // Show the Register Success Modal
        function showRegisterSuccessModal() {
            var modal = document.getElementById("registerSuccessModal");
            modal.style.display = "block";
        }

        // Show the Reset Password Success Modal
        function showResetPasswordModal() {
            var modal = document.getElementById("resetPasswordModal");
            modal.style.display = "block";
        }

        // Show the Error Modal
        function showErrorModal() {
            var modal = document.getElementById("forgot-password-modal-error");
            modal.style.display = "block";
        }

        // Close the modal when the user clicks the 'X'
        document.getElementById("closeRegisterSuccessModal").onclick = function() {
            document.getElementById("registerSuccessModal").style.display = "none";
        }

        document.getElementById("closeResetPasswordModal").onclick = function() {
            document.getElementById("resetPasswordModal").style.display = "none";
        }

        // Close the error modal when the user clicks the 'X'
        document.getElementById("closeErrorModal").onclick = function() {
            document.getElementById("forgot-password-modal-error").style.display = "none";
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            var successModal = document.getElementById("registerSuccessModal");
            var resetModal = document.getElementById("resetPasswordModal");
            var errorModal = document.getElementById("forgot-password-modal-error");

            if (event.target == successModal) {
                successModal.style.display = "none";
            }
            if (event.target == resetModal) {
                resetModal.style.display = "none";
            }
            if (event.target == errorModal) {
                errorModal.style.display = "none";
            }
        }

        // Check URL parameters to show the correct modal
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);

            // Show registration success modal if register_success is true
            if (urlParams.has('register_success') && urlParams.get('register_success') === 'true') {
                showRegisterSuccessModal();
            }

            // Show reset password success modal if reset_success is true
            if (urlParams.has('reset_success') && urlParams.get('reset_success') === 'true') {
                showResetPasswordModal();
            }

            // Show error modal if reset_failed is true
            if (urlParams.has('reset_failed') && urlParams.get('reset_failed') === 'true') {
                showErrorModal();
            }
        }
    </script>
</body>

</html>

<style>
    #password-strength-message {
        text-align: center;
        font-weight: bold;
        transition: color 0.3s ease;
        margin-bottom: 15px;
    }

    .weak {
        color: red;
    }

    .medium {
        color: orange;
    }

    .strong {
        color: green;
    }

    /* Modal Styles */
    .resetPasswordModal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .resetPasswordModal .modal-content {
        background-color: #add8e6; /* Light blue color */
        margin: 200px auto 15% auto; /* Added 200px top margin */
        max-width: 500px;
        padding: 20px;
        border: 2px solid #1b212f;
        width: 80%;
        border-radius: 30px;
        text-align: center;
    }

    .resetPasswordModal .close {
        margin-top: -10px;
        color: maroon;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .resetPasswordModal .close:hover,
    .resetPasswordModal .close:focus {
        color: red;
        text-decoration: none;
        cursor: pointer;
    }
</style>
