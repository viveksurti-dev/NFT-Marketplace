<div>
    <?php
    require_once "../config.php";
    require_once "../Navbar.php";

    if (!isset($_SESSION['username'])) {
        echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
        exit();
    }

    $username = $_SESSION['username'];
    // Fetch collection ID from the URL parameter
    $NFTId = isset($_GET['nftid']) ? $_GET['nftid'] : null;

    if ($NFTId) {
        // Fetch collection details based on the provided collection ID
        $NFTQuery = "SELECT * FROM nft WHERE nftid = '$NFTId'";
        $NFTResult = $conn->query($NFTQuery);



        if ($NFTResult) {
            $row = $NFTResult->fetch_assoc();
            $collectionid = $row['collectionid'];


            if (!$row) { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>Remaining Payments Not Found</div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php exit;
            }

            $collectionImg = isset($row['nftimage']) ? $row['nftimage'] : '';
            $collectionName = isset($row['nftname']) ? $row['nftname'] : '';
            $collectionPrice = isset($row['nftprice']) ? $row['nftprice'] : '';
            $nftSupply = isset($row['nftsupply']) ? $row['nftsupply'] : '';
            $nftStatus = isset($row['nftstatus']) ? $row['nftstatus'] : '';

            // If Requested NFT Status Active Or Already Paid For This Then Redirect
            if ($nftStatus === 'active') {
                echo "<script>window.location.href='" . BASE_URL . "error-002.php?allowRedirect=true';</script>";
                exit();
            }
        } else {
            echo "Query failed: " . $conn->error;
            exit;
        }
    } else {
        echo "NFT not provided";
        exit;
    }

    ?>


    <?php
    if ($collectionPrice > 99) {
        $DeployCharge = $collectionPrice * 0.12 + $collectionPrice * $nftSupply;
    } else {
        $DeployCharge = $collectionPrice * $nftSupply;
    }

    // Define Error 
    $debit_error = array();

    define("DEPLOYMENT_CHARGE", $DeployCharge);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['username'];
        // Fetch the hashed wallet password from the database based on the user's session
        $query = "SELECT walletPassword, id FROM wallet WHERE userid = (SELECT id FROM auth WHERE username = '$username')";
        $result = $conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();

            if ($row) {
                // Compare the submitted password with the hashed password
                $submittedPassword = $_POST['walletPassword'];
                $hashedPassword = $row['walletPassword'];

                if (password_verify($submittedPassword, $hashedPassword)) {
                    // Check if wallet balance is sufficient
                    $userId = $row['id'];

                    // Check if the wallet balance is greater than the defined deployment charge
                    $walletQuery = "SELECT balance FROM wallet WHERE id = '$userId'";
                    $walletResult = $conn->query($walletQuery);

                    if ($walletResult) {
                        $walletRow = $walletResult->fetch_assoc();

                        if ($walletRow) {
                            $walletBalance = $walletRow['balance'];

                            if ($walletBalance >= DEPLOYMENT_CHARGE) {
                                // Deduct deployment charge from user's wallet
                                $newUserBalance = $walletBalance - DEPLOYMENT_CHARGE;
                                $updateUserWalletQuery = "UPDATE wallet SET balance = '$newUserBalance' WHERE id = '$userId'";
                                $conn->query($updateUserWalletQuery);

                                // Fetch admin's wallet ID
                                $adminWalletQuery = "SELECT id FROM wallet WHERE userid = (SELECT id FROM auth WHERE user_role = 'admin')";
                                $adminWalletResult = $conn->query($adminWalletQuery);

                                if ($adminWalletResult) {
                                    $adminWalletRow = $adminWalletResult->fetch_assoc();

                                    if ($adminWalletRow) {
                                        $adminWalletId = $adminWalletRow['id'];

                                        // Add deployment charge to admin's wallet
                                        $adminWalletBalanceQuery = "SELECT balance FROM wallet WHERE id = '$adminWalletId'";
                                        $adminWalletBalanceResult = $conn->query($adminWalletBalanceQuery);

                                        if ($adminWalletBalanceResult) {
                                            $adminWalletBalanceRow = $adminWalletBalanceResult->fetch_assoc();

                                            if ($adminWalletBalanceRow) {
                                                $adminWalletBalance = $adminWalletBalanceRow['balance'];
                                                $newAdminBalance = $adminWalletBalance + DEPLOYMENT_CHARGE;

                                                // Update admin's wallet balance
                                                $updateAdminWalletQuery = "UPDATE wallet SET balance = '$newAdminBalance' WHERE id = '$adminWalletId'";
                                                $conn->query($updateAdminWalletQuery);
                                                // the time zone for India
                                                date_default_timezone_set("Asia/Kolkata");
                                                // Record transactions
                                                $transactionDate = date("Y-m-d");
                                                $transactionTime = date("H:i:s");
                                                $transactionReason = "Deployment charge deduction for NFT : $collectionName";

                                                // Record transaction for user
                                                $recordUserTransactionQuery = "INSERT INTO transactions (userid ,transactuser, debitamount, transactionreason, transactiondate, transactiontime) VALUES ('$userId', 'NFT Marketplace', '" . DEPLOYMENT_CHARGE . "', '$transactionReason', '$transactionDate', '$transactionTime')";
                                                $conn->query($recordUserTransactionQuery);

                                                // Record transaction for admin
                                                $recordAdminTransactionQuery = "INSERT INTO transactions (userid, transactuser, creditamount, transactionreason, transactiondate, transactiontime) VALUES ('$adminWalletId', '$username' ,'" . DEPLOYMENT_CHARGE . "', '$transactionReason', '$transactionDate', '$transactionTime')";
                                                $conn->query($recordAdminTransactionQuery);

                                                $updateCollectionStatusQuery = "UPDATE nft SET nftstatus = 'active' WHERE nftid = '$NFTId'";
                                                $conn->query($updateCollectionStatusQuery);


                                                // the time zone for India
                                                date_default_timezone_set("Asia/Kolkata");
                                                $currentDate = date("y-m-d");
                                                $currentTime = date("H:i");

                                                $createActivity = "INSERT INTO activity (userid, collectionid, nftid, activityicon, activityitem, activtyquantity, activityfrom, activityto, activity_date, activity_time) VALUES ('$userId', '$collectionid', '$NFTId', 'createnft', '-', '$nftSupply', '$userId', '-', '$currentDate', '$currentTime')";
                                                $conn->query($createActivity);

                                                echo "Your NFT Was Minted";
                                                unset($_SESSION['collection_details']);
                                                echo "<script>window.location.href='" . BASE_URL . "Dashboard.php';</script>";
                                                exit();
                                            }
                                        }
                                    }
                                }
                            } else {
                                $debit_error = "Insufficient Wallet Balance";
                            }
                        }
                    }
                } else {
                    // Passwords do not match, handle the error as needed
                    $debit_error = "Incorrect wallet password";
                }
            } else {
                // User not found in the database, handle the error as needed
                $debit_error = "User not found";
            }
        } else {
            // Query failed, handle the error as needed
            $debit_error = "Query failed: " . $conn->error;
        }

        $conn->close();
    }
    ?>
    <style>
        .contract-details {
            background-color: #151515;
            padding: 10px;
            border-radius: 5px;
            text-transform: capitalize;
            display: flex;
            align-items: center;
        }

        .contract-details p {
            margin: 0;
            padding: 0;
            margin-top: 5px;
            font-size: 15px;
        }

        .contract-image {
            height: 100%;
            max-height: 150px;
            width: 100%;
            max-width: 150px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;

        }

        .contract-image img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .status p {
            margin: 0;
            padding: 0;
        }

        .pending {
            padding: 10px;
            width: 100%;
            max-width: 200px;
            display: flex;
            justify-content: center;
            border-radius: 5px;
            background-color: #693800;
            border: 1px solid orange;
        }

        .Payment-detail {
            background-color: #202020;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #505050;
            font-size: 15px;
        }
    </style>
    <div class="container-fluid d-flex justify-content-center mt-5">
        <div class="card col-md-4">
            <div class="contract-details d-flex flex-nowrap justify-content-center">
                <div class="contract-image col-md-3">
                    <img src="<?php echo BASE_URL; ?><?php echo $collectionImg ?>" alt="">
                </div>
                <div class=" col-md-6 d-flex flex-column justify-content-center">
                    <p>Contract :
                        <span class="caption">
                            <?php echo $collectionName; ?>
                        </span>
                    </p>
                    <p>NFT Price :
                        <span class="caption">
                            ₹ <?php echo $collectionPrice; ?>
                        </span>
                    </p>
                    <p>NFT Price :
                        <span class="caption">
                            <?php echo $nftSupply; ?> Items
                        </span>
                    </p>
                    <p>Deploying Charge :
                        <span class="caption">
                            <?php
                            if ($collectionPrice > 99) {
                                echo '12 %';
                            } else {
                                echo '0 %';
                            }
                            ?>
                        </span>
                    </p>

                </div>
            </div>
            <hr class="mt-2 mb-2" />
            <small class="caption text-center mb-2 mt-2">Transaction Id : achaksgncausdbqwdkamxncakjb</small>
            <div class="Payment-detail">
                <div class="d-flex flex-nowrap justify-content-between">
                    <div>Amount </div>
                    <div> ₹ <?php echo $collectionPrice ?> X <?php echo $nftSupply ?></div>
                </div>
                <div class="d-flex flex-nowrap justify-content-between">
                    <div>Estimated Service Charge </div>
                    <div> <?php
                            if ($collectionPrice > 99) {
                                echo '12 %';
                            } else {
                                echo '0 %';
                            }
                            ?></div>
                </div>
                <hr class="mt-2 mb-2" />
                <div class="d-flex flex-nowrap justify-content-between">
                    <div>Total Amount </div>
                    <div> ₹ <?php echo DEPLOYMENT_CHARGE ?></div>
                </div>
            </div>
            <hr class="mt-2 mb-2" />
            <?php
            if ($debit_error) { ?>
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <?php echo $debit_error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } else ?>
            <form action="" method="post" class="mt-2 ">
                <input type="hidden" name="collectionId" value="<?php echo $NFTId; ?>">
                <div class="form-group">
                    <input type="password" name="walletPassword" class="form-control input" placeholder="Your Wallet Password" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-wallet w-100">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>