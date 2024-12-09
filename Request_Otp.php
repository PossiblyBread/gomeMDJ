<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$config = require 'Admin/Admin_Config.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired']);
    exit();
}

// Generate OTP first
$otp = sprintf("%06d", random_int(0, 999999));
$_SESSION['otp'] = strval($otp);
$_SESSION['otp_expiry'] = time() + 120; //timer 

// Configure mailer with optimized settings
$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = $config['smtp']['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp']['username'];
    $mail->Password = $config['smtp']['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $config['smtp']['port'];

    // Performance optimizations
    $mail->SMTPKeepAlive = true; // Keep connection alive
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Recipients
    $mail->setFrom($config['smtp']['username'], 'MDJ E-Bikes - OTP Verification Code');
    $mail->addAddress($_SESSION['email']);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'One-Time Password VerificationCode - MDJ E-Bikes';

    // Professional email template with clean design
    $mail->Body = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; background: #ffffff; color: #333333; border: 1px solid #dddddd; border-radius: 8px;'>
        <h1 style='text-align: center; color: #333333; margin-bottom: 10px;'>MDJ E-Bikes</h1>
        <h2 style='text-align: center; color: #333333; margin-bottom: 20px;'>One-Time Password Verification</h2>
        <p style='text-align: center; color: #666666; margin-bottom: 25px;'>Dear Valued Customer,</p>
        <p style='text-align: center; color: #666666; margin-bottom: 25px;'>Please use the following verification code to complete your login process:</p>
        <div style='background: #f5f5f5; padding: 20px; border-radius: 8px; text-align: center; margin: 25px 0;'>
            <div style='font-size: 32px; letter-spacing: 8px; color: #333333; font-weight: bold;'>{$otp}</div>
            <p style='margin-top: 15px; color: #666666;'>This code will expire in 2 minutes</p>
        </div>
        <div style='border-top: 1px solid #eeeeee; margin-top: 30px; padding-top: 20px;'>
            <p style='color: #666666; font-size: 14px; text-align: center;'>For your security:</p>
            <ul style='color: #666666; font-size: 14px;'>
                <li>Never share this code with anyone</li>
                <li>Our staff will never ask for this code</li>
                <li>If you didn't request this code, please contact our support team immediately</li>
            </ul>
        </div>
        <p style='text-align: center; color: #999999; font-size: 12px; margin-top: 30px;'>This is an automated message, please do not reply to this email.</p>
    </div>";

    $mail->send();
    echo json_encode(['status' => 'OTP sent', 'otp_expiry' => $_SESSION['otp_expiry']]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Mail error: ' . $mail->ErrorInfo]);
}

session_write_close();
