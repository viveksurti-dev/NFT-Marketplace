<?php
require_once '../Navbar.php';
require_once '../config.php';


// Buy NFT Payment
if (isset($_SESSION['BUY_NFT'])) {
    $BuyDetails = $_SESSION['BUY_NFT'];
    if ($BuyDetails) {
        $collectionid = $BuyDetails['collectionid'];
        $collectionname = $BuyDetails['collectionname'];
        $nftprice = $BuyDetails['currentNFTPrice'];
        $buysupply = $BuyDetails['buysupply'];
        $nftid = $BuyDetails['nftid'];
        $nftname = $BuyDetails['nftname'];
        $nftautherid = $BuyDetails['nftautherid'];
        $nftimage = $BuyDetails['nftimage'];
        $authid = $BuyDetails['authid'];
        $authusername = $BuyDetails['authusername'];
        $buydate = $BuyDetails['buydate'];
        $buytime = $BuyDetails['buytime'];

        // Calculate Total Amount & Trasaction charge
        if ($nftprice > 99) {
            $transactionCharge = $nftprice * 0.02;
            $autherAmmount = $nftprice * $buysupply;
            $totalAmount = $nftprice * $buysupply + $transactionCharge;
        } else {
            $transactionCharge = $nftprice * 0;
            $autherAmmount = $nftprice * $buysupply;
            $totalAmount = $nftprice * $buysupply + $transactionCharge;
        }

        // fetch NFT Auther Details
        $selectAuther = "SELECT * FROM auth WHERE id = $nftautherid";
        $AutherDetails = mysqli_query($conn, $selectAuther);

        if ($AutherDetails && $AutherDetails->num_rows > 0) {
            $NFTAuther = mysqli_fetch_assoc($AutherDetails);
        } else {
            echo 'Auther Not Found';
        }
        // Fetch Admin Details
        $selectAdmin = "SELECT * FROM auth WHERE user_role = 'admin'";
        $AdminDetails = mysqli_query($conn, $selectAdmin);
        if ($AdminDetails && $AdminDetails->num_rows > 0) {
            $Admin = mysqli_fetch_assoc($AdminDetails);
        } else {
            echo 'Admin Details Not Found';
        }
        // Fetch Buyer wallet Details
        $buyerBalance = "SELECT * FROM wallet WHERE userid = {$USER['id']}";
        $buyerbalancedetails = mysqli_query($conn, $buyerBalance);

        if ($buyerbalancedetails && $buyerbalancedetails->num_rows > 0) {
            $buyerWallet = mysqli_fetch_assoc($buyerbalancedetails);
        } else {
            echo 'Buyer Wallet Details Not Found';
        }
        $buyerBalance = $buyerWallet['balance'];

        // Fetch NFTAuther wallet Details
        $autherBalance = "SELECT * FROM wallet WHERE userid =  $nftautherid";
        $autherbalancedetails = mysqli_query($conn, $autherBalance);

        if ($autherbalancedetails && $autherbalancedetails->num_rows > 0) {
            $autherWallet = mysqli_fetch_assoc($autherbalancedetails);
        } else {
            echo 'Auther Wallet Details Not Found';
        }

        // Fetch Admin wallet Details
        $adminBalance = "SELECT * FROM wallet WHERE userid =  {$Admin['id']}";
        $adminbalancedetails = mysqli_query($conn, $adminBalance);

        if ($adminbalancedetails && $adminbalancedetails->num_rows > 0) {
            $adminWallet = mysqli_fetch_assoc($adminbalancedetails);
        } else {
            echo 'Admin Wallet Details Not Found';
        }

        // Fetch nft
        $selectTotal = "SELECT * FROM nft WHERE nftid = $nftid";
        $nftdetails = mysqli_query($conn, $selectTotal);
        if ($nftdetails) {
            $NFT = mysqli_fetch_assoc($nftdetails);
        } else {
            echo 'nft details not Found';
        }
        $nftfloorprice = $NFT['nftfloorprice'];
        $collectionId = $NFT['collectionid'];
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buy <?php echo $nftname; ?> - NFT Marketplace</title>
        <style>
            .item-details {
                padding: 10px;
                background-color: #202020;
                border-radius: 7px;
                border: 2px solid #232323;
            }

            .item-image {
                width: 100%;
                height: auto;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 5px;
            }

            .item-image img {
                width: 100%;
                height: 100%;
                max-height: auto;
                object-fit: cover;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 5px;
            }
        </style>
    </head>

    <body>
        <?php
        date_default_timezone_set("Asia/Kolkata");
        $transactionDate = date("Y-m-d");
        $transactionTime = date("H:i:s");
        // buyer Reason
        $buyTransactionReason = "Purchasing charge deduction for NFT : $nftname from $collectionname";
        // Reciver Reason
        $reciveTransactionReason = "Selling Amount credited into wallet for NFT : $nftname from $collectionname";
        // Admin Reason
        $adminTransactionReason = "Transaction charge credited into wallet for NFT : $nftname from $collectionname";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy-payment'])) {
            $SubmittedWalletPassword = $_POST['walletpassword'];
            $WalletPassword = $buyerWallet['walletPassword'];

            if (password_verify($SubmittedWalletPassword, $WalletPassword)) {
                if ($buyerBalance > $totalAmount) {
                    if ($autherWallet) {
                        if ($adminWallet) {
                            // Record Buyer Transaction
                            $buyerTransaction = "INSERT INTO transactions (userid ,transactuser, debitamount, transactionreason, transactiondate, transactiontime) VALUES ('$USER[id]', '$NFTAuther[id]', '$totalAmount', '$buyTransactionReason', '$transactionDate', '$transactionTime')";
                            $conn->query($buyerTransaction);

                            // Record Reciver Transaction
                            $reciverTransaction = "INSERT INTO transactions (userid ,transactuser, creditamount, transactionreason, transactiondate, transactiontime) VALUES ('$NFTAuther[id]', '$USER[id]', '$autherAmmount', '$reciveTransactionReason', '$transactionDate', '$transactionTime')";
                            $conn->query($reciverTransaction);

                            if ($nftprice > 99) {
                                // Record Admin Transaction
                                $adminTransaction = "INSERT INTO transactions (userid ,transactuser, creditamount, transactionreason, transactiondate, transactiontime) VALUES ('$Admin[id]', '$USER[id]', '$transactionCharge', '$adminTransactionReason', '$transactionDate', '$transactionTime')";
                                $conn->query($adminTransaction);
                            }

                            // Record Activity
                            $nftActivity = "INSERT INTO nftactivity(autherid, currentautherid, nftid, nftprice, nftsupply, activitydate, activitytime, nftactivitystatus) VALUES ('$NFTAuther[id]','$USER[id]','$nftid','$nftprice','$buysupply','$transactionDate','$transactionTime','sale')";
                            $conn->query($nftActivity);

                            // Record Activity
                            $nftActivity = "INSERT INTO nftactivity(autherid, currentautherid, nftid,nftprice, nftsupply, activitydate, activitytime, nftactivitystatus) VALUES ('$NFTAuther[id]','$USER[id]','$nftid','-','-','$transactionDate','$transactionTime','transfer')";
                            $conn->query($nftActivity);

                            // Record Collection Total Activity
                            $activity = "INSERT INTO `activity`(userid,collectionid ,nftid, activityicon, activtyquantity, activityfrom, activityto, activity_date, activity_time) VALUES ('$USER[id]',' $collectionid','$nftid','sale','$buysupply','$NFTAuther[id]','$USER[id]','$transactionDate','$transactionTime')";
                            $conn->query($activity);

                            // insert Into Collection
                            $nftActivity = "INSERT INTO nftcollected( `autherid`, `currentautherid`, `nftid`, `nftprice`, `nftsupply`, `collectdate`, `collecttime`, `collectstatus`) VALUES ('$NFTAuther[id]','$USER[id]','$nftid','$nftprice','$buysupply','$transactionDate','$transactionTime','collected')";
                            $conn->query($nftActivity);

                            //deactive collection if collection exist
                            $collected = "SELECT * FROM nftcollected WHERE nftid = {$NFT['nftid']}";
                            $collecteddetails = mysqli_query($conn, $collected);

                            if ($collecteddetails) {
                                $collectedNFT = mysqli_fetch_assoc($collecteddetails);
                                $collectedNFTSupply = $collectedNFT['nftsupply'];

                                if ($collectedNFTSupply > 1) {
                                    $newsupply = $collectedNFTSupply - $buysupply;
                                    $updateCollect = "UPDATE `nftcollected` SET nftsupply = '$newsupply' WHERE autherid = {$NFTAuther['id']}";
                                    $conn->query($updateCollect);

                                    // insert Into Collect
                                    $nftActivity = "INSERT INTO nftcollected( `autherid`, `nftid`, `nftprice`, `nftsupply`, `collectdate`, `collecttime`, `collectstatus`) VALUES ('$USER[id]','$nftid','$nftprice','$buysupply','$transactionDate','$transactionTime','collected')";
                                    $conn->query($nftActivity);
                                } else {
                                    $updateCollect = "UPDATE `nftcollected` SET collectstatus = 'saled' WHERE autherid = {$NFTAuther['id']}";
                                    $conn->query($updateCollect);

                                    // insert Into Collect
                                    $nftActivity = "INSERT INTO nftcollected( `autherid`, `nftid`, `nftprice`, `nftsupply`, `collectdate`, `collecttime`, `collectstatus`) VALUES ('$USER[id]','$nftid','$nftprice','$buysupply','$transactionDate','$transactionTime','collected')";
                                    $conn->query($nftActivity);
                                }
                            }


                            // nft transafer 
                            if ($buysupply > 1) {
                                $newNFTQantity = $NFT['nftsupply'] - $buysupply;
                                // Update Reciver Quantity
                                $updateQantity = "UPDATE `nft` SET nftsupply = '$newNFTQuantity' WHERE nftid = $nftid";
                                $conn->query($updateQantity);

                                // insert new nft
                                $userNFT = "INSERT INTO `nft`(`userid`, `collectionid`, `nftimage`, `nftname`, `nftsupply`, `nftprice`, `nftfloorprice`, `nftdescription`, `nftstatus`, `nftcreated_date`, `nftcreated_time`) VALUES ('$USER[id]','$collectionid','$nftimage','$nftname','$buysupply','$nftprice','$nftprice','$NFT[nftdescription]','active','$transactionDate','$transactionTime')";
                                $conn->query($userNFT);
                            } else {
                                // update Auther
                                $updateAuther = "UPDATE `nft` SET userid = '{$USER['id']}', nftprice = '$nftprice' WHERE nftid = $nftid";
                                $conn->query($updateAuther);

                                if ($nftprice < $nftfloorprice) {
                                    $updateprice = "UPDATE `nft` SET nftfloorprice = '$nftprice' WHERE nftid = $nftid";
                                    $conn->query($updateprice);
                                }

                                $closeOffers = "UPDATE nftoffers SET offerstatus = 'close' WHERE nftid = $nftid";
                                $conn->query($closeOffers);

                                $closeSales = "UPDATE nftsale SET salestatus = 'close' WHERE nftid = $nftid";
                                $conn->query($closeSales);

                                $closeAuctions = "UPDATE auction SET auctionstatus ='close' WHERE nftid = $nftid";
                                $conn->query($closeAuctions);
                            }

                            // give 10% Royalty of nft price if this nft purchase more then 2 times
                            if ($NFT['royaltyid']) {
                                $royaltyId = $NFT['royaltyid'];
                                $RoyaltyUserWallet = "SELECT * FROM wallet WHERE userid = $royaltyId";
                                $royaltyUserData = mysqli_query($conn, $RoyaltyUserWallet);

                                if ($royaltyUserData) {
                                    date_default_timezone_set("Asia/Kolkata");
                                    $transactionDate = date("Y-m-d");
                                    $transactionTime = date("H:i:s");

                                    $RoyaltyUser = mysqli_fetch_assoc($royaltyUserData);
                                    $CalcRoyalty = $nftprice * 0.1;
                                    $NewRoyaltyBal = $RoyaltyUser['balance'] + $CalcRoyalty;

                                    $UpdateRoyaltyWallet = "UPDATE wallet SET balance = $NewRoyaltyBal WHERE userid = $royaltyId";
                                    $conn->query($UpdateRoyaltyWallet);

                                    $RoyaltyTransactionReason = "Your wallet has been credited with royalties following the successful sale of the $nftname, acknowledging your entitlement to ongoing earnings from this transaction.";
                                    $createRoyaltyTransaction = "INSERT INTO transactions(userid, transactuser, creditamount, debitamount, transactionreason, transactiondate, transactiontime) VALUES ('$royaltyId','NFT Marketplace',' $CalcRoyalty','',' $RoyaltyTransactionReason','$transactionDate','$transactionTime')";
                                    $conn->query($createRoyaltyTransaction);
                                }
                            } else {
                                $setRoyalty = "UPDATE nft SET royaltyid =  $nftautherid WHERE nftid = $nftid";
                                $conn->query($setRoyalty);
                            }

                            // update New Balance
                            $newBuyerBalance = $buyerWallet['balance'] - $totalAmount;
                            $newReciverBalance = $autherWallet['balance'] + $autherAmmount;

                            // Update Buyer Balance
                            $UpdateBuyerBalance = "UPDATE wallet SET balance = '$newBuyerBalance' WHERE id = {$buyerWallet['id']}";
                            $conn->query($UpdateBuyerBalance);
                            // Update nft Auther Balance
                            $UpdateAutherBalance = "UPDATE wallet SET balance = '$newReciverBalance' WHERE id = {$autherWallet['id']}";
                            $conn->query($UpdateAutherBalance);

                            if ($nftprice > 99) {
                                $newAdminBalance = $adminWallet['balance'] + $transactionCharge;
                                // Update nft Auther Balance
                                $UpdateAdminBalance = "UPDATE wallet SET balance = '$newAdminBalance' WHERE id = {$adminWallet['id']}";
                                $conn->query($UpdateAdminBalance);
                            }

                            unset($_SESSION['BUY_NFT']);
                            $_SESSION['create'] = "Buy NFT Successfully!";
                            echo "<script>window.location.href='" . BASE_URL . "Dashboard.php';</script>";
                            exit();
                        } else {
                            echo 'Admin Wallet Details Not Found';
                        }
                    } else {
                        echo "Auther Wallet Not Found";
                    }
                } else {
                    echo "Insufficient Wallet Balance";
                }
            } else {
                echo 'Incorrect wallet Password';
            }
        }
        ?>

        <div class="container-fluid d-flex justify-content-center align-content-between mt-2">
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <h4 class="text-center">Make Your Payment</h4>
                    </div>
                    <!-- Items details -->
                    <div class="item-details mt-2 d-flex flex-wrap">
                        <div class="item-image col-md-4">
                            <img src="<?php echo BASE_URL . $nftimage ?>" alt="">
                        </div>
                        <div class="col-md-8 mt-2">
                            <small>Item : <span class="caption"><?php echo $nftname; ?></span></small> <br />
                            <small>Price : <span class="caption"> <?php echo $nftprice; ?> INR </span></small> <br />
                            <small>Supply : <span class="caption"> <?php echo $buysupply; ?> Items </span></small> <br />
                            <small>Transaction Charge : <span class="caption">
                                    <?php if ($nftprice > 99) {
                                        echo '02 %';
                                    } else {
                                        echo '00';
                                    } ?> </span></small> <br />
                            <small>Auther : <span class="caption text-capitalize"><?php echo $NFTAuther['username'] ?></span></small> <br />
                            <small>Contract : <span class="caption"> <?php echo $collectionname; ?></span></small> <br />
                        </div>

                    </div>
                    <!-- Transaction Details -->
                    <hr class="mt-3 mb-3" />
                    <div class="d-flex text-start">
                        <div class="col-6">
                            <small class="caption">
                                From
                            </small> <br />
                            <small class="text-capitalize">
                                <?php echo $USER['username']; ?>
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <small class="caption">
                                To
                            </small> <br />
                            <small class="text-capitalize">
                                <?php echo $NFTAuther['username'] ?>
                            </small>
                        </div>
                    </div>
                    <hr class="mt-3 mb-3" />
                    <div class="Payment-detail item-details">
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Amount </div>
                            <div> ₹ <?php echo $nftprice ?> X <?php echo $buysupply ?></div>
                        </div>
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Transaction Charge </div>
                            <div> ₹ <?php echo $transactionCharge ?></div>
                        </div>
                        <hr class="mt-2 mb-2" />
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Total Amount </div>
                            <div> ₹ <?php echo $totalAmount ?></div>
                        </div>
                    </div>
                    <hr class="mt-3 mb-3" />
                    <div>
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control input" name="walletpassword" placeholder="Wallet Password">
                            </div>
                            <button class="btn w-100 btn-primary" name="buy-payment">Sign Payment</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </body>

    </html>
<?php
} else {
    echo 'You Have No Remaining Payment';
}
?>