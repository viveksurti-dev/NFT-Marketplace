<?php
$mail->addAddress($email, $username);
$mail->Subject = "Wallet Password Reset Request";
$mail->isHTML(true);
$mail->Body = "<html>
        <body style='margin: 0; padding: 0;'>
            <div>
                <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                    <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                        Wallet Password Reset Request
                    </div>
                    <hr style='width: 98%; margin: 25px 0px;' />
                    <div>
                        Dear $username, <br />

                        We have received a request to reset your wallet password. If you did not make this request, you can ignore this email.<br /><br />

                        To reset your wallet password, please click the button below:<br />
                        <a href='http://localhost/nft/Trans/ResetCradantial.php?token=$enEmail' style='background-color:#4CAF50; border:none; color:white; padding:15px 32px; text-align:center; text-decoration:none; display:inline-block; font-size:16px; margin:4px 2px; cursor:pointer; border-radius:5px;'>Reset Wallet Password</a><br /><br />

                        This link will expire in 24 hours for security reasons.<br /><br />

                        If you have any questions or need further assistance, please contact our support team at <a href='mailto: nftmarketplace.acs@gmail.com'>nftmarketplace.acs@gmail.com</a>.<br /><br />

                        Please note that we will never ask for your wallet password or any sensitive information via email. If you receive any suspicious emails claiming to be from us, do not click on any links and report it to us immediately.<br /><br />

                        Thank you for choosing our service.<br /><br />

                        Best regards,<br />
                        NFT Marketplace
                    </div>
                </div>
            </div>
        </body>
    </html>";
$mail->AltBody = 'Wallet Password Reset Request: Please visit the provided link to reset your wallet password.';
$mail->send();
