<?php
$mail->addAddress("$userOffer[email]", "$userOffer[username]");
$mail->Subject = "Your NFT Offer Accepted!";
$mail->isHTML(true);
$mail->Body = "<html>
                <body style='margin: 0; padding: 0;'>
                <div>
                    <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                        <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                            Your NFT Offer Accepted
                        </div>

                        <hr style='width: 98%; margin: 25px 0px;' />
                        <div>
                            Dear $userOffer[username], <br />

                            Congratulations! We are thrilled to inform you that your offer for the $NFT[nftname] has been accepted on $OFFERS[offerprice]<br /><br />
                            <b>Please make the payment within 24 hours to secure your ownership. Your offer Expired On $OFFERS[offerenddate], $OFFERS[offerendtime]</b>
                            <br /><br />
                             You can now enjoy and trade your NFT as you please. Don't hesitate to explore further opportunities in our marketplace.
                            <br />
                            Should you have any queries or need assistance, our support team is always available at <a href='mailto:nftmarketplace.acs@gmail.com'>nftmarketplace.acs@gmail.com</a>.
                            <br /><br />
                            Thank you for being part of our NFT Marketplace community!
                            <br /><br />
                            Best regards,<br />
                            Vivek Surati<br />
                            [Founder & CEO]
                        </div>
                    </div>
                </div>
                </body>
                </html>";
$mail->AltBody = 'Your NFT Offer Accepted!';
$mail->send();
