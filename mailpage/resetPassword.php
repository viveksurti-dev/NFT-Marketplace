<?php
$mail->addAddress($deEmail, $username);
$mail->Subject = "Password Reset Successful";
$mail->isHTML(true);
$mail->Body = "<html>
        <body style='margin: 0; padding: 0;'>
            <div>
                <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                    <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                        Password Reset Successful
                    </div>
                    <hr style='width: 98%; margin: 25px 0px;' />
                    <div>
                        Dear $username, <br />

                        Your account password has been successfully reset.<br /><br />

                        If you did not make this change, please contact us immediately.<br /><br />

                        If you have any questions or need further assistance, please contact our support team at <a href='mailto: nftmarketplace.acs@gmail.com'>nftmarketplace.acs@gmail.com</a>.<br /><br />

                        We appreciate your patience and cooperation during this process. <br /><br />

                        Here are some tips to keep your account secure:<br />
                        - Regularly update your password<br />
                        - Avoid using common passwords<br />
                        - Be cautious of phishing emails<br /><br />

                        Thank you for choosing our service and ensuring the security of your account.<br /><br />

                        Best regards,<br />
                        NFT Marketplace
                    </div>
                </div>
            </div>
        </body>
    </html>";
$mail->AltBody = 'Password Reset Successful: Your account password has been successfully reset. If you have any questions or need further assistance, please contact our support team at nftmarketplace.acs@gmail.com. Best regards, NFT Marketplace';
$mail->send();
