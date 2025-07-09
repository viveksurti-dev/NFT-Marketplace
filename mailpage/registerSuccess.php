<?php

$mail->addAddress("$email", "$username");
$mail->Subject = "Registration Successful!";
$mail->isHTML(true);
$mail->Body = "<html>
                <body style='margin: 0; padding: 0;'>
                <div>
                    <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                         <div style='margin: 0 auto; max-width: 150px; text-align: center;'>
                           <img src='https://cdni.iconscout.com/illustration/premium/thumb/login-3305943-2757111.png' alt='register image' style='border-radius:5px; max-width:100%; height:auto;'>
                         </div>
                     
                        <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                            You Have Successfully Registered
                        </div>

                        <hr style='width: 98%; margin: 25px 0px;' />
                        <div>
                            Dear $username, <br />

                            We are delighted to inform you that your registration has been successfully processed. Welcome to the NFT Marketplace!<br /><br />

                             We encourage you to explore and make the most out of our offerings.
                            <br />
                            If you have any questions or encounter any issues, feel free to reach out to our support team at <a href='mailto:nftmarketplace.acs@gmail.com'>nftmarketplace.acs@gmail.com</a>.
                            <br /><br />
                            Thank you for choosing the NFT Marketplace! We look forward to serving you.
                            <br /><br />
                            Best regards,<br />
                            Vivek Surati<br />
                            [Founder & CEO]
                        </div>
                    </div>
                </div>
                </body>
                </html>";
$mail->AltBody = 'You Have Successfully Registered!';
$mail->send();
