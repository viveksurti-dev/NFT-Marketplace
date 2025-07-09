<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $name = $_POST['username'];

    $otp = mt_rand(100000, 999999);
    session_start();
    $_SESSION['otp'] = $otp;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nftmarketplace.acs@gmail.com';
        $mail->Password   = 'jwtzexdqisfqeghp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('nftmarketplace.acs@gmail.com', 'NFT Marketplace');
        $mail->addReplyTo('nftmarketplace.acs@gmail.com', 'NFT Marketplace');


        // Email content
        $mail->addAddress("$email", "$name");
        $mail->isHTML(true);
        $mail->Subject = "Registration Code : " . $otp;
        $uniqueClass = 'email_' . uniqid();

        $mail->Body = "<html>
                            <head>
                                <style>
                                    .heading.$uniqueClass {
                                        font-size:115%;
                                    }
                                    h5.$uniqueClass {
                                        margin:0;
                                        padding:0;
                                        font-size:150%;
                                    }
                                    .card.$uniqueClass {
                                        border: 1px solid #ccc;
                                        border-radius: 5px;
                                        padding: 20px;
                                    }
                                    .text-center.$uniqueClass {
                                        text-align: center;
                                    }
                                    .mt-3.$uniqueClass {
                                        margin-top: 15px;
                                    }
                                    .mt-2.$uniqueClass {
                                        margin-top: 10px;
                                    }
                                    .mb-2.$uniqueClass {
                                        margin-bottom: 10px;
                                    }
                                    .small.$uniqueClass {
                                        font-size: 80%;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <div class='card $uniqueClass'>
                                        <div class='text-center $uniqueClass'>
                                            <p class='heading $uniqueClass'>NFT Marketplace</p>
                                            <h5 class='$uniqueClass'>Verify Your Email</h5>
                                        </div>
                                        <hr class='w-100 mt-3 mb-3 $uniqueClass' />
                                        <div>
                                            <div>NFT Marketplace received a request to verify OTP for <strong>" . $email . "</strong>.</div>
                                            <div class='mt-3 $uniqueClass'>Use this code to finish setting up your account:</div>
                                            <h5 class='mt-2 mb-2 text-center $uniqueClass'>$otp</h5>
                                            <div><small class='$uniqueClass'>This code will expire in 2 minutes.</small></div>
                                        </div>
                                    </div>
                                </div>
                            </body>
                        </html>";


        $mail->AltBody = 'Your OTP for registration is: ' . $otp;

        // Send email
        $mail->send();
        echo 'OTP sent successfully';
    } catch (Exception $e) {
        echo "Failed to send OTP. Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid request';
}
