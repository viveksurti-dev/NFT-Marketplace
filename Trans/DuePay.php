<?php
require_once "../config.php";
require_once "../Navbar.php";
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

$username = $_SESSION['username'];

$userDetails = "SELECT * FROM auth WHERE username = '$username'";
$getUserDetails = mysqli_query($conn, $userDetails);

// Fetch transactions for the logged-in user
$transactionsQuery = "SELECT * FROM transactions WHERE username = '$username'";
$getTransactions = mysqli_query($conn, $transactionsQuery);

// Fetch wallet details for the logged-in user
$walletQuery = "SELECT * FROM wallet WHERE username = '$username'";
$getWalletDetails = mysqli_query($conn, $walletQuery);

$DuePay = "SELECT * FROM nftcollection INNER JOIN auth ON nftcollection.userid = auth.id WHERE auth.username = '$username' AND nftcollection.collectionStatus = 'pending'";
$getDuePay = $conn->query($DuePay);

$activeCollection = "SELECT * FROM nftcollection INNER JOIN auth ON nftcollection.userid = auth.id WHERE auth.username = '$username' AND nftcollection.collectionStatus = 'active'";
$getActiveCollection = $conn->query($activeCollection);
?>

<body style="overflow-x: scroll;">
    <div class="w-info">
        <h4>Remaining Payments</h4>
        <p>Welcome! <span><?php echo $username ?></span></p>
    </div>
    <?php

    if ($getDuePay && $getDuePay->num_rows > 0) {
        while ($row = $getDuePay->fetch_assoc()) {
            $originalDate = $row['collection_created_date'];
            $TransactionDate = date('d M Y', strtotime($originalDate));
    ?>
            <style>
                .product-image {
                    height: 100%;
                    max-height: 100px;
                    width: 100%;
                    max-width: 100px;
                    overflow: hidden;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border-radius: 5px;
                }

                .product-image img {
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
            <div class="container-fluid">
                <div class="card col-md-12 d-flex flex-wrap flex-row align-items-center justify-content-center">
                    <div class="col-md-1">
                        <div class="product-image">
                            <img src="<?php echo BASE_URL; ?><?php echo $row['collectionimage']; ?>" loading="lazy">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex mt-2 align-items-center">
                        <div>
                            <h4>| Mint</h4>
                            <p class="caption"><?php echo $TransactionDate ?></p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center flex-wrap" style="text-transform :capitalize">
                        <small class="caption">
                            Contract : <?php echo $row['collectionname']; ?>
                        </small>
                        <small class="caption">
                            Blockchain : ₹ <?php echo $row['collectionblockchain']; ?>
                        </small>
                        <small class="caption">
                            Deployment : ₹ <?php echo $row['collectionDeployCharge']; ?>
                        </small>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center align-items-center m-2">
                        <div class="status pending">
                            <p class="text-warning"><?php echo $row['collectionStatus']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <small class="caption text-center">
                            Please make the payment to finalize your creation contract.
                        </small>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                        <button class="btn btn-wallet w-100" onclick="openCollection(<?php echo $row['collectionid']; ?>)"><i class="bi bi-transparency"></i></button>
                    </div>
                </div>
            </div>

            <div id="collection_<?php echo $row['collectionid']; ?>" class="modal">
                <div class="modal-content col-md-4">
                    <span class="close" onclick="closeCollection(<?php echo $row['collectionid']; ?>)">&times;</span>
                    <h4>Make Payment</h4>

                    <div class="contract-details d-flex flex-nowrap">
                        <div class="contract-image col-md-3">
                            <img src="<?php echo BASE_URL; ?><?php echo $row['collectionimage']; ?>" alt="">
                        </div>
                        <div class=" col-md-9 d-flex flex-column justify-content-center">
                            <p>Contract :
                                <span class="caption">
                                    <?php echo $row['collectionname']; ?>
                                </span>
                            </p>
                            <p>Blockchain :
                                <span class="caption">
                                    <?php echo $row['collectionblockchain']; ?>
                                </span>
                            </p>
                            <p>Deployment :
                                <span class="caption">
                                    ₹ <?php echo $row['collectionDeployCharge']; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <hr class="mt-2 mb-2" />
                    <!-- Current Balance -->
                    <div class="balance d-flex flex-nowrap justify-content-between">
                        <div class="ms-2">Current Balance : </div>
                        <div class="me-2"> ₹ <?php echo $balance ?></div>
                    </div>
                    <hr class="mt-2 mb-2" />
                    <div class="Transaction-From d-flex justify-content-between">
                        <div class="ms-3 text-left">
                            <small>From</small><br />
                            <Small class="caption"><?php echo $username; ?></Small>
                        </div>
                        <div class="me-3 text-right">
                            <small>To</small><br />
                            <Small class="caption">NFT Marketplace</Small>
                        </div>
                    </div>
                    <hr class="mt-2 mb-2" />
                    <!-- Transactions Info -->
                    <small class="caption text-center mb-2 mt-2">Transaction Id : achaksgncausdbqwdkamxncakjb</small>
                    <div class="Payment-detail">
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Amount </div>
                            <div> ₹ <?php echo $row['collectionDeployCharge']; ?></div>
                        </div>
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Estimated Service Charge </div>
                            <div> 0%</div>
                        </div>
                        <hr class="mt-2 mb-2" />
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Total Amount </div>
                            <div> ₹ <?php echo $row['collectionDeployCharge']; ?></div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <a href="<?php echo BASE_URL; ?>Trans/CollectionPayment.php?collectionid=<?php echo $row['collectionid'] ?>" class="btn btn-primary mt-3">Sign Payment</a>
                    </div>
                </div>
            </div>

        <?php
        }
    }

    // NFT Remaining Payments
    $getNFT = "SELECT * FROM nft INNER JOIN auth ON nft.userid = auth.id WHERE auth.username = '$username' AND nft.nftstatus = 'pending'";
    $pendingNFT = mysqli_query($conn, $getNFT);
    if ($pendingNFT && $pendingNFT->num_rows > 0) {
        while ($NFT = $pendingNFT->fetch_assoc()) {
            $nftoriginalDate = $NFT['nftcreated_date'];
            $nftTransactionDate = date('d M Y', strtotime($nftoriginalDate));
        ?>
            <div class="container-fluid mt-1">
                <div class="card col-md-12 d-flex flex-wrap flex-row align-items-center justify-content-center">
                    <div class="col-md-1">
                        <div class="product-image">
                            <img src="<?php echo BASE_URL; ?><?php echo $NFT['nftimage']; ?>" loading="lazy">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex mt-2 align-items-center">
                        <div>
                            <h4>| Mint</h4>
                            <p class="caption"><?php echo $nftTransactionDate ?></p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center flex-wrap" style="text-transform :capitalize">
                        <small class="caption">
                            NFT Item : <?php echo $NFT['nftname']; ?>
                        </small>
                        <small class="caption">
                            Price : ₹ <?php echo $NFT['nftprice']; ?>
                        </small>
                        <small class="caption">
                            Mint Charge : <?php
                                            if ($NFT['nftprice'] > 99) {
                                                echo '12 %';
                                            } else {
                                                echo '0 %';
                                            }
                                            ?>
                        </small>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center align-items-center m-2">
                        <div class="status pending">
                            <p class="text-warning"><?php echo $NFT['nftstatus'] ?></p>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <small class="caption text-center">
                            Please make the payment to finalize your creation contract.
                        </small>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                        <button class="btn btn-wallet w-100" onclick="openCollection(<?php echo $NFT['nftid']; ?>)"><i class="bi bi-transparency"></i></button>
                    </div>
                </div>
            </div>

            <div id="collection_<?php echo $NFT['nftid']; ?>" class="modal">
                <div class="modal-content col-md-4">
                    <span class="close" onclick="closeCollection(<?php echo $NFT['nftid']; ?>)">&times;</span>
                    <h4>Make Payment</h4>

                    <div class="contract-details d-flex flex-nowrap">
                        <div class="contract-image col-md-3">
                            <img src="<?php echo BASE_URL; ?><?php echo $NFT['nftimage']; ?>" alt="">
                        </div>
                        <div class=" col-md-9 d-flex flex-column justify-content-center">
                            <p>Contract :
                                <span class="caption">
                                    <?php echo $NFT['nftname']; ?>
                                </span>
                            </p>
                            <p>Price :
                                <span class="caption">
                                    <?php echo $NFT['nftprice']; ?>
                                </span>
                            </p>
                            <p>Supply :
                                <span class="caption">
                                    <?php echo $NFT['nftsupply']; ?> Items
                                </span>
                            </p>
                            <p>Mint Charge :
                                <span class="caption">
                                    <?php
                                    if ($NFT['nftprice'] > 99) {
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
                    <!-- Current Balance -->
                    <div class="balance d-flex flex-nowrap justify-content-between">
                        <div class="ms-2">Current Balance : </div>
                        <div class="me-2"> ₹ <?php echo $balance ?></div>
                    </div>
                    <hr class="mt-2 mb-2" />
                    <div class="Transaction-From d-flex justify-content-between">
                        <div class="ms-3 text-left">
                            <small>From</small><br />
                            <Small class="caption"><?php echo $username; ?></Small>
                        </div>
                        <div class="me-3 text-right">
                            <small>To</small><br />
                            <Small class="caption">NFT Marketplace</Small>
                        </div>
                    </div>
                    <hr class="mt-2 mb-2" />
                    <!-- Transactions Info -->
                    <small class="caption text-center mb-2 mt-2">Transaction Id : achaksgncausdbqwdkamxncakjb</small>
                    <div class="Payment-detail">
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Amount </div>
                            <div><?php echo $NFT['nftprice']; ?> X <?php echo $NFT['nftsupply'] ?></div>
                        </div>
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Estimated Service Charge </div>
                            <div>
                                <?php
                                if ($NFT['nftprice'] > 99) {
                                    echo '12 %';
                                } else {
                                    echo '0 %';
                                }
                                ?>
                            </div>
                        </div>
                        <hr class="mt-2 mb-2" />
                        <div class="d-flex flex-nowrap justify-content-between">
                            <div>Total Amount </div>
                            <div> ₹ <?php
                                    if ($NFT['nftprice'] > 99) {
                                        $totalNFTamount = $NFT['nftprice'] * 0.12 + $NFT['nftprice'] * $NFT['nftsupply'];
                                        echo $totalNFTamount;
                                    } else {
                                        echo $NFT['nftprice'] * $NFT['nftsupply'];
                                    }

                                    ?></div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <a href="<?php echo BASE_URL; ?>Trans/NFTPayment.php?nftid=<?php echo $NFT['nftid'] ?>" class="btn btn-primary mt-3">Sign Payment</a>
                    </div>
                </div>
            </div>
        <?php  }
    }

    // Buy NFT Payment
    if (isset($_SESSION['BUY_NFT'])) {
        $BuyDetails = $_SESSION['BUY_NFT'];
        if ($BuyDetails) {
            $collectionid = $BuyDetails['collectionid'];
            $collectionname = $BuyDetails['collectionname'];
            $nftprice = $BuyDetails['currentNFTPrice']; // Corrected the key
            $buysupply = $BuyDetails['buysupply'];
            $nftid = $BuyDetails['nftid'];
            $nftname = $BuyDetails['nftname'];
            $nftautherid = $BuyDetails['nftautherid'];
            $nftimage = $BuyDetails['nftimage'];
            $authid = $BuyDetails['authid'];
            $authusername = $BuyDetails['authusername'];
            $buydate = $BuyDetails['buydate'];
            $buytime = $BuyDetails['buytime'];

            $selectAuther = "SELECT * FROM auth WHERE id = $nftautherid";
            $AutherDetails = mysqli_query($conn, $selectAuther);

            if ($AutherDetails && $AutherDetails->num_rows > 0) {
                $NFTAuther = mysqli_fetch_assoc($AutherDetails);
            }
        } ?>
        <table class="w-100 p-2 rounded-1" style="background:#191919; overflow-x: scroll;">
            <tr>
                <td class="p-2">
                    <img src="<?php echo BASE_URL . $nftimage ?>" alt="NFT Image" width="auto" height="100px" class="object-fit-cover rounded-1">
                </td>
                <td class="p-2">
                    <small>Item : <span class="caption"><?php echo $nftname; ?></span></small> <br />
                    <small>Price : <span class="caption"> <?php echo $nftprice; ?> INR </span></small> <br />
                    <small>Supply : <span class="caption"> <?php echo $buysupply; ?> Items </span></small> <br />
                    <small>Transaction Charge : <span class="caption"> <?php if ($nftprice > 99) {
                                                                            echo '02 %';
                                                                        } else {
                                                                            echo '00';
                                                                        } ?> </span></small>
                </td>
                <td class="p-2">
                    <small>Auther : <span class="caption text-capitalize"><?php echo $NFTAuther['username'] ?></span></small> <br />
                    <small>Contract : <span class="caption"> <?php echo $collectionname; ?></span></small> <br />
                    <small>Transaction Id : <span class="caption">
                            <?php $enCollectionId = md5($collectionid);
                            echo $enCollectionId; ?>
                        </span>
                    </small> <br />
                    <small>Transaction Date : <span class="caption"> <?php echo $buydate; ?> </span></small>
                </td>
                <td class="p-2">
                    <small> You are buying the NFT'<strong><?php echo $nftname ?></strong>' from the Contract '<strong><?php echo $collectionname ?></strong>'.</small>
                </td>
                <td class="p-2">
                    <div class="status pending">
                        <p class="text-warning">Pending</p>
                    </div>
                </td>
                <td class="p-2 ps-5">
                    <a href="<?php echo BASE_URL ?>Trans/BuyingPayment.php" class="btn btn-success ps-3 pt-2 pb-2 pe-3"><i class="bi bi-cash"></i></a>
                    <a href="?buy_cancel" class="btn btn-outline-danger ps-3 pt-2 pb-2 pe-3"><i class="bi bi-x-lg"></i></a>
                </td>
            </tr>
        </table>
    <?php } ?>

    <?php
    if (!$getDuePay || mysqli_num_rows($getDuePay) === 0 && (!$pendingNFT || mysqli_num_rows($pendingNFT) === 0) && (!isset($_SESSION['BUY_NFT']))) {
        echo '<small class="text-center card p-5">No Remaining Payments</small>';
    }
    ?>


    <!-- Modal Open Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalFlag = localStorage.getItem("modalOpened");

            // Check if modal was opened by the user
            if (modalFlag === "true") {
                var openModals = document.querySelectorAll('[id^="collection_"]:not([style="display: none;"])');
                if (openModals.length > 0) {
                    openModals.forEach(function(modal) {
                        var collectionid = modal.id.replace("collection_", "");
                        openCollection(collectionid);
                    });
                }
            }
        });

        function openCollection(collectionid) {
            document.getElementById("collection_" + collectionid).style.display = "block";
            document.body.classList.add('modal-open');

            // Set localStorage flag to indicate that the modal was opened by the user
            localStorage.setItem("modalOpened", "true");
        }

        function closeCollection(collectionid) {
            document.getElementById("collection_" + collectionid).style.display = "none";
            document.body.classList.remove('modal-open');

            // Clear the localStorage flag when closing the modal
            localStorage.removeItem("modalOpened");
        }
    </script>
</body>