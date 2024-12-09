<?php
$f_email = $_POST["f_email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 5);

$mysqli = require __DIR__ . "/db_conn.php";

$sql = "UPDATE accounts
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli = $conn->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $f_email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("mdjbikes23@gmail.com");
    $mail->addAddress($f_email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 30px auto;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header h2 {
                color: #333;
            }
            .content {
                font-size: 16px;
                line-height: 1.5;
                color: #555;
                margin-bottom: 20px;
            }
            .content a {
                color: #007bff;
                text-decoration: none;
            }
            .content a:hover {
                text-decoration: underline;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #888;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>Password Reset Request</h2>
            </div>
            <div class="content">
                <p>Hello,</p>
                <p>We received a request to reset your password. Please click the link below to reset your password:</p>
                <p><a href="https://gomemdj.online/reset-password.php?token=$token">Reset Your Password</a></p>
                <p>If you did not request this change, please ignore this email.</p>
            </div>
            <div class="footer">
                <p>Best regards, <br> MDJ Bikes Team</p>
            </div>
        </div>
    </body>
    </html>
    END;

    try {
        $mail->send();

        header("Location: index.php?reset_success=true");
        exit;
    } catch (Exception $e) {
        header("Location: index.php?Mailer error: {$mail->ErrorInfo}");
        exit;
    }
} else {
    header("Location: index.php?reset_failed=true");
    exit;
}
?>