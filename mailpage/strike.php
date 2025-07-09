<?php
$mail->addAddress($email, $username);
$mail->Subject = "Strike Successfully Removed";
$mail->isHTML(true);
$mail->Body = "<html>
        <body style='margin: 0; padding: 0;'>
            <div>
                <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                    <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                        Strike Successfully Removed
                    </div>
                    <hr style='width: 98%; margin: 25px 0px;' />
                    <div>
                        Dear $username, <br />

                        We are pleased to inform you that a strike has been successfully removed from your account.<br /><br />

                        Your access to the NFT Marketplace has been reinstated. We appreciate your cooperation in maintaining a positive user experience within our community.<br /><br />

                        If you have any further questions or require assistance, feel free to reach out to us.<br /><br />

                        Thank you for your understanding and continued support of the NFT Marketplace.<br /><br />
                        Best regards,<br />
                        Vivek Surati<br />
                    </div>
                </div>
            </div>
        </body>
    </html>";
$mail->AltBody = 'A Strike has been Successfully Removed from Your Account.';
$mail->send();
