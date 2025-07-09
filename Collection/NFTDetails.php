<?php
require_once '../Navbar.php';
require_once '../config.php';

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../error-001.php?allowRedirect=true';</script>";
    exit();
}

// $createFavorite = "CREATE TABLE favorites (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     nftid INT NOT NULL,
//     userid INT NOT NULL
// )";

// $conn->query($createFavorite);

$error = '';

$currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata")); // India time zone
$currentDate = $currentDateTime->format("Y-m-d");
$currentTime = $currentDateTime->format("H:i:s");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Details - NFT Marketplace</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- CSS : nft.css | Line : 493 -->
</head>
<?php
// Display error message if it exists
if (isset($_SESSION['create'])) {
    echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert alert-danger' id='myAlert'>
                    <div class='cust_alert-header'>
                        <div class='brand-info'>
                            <div class='Header-image me-2'>
                            <img src='" . BASE_URL . "Assets/illu/web-logo.png' alt='Brand Image'/>
                            </div>
                            <div class='header-name'>NFT Marketplace</div>
                        </div>
                        <div class='time'>
                            Just Now
                        </div>
                    </div>
                    <div class='cust_alert-body'>
                    {$_SESSION['create']}
                    </div>
                </div>
            </div>";
    unset($_SESSION['create']);
}
?>

<body class="container-fluid d-flex flex-wrap">
    <?php
    if (isset($_GET['nftid'])) {
        $enNFTid = $_GET['nftid'];
        $deNFTid = base64_decode($enNFTid);

        $getNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND nftid = '$deNFTid'";
        $NFTDetails = mysqli_query($conn, $getNFT);


        if ($NFT = mysqli_fetch_assoc($NFTDetails)) {
            $nftFloorPrice = $NFT['nftfloorprice'];
            // get nft user details
            $getUser = "SELECT * FROM auth WHERE id = " . $NFT['userid'];
            $userDetail = mysqli_query($conn, $getUser);

            if ($userDetail) {
                $nftuser = mysqli_fetch_assoc($userDetail);

                // get collection info from database
                $getCollection = "SELECT * FROM nftcollection WHERE collectionid =" . $NFT['collectionid'];
                $collectionDetails = mysqli_query($conn, $getCollection);
                $collection = mysqli_fetch_assoc($collectionDetails);

                // encrypt Collection id
                $collectionId = $collection['collectionid'];
                $enCollectionId = base64_encode($collectionId);

                // Select Sale Price
                $selectSalePrice = "SELECT * FROM nftsale 
                    WHERE salestatus = 'activate' 
                    AND nftid = {$NFT['nftid']}  
                    AND '$currentDate $currentTime' BETWEEN CONCAT(salecreatedate, ' ', salecreatetime)
                    AND CONCAT(saleenddate, ' ', saleendtime)
                    ORDER BY saleid DESC LIMIT 1";

                $priceDetails = mysqli_query($conn, $selectSalePrice);

                if ($priceDetails && $priceDetails->num_rows > 0) {
                    $NFTprice = mysqli_fetch_assoc($priceDetails);
                    $currentNFTPrice = $NFTprice['saleprice'];
                    $onSale = true;
                } else {
                    $currentNFTPrice = $NFT['nftprice'];
                    $onSale = false;
                }
    ?>

                <!-- NFT IMAGE -->
                <div class="col-md-5 mt-3">
                    <div class="nft-image">
                        <div class="d-flex mt-2 mb-1">
                            <div class="nft-blockchain d-flex col-md-6 justify-content-start">
                                <?php
                                if ($row['collectionblockchain'] = 'inr') {
                                    echo '<span> ₹ </span>';
                                } ?>
                            </div>
                            <div class="nft-blockchain d-flex justify-content-end col-md-6">
                                <div>
                                    <a class="link" target="_blank" href="<?php echo BASE_URL . $NFT['nftimage'] ?>">
                                        <small><i class="bi bi-box-arrow-up-right me-3"></i></small>
                                    </a>
                                </div>
                                <?php

                                $username = $_SESSION['username'];
                                $selectuser = "SELECT id FROM auth WHERE username = '$username' LIMIT 1";
                                $userdetails = mysqli_query($conn, $selectuser);

                                if ($userdetails && $userdetails->num_rows > 0) {
                                    $rows = mysqli_fetch_assoc($userdetails);
                                    $likeuserid = $rows['id'];
                                    $nftid = $NFT['nftid'];

                                    $selectLike = "SELECT * FROM favorites WHERE nftid = $nftid AND userid = $likeuserid LIMIT 1";
                                    $LikeDetails = mysqli_query($conn, $selectLike);

                                    if ($LikeDetails && $LikeDetails->num_rows > 0) {
                                        // User has already liked the NFT
                                        $query = "DELETE FROM favorites WHERE nftid = $nftid AND userid = $likeuserid";
                                        $action = 'like';
                                    } else {
                                        $query = "INSERT INTO favorites (nftid, userid) VALUES ($nftid, $likeuserid)";
                                        $action = 'unlike';
                                    }

                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addfavorite'])) {
                                        if ($conn->query($query) === TRUE) {
                                            echo "<script>window.location.href='';</script>";
                                            exit();
                                        } else {
                                        }
                                    }
                                ?>
                                    <form method="post" id="favoriteForm">
                                        <button type="submit" class="btn bi <?php echo ($action === 'like') ? 'bi-heart-fill' : 'bi-heart'; ?> p-0" style="color: white;" name="addfavorite" id="addFavoriteBtn"></button>
                                    </form>
                                <?php
                                } else {
                                    echo 'Liker not found';
                                }
                                ?>
                            </div>
                        </div>
                        <div style="width:100%; height:100%;">
                            <img src="<?php echo BASE_URL . $NFT['nftimage'] ?>" alt="NFT Image" class="w-100" style="height: 100%;">
                        </div>
                    </div>
                </div>
                <!-- NFT Details -->
                <div class="col-md-7 mt-3 nft-details p-3">
                    <div class="nft-collection-name">
                        <a href="<?php echo BASE_URL ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionId ?>" class="link redirect-collection"><?php echo $collection['collectionname'] ?></a>
                    </div>
                    <div class="nft-name">
                        <?php echo $NFT['nftname']; ?>
                    </div>
                    <div class="nft-auther">
                        Owned By <a href="" class="link"> <?php echo $nftuser['username']; ?></a>
                    </div>
                    <div class="mt-3">
                        <span><i class="bi bi-heart"></i>
                            <?php
                            $nftid = $NFT['nftid'];

                            $countLikesQuery = "SELECT COUNT(*) AS totalLikes FROM favorites WHERE nftid = $nftid";
                            $countLikesResult = mysqli_query($conn, $countLikesQuery);

                            if ($countLikesResult && $countLikesResult->num_rows > 0) {
                                $likesData = mysqli_fetch_assoc($countLikesResult);
                                $totalLikes = $likesData['totalLikes'];
                                echo "$totalLikes";
                            } else {
                                echo "Error fetching likes count";
                            }
                            ?> Favorites</span>
                        <span class="ms-3"><i class="bi bi-columns-gap me-2"></i><span class="text-capitalize"><?php echo $collection['collectioncategory'] ?></span> Category </span>
                    </div>

                    <div class="card mt-4">
                        <!----------------------------------- NFT NonAuther Part Start ----------------------------------->
                        <?php
                        if ($nftuser['id'] === $USER['id']) { ?>
                            <?php
                            if ($onSale) { ?>
                                <?php
                                $endDate = $NFTprice['saleenddate'];
                                $endTime = $NFTprice['saleendtime'];

                                // Convert the date and time to the desired format
                                $SaleEndDate = date('d F Y', strtotime($endDate));
                                $SaleEndTime = date('h:i', strtotime($endTime));
                                ?>

                                <div class="sale-time mb-2" id="sale-countdown">
                                    <i class="bi bi-clock me-2"></i> Sale ends
                                    <span id="countdown-date"><?php echo $SaleEndDate; ?></span> at
                                    <span id="countdown-time">
                                        <?php echo $SaleEndTime; ?>
                                    </span>
                                    <div id="countdown" style="font-size:30px;" class="mt-3 text-center caption"></div>
                                </div>
                                <hr class="mt-2 mb-2" />
                            <?php } ?>
                            <div class="nft-price">
                                <small class="caption">Current Price</small>
                                <p class="current-price"><?php echo $currentNFTPrice; ?> INR
                                    <span style="font-size:14px;" class="ms-2">
                                        <?php if ($currentNFTPrice < $NFT['nftprice']) { ?>
                                            <span style="color:red">
                                                <i class="bi bi-graph-down-arrow"></i>
                                                <?php
                                                $price = $currentNFTPrice - $NFT['nftprice'];
                                                echo $price . " INR Dropped";
                                                ?>
                                            </span>
                                        <?php } else if ($currentNFTPrice > $NFT['nftprice']) { ?>
                                            <span style="color:green">
                                                <i class="bi bi-graph-up-arrow"></i>
                                                <?php
                                                $price = $currentNFTPrice - $NFT['nftprice'];
                                                echo $price . " INR Up";
                                                ?>
                                            </span>
                                        <?php } ?>
                                        <span>
                                </p>
                                <small class="caption"><?php echo $NFT['nftsupply']; ?> item is available</small>
                            </div>


                            <div class="eventCreator d-flex flex-wrap mt-2">
                                <!-- Check Auction Avilable Or Not -->
                                <?php
                                $currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata")); // India time zone
                                $currentDate = $currentDateTime->format("Y-m-d H:i:s");

                                $sqlSelectAuction = "SELECT * FROM auction 
                                    WHERE auctionstatus = 'active' 
                                      AND nftid = '{$NFT['nftid']}' 
                                      AND '$currentDate' BETWEEN auctioncreatedate AND CONCAT(auctionenddate, ' ', auctionendtime)
                                      AND '$currentDate' <= CONCAT(auctionenddate, ' ', auctionendtime)";

                                $result = $conn->query($sqlSelectAuction);

                                if ($result && $result->num_rows > 0) { ?>
                                    <hr class="mt-2 mb-2 w-100" />
                                    <?php while ($row = $result->fetch_assoc()) {
                                        $auctionId = $row["auctionid"];
                                        $auctionEndDate = $row["auctionenddate"];
                                        $auctionEndTime = $row["auctionendtime"];
                                        // Combine end date and time
                                        $auctionEndDateTime = "$auctionEndDate $auctionEndTime";
                                        $auctionEndTimestamp = strtotime($auctionEndDateTime);   ?>


                                        <div class="d-flex flex-column flex-wrap align-items-center col-md-6 justify-content-center" id="auction_<?php echo $auctionId; ?>">
                                            <div>
                                                Auction Duration
                                            </div>
                                            <div> Loading...</div>
                                        </div>
                                        <!-- Stop Auction Button -->
                                        <div class="col-md-6 d-flex flex-column flex-wrap align-items-center justify-content-center">
                                            <?php
                                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["stopauction"])) {
                                                $updateQuery = "UPDATE auction SET auctionstatus = 'deactive' WHERE auctionid = $auctionId";
                                                if ($conn->query($updateQuery) === TRUE) {
                                                    $_SESSION['create'] = "Your Auction For NFT Stopped!.";
                                                    echo "<script>window.location.href='';</script>";
                                                    exit();
                                                } else {
                                                    echo "Error updating auction status: " . $conn->error;
                                                }
                                            }
                                            ?>
                                            <form action="" method="post">
                                                <button class="btn btn-outline-danger w-100" name="stopauction">Stop Auction</button>
                                            </form>
                                        </div>

                                        <!----------------------------------- NFTAuther salepart Part End----------------------------------->
                                    <?php }
                                } else { ?>
                                    <!----------------------------------- NFT Auther create sale Part Start ----------------------------------->
                                    <div class="col-md-6">
                                        <?php
                                        // $createSaleTable = "CREATE TABLE IF NOT EXISTS nftsale (
                                        //         saleid INT AUTO_INCREMENT PRIMARY KEY,
                                        //         userid INT NOT NULL,
                                        //         nftid INT NOT NULL,
                                        //         saleprice DECIMAL(10, 2) NOT NULL,
                                        //         salecreatedate DATE NOT NULL,
                                        //         salecreatetime TIME NOT NULL,
                                        //         saleenddate DATE NOT NULL,
                                        //         saleendtime TIME NOT NULL,
                                        //         salestatus VARCHAR(255) NOT NULL
                                        //         )";
                                        // $conn->query($createSaleTable);
                                        ?>
                                        <!-- Sale Button -->
                                        <button type="button" class="btn btn-primary w-100 p-2 mt-1" onclick="toggleSale(<?php echo $NFT['nftid'] ?>)">Listed On Sale</button>
                                        <script>
                                            function toggleSale(nftId) {
                                                var auctionBlock = $('#sale_block_' + nftId);

                                                // Check if the auction block is visible
                                                if (auctionBlock.is(':visible')) {
                                                    // Hide the auction block with animation
                                                    auctionBlock.slideUp();
                                                } else {
                                                    // Show the auction block with animation
                                                    auctionBlock.slideDown();
                                                }
                                            }
                                        </script>
                                    </div>
                                    <div class="col-md-6">
                                        <button style="width: 100%;" class="btn btn-outline-primary mt-1 p-2" onclick="toggleAuction(<?php echo $NFT['nftid'] ?>)">Timed Auction</button>
                                    </div>
                                    <!-- Sale Block -->
                                    <div id="sale_block_<?php echo $NFT['nftid']; ?>" class="mt-4 col-md-12" style="display: none;">
                                        <?php
                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-createsale'])) {
                                            $salePrice = $_POST['sale_price'];
                                            $saleEndDate = $_POST['sale_end_date'];
                                            $saleEndTime = $_POST['sale_end_time'];

                                            // Validate end date and time
                                            $currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata")); // India time zone
                                            $currentDate = $currentDateTime->format("Y-m-d");
                                            $currentTime = $currentDateTime->format("H:i:s");

                                            if ($saleEndDate < $currentDate || ($saleEndDate == $currentDate && $saleEndTime <= $currentTime)) {
                                                $_SESSION['create'] = "Please Enter a correct end date and time for the price drop.";
                                                echo "<script>window.location.href='';</script>";
                                                exit();
                                            } else {
                                                $userId = $NFT['userid'];
                                                $nftId = $NFT["nftid"];

                                                if ($salePrice < $nftFloorPrice) {
                                                    $updateFloorPrice = "UPDATE nft SET nftfloorprice='$salePrice' WHERE nftid = '$nftid'";
                                                    if (mysqli_query($conn, $updateFloorPrice)) {
                                                        $_SESSION['create'] = "Floor price updated successfully!";
                                                    } else {
                                                        echo "Error updating floor price: " . mysqli_error($conn);
                                                    }

                                                    $hostSale = $conn->prepare("INSERT INTO nftsale(userid, nftid, saleprice, salecreatedate, salecreatetime, saleenddate, saleendtime, salestatus) VALUES (?, ?, ?, ?, ?, ?, ?, 'activate')");
                                                    $hostSale->bind_param("iiissss", $userId, $nftId, $salePrice, $currentDate, $currentTime, $saleEndDate, $saleEndTime);

                                                    if ($hostSale->execute()) {
                                                        $_SESSION['create'] = "Your NFT Price Was Dropped! To $salePrice";
                                                        echo "<script>window.location.href='';</script>";
                                                        exit();
                                                    } else {
                                                        echo "Error: " . $conn->error;
                                                    }
                                                } else if ($salePrice > $nftFloorPrice) {
                                                    $hostSale = $conn->prepare("INSERT INTO nftsale(userid, nftid, saleprice, salecreatedate, salecreatetime, saleenddate, saleendtime, salestatus) VALUES (?, ?, ?, ?, ?, ?, ?, 'activate')");
                                                    $hostSale->bind_param("iiissss", $userId, $nftId, $salePrice, $currentDate, $currentTime, $saleEndDate, $saleEndTime);

                                                    if ($hostSale->execute()) {
                                                        $_SESSION['create'] = "Your NFT Price Was Dropped! To $salePrice";
                                                        echo "<script>window.location.href='';</script>";
                                                        exit();
                                                    } else {
                                                        echo "Error: " . $conn->error;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <?php if ($error) { ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong><?php echo $USER['username']; ?>!</strong> <?php echo $error; ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php } ?>
                                        <form action="" method="post">
                                            <div class="d-flex flex-wrap">
                                                <div class="form-group col-md-6">
                                                    <label>Sale End Date *</label>
                                                    <input type="date" class="form-control input" name="sale_end_date" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Sale End Time *</label>
                                                    <input type="time" class="form-control input" name="sale_end_time" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Sale Price *</label>
                                                    <input type="number" class="form-control input" name="sale_price" placeholder="Sale Price Drop" required>
                                                </div>
                                                <div class="form-group col-md-6 d-flex justify-content-center align-items-end">
                                                    <button class="btn btn-outline-danger w-100 p-2" name="btn-createsale"><i class="bi bi-graph-down-arrow me-4"></i>Drop Price</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                <?php  } ?>

                                <div id="auction_block_<?php echo $NFT['nftid']; ?>" class="mt-4 col-md-12" style="display: none;">
                                    <?php
                                    // Create nftcollection table if it doesn't exist
                                    // $sqlCreateAuction = "CREATE TABLE IF NOT EXISTS auction (
                                    //             auctionid INT AUTO_INCREMENT PRIMARY KEY,
                                    //             userid INT NOT NULL,
                                    //             nftid INT NOT NULL,
                                    //             auctioncreatedate DATE NOT NULL,
                                    //             auctioncreatetime TIME NOT NULL,
                                    //             auctionenddate DATE NOT NULL,
                                    //             auctionendtime TIME NOT NULL,
                                    //             auctionstatus VARCHAR(255) NOT NULL
                                    //             )";
                                    // $conn->query($sqlCreateAuction);
                                    $error = "";
                                    // Check if the form is submitted
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-auction'])) {

                                        // Retrieve form data
                                        $endDate = $_POST["enddate"];
                                        $endTime = $_POST["endtime"];

                                        // Validate end date and time
                                        $currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata")); // India time zone
                                        $currentDate = $currentDateTime->format("Y-m-d");
                                        $currentTime = $currentDateTime->format("H:i:s");

                                        if ($endDate < $currentDate || ($endDate == $currentDate && $endTime <= $currentTime)) {
                                            $_SESSION['create'] = " Please Enter a correct end date and time for auction.";
                                            echo "<script>window.location.href='';</script>";
                                            exit();
                                        } else {

                                            $userId = $NFT['userid'];
                                            $nftId = $NFT["nftid"];

                                            $sqlInsertAuction = "INSERT INTO auction (userid, nftid, auctioncreatedate, auctioncreatetime, auctionenddate, auctionendtime, auctionstatus)
                             VALUES ('$userId', '$nftId', '$currentDate', '$currentTime', '$endDate', '$endTime', 'active')";

                                            if ($conn->query($sqlInsertAuction) === TRUE) {
                                                $_SESSION['create'] = "Your Auction For NFT Hosting successful!.";
                                                echo "<script>window.location.href='';</script>";
                                                exit();
                                            } else {
                                                echo "Error: " . $conn->error;
                                            }
                                        }
                                    }
                                    ?>
                                    <div>
                                        <hr class="mt-3 mb-3" />
                                        <h5 class="text-center mb-3">Timed Auction</h5>
                                        <form action="" method="post">
                                            <div class="d-flex flex-wrap">
                                                <div class="form-group col-md-6">
                                                    <label for="enddate">End Date <span class="text-danger">*</span></label>
                                                    <input type="date" name="enddate" class="form-control input" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="enddate">End Time<span class="text-danger">*</span></label>
                                                    <input type="time" name="endtime" class="form-control input" required>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex justify-content-center mt-3">
                                                <button class="btn btn-primary" name="btn-auction">Create Auction</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <script>
                                    function toggleAuction(nftId) {
                                        var auctionBlock = $('#auction_block_' + nftId);

                                        // Check if the auction block is visible
                                        if (auctionBlock.is(':visible')) {
                                            // Hide the auction block with animation
                                            auctionBlock.slideUp();
                                        } else {
                                            // Show the auction block with animation
                                            auctionBlock.slideDown();
                                        }
                                    }
                                </script>

                            </div>
                            <!----------------------------------- NFT Auther Part End----------------------------------->
                        <?php } else { ?>
                            <?php if ($onSale) { ?>
                                <?php
                                $endDate = $NFTprice['saleenddate'];
                                $endTime = $NFTprice['saleendtime'];

                                // Convert the date and time to the desired format
                                $SaleEndDate = date('d F Y', strtotime($endDate));
                                $SaleEndTime = date('h:i', strtotime($endTime));
                                ?>

                                <div class="sale-time mb-2" id="sale-countdown">
                                    <i class="bi bi-clock me-1"></i>
                                    <span>Sale ends</span>
                                    <span id="countdown-date"><?php echo $SaleEndDate; ?></span>
                                    <span>At</span>
                                    <span id="countdown-time">
                                        <?php echo $SaleEndTime; ?>
                                    </span>
                                    <div id="countdown" style="font-size:30px;" class="mt-3 text-center caption"></div>
                                </div>
                                <hr class="mt-2 mb-2" />
                            <?php } ?>
                            <div class="nft-price">
                                <small class="caption">Current Price</small>
                                <p class="current-price">
                                    <?php echo $currentNFTPrice; ?> INR
                                    <span style="font-size:14px;" class="ms-2">
                                        <?php if ($currentNFTPrice < $NFT['nftprice']) { ?>
                                            <span style="color:red">
                                                <i class="bi bi-graph-down-arrow"></i>
                                                <?php
                                                $price = $currentNFTPrice - $NFT['nftprice'];
                                                echo $price . " INR Dropped";
                                                ?>
                                            </span>
                                        <?php } else if ($currentNFTPrice > $NFT['nftprice']) { ?>
                                            <span style="color:green">
                                                <i class="bi bi-graph-up-arrow"></i>
                                                <?php
                                                $price = $currentNFTPrice - $NFT['nftprice'];
                                                echo $price . " INR Up";
                                                ?>
                                            </span>
                                        <?php } ?>
                                        <span>
                                </p>
                                <small class="caption"><?php echo $NFT['nftsupply']; ?> item is available</small>
                                <div class="button mt-3 d-flex flex-wrap">
                                    <div class="col-md-12 d-flex flex-wrap">

                                        <?php
                                        $currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata")); // India time zone
                                        $currentDate = $currentDateTime->format("Y-m-d H:i:s");

                                        $sqlSelectAuction = "SELECT * FROM auction 
                                                 WHERE auctionstatus = 'active' 
                                                   AND nftid = '{$NFT['nftid']}' 
                                                   AND '$currentDate' BETWEEN auctioncreatedate AND CONCAT(auctionenddate, ' ', auctionendtime)
                                                   AND '$currentDate' <= CONCAT(auctionenddate, ' ', auctionendtime)";

                                        $result = $conn->query($sqlSelectAuction);
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $auctionId = $row["auctionid"];
                                                $auctionEndDate = $row["auctionenddate"];
                                                $auctionEndTime = $row["auctionendtime"];
                                                // Combine end date and time
                                                $auctionEndDateTime = "$auctionEndDate $auctionEndTime";
                                                $auctionEndTimestamp = strtotime($auctionEndDateTime);   ?>

                                                <div class="col-md-6">
                                                    <button style="width: 100%;" class="btn btn-primary mt-1 p-2" onclick="toggleBid(<?php echo $NFT['nftid'] ?>)">Bid</button>
                                                </div>

                                                <div class="col-md-6">
                                                    <button class="btn btn-outline-secondary mt-1 p-2 w-100" onclick="toggleOffer(<?php echo $NFT['nftid']; ?>)">Make Offer</button>
                                                </div>
                                                <?php
                                                // $BidTable = "CREATE TABLE IF NOT EXISTS nftoffers (
                                                //         offerid INT AUTO_INCREMENT PRIMARY KEY,
                                                //         userid INT NOT NULL,
                                                //         collectionid INT NOT NULL,
                                                //         nftid INT NOT NULL,
                                                //         offerprice DECIMAL(10, 2) NOT NULL,
                                                //         offersupply VARCHAR(255) NOT NULL,
                                                //         offerdate DATE NOT NULL,
                                                //         offertime TIME NOT NULL,
                                                //         offerenddate DATE NOT NULL,
                                                //         offerendtime TIME NOT NULL,
                                                //         offerstatus VARCHAR(255) NOT NULL
                                                //         )";
                                                // $conn->query($BidTable);
                                                $error = '';

                                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-offer'])) {
                                                    $offerprice = $_POST['offerprice'];
                                                    $offersupply = $_POST['offersupply'];
                                                    $nftSupply = $NFT['nftsupply'];

                                                    if ($offersupply <= $nftSupply) {

                                                        $MadeOffer = "INSERT INTO `nftoffers`(`userid`, `collectionid`, `nftid`, `offerprice`, `offersupply`, `offerdate`, `offertime`, `offerstatus`) VALUES ('$USER[id]','$collectionId','$NFT[nftid]','$offerprice','$offersupply','$currentDate','$currentTime','pending')";
                                                        if ($conn->query($MadeOffer) === TRUE) {
                                                            $_SESSION['create'] = "Your Offer Successfully Placed!";
                                                            echo "<script>window.location.href='';</script>";
                                                            exit();
                                                        } else {
                                                            $_SESSION['create'] = "$conn->error";
                                                        }
                                                    } else {
                                                        $_SESSION['create'] = "Please Enter Valid Quantity";
                                                        echo "<script>window.location.href='';</script>";
                                                        exit();
                                                    }
                                                }
                                                ?>
                                                <!-- offer Block -->
                                                <div id="offer_block_<?php echo $NFT['nftid']; ?>" class="col-md-12" style="display: none;">
                                                    <hr class="mb-3 mt-3" />
                                                    <form action="" method="post">
                                                        <div class="d-flex flex-wrap">
                                                            <h5 class="text-center col-md-12">
                                                                Make Call For NFT
                                                            </h5>
                                                            <div class="form-group col-md-6 p-1">
                                                                <input type="number" name="offerprice" class="form-control input" placeholder="Your Offer Price" required />
                                                            </div>
                                                            <div class="form-group col-md-6 p-1">
                                                                <input type="number" name="offersupply" class="form-control input" placeholder="Supply" required />
                                                            </div>
                                                            <div class="form-group d-flex col-md-12 p-1 align-items-center justify-content-center">
                                                                <button type="submit" class="btn btn-outline-primary w-100 p-2" name="btn-offer">Made Offer</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <script>
                                                        function toggleOffer(nftId) {
                                                            var auctionBlock = $('#offer_block_' + nftId);

                                                            // Check if the auction block is visible
                                                            if (auctionBlock.is(':visible')) {
                                                                // Hide the auction block with animation
                                                                auctionBlock.slideUp();
                                                            } else {
                                                                // Show the auction block with animation
                                                                auctionBlock.slideDown();
                                                            }
                                                        }
                                                    </script>
                                                </div>
                                                <hr class="w-100 mt-3 mb-2" />
                                                <!-- Show Auction Timing -->
                                                <div class="d-flex flex-column flex-wrap align-items-center mt-2 justify-content-center col-md-12" id="auction_<?php echo $auctionId; ?>">
                                                </div>

                                                <!------------ Bidding ------------>
                                                <?php
                                                // $BidTable = "CREATE TABLE IF NOT EXISTS bidding (
                                                //         biddingid INT AUTO_INCREMENT PRIMARY KEY,
                                                //         bidderid INT NOT NULL,
                                                //         auctionid INT NOT NULL,
                                                //         nftid INT NOT NULL,
                                                //         bidprice DECIMAL(10, 2) NOT NULL,
                                                //         biddate DATE NOT NULL,
                                                //         bidtime TIME NOT NULL,
                                                //         bidstatus VARCHAR(255) NOT NULL
                                                //         )";
                                                // $conn->query($BidTable);
                                                $error = '';

                                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-bid'])) {
                                                    $bidprice = $_POST['bidprice'];

                                                    // Select the last bid details
                                                    $selectbid = "SELECT * FROM bidding WHERE nftid = {$NFT['nftid']} AND auctionid = {$auctionId} ORDER BY biddingid DESC LIMIT 1";
                                                    $bidDetails = mysqli_query($conn, $selectbid);

                                                    if ($bidDetails && $bidDetails->num_rows > 0) {
                                                        $lastbid = mysqli_fetch_assoc($bidDetails)['bidprice'];

                                                        // Execute this if the last bid price exists
                                                        if ($lastbid < $bidprice) {
                                                            $InsertBid = "INSERT INTO bidding(`bidderid`, `auctionid`, `nftid`, `bidprice`, `biddate`, `bidtime`, `bidstatus`) VALUES ('$USER[id]', '$auctionId', '{$NFT['nftid']}', '$bidprice', '$currentDate', '$currentTime', 'bidded')";

                                                            if ($conn->query($InsertBid) === TRUE) {
                                                                $_SESSION['create'] = "Your Bid Successfully Placed!";
                                                                echo "<script>window.location.href='';</script>";
                                                                exit();
                                                            } else {
                                                                echo "Error: " . $conn->error;
                                                            }
                                                        } else {
                                                            $_SESSION['create'] = "Please Bid More Than: $lastbid INR";
                                                            echo "<script>window.location.href='';</script>";
                                                            exit();
                                                        }
                                                    } else {
                                                        // Execute this if the last bid price not exists
                                                        if ($NFT['nftprice'] < $bidprice) {
                                                            $InsertBid = "INSERT INTO bidding(`bidderid`, `auctionid`, `nftid`, `bidprice`, `biddate`, `bidtime`, `bidstatus`) VALUES ('$USER[id]', '$auctionId', '{$NFT['nftid']}', '$bidprice', '$currentDate', '$currentTime', 'bidded')";

                                                            if ($conn->query($InsertBid) === TRUE) {
                                                                $_SESSION['create'] = "Your Bid Successfully Placed!";
                                                                echo "<script>window.location.href='';</script>";
                                                                exit();
                                                            } else {
                                                                echo "Error: " . $conn->error;
                                                            }
                                                        } else {
                                                            $_SESSION['create'] = "Please Bid More Than: $NFT[nftprice] INR";
                                                            echo "<script>window.location.href='';</script>";
                                                            exit();
                                                        }
                                                    }
                                                }

                                                ?>
                                                <!-- bidding Block -->
                                                <div id="bid_block_<?php echo $NFT['nftid']; ?>" class="col-md-12" style="display: none;">
                                                    <hr class="mb-3 mt-3" />
                                                    <form action="" method="post">
                                                        <div class="d-flex flex-wrap">
                                                            <h5 class="text-center col-md-12">
                                                                Put Your Call
                                                            </h5>
                                                            <div class="form-group col-md-6 p-1">
                                                                <input type="number" name="bidprice" class="form-control input" placeholder="Your Bidding Price" required />
                                                            </div>
                                                            <div class="form-group d-flex col-md-6 p-1 align-items-center justify-content-center">
                                                                <button type="submit" class="btn btn-outline-primary w-100 p-2" name="btn-bid">Confirm Bid</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <script>
                                                        function toggleBid(nftId) {
                                                            var auctionBlock = $('#bid_block_' + nftId);

                                                            // Check if the auction block is visible
                                                            if (auctionBlock.is(':visible')) {
                                                                // Hide the auction block with animation
                                                                auctionBlock.slideUp();
                                                            } else {
                                                                // Show the auction block with animation
                                                                auctionBlock.slideDown();
                                                            }
                                                        }
                                                    </script>
                                                </div>


                                            <?php  } ?>
                                        <?php } else { ?>
                                            <!-- Buy NFT -->
                                            <div class="btn-group w-100 mt-1 col-md-6" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary p-2 w-25"><i class="bi bi-cart3"></i></button>
                                                <button type="button" class="btn btn-primary w-75" onclick="toggleBuy(<?php echo $NFT['nftid']; ?>)">Buy Now</button>
                                            </div>

                                            <!-- Make offer -->
                                            <div class="col-md-6">
                                                <button class="btn btn-outline-secondary mt-1 p-2 w-100" onclick="toggleOffer(<?php echo $NFT['nftid']; ?>)">Make Offer</button>
                                            </div>

                                            <!-- Buy NFT Block -->
                                            <div id="Buy_block_<?php echo $NFT['nftid']; ?>" class="col-md-12" style="display: none;">
                                                <?php
                                                // $nftTable = "CREATE TABLE IF NOT EXISTS nftactivity (
                                                //         transferid INT AUTO_INCREMENT PRIMARY KEY,
                                                //         autherid INT NOT NULL,
                                                //         currentautherid INT NOT NULL,
                                                //         nftid INT NOT NULL,
                                                //         nftprice DECIMAL(10, 2) NOT NULL,
                                                //         nftsupply VARCHAR(255) NOT NULL,
                                                //         activitydate DATE NOT NULL,
                                                //         activitytime TIME NOT NULL,
                                                //         nftactivitystatus VARCHAR(255) NOT NULL
                                                //         )";
                                                // $conn->query($nftTable);

                                                // $nftTable = "CREATE TABLE IF NOT EXISTS nftcollected (
                                                //         collectid INT AUTO_INCREMENT PRIMARY KEY,
                                                //         autherid INT NOT NULL,
                                                //         currentautherid INT NOT NULL,
                                                //         nftid INT NOT NULL,
                                                //         nftprice DECIMAL(10, 2) NOT NULL,
                                                //         nftsupply VARCHAR(255) NOT NULL,
                                                //         collectdate DATE NOT NULL,
                                                //         collecttime TIME NOT NULL,
                                                //         collectstatus VARCHAR(255) NOT NULL
                                                //         )";
                                                // $conn->query($nftTable);

                                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-Buying'])) {
                                                    $buysupply = $_POST['buysupply'];
                                                    $nftSupply = $NFT['nftsupply'];

                                                    if ($buysupply <= $nftSupply) {
                                                        $_SESSION['BUY_NFT'] = [
                                                            'collectionid' => $collection['collectionid'],
                                                            'collectionname' => $collection['collectionname'],
                                                            'currentNFTPrice' => $currentNFTPrice,
                                                            'buysupply' => $buysupply,
                                                            'nftid' => $NFT['nftid'],
                                                            'nftname' => $NFT['nftname'],
                                                            'nftautherid' => $NFT['userid'],
                                                            'nftimage' => $NFT['nftimage'],
                                                            'authid' => $USER['id'],
                                                            'authusername' => $USER['username'],
                                                            'buydate' => $currentDate,
                                                            'buytime' => $currentTime
                                                        ];

                                                        if ($_SESSION['BUY_NFT']) {
                                                            echo "<script>window.location.href='" . BASE_URL . "Trans/Wallet.php';</script>";
                                                            exit();
                                                        }
                                                    } else {
                                                        $_SESSION['create'] = "Please Enter Valid Quantity!";
                                                        echo "<script>window.location.href='';</script>";
                                                        exit();
                                                    }
                                                }
                                                ?>
                                                <hr class="mb-3 mt-3" />
                                                <form action="" method="post">
                                                    <div class="d-flex flex-wrap">
                                                        <h5 class="text-center col-md-12">
                                                            Buy Details
                                                        </h5>
                                                        <div class="form-group col-md-6 p-1">
                                                            <input type="number" name="buysupply" class="form-control input" placeholder="Enter Supply" required min="1" />
                                                        </div>
                                                        <div class="form-group d-flex col-md-6 p-1 align-items-center justify-content-center">
                                                            <button type="submit" class="btn btn-outline-primary w-100 p-2" name="btn-Buying">Buy</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <script>
                                                    function toggleBuy(nftId) {
                                                        var auctionBlock = $('#Buy_block_' + nftId);

                                                        // Check if the auction block is visible
                                                        if (auctionBlock.is(':visible')) {
                                                            // Hide the auction block with animation
                                                            auctionBlock.slideUp();
                                                        } else {
                                                            // Show the auction block with animation
                                                            auctionBlock.slideDown();
                                                        }
                                                    }
                                                </script>
                                            </div>

                                            <!-- Make Offer Block Query -->
                                            <?php
                                            // $BidTable = "CREATE TABLE IF NOT EXISTS nftoffers (
                                            //             offerid INT AUTO_INCREMENT PRIMARY KEY,
                                            //             userid INT NOT NULL,
                                            //             collectionid INT NOT NULL,
                                            //             nftid INT NOT NULL,
                                            //             offerprice DECIMAL(10, 2) NOT NULL,
                                            //             offersupply VARCHAR(255) NOT NULL,
                                            //             offerdate DATE NOT NULL,
                                            //             offertime TIME NOT NULL,
                                            //             offerenddate DATE NOT NULL,
                                            //             offerendtime TIME NOT NULL,
                                            //             offerstatus VARCHAR(255) NOT NULL
                                            //             )";
                                            // $conn->query($BidTable);
                                            $error = '';

                                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-offer'])) {
                                                $offerprice = $_POST['offerprice'];
                                                $offersupply = $_POST['offersupply'];
                                                $nftSupply = $NFT['nftsupply'];

                                                if ($offersupply <= $nftSupply) {

                                                    $MadeOffer = "INSERT INTO `nftoffers`(`userid`, `collectionid`, `nftid`, `offerprice`, `offersupply`, `offerdate`, `offertime`, `offerstatus`) VALUES ('$USER[id]','$collectionId','$NFT[nftid]','$offerprice','$offersupply','$currentDate','$currentTime','pending')";
                                                    if ($conn->query($MadeOffer) === TRUE) {
                                                        $_SESSION['create'] = "Your Offer Successfully Placed!";
                                                        echo "<script>window.location.href='';</script>";
                                                        exit();
                                                    } else {
                                                        $_SESSION['create'] = "$conn->error";
                                                    }
                                                } else {
                                                    $_SESSION['create'] = "Please Enter Valid Quantity";
                                                    echo "<script>window.location.href='';</script>";
                                                    exit();
                                                }
                                            }
                                            ?>
                                            <!-- offer Block -->
                                            <div id="offer_block_<?php echo $NFT['nftid']; ?>" class="col-md-12" style="display: none;">
                                                <hr class="mb-3 mt-3" />
                                                <form action="" method="post">
                                                    <div class="d-flex flex-wrap">
                                                        <h5 class="text-center col-md-12">
                                                            Make Call For NFT
                                                        </h5>
                                                        <div class="form-group col-md-6 p-1">
                                                            <input type="number" name="offerprice" class="form-control input" placeholder="Your Offer Price" required />
                                                        </div>
                                                        <div class="form-group col-md-6 p-1">
                                                            <input type="number" name="offersupply" class="form-control input" placeholder="Supply" required />
                                                        </div>
                                                        <div class="form-group d-flex col-md-12 p-1 align-items-center justify-content-center">
                                                            <button type="submit" class="btn btn-outline-primary w-100 p-2" name="btn-offer">Made Offer</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <script>
                                                    function toggleOffer(nftId) {
                                                        var auctionBlock = $('#offer_block_' + nftId);

                                                        // Check if the auction block is visible
                                                        if (auctionBlock.is(':visible')) {
                                                            // Hide the auction block with animation
                                                            auctionBlock.slideUp();
                                                        } else {
                                                            // Show the auction block with animation
                                                            auctionBlock.slideDown();
                                                        }
                                                    }
                                                </script>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Collection Info -->

                <div class="col-md-5 mt-3">
                    <div class="card rounded-2" style="border:2px solid #252525">
                        <div class="head">
                            <strong class="me-3"><i class="bi bi-layout-text-sidebar-reverse"></i></strong>
                            Description
                            <hr class="mb-3 mt-3" />
                            <?php
                            $getUser = "SELECT * FROM auth WHERE id = " . $collection['userid'];
                            $userDetails = mysqli_query($conn, $getUser);
                            $user = mysqli_fetch_assoc($userDetails);
                            ?>
                            <span class="collection-auther-name">
                                <span class="caption"> By </span>
                                <a href="<?php echo BASE_URL ?>userDashboard.php?username=<?php echo $user['username'] ?>" class="link">
                                    <?php echo $user['username'] ?>
                                </a>
                            </span>
                        </div>
                    </div>
                    <style>
                        #nft-description-details .nft-collection-image {
                            width: 100px;
                            height: 100px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            overflow: hidden;
                            border-radius: 5px;
                            border: 1px solid #252525;
                        }

                        #nft-description-details .nft-collection-image img {
                            object-fit: cover;
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                    <!-- collection Info -->
                    <div class="accordion mt-2" id="nft-description">
                        <div class="accordion-item card p-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nft-description-details" aria-expanded="true" aria-controls="collapse">
                                    <i class="bi bi-columns-gap me-3"></i> About <?php echo $collection['collectionname'] ?>
                                </button>
                            </h2>
                            <div id="nft-description-details" class="accordion-collapse collapse show" data-bs-parent="#nft-description">
                                <div class="accordion-body">
                                    <div class="d-flex">
                                        <div class="nft-collection-image">
                                            <img src="<?php echo BASE_URL . $collection['collectionimage'] ?>" alt="">
                                        </div>
                                        <div class="nft-collection-description col-md-9">
                                            <small><?php echo $collection['collectiondescription']; ?></small><br />
                                            <small>Category <strong class="text-capitalize"><?php echo $collection['collectioncategory']; ?></strong></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Collection Info -->
                    <div class="accordion mt-2" id="nft-description-2">
                        <div class="accordion-item card p-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nft-description-details-2" aria-expanded="true" aria-controls="collapse">
                                    <i class="bi bi-journal-richtext me-3"></i>More Details
                                </button>
                            </h2>
                            <div id="nft-description-details-2" class="accordion-collapse collapse show" data-bs-parent="#nft-description-2">
                                <div class="accordion-body">
                                    <div class="col-md-12 d-flex mt-1">
                                        <div class="col-md-6 d-flex justify-content-start">Conract Address</div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <?php
                                            $collectionAdress = base64_encode($enCollectionId) ?>
                                            <a href="<?php echo BASE_URL ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionId ?>" class="link">
                                                <?php echo $collectionAdress ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex mt-1">
                                        <div class="col-md-6 d-flex justify-content-start">Token Standard</div>
                                        <div class="col-md-6 d-flex justify-content-end">ERC-721</div>
                                    </div>
                                    <div class="col-md-12 d-flex mt-1">
                                        <div class="col-md-6 d-flex justify-content-start">Chain</div>
                                        <div class="col-md-6 d-flex justify-content-end text-uppercase"><?php echo $collection['collectionblockchain'] ?></div>
                                    </div>
                                    <div class="col-md-12 d-flex mt-1">
                                        <div class="col-md-6 d-flex justify-content-start">Last Updated</div>
                                        <div class="col-md-6 d-flex justify-content-end ">[ Time ]</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Price History -->
                <div class="mt-3 col-md-7">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item card p-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <strong class="me-3"><i class="bi bi-graph-up-arrow"></i></strong>
                                    Price History
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div style="width:100%; height:425px">
                                        <canvas id="nftChart" width="auto" height="auto"></canvas>
                                    </div>
                                    <?php
                                    // Fetch NFT price data
                                    $nftPriceQuery = "SELECT nftprice, nftcreated_date, nftcreated_time FROM nft WHERE nftid = {$NFT['nftid']} AND nftstatus = 'active'";
                                    $nftPriceResult = mysqli_query($conn, $nftPriceQuery);

                                    // Fetch offer prices data
                                    $offerPricesQuery = "SELECT saleprice, salecreatedate, salecreatetime FROM nftsale WHERE nftid = {$NFT['nftid']}";
                                    $offerPricesResult = mysqli_query($conn, $offerPricesQuery);

                                    // Check if queries executed successfully
                                    if ($nftPriceResult && $offerPricesResult) {
                                        $nftData = [];
                                        $offerData = [];

                                        // Fetch NFT price data
                                        while ($row = mysqli_fetch_assoc($nftPriceResult)) {
                                            $nftData[] = [
                                                'date' => $row['nftcreated_date'] . ' ' . $row['nftcreated_time'],
                                                'price' => $row['nftprice'],
                                            ];
                                        }

                                        // Fetch offer prices data
                                        while ($row = mysqli_fetch_assoc($offerPricesResult)) {
                                            $offerData[] = [
                                                'date' => $row['salecreatedate'] . ' ' . $row['salecreatetime'],
                                                'price' => $row['saleprice'],
                                            ];
                                        }

                                        // Merge NFT and offer data
                                        $allData = array_merge($nftData, $offerData);

                                        // Sort data by date
                                        usort($allData, function ($a, $b) {
                                            return strtotime($a['date']) - strtotime($b['date']);
                                        });

                                        // Convert data to JSON
                                        $allDataJson = json_encode($allData);
                                    }
                                    ?>

                                    <!-- Chart.js code -->
                                    <script>
                                        // Check if data is available
                                        <?php if (isset($allDataJson)) : ?>
                                            var ctx = document.getElementById('nftChart').getContext('2d');
                                            var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: <?php echo json_encode(array_column($allData, 'date')); ?>,
                                                    datasets: [{
                                                        label: 'NFT Prices',
                                                        data: <?php echo json_encode(array_column($allData, 'price')); ?>,
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 2,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        x: [{
                                                            type: 'time',
                                                            time: {
                                                                unit: 'day',
                                                                displayFormats: {
                                                                    day: 'MMM D'
                                                                }
                                                            }
                                                        }],
                                                        y: {
                                                            beginAtZero: true
                                                        }
                                                    }
                                                }
                                            });
                                        <?php endif; ?>
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- offers & bidder Details -->
                <div class="col-md-12">
                    <!-- NFT Offers -->
                    <div class="accordion mt-2" id="nft-offers">
                        <div class="accordion-item card p-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nft-offer" aria-expanded="true" aria-controls="collapse">
                                    <i class="bi bi-tag me-3"></i> Offers
                                </button>
                            </h2>
                            <div id="nft-offer" class="accordion-collapse collapse show" data-bs-parent="#nft-offers">
                                <div class="accordion-body p-1" style="overflow-y:scroll; max-height:250px;">
                                    <?php
                                    $selectOffer = "SELECT * FROM nftoffers WHERE offerstatus = 'pending' AND nftid = {$NFT['nftid']} ORDER BY offerid DESC";
                                    $offerDetails = mysqli_query($conn, $selectOffer);

                                    if ($offerDetails && $offerDetails->num_rows > 0) { ?>
                                        <table class="w-100">
                                            <tr>
                                                <td class="p-2 text-center caption">
                                                    Activity
                                                </td>
                                                <td class="p-2 text-center caption">
                                                    Offer Id
                                                </td>
                                                <td class="p-2 text-center caption">
                                                    User
                                                </td>
                                                <td class="p-2 text-center caption">
                                                    Price
                                                </td>
                                                <td class="p-2 text-center caption">
                                                    Supply
                                                </td>
                                                <td class="p-2 text-center caption">
                                                    Date & Time
                                                </td>

                                            </tr>
                                            <?php while ($OFFERS = mysqli_fetch_assoc($offerDetails)) {
                                                $OfferUser = "SELECT * FROM auth WHERE id = {$OFFERS['userid']}";
                                                $UserDetail = mysqli_query($conn, $OfferUser);
                                                if ($UserDetail) {
                                                    $userOffer = mysqli_fetch_assoc($UserDetail);
                                                }
                                            ?>
                                                <tr style="border-top: 1px solid #252525;">
                                                    <td class="p-2 text-center">

                                                        <i class="bi bi-hexagon-half ms-1 me-1"></i>
                                                        <small>Offered</small>
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        <small>
                                                            <?php
                                                            $offerid = $OFFERS['offerid'];
                                                            $enOfferid = md5($offerid);
                                                            echo $enOfferid;
                                                            ?>
                                                        </small>
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        <img src="<?php echo BASE_URL . $userOffer['userimage']; ?>" alt="User Image" height="50px" width="50px" class="rounded-1">
                                                        <small class="text-capitalize ms-2"><?php echo $userOffer['username']; ?></small>
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        <small><?php echo $OFFERS['offerprice']; ?> INR</small>
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        <small><?php echo $OFFERS['offersupply']; ?></small>
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        <small>
                                                            <?php echo date("d F Y", strtotime($OFFERS['offerdate'])); ?> |
                                                            <?php echo date("H : i", strtotime($OFFERS['offertime'])); ?>
                                                        </small>
                                                    </td>

                                                    <?php
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-offer-accept'])) {
                                                        if ($NFT['userid'] === $USER['id']) {
                                                            $updateStatus = "UPDATE nftoffers SET offerstatus = 'accept', 
                                                                offerenddate = DATE_ADD(NOW(), INTERVAL 1 DAY), 
                                                                offerendtime = '$currentTime' WHERE nftid = {$NFT['nftid']} AND offerid = {$OFFERS['offerid']}";

                                                            if ($conn->query($updateStatus) === TRUE) {
                                                                $_SESSION['create'] = "Your Offer Sent To $userOffer[username]";
                                                                require_once '../mailpage/nftofferaccept.php';
                                                                echo "<script>window.location.href='';</script>";
                                                                exit();
                                                            } else {
                                                                $_SESSION['create'] = $conn->error;
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                    <?php if ($NFT['userid'] === $USER['id']) { ?>
                                                        <td>
                                                            <form action="" method="post">
                                                                <button class="btn btn-outline-success" name="btn-offer-accept"><i class="bi bi-layer-forward"></i></button>
                                                            </form>
                                                        </td>
                                                    <?php } ?>

                                                </tr>
                                            <?php } ?>
                                        </table>
                                    <?php } else { ?>
                                        <div class="col-md-12 mt-3 mb-3">
                                            <div class="collection-offers">
                                                <div class="container-fluid">
                                                    <div class="no-offers" style="height: 200px; margin-top: 0px;">
                                                        <div>Offers Not Available</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata")); // India time zone
                    $currentDate = $currentDateTime->format("Y-m-d H:i:s");

                    $sqlSelectAuction = "SELECT * FROM auction 
                                                 WHERE auctionstatus = 'active' 
                                                   AND nftid = '{$NFT['nftid']}' 
                                                   AND '$currentDate' BETWEEN auctioncreatedate AND CONCAT(auctionenddate, ' ', auctionendtime)
                                                   AND '$currentDate' <= CONCAT(auctionenddate, ' ', auctionendtime)";

                    $result = $conn->query($sqlSelectAuction);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $auctionId = $row["auctionid"];
                            $auctionEndDate = $row["auctionenddate"];
                            $auctionEndTime = $row["auctionendtime"];
                            // Combine end date and time
                            $auctionEndDateTime = "$auctionEndDate $auctionEndTime";
                            $auctionEndTimestamp = strtotime($auctionEndDateTime); ?>

                            <!-- bidders block -->
                            <div class="accordion mt-2" id="nft-bidders">
                                <div class="accordion-item card p-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nft-bidder" aria-expanded="true" aria-controls="collapse">
                                            <i class="bi bi-diagram-3 me-3"></i> Bidders
                                        </button>
                                    </h2>
                                    <div id="nft-bidder" class="accordion-collapse collapse show" data-bs-parent="#nft-bidders">
                                        <div class="accordion-body p-1" style="overflow-y: scroll; max-height: 250px;">
                                            <?php
                                            // Select the last bid details
                                            $selectbid = "SELECT * FROM bidding WHERE nftid = {$NFT['nftid']} AND auctionid = {$auctionId} ORDER BY biddingid DESC";
                                            $bidDetails = mysqli_query($conn, $selectbid);

                                            if ($bidDetails && $bidDetails->num_rows > 0) { ?>

                                                <div class="container-fluid">
                                                    <table class="w-100" style="background-color: none;">
                                                        <thead class="position-sticky sticky-top z-1 p-0" style="background-color: #151515;">
                                                            <tr class="p-0 m-0">
                                                                <td class=" p-2 text-center caption">
                                                                    Activity
                                                                </td>
                                                                <td class="p-2 text-center caption">
                                                                    User
                                                                </td>
                                                                <td class="p-2 text-center caption">
                                                                    Unique Id
                                                                </td>
                                                                <td class="p-2 text-center caption">
                                                                    Bid Amount
                                                                </td>
                                                                <td class="p-2 text-center caption">
                                                                    Date & Time
                                                                </td>

                                                            </tr>

                                                        </thead>
                                                        <tbody style="max-height: 200px; overflow-y:scroll;">
                                                            <?php while ($bid = mysqli_fetch_assoc($bidDetails)) {
                                                                $getuser = "SELECT * FROM auth WHERE id = {$bid['bidderid']}";
                                                                $bidderDetails = mysqli_query($conn, $getuser);
                                                                if ($bidderDetails) {
                                                                    $bidder = mysqli_fetch_assoc($bidderDetails);
                                                                } ?>

                                                                <tr style="border-top:1px solid #252525;">

                                                                    <td class="p-2 text-center">
                                                                        <div>
                                                                            <i class="bi bi-bezier2 me-2"></i> Bid
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-2 text-center">
                                                                        <div>
                                                                            <img src="<?php echo BASE_URL . $bidder['userimage'] ?>" height="50px" width="50px" class="rounded-1">
                                                                            <a href=""><small class="ms-1 text-capitalize"><?php echo $bidder['username'] ?></small></a>
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-2 text-center">
                                                                        <div>
                                                                            <?php
                                                                            $enBidId = md5($bid['biddingid']);
                                                                            echo $enBidId;
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-2 text-center">
                                                                        <small><?php echo $bid['bidprice']; ?> INR</small>
                                                                    </td>
                                                                    <td class="p-2 text-center">
                                                                        <div>
                                                                            <small>
                                                                                <?php echo date("d F Y", strtotime($bid['biddate'])); ?> |
                                                                                <?php echo date("H : i", strtotime($bid['bidtime'])); ?>
                                                                            </small>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php  } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <?php  }
                    } ?>
                </div>

                <!-- NFT activity -->
                <div class="col-md-12">
                    <div class="accordion mt-2" id="nft-activity">
                        <div class="accordion-item card p-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nft-activitys" aria-expanded="true" aria-controls="collapse">
                                    <i class="bi bi-activity me-3"></i> Activity
                                </button>
                            </h2>
                            <div id="nft-activitys" class="accordion-collapse collapse show" data-bs-parent="#nft-activity">
                                <div class="accordion-body p-1" style="overflow-y:scroll; max-height:250px;">
                                    <?php
                                    $selectNFTactivity = "SELECT * FROM nftactivity WHERE nftid = {$NFT['nftid']} ORDER BY transferid DESC";
                                    $nftactivityDetails = mysqli_query($conn, $selectNFTactivity);
                                    if ($nftactivityDetails && mysqli_num_rows($nftactivityDetails) > 0) { ?>
                                        <table class="w-100">
                                            <thead>
                                                <tr>
                                                    <th class="p-3 text-capitalize text-center">Event</th>
                                                    <th class="p-3 text-capitalize text-center">Price</th>
                                                    <th class="p-3 text-capitalize text-center">From</th>
                                                    <th class="p-3 text-capitalize text-center">To</th>
                                                    <th class="p-3 text-capitalize text-center">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($NFTact = mysqli_fetch_assoc($nftactivityDetails)) { ?>
                                                    <tr style="border-top: 1px solid #252525;">
                                                        <td class="p-3 text-center text-capitalize">
                                                            <small>
                                                                <?php
                                                                if ($NFTact['nftactivitystatus'] == 'transfer') {
                                                                    echo '<i class="bi bi-arrow-left-right me-2"></i> Transfer';
                                                                } else if ($NFTact['nftactivitystatus'] == 'sale') {
                                                                    echo '<i class="bi bi-cart3 me-2"></i> Sale';
                                                                }
                                                                ?>
                                                            </small>
                                                        </td>
                                                        <td class="p-3 text-center text-capitalize">
                                                            <small>
                                                                <?php
                                                                if ($NFTact['nftprice'] <= '0') {
                                                                    echo '';
                                                                } else if ($NFTact['nftprice'] > '0') {
                                                                    echo $NFTact['nftprice'] . ' INR';
                                                                }
                                                                ?>
                                                            </small>
                                                        </td>
                                                        <td class="p-3 text-center text-capitalize">
                                                            <small>
                                                                <?php
                                                                $select = "SELECT * FROM auth WHERE id = {$NFTact['autherid']}";
                                                                $user = mysqli_query($conn, $select);
                                                                if ($user) {
                                                                    $actUser = mysqli_fetch_assoc($user);
                                                                    echo "<a href='" . BASE_URL . "userDashboard.php?username={$actUser['username']}' class='link'>";
                                                                    echo $actUser['username'];
                                                                    echo "</a>";
                                                                }
                                                                ?>
                                                            </small>
                                                        </td>
                                                        <td class="p-3 text-center text-capitalize">
                                                            <small>
                                                                <?php
                                                                $select = "SELECT * FROM auth WHERE id = {$NFTact['currentautherid']}";
                                                                $user = mysqli_query($conn, $select);
                                                                if ($user) {
                                                                    $actUser = mysqli_fetch_assoc($user);
                                                                    echo "<a href='" . BASE_URL . "userDashboard.php?username={$actUser['username']}' class='link'>";
                                                                    echo $actUser['username'];
                                                                    echo "</a>";
                                                                }
                                                                ?>
                                                            </small>
                                                            </a>
                                                        </td>
                                                        <td class="p-3 text-center text-capitalize">
                                                            <small data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo date('d F Y, H:i', strtotime($NFTact['activitydate'] . " " . $NFTact['activitytime'])); ?>">
                                                                <?php
                                                                date_default_timezone_set('Asia/Kolkata');
                                                                $activity_timestamp = strtotime($NFTact['activitydate'] . " " . $NFTact['activitytime']);
                                                                $time_difference = time() - $activity_timestamp;
                                                                if ($time_difference < 60) {
                                                                    $time_ago = $time_difference . " seconds ago";
                                                                } elseif ($time_difference < 3600) {
                                                                    $time_ago = round($time_difference / 60) . " minutes ago";
                                                                } elseif ($time_difference < 86400) {
                                                                    $time_ago = round($time_difference / 3600) . " hours ago";
                                                                } else {
                                                                    $time_ago = round($time_difference / 86400) . " days ago";
                                                                }
                                                                echo $time_ago;
                                                                ?>
                                                            </small>

                                                            <!-- Bootstrap JS -->
                                                            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

                                                            <script>
                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                                                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                                                        return new bootstrap.Tooltip(tooltipTriggerEl)
                                                                    });
                                                                });
                                                            </script>

                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="col-md-12">
                                            <div class="collection-offers">
                                                <div class="container-fluid">
                                                    <div class="no-offers">
                                                        <div>Activity Not Detected</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- More NFTs From Same Collection -->
                <div class="mt-3 col-md-12 p-0">
                    <div class="accordion" id="collection-related-items">
                        <div class="accordion-item card p-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collection-related-item" aria-expanded="true" aria-controls="collapse">
                                    <strong class="me-3"><i class="bi bi-grid-1x2"></i></strong>
                                    More From This Collection
                                </button>
                            </h2>
                            <div id="collection-related-item" class="accordion-collapse collapse show" data-bs-parent="#collection-related-items">
                                <div class="accordion-body p-0">
                                    <div class="d-flex flex-wrap collectionabout1 ">
                                        <?php
                                        $getNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND collectionid = " . $collection['collectionid'];
                                        $NFTDetails = mysqli_query($conn, $getNFT);

                                        if ($NFTDetails && $NFTDetails->num_rows > 0) {
                                            // $NFT = mysqli_fetch_assoc($NFTDetails);  

                                            while ($NFT = mysqli_fetch_assoc($NFTDetails)) {
                                                $nftid = $NFT['nftid'];
                                                $enNFTid = base64_encode($nftid);

                                                if ($nftid != $deNFTid) {
                                        ?>
                                                    <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>" class="col-md-2-5">
                                                        <div class="collection-nft-card">
                                                            <div class="nft-blockchain">
                                                                <?php
                                                                if ($row['collectionblockchain'] = 'inr') {
                                                                    echo '<span> ₹ </span>';
                                                                } ?>
                                                            </div>
                                                            <div class="collection-nft-image">
                                                                <img src="<?php echo BASE_URL . $NFT['nftimage'] ?>" alt="NFT Image">
                                                            </div>
                                                            <div class="collection-nft-detail">
                                                                <p class="nft-head"><?php echo $NFT['nftname'] ?></p>
                                                                <div class="d-flex">
                                                                    <div class="mt-3 text-left col-6">
                                                                        <small>
                                                                            BASE PRICE
                                                                        </small>
                                                                        <div>
                                                                            <?php echo $NFT['nftprice'] ?> INR
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right mt-3 col-6">
                                                                        <small>
                                                                            Floor Price
                                                                        </small>
                                                                        <div>
                                                                            <?php echo $NFT['nftfloorprice'] ?> INR
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="buy-button <?php
                                                                                    if ($NFT['userid'] === $USER['id']) {
                                                                                        echo 'hidden';
                                                                                    } else {
                                                                                        echo 'block';
                                                                                    } ?>">
                                                                <form>
                                                                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                                                                        <button type="button" class="btn btn-primary w-25"><i class="bi bi-cart3"></i></button>
                                                                        <button type="button" class="btn btn-primary w-75">Buy Now</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </a>

                                            <?php }
                                            }
                                        } else { ?>
                                            <div class="col-md-12 mt-3 mb-3">
                                                <div class="collection-offers">
                                                    <div class="container-fluid">
                                                        <div class="no-offers">
                                                            <div>More Items Not Available</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <?php
            } else { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>Opps! Somthing Wents Wrong</div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
    <?php }
    }

    ?>

</body>
<!-- Update Sale Time -->
<script>
    function updateCountdown(endDate, endTime) {
        var saleEnd = new Date(endDate + ' ' + endTime);

        function updateDisplay() {
            var now = new Date();
            var timeRemaining = saleEnd - now;

            if (timeRemaining < 0) {
                clearInterval(countdownInterval);
                document.getElementById('countdown').innerHTML = "Sale ended!";
                return;
            }

            var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            // Calculate total remaining time in hours, minutes, and seconds format
            var totalRemainingHours = (days * 24) + hours;
            var totalRemainingMinutes = minutes;
            var totalRemainingSeconds = seconds;

            document.getElementById('countdown').innerHTML = padZero(totalRemainingHours) + ' Hours : ' + padZero(totalRemainingMinutes) + ' Minutes : ' + padZero(totalRemainingSeconds) + ' Seconds';
        }

        var countdownInterval = setInterval(updateDisplay, 1000);
        updateDisplay(); // Initial display

        // Function to pad zeros to a number
        function padZero(num) {
            return num < 10 ? '0' + num : num;
        }
    }

    updateCountdown('<?php echo $endDate; ?>', '<?php echo $endTime; ?>');
</script>

<!-- Time Update Javascript -->
<script>
    function updateRemainingTime(serverTimezoneOffset) {
        var currentTime = Math.floor(Date.now() / 1000); // Current time in seconds
        var auctionEndTimestamp = <?php echo $auctionEndTimestamp; ?>;

        // Adjust the auction end timestamp based on the server's timezone offset
        auctionEndTimestamp += serverTimezoneOffset * 60; // Convert minutes to seconds

        var timeDifference = auctionEndTimestamp - currentTime;

        var days = Math.floor(timeDifference / (60 * 60 * 24));
        var hours = Math.floor((timeDifference % (60 * 60 * 24)) / (60 * 60));
        var minutes = Math.floor((timeDifference % (60 * 60)) / 60);
        var seconds = timeDifference % 60;

        var remainingTime = days + " Days | " + hours + "H : " + minutes + "M : " + seconds + "s";

        $("#auction_<?php echo $auctionId; ?>").html("Auction Duration: " + remainingTime);
    }

    // Pass the server's timezone offset to the function
    var serverTimezoneOffset = <?php echo (new DateTimeZone("Asia/Kolkata"))->getOffset(new DateTime()) / 60; ?>;

    setInterval(function() {
        updateRemainingTime(serverTimezoneOffset);
    }, 1000);

    updateRemainingTime(serverTimezoneOffset);
</script>

<!-- alert Loader -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertContainer = document.getElementById('cust_alertContainer');

        setTimeout(function() {
            alertContainer.style.right = '20px';

            setTimeout(function() {
                alertContainer.style.right = '-400px';
            }, 5000);
        }, 50);
    });
</script>

</html>
<?php require_once '../footer.php' ?>