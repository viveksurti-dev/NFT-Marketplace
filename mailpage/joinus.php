<?php
$mail->addAddress("nftmarketplace.acs@gmail.com", "NFT Marketplace");
$mail->Subject = "Join Team Request";
$mail->isHTML(true);
$mail->Body = "<html>
                    <body style='margin: 0; padding: 0;'>
                        <div>
                            <div style='width: 95%; padding:10px; border-radius:5px; border:1px solid #252525;'>
                                <div style='margin-top:20px; text-align:center; font-size : 22px;'>
                                    Join Team Request
                                </div>
                                <hr style='width: 98%; margin: 25px 0px;' />
                                <div>
                                    Dear Hiring Manager, <br />

                                    I am writing to express my interest in joining the NFT Marketplace team. <br /><br />

                                    Please find attached my resume for your review. I am excited about the opportunity to contribute to your team and be part of such an innovative project.<br /><br />

                                    I am confident that my skills and experience align well with the requirements of the position. I am eager to bring my enthusiasm and dedication to your organization.<br /><br />

                                    Thank you for considering my application. I look forward to the possibility of discussing this exciting opportunity with you further.<br /><br />

                                    $joinname Queries :<br />
                                    $jointext <br /><br />

                                    Best regards,<br />
                                    $joinname<br />
                
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>";
$mail->AltBody = 'Join Team Request';
$mail->send();
