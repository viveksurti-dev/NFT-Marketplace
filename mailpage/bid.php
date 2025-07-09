<?php
$mail->addAddress("$lastBidders[email]", "$lastBidders[username]");
$mail->Subject = "Congratulations! Your NFT Bid Has Been Accepted";
$mail->isHTML(true);
$mail->Body = "<html>
                <body style='margin: 0; padding: 0;'>
                <div>
                    <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                        <div style='margin-top:20px; text-align:center; font-size : 22px; color: #4CAF50;'>
                            Congratulations! Your NFT Bid Has Been Accepted
                        </div>

                        <hr style='width: 98%; margin: 25px 0px;' />
                        <div>
                            Dear $lastBidders[username], <br />

                            We are thrilled to inform you that your bid for the $BidNftData[nftname] has been accepted at the highest bid of $bidNftPrice.<br /><br />
                            <b>Please make the payment within 24 hours to secure your ownership.</b>
                            <br /><br />
                            Kindly visit your dashboard to view the details of the transaction.
                            <br /><br />
                            You can now enjoy and trade your NFT as you please. Feel free to explore further opportunities in our vibrant marketplace.
                            <br />
                            Should you have any queries or require assistance, our dedicated support team is available at <a href='mailto:nftmarketplace.acs@gmail.com'>nftmarketplace.acs@gmail.com</a>.
                            <br /><br />
                            Thank you for being an esteemed member of our NFT Marketplace community!
                            <br /><br />
                            Best regards,<br />
                            Vivek Surati<br />
                            Founder & CEO<br />
                            NFT Marketplace
                        </div>
                    </div>
                </div>
                </body>
                </html>";
$mail->AltBody = 'Congratulations! Your NFT Bid Has Been Accepted';
$mail->send();
