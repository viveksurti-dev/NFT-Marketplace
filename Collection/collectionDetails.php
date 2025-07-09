<?php
require_once '../Navbar.php';
require_once '../config.php';

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../error-001.php?allowRedirect=true';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection - NFT Marketplace</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Styles/nft.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Styles/main.css">
    <!-- CSS : nft.css | Line : 266 -->
    <style>

    </style>

</head>

<body>
    <?php
    if (isset($_GET['collectionid'])) {
        $enCollectionid = $_GET['collectionid'];
        $deId = base64_decode($enCollectionid);

        $collectionDetails = "SELECT * FROM nftcollection WHERE collectionid = '$deId'";
        $getCollection = mysqli_query($conn, $collectionDetails);


        if ($getCollection && $getCollection->num_rows > 0) {
            $row = mysqli_fetch_assoc($getCollection);

            $collectionUserDetails = "SELECT * FROM auth WHERE id = " . $row['userid'];
            $collectionUser = mysqli_query($conn, $collectionUserDetails);

            if ($collectionUser && $collectionUser->num_rows > 0) {
                $userRow = mysqli_fetch_assoc($collectionUser);

    ?>
                <div>
                    <div class="container-collection-detail col-md-12 p-0">
                        <div class="collection-background" style="background-image: url('<?php echo BASE_URL . $row['collectionbackground'] ?>')">

                            <div class="container-fluid collections-details d-flex justify-content-between align-items-end">
                                <div class="col-md-3">
                                    <div class="collections-image">
                                        <img src="<?php echo BASE_URL . $row['collectionimage'] ?>" alt="Collection Image">
                                    </div>
                                    <div class="collection-holder mt-2">
                                        <p sty>
                                            <?php echo $row['collectionname'] ?>
                                            <?php if ($row['userid'] == $USER['id']) { ?>
                                                <a href="<?php echo BASE_URL ?>/Collection/editCollection.php?collectionid=<?php echo $enCollectionid ?>" class="edit-icons ms-2">
                                                    <img src="<?php echo BASE_URL ?>Assets/icons/pencil-fill.svg" class="mb-1">
                                                </a>
                                            <?php } ?>

                                        </p>
                                        <small class="caption">
                                            <?php echo $userRow['username']; ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex mb-3 justify-content-between" style="overflow-x:auto;">
                                    <div>
                                        <p class="text-center">₹
                                            <?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid =" . $row['collectionid'];
                                            $volume = mysqli_query($conn, $getTotalPrice);
                                            if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                                if ($totalVolume['nftprice'] <= 0) {
                                                    echo '00';
                                                } else if ($totalVolume['nftprice'] < 9) {
                                                    echo '0' . $totalVolume['nftprice'];
                                                } else {
                                                    echo $totalVolume['nftprice'];
                                                }
                                            }
                                            ?></p>
                                        <small class="caption">Total Volume</small>
                                    </div>
                                    <div>
                                        <p class="text-center">₹
                                            <?php
                                            $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = " . $row['collectionid'];
                                            $volume = mysqli_query($conn, $getTotalPrice);
                                            $volume = mysqli_query($conn, $getTotalPrice);
                                            if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                                if ($totalVolume['nftfloorprice'] <= 0) {
                                                    echo '00';
                                                } else if ($totalVolume['nftfloorprice'] <= 9) {
                                                    echo '0' . $totalVolume['nftfloorprice'];
                                                } else {
                                                    echo $totalVolume['nftfloorprice'];
                                                }
                                            }
                                            ?>
                                        </p>
                                        <small class="caption">Floor Price</small>
                                    </div>
                                    <div>
                                        <p class="text-center">₹
                                            <?php
                                            $getTotalPrice = "SELECT MIN(offerprice) as offerprice 
                                            FROM nftoffers 
                                            WHERE collectionid = " . $row['collectionid'];
                                            $volume = mysqli_query($conn, $getTotalPrice);

                                            if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                                if ($totalVolume['offerprice'] <= 0) {
                                                    echo '00';
                                                } else if ($totalVolume['offerprice'] <= 9) {
                                                    echo '0' . $totalVolume['offerprice'];
                                                } else {
                                                    echo $totalVolume['offerprice'];
                                                }
                                            } else {
                                                echo '00 INR';
                                            }
                                            ?>
                                        </p>
                                        <small class="caption">Best Offer</small>
                                    </div>
                                    <div>
                                        <p class="text-center">
                                            <!-- get Total Nfts Of Collection -->
                                            <?php
                                            $getNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND collectionid = " . $row['collectionid'];
                                            $NFTDetails = mysqli_query($conn, $getNFT);
                                            if ($NFTDetails && $NFTDetails->num_rows > 0) {
                                                $totalNFT = mysqli_num_rows($NFTDetails);
                                                if ($totalNFT <= 9) {
                                                    echo "0" . $totalNFT;
                                                } else {
                                                    echo $totalNFT;
                                                }
                                            } else {
                                                echo '00';
                                            }

                                            ?>
                                        </p>
                                        <small class="caption">Items</small>
                                    </div>
                                    <div>
                                        <p class="text-center">
                                            <?php
                                            // Query to count total unique users
                                            $countQuery = "SELECT COUNT(DISTINCT userid) AS total_users FROM nft WHERE collectionid = $deId";
                                            $result = mysqli_query($conn, $countQuery);

                                            if ($result) {
                                                // Fetch the result
                                                $total = mysqli_fetch_assoc($result);
                                                $totalUsers = $total['total_users'];

                                                // Echo the total
                                                echo "$totalUsers";
                                            } else {
                                                // Query failed
                                                echo "Query failed";
                                            }
                                            ?>

                                        </p>
                                        <small class="caption">Owners</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collection-description container-fluid d-flex flex-wrap">
                        <div class="col-md-8">
                            <p class="caption ">
                                <span class="text-capitalize">
                                    <?php echo $row['collectiondescription'] ?>
                                </span>
                            </p>
                            <?php
                            $originalDate = $row['collection_created_date'];
                            $collectionDate = date('M Y', strtotime($originalDate));
                            ?>
                            <div class="d-flex">
                                <p>Created <?php echo $collectionDate ?></p>
                                <i class="bi bi-dot ms-1 me-1"></i>
                                <p>Blockchain
                                    <span class="text-capitalize">
                                        <?php echo $row['collectionblockchain'] ?>
                                    </span>
                                </p>
                                <i class="bi bi-dot ms-1 me-1"></i>
                                <p>Category
                                    <span class="text-capitalize">
                                        <?php echo $row['collectioncategory'] ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <p class="caption d-flex justify-content-end col-md-4">
                            <a href="#"><i class="bi bi-three-dots"></i></a>
                        </p>
                    </div>
                    <div class="container-fluid mt-2 mb-2">
                        <div class="collection-about col-md-12 d-flex " style="overflow-X:scroll;">
                            <div class="collection-about col-md-12 d-flex " style="overflow-X:scroll;">
                                <button id="collectionbtn1" class="m-2 btn dash-menu active" onclick="showContent('collectionabout1', 'collectionbtn1')">Items</button>
                                <button id="collectionbtn2" class="m-2 btn dash-menu" onclick="showContent('collectionabout2', 'collectionbtn2')">Offers</button>
                                <button id="collectionbtn3" class="m-2 btn dash-menu" onclick="showContent('collectionabout3', 'collectionbtn3')">Analytics</button>
                                <button id="collectionbtn4" class="m-2 btn dash-menu" onclick="showContent('collectionabout4', 'collectionbtn4')">Activity</button>
                            </div>

                            <script>
                                // Function to activate the correct menu
                                function showContent(contentId, buttonId) {
                                    // Hide all content 
                                    var contentDivs = document.getElementsByClassName('content');
                                    for (var i = 0; i < contentDivs.length; i++) {
                                        contentDivs[i].classList.add('hidden');
                                    }

                                    // Deactivate all buttons
                                    var buttonElements = document.getElementsByTagName('button');
                                    for (var i = 0; i < buttonElements.length; i++) {
                                        buttonElements[i].classList.remove('active');
                                    }

                                    // Show the selected content and activate the corresponding button
                                    document.getElementById(contentId).classList.remove('hidden');
                                    document.getElementById(buttonId).classList.add('active');

                                    // // Store the active button in local storage
                                    // localStorage.setItem('activeButtonId', buttonId);
                                }
                            </script>

                        </div>

                    </div>
                    <div class="container-fluid">
                        <hr class="mt-1 mb-1" />
                    </div>
                    <div class="container-fluid mt-2">
                        <!-- Collection NFTs -->
                        <style>
                            .collectionabout1 a {
                                text-decoration: none;
                                text-shadow: none;
                                color: white;
                            }
                        </style>
                        <div id="collectionabout1" class="content ">
                            <div class="d-flex flex-wrap collectionabout1">
                                <?php
                                $getNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND collectionid = " . $row['collectionid'];
                                $NFTDetails = mysqli_query($conn, $getNFT);

                                if ($NFTDetails && $NFTDetails->num_rows > 0) {
                                    // $NFT = mysqli_fetch_assoc($NFTDetails);  

                                    while ($NFT = mysqli_fetch_assoc($NFTDetails)) {
                                        $nftid = $NFT['nftid'];
                                        $nftUserId = $NFT['userid'];
                                        $enNFTid = base64_encode($nftid);
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
                                                    <div class="mt-2 d-flex justify-content-between">
                                                        <div>
                                                            <small class="caption">
                                                                Floorprice
                                                            </small>
                                                            <div><?php echo $NFT['nftfloorprice'] ?> INR</div>
                                                        </div>
                                                        <div class="text-end">
                                                            <small class="caption">
                                                                Base Price
                                                            </small>
                                                            <div><?php echo $NFT['nftprice'] ?> INR </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="buy-button 
                                            <?php
                                            if ($NFT['userid'] == $USER['id']) {
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
                                } else { ?>
                                    <div class="col-md-12">
                                        <div class="collection-offers">
                                            <div class="container-fluid">
                                                <div class="no-offers">
                                                    <div>Items Not Available</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php  } ?>
                            </div>
                        </div>
                        <div id="collectionabout2" class="collectionabout2 content hidden">
                            <div class="collection-offers">
                                <?php
                                $selectOffer = "SELECT * FROM nftoffers WHERE offerstatus = 'pending' AND collectionid = {$row['collectionid']} ORDER BY offerid DESC";
                                $offerDetails = mysqli_query($conn, $selectOffer);

                                if ($offerDetails && $offerDetails->num_rows > 0) {
                                ?>
                                    <table class="w-100">
                                        <tr>
                                            <td class="p-2 text-center caption">Activity</td>
                                            <td class="p-2 text-center caption">Offer Id</td>
                                            <td class="p-2 text-center caption">User</td>
                                            <td class="p-2 text-center caption">Item</td>
                                            <td class="p-2 text-center caption">Price</td>
                                            <td class="p-2 text-center caption">Supply</td>
                                            <td class="p-2 text-center caption">Date & Time</td>
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
                                                    <a href="<?php echo BASE_URL ?>userDashboard.php?username=<?php echo $userRow['username'] ?>">
                                                        <img src="<?php echo BASE_URL . $userOffer['userimage']; ?>" alt="User Image" height="50px" width="50px" class="rounded-1">
                                                        <small class="text-capitalize ms-2"><?php echo $userOffer['username']; ?></small>
                                                </td>
                                                <td class="p-2 text-center">
                                                    <?php
                                                    $Offernft = "SELECT * FROM nft WHERE nftid = {$OFFERS['nftid']}";
                                                    $NFTDetails = mysqli_query($conn, $Offernft);

                                                    if ($NFTDetails && $NFTDetails->num_rows > 0) {
                                                        $nftoffer = mysqli_fetch_assoc($NFTDetails);
                                                        $enNFTId = base64_encode($nftoffer['nftid']);
                                                    ?>
                                                        <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                                            <img src="<?php echo BASE_URL . $nftoffer['nftimage']; ?>" alt="item Image" width="50px" height="50px" class="rounded-1 object-fit-cover me-1">
                                                            <small><?php echo $nftoffer['nftname']; ?></small>
                                                        </a>
                                                    <?php } ?>
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
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } else { ?>
                                    <div class="col-md-12">
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
                        <div id="collectionabout3" class="collectionabout3 content hidden">
                            <div class="container-fluid d-flex justify-content-end">
                                <div class="mb-2 mt-2">
                                    <div class="btn-group container">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Last 7 Days
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button class="dropdown-item" id="last7DaysBtn">Last 7 Days</button></li>
                                            <li><button class="dropdown-item" id="lastMonthBtn">Last Month</button></li>
                                            <li><button class="dropdown-item" id="lastYearBtn">Last Year</button></li>
                                            <li><button class="dropdown-item" id="allTimeBtn">All Time</button></li>
                                        </ul>
                                        <script>
                                            // jQuery script to handle dropdown item clicks
                                            $(document).ready(function() {
                                                $(".dropdown-item").click(function() {
                                                    var selectedText = $(this).text();
                                                    $(".btn-primary").html(selectedText);
                                                });
                                            });
                                        </script>
                                        <script>
                                            $(document).ready(function() {
                                                $("#last7DaysBtn, #lastMonthBtn, #lastYearBtn, #allTimeBtn").on("click", function() {
                                                    var timePeriod = $(this).text().toLowerCase().replace(/\s/g, '');

                                                    $.ajax({
                                                        url: "totalVolume.php",
                                                        method: "POST",
                                                        data: {
                                                            timePeriod: timePeriod
                                                        },
                                                        success: function(response) {
                                                            $("#volumeCard").html('<div class="card"><small class="caption"> Volume</small><h4 class="mt-3">' + response + '</h4></div>');
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error("Error fetching data:", error);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="collection-details d-flex flex-wrap">
                                    <div class="col-md-4 mt-1" id="volumeCard">
                                        <?php
                                        $currentDate = date('Y-m-d');
                                        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));

                                        // Fetch and display data for the last 7 days by default
                                        $sql = "SELECT SUM(nftprice) AS nftprice FROM nft WHERE nftstatus = 'active' AND collectionid = $row[collectionid] AND nftcreated_date BETWEEN '$sevenDaysAgo' AND '$currentDate'";
                                        $result = $conn->query($sql);

                                        if ($result === false) {
                                            die("Error executing the query: " . $conn->error);
                                        }

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $totalPrice = $row['nftprice']; ?>

                                            <div class="card">
                                                <small class="caption"> Volume</small>
                                                <h4 class="mt-3"><?php echo number_format($totalPrice, 2); ?> INR</h4>
                                            </div>
                                        <?php   } else {
                                            echo "No data found";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="card">
                                            <small class="caption">Floor Price</small>
                                            <h4 class="mt-3">
                                                <?php
                                                $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = $deId";
                                                $volume = mysqli_query($conn, $getTotalPrice);
                                                $volume = mysqli_query($conn, $getTotalPrice);
                                                if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                                    if ($totalVolume['nftfloorprice'] <= 0) {
                                                        echo '00';
                                                    } else if ($totalVolume['nftfloorprice'] <= 9) {
                                                        echo '0' . $totalVolume['nftfloorprice'];
                                                    } else {
                                                        echo $totalVolume['nftfloorprice'];
                                                    }
                                                }
                                                ?> INR
                                            </h4>

                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="card">
                                            <small class="caption">Floor Price</small>
                                            <h4 class="mt-3">

                                                <?php
                                                $getTotalPrice = "SELECT MIN(offerprice) as offerprice 
                                            FROM nftoffers 
                                            WHERE collectionid = $deId";
                                                $volume = mysqli_query($conn, $getTotalPrice);
                                                $volume = mysqli_query($conn, $getTotalPrice);
                                                if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                                    if ($totalVolume['offerprice'] <= 0) {
                                                        echo '00';
                                                    } else if ($totalVolume['offerprice'] <= 9) {
                                                        echo '0' . $totalVolume['offerprice'];
                                                    } else {
                                                        echo $totalVolume['offerprice'];
                                                    }
                                                }
                                                ?> INR
                                            </h4>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collectionabout4" class="collectionabout4 content hidden">
                            <?php
                            // Get All Activities of Collection
                            $row = mysqli_fetch_assoc($getCollection);
                            $deId = base64_decode($enCollectionid);
                            $getActivity = "SELECT * FROM activity WHERE collectionid = " . $deId . " ORDER BY activityid DESC";
                            $activityDetails = mysqli_query($conn, $getActivity);


                            if ($activityDetails && $activityDetails->num_rows > 0) {
                            ?>
                                <style>
                                    .activity-table {
                                        width: 100%;
                                        margin-top: 10px;
                                        border-radius: 5px;
                                        overflow: hidden;
                                    }

                                    .activity-table thead {
                                        background-color: #181818;
                                        border-bottom: 1px solid #303030;
                                    }

                                    .activity-table thead th {
                                        padding: 10px 5px;
                                        text-align: center;
                                    }

                                    .activity-table tbody td {
                                        padding: 15px 5px;
                                        text-align: center;
                                        border-bottom: 1px solid #303030;
                                    }
                                </style>
                                <div class="collection-offers">
                                    <div class="container-fluid">
                                        <?php
                                        if ($activityDetails && $activityDetails->num_rows > 0) { ?>

                                            <div class='table-responsive'>
                                                <table class='activity-table'>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Item</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php while ($activity = mysqli_fetch_assoc($activityDetails)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?php
                                                                    if ($activity['activityicon'] == 'createcollection') {
                                                                        echo '<div class="d-flex justify-content-around">
                                                                            <span class="col-3"><i class="bi bi-box-seam "></i></span>
                                                                            <span class="col-9"> Contract Deployed </span>
                                                                        </div>';
                                                                    } else if ($activity['activityicon'] == 'sale') {
                                                                        echo '<div class="d-flex justify-content-around">
                                                                            <span class="col-3"><i class="bi bi-cart3"></i></span>
                                                                            <span class="col-9"> Sale </span>
                                                                        </div>';
                                                                    } else if ($activity['activityicon'] == 'createnft') {
                                                                        echo '<div class="d-flex justify-content-around">
                                                                            <span class="col-3"><i class="bi bi-card-heading"></i></span>
                                                                            <span class="col-9"> NFT Created </span>
                                                                        </div>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <style>
                                                                    .activity-product .product-image {
                                                                        width: 65px;
                                                                        height: 65px;
                                                                        padding: 0 !important;
                                                                        border: 2px solid #252525;
                                                                    }

                                                                    .activity-product .product-image img {
                                                                        width: 100%;
                                                                        height: 100%;
                                                                        aspect-ratio: 1;
                                                                        object-fit: cover;
                                                                    }
                                                                </style>
                                                                <!-- Items Info -->
                                                                <td class="activity-product">
                                                                    <?php
                                                                    // Collection Details from Collection table using collection id
                                                                    $selectCollection = "SELECT * FROM nftcollection WHERE collectionid = " . $activity['activityitem'];
                                                                    $collectionDetails = mysqli_query($conn, $selectCollection);

                                                                    // get nft details using nft id
                                                                    $selectNFT = "SELECT * FROM nft WHERE (nftstatus = 'active' OR nftstatus = 'transferd') AND nftid = " . $activity['nftid'];

                                                                    $nftDetails = mysqli_query($conn, $selectNFT);

                                                                    if ($collectionDetails && $collectionDetails->num_rows > 0) {
                                                                        $item = mysqli_fetch_assoc($collectionDetails);
                                                                        $itemsimage = $item['collectionimage'];
                                                                        $itemsname = $item['collectionname'];
                                                                        $itemscategory = $item['collectioncategory'];
                                                                        $itemprice = "-";
                                                                    } elseif ($nftDetails && $nftDetails->num_rows > 0) {
                                                                        $nft = mysqli_fetch_assoc($nftDetails);
                                                                        $itemsimage = $nft['nftimage'];
                                                                        $itemsname = $nft['nftname'];
                                                                        $itemscategory = "-";
                                                                        $itemprice = $nft['nftprice'];
                                                                    }

                                                                    ?>
                                                                    <div class="d-flex justify-content-center">
                                                                        <div class="product-image me-2 col-6">
                                                                            <img src="<?php echo BASE_URL . $itemsimage ?>" loading="lazy">
                                                                        </div>
                                                                        <div class="product-info d-flex col-6 flex-column text-left justify-content-center text-capitalize">
                                                                            <small> <?php echo $itemsname; ?></small>
                                                                            <small> <?php echo $itemscategory; ?></small>
                                                                        </div>
                                                                    </div>


                                                                </td>

                                                                <td>
                                                                    <?php echo $itemprice; ?>
                                                                </td>

                                                                <td>
                                                                    <?php if ($activity['activtyquantity'] <= 0) {
                                                                        echo '-';
                                                                    } else {
                                                                        echo $activity['activtyquantity'];
                                                                    } ?>
                                                                </td>

                                                                <td><?php
                                                                    // get user details using nft id
                                                                    $fromuser = "SELECT * FROM auth WHERE id = " . $activity['activityfrom'];
                                                                    $fromDetails = mysqli_query($conn, $fromuser);

                                                                    if ($from = mysqli_fetch_assoc($fromDetails)) {
                                                                        echo "<span class='text-capitalize'>
                                                                            <a href='" . BASE_URL . "userDashboard.php?username=$from[username]' class='link'>
                                                                                $from[username]
                                                                            </a>
                                                                        <span>";
                                                                    }

                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                    // get user details using user id
                                                                    if ($activity['activityto'] > 0) {
                                                                        $fromuser = "SELECT * FROM auth WHERE id = " . $activity['activityto'];
                                                                        $fromDetails = mysqli_query($conn, $fromuser);

                                                                        if ($from = mysqli_fetch_assoc($fromDetails)) {
                                                                            echo "<span class='text-capitalize'>
                                                                             <a href='" . BASE_URL . "userDashboard.php?username=$from[username]' class='link'>
                                                                                 $from[username]
                                                                             </a>
                                                                         <span>";
                                                                        }
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo $activity['activity_date']; ?>
                                                                    <br />
                                                                    <?php echo $activity['activity_time'] ?>
                                                                </td>

                                                            </tr>
                                                    <?php }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="collection-offers">
                                    <div class="container-fluid">
                                        <div class="no-offers">
                                            <div>No Activities Are Here</div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
    <?php
            } else {
                echo 'User not found';
            }
        }
    } else {
        echo "Collection ID not set.";
    }
    ?>
</body>

</html>
<!-- Container Open Script -->
<script>
    // Function to activate the correct menu
    function showContent(contentId, buttonId) {
        // Hide all content 
        var contentDivs = document.getElementsByClassName('content');
        for (var i = 0; i < contentDivs.length; i++) {
            contentDivs[i].classList.add('hidden');
        }

        // Deactivate all buttons
        var buttonElements = document.getElementsByTagName('button');
        for (var i = 0; i < buttonElements.length; i++) {
            buttonElements[i].classList.remove('active');
        }

        // Show the selected content and activate the corresponding button
        document.getElementById(contentId).classList.remove('hidden');
        document.getElementById(buttonId).classList.add('active');

        // // Store the active button in local storage
        // localStorage.setItem('activeButtonId', buttonId);
    }
</script>

<?php require_once '../footer.php'; ?>