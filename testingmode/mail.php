<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
$mail = new PHPMailer(true);

try {
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nftmarketplace.acs@gmail.com';
    $mail->Password   = 'jwtzexdqisfqeghp';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('nftmarketplace.acs@gmail.com', 'NFT Marketplace');
    $mail->addAddress('viveksurati17@gmail.com', 'Joe User');   // Add a recipient
    $mail->addReplyTo('nftmarketplace.acs@gmail.com', 'NFT Marketplace');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Successful Registation';
    $mail->Body    = 'Your Registration Code Is 112233';
    $mail->AltBody = 'This is the mail for your success full registration';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
