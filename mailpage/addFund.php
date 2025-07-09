<?php
$email = $USER['email'];
$mail->addAddress("$email", "$username");
$mail->Subject = "Payment Successful: Funds Added to Your Wallet!";
$mail->isHTML(true);
$mail->Body = "<html>
                <body style='margin: 0; padding: 0;'>
                <div>
                    <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                         <div style='margin: 0 auto; max-width: 150px; text-align: center;'>
                           <img src='https://cdn3d.iconscout.com/3d/premium/thumb/payment-successful-6929803-5686174.png?f=webp' alt='register image' style='border-radius:5px; max-width:100%; height:auto;'>
                         </div>
                     
                        <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                            Fund Added Successfully!
                        </div>

                        <hr style='width: 98%; margin: 25px 0px;' />
                        <div>
                        Dear $username, <br />
                        We're delighted to inform you that your recent payment to add funds to your wallet in our NFT Marketplace has been successfully processed!<br />

                        Your wallet has been credited with the amount you specified, enabling you to dive deeper into the world of digital art, collectibles, and experiences within our platform.<br /><br />
                        
                        Here's a quick overview of your transaction:<br />
                        
                        Transaction ID: $transactionId<br />
                        Amount Added: $TotalAmount<br />
                        Payment Method: $paymentInstrument <br /><br />
                        With your wallet now replenished, you can seamlessly engage with your favorite creators, discover new digital assets, and support the vibrant community of artists and collectors on our platform. <br /> <br />
                        
                        Ready to explore? Simply log in to your account and start browsing the latest offerings available in our marketplace. Whether you're looking for unique artworks, limited-edition collectibles, or immersive experiences, your wallet balance empowers you to make the most of your NFT journey. <br /> <br />
                        
                        Should you have any questions about your transaction or need assistance with anything else, our dedicated support team is here to help. Feel free to reach out to us at nftmarketplace.acs@gmail.com for prompt assistance. <br /> <br />
                        
                        Thank you for choosing to be a part of our NFT Marketplace community. We're excited to see the incredible experiences you'll discover and create with your newly added funds. <br /> <br />
                        
                        Happy exploring!
                        <br />
                        <br />
                            Best regards,<br />
                            Vivek Surati<br />
                            Founder & CEO
                        </div>
                    </div>
                </div>
                </body>
                </html>";
$mail->AltBody = 'Payment Successful: Funds Added to Your Wallet!';
$mail->send();
