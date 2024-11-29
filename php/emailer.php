<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../vendor/autoload.php";

$mail = new PHPMailer(true);

// Enable verbose debug output (optional for troubleshooting)
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

// Gmail SMTP settings
$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Replace with your Gmail account credentials
$mail->Username = 'adave.amparo@gmail.com'; // Replace with your email
$mail->Password = 'vbnj ykql fuoq fnfk';    // Replace with your app password

$mail->addReplyTo('adave.amparo@gmail.com', 'Kan-anan by the Sea'); // Optional: Ensure replies show the same name
$mail->addCustomHeader('X-Priority', '3');
$mail->isHTML(true);

return $mail;
