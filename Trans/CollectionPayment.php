<div>
    <?php
    require_once "../config.php";
    require_once "../Navbar.php";

    $username = $_SESSION['username'];
    // Fetch collection ID from the URL parameter
    $collectionId = isset($_GET['collectionid']) ? $_GET['collectionid'] : null;

    if ($collectionId) {
        // Fetch collection details based on the provided collection ID
        $collectionQuery = "SELECT * FROM nftcollection WHERE collectionstatus = 'pending' AND collectionid = '$collectionId'";
        $collectionResult = $conn->query($collectionQuery);

        if ($collectionResult) {
            $row = $collectionResult->fetch_assoc();

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

            $collectionImg = isset($row['collectionimage']) ? $row['collectionimage'] : '';
            $collectionId = isset($row['collectionid']) ? $row['collectionid'] : '';
            $collectionName = isset($row['collectionname']) ? $row['collectionname'] : '';
            $collectionBlockchain = isset($row['collectionblockchain']) ? $row['collectionblockchain'] : '';
            $collectionDeployCharge = isset($row['collectionDeployCharge']) ? $row['collectionDeployCharge'] : 0;

            // Fetch other necessary details from $row
        } else {
            echo "Query failed: " . $conn->error;
            exit;
        }
    } else {
        echo "Collection ID not provided";
        exit;
    }
    ?>


    <?php
    // Define the deployment charge as a constant
    define("DEPLOYMENT_CHARGE", 149);

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

                            if ($walletBalance > DEPLOYMENT_CHARGE) {
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

                                                // Get the current date and time
                                                $currentDate = date("y-m-d");
                                                $currentTime = date("H:i");
                                                $transactionReason = "Deployment charge deduction for collection :   $collectionName";
                                                $admintransactionReason = "Deployment charge credited for collection :  $collectionName";

                                                // Record transaction for user
                                                $recordUserTransactionQuery = "INSERT INTO transactions (userid ,transactuser, debitamount, transactionreason, transactiondate, transactiontime) VALUES ('$userId', 'NFT Marketplace', '" . DEPLOYMENT_CHARGE . "', '$transactionReason', '$currentDate', '$currentTime')";
                                                $conn->query($recordUserTransactionQuery);

                                                // Record transaction for admin
                                                $recordAdminTransactionQuery = "INSERT INTO transactions (userid, transactuser, creditamount, transactionreason, transactiondate, transactiontime) VALUES ('$adminWalletId', '$username' ,'" . DEPLOYMENT_CHARGE . "', '$admintransactionReason', '$currentDate', '$currentTime')";
                                                $conn->query($recordAdminTransactionQuery);

                                                // Update the collection status to "active" after successful deployment
                                                $updateCollectionStatusQuery = "UPDATE nftcollection SET collectionStatus = 'active' WHERE collectionid = '$collectionId'";
                                                $conn->query($updateCollectionStatusQuery);

                                                // Record Activity
                                                $createActivity = "INSERT INTO activity (userid, collectionid, nftid, activityicon, activityitem, activtyquantity, activityfrom, activityto, activity_date, activity_time) VALUES ('$userId', '$collectionId', '-', 'createcollection', '$collectionId', '-', '$userId', '-', '$currentDate', '$currentTime')";
                                                $conn->query($createActivity);

                                                $_SESSION['create'] = "Your Collection Deployed";

                                                unset($_SESSION['collection_details']);
                                                echo "<script>window.location.href='" . BASE_URL . "createNFT.php';</script>";
                                                exit();
                                            }
                                        }
                                    }
                                }
                            } else {
                                echo "Insufficient Wallet Balance";
                            }
                        }
                    }
                } else {
                    // Passwords do not match, handle the error as needed
                    echo "Incorrect wallet password";
                }
            } else {
                // User not found in the database, handle the error as needed
                echo "User not found";
            }
        } else {
            // Query failed, handle the error as needed
            echo "Query failed: " . $conn->error;
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
            object-fit: contain;
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
    <div class="container-fluid d-flex justify-content-center mt-3">
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
                    <p>Blockchain :
                        <span class="caption">
                            <?php echo $collectionBlockchain; ?>
                        </span>
                    </p>
                    <p>Deployment :
                        <span class="caption">
                            ₹ <?php echo $collectionDeployCharge; ?>
                        </span>
                    </p>

                </div>
            </div>
            <hr class="mt-2 mb-2" />
            <small class="caption text-center mb-2 mt-2">Transaction Id : achaksgncausdbqwdkamxncakjb</small>
            <div class="Payment-detail">
                <div class="d-flex flex-nowrap justify-content-between">
                    <div>Amount </div>
                    <div> ₹ <?php echo $collectionDeployCharge; ?></div>
                </div>
                <div class="d-flex flex-nowrap justify-content-between">
                    <div>Estimated Service Charge </div>
                    <div> 0%</div>
                </div>
                <hr class="mt-2 mb-2" />
                <div class="d-flex flex-nowrap justify-content-between">
                    <div>Total Amount </div>
                    <div> ₹ <?php echo $collectionDeployCharge; ?></div>
                </div>
            </div>
            <hr class="mt-2 mb-2" />
            <form action="" method="post" class="mt-2 ">
                <!-- Add a hidden input field to store the collection ID -->
                <input type="hidden" name="collectionId">
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