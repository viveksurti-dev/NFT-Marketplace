<?php
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'nftmarketplace.acs@gmail.com';
$mail->Password   = 'jwtzexdqisfqeghp';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

$mail->setFrom('nftmarketplace.acs@gmail.com', 'NFT Marketplace');
$mail->addReplyTo('nftmarketplace.acs@gmail.com', 'NFT Marketplace');
