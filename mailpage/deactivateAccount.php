<?php
$mail->addAddress($email, $username);
$mail->Subject = "Account Deactivation Confirmation";
$mail->isHTML(true);
$mail->Body = "<html>
        <body style='margin: 0; padding: 0;'>
            <div>
                <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                    <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                        Account Deactivation Confirmation
                    </div>
                    <hr style='width: 98%; margin: 25px 0px;' />
                    <div>
                        Dear $username, <br />

                        We regret to inform you that your account has been successfully deactivated as per your request.<br /><br />

                        Your access to the NFT Marketplace has been terminated. Should you ever wish to reactivate your account, please contact our support team at <a href='mailto:nftmarketplace.acs@gmail.com'>nftmarketplace.acs@gmail.com</a>.<br /><br />

                        Please note that upon account deactivation, all associated data and content will be permanently deleted. By deactivating your account, you agree to the terms outlined in our <a href='#'>Terms of Service</a>.<br /><br />

                        If you have any further questions or require assistance, feel free to reach out to us.<br /><br />

                        Thank you for being a part of the NFT Marketplace community.<br /><br />
                        Best regards,<br />
                        Vivek Surati<br />
                    </div>
                </div>
            </div>
        </body>
    </html>";
$mail->AltBody = 'Your Account has been Deactivated.';
$mail->send();
