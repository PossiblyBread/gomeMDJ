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
                    <img src=Images/ebikeModel.png class="ebikeImage">
                </div>
            </div>

        </div>
    </section>
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
</style>
