<?php
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = '' // Enter Your Email;
$mail->Password   = '' //Enter Your Security Pass Key;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

$mail->setFrom('nftmarketplace.acs@gmail.com', 'NFT Marketplace');
$mail->addReplyTo('nftmarketplace.acs@gmail.com', 'NFT Marketplace');
