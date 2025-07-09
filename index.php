<?php
require_once("Navbar.php");
// Database connection details
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">
    <link rel="stylesheet" type="text/css" href="Styles/nft.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .card,
        .faq-card {
            background-color: #191919 !important;

        }

        .nft-collection a {
            text-decoration: none;
            text-shadow: none;
            color: white;
        }
    </style>

</head>

<body>

    <div style="position: relative;">
        <div>
            <video id="myVideo" autoplay muted loop style="object-fit: cover;" width="100%" height="500">
                <source src="./Assets/ads/OthersideTrailer.mp4" type="video/mp4">
            </video>
            <div style="position: absolute; bottom: 30px; left:30px; font-size: 125%;"><span style="color:blueviolet; font-weight: bold; text-shadow: 5px 0px 10px blueviolet;">| </span><small>Otherside Trailer</small></div>
        </div>
    </div>

    <!-- Display In ART categories NFT Collections-->
    <?php
    $selectcollection = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND collectioncategory = 'art' ORDER BY collectionid DESC LIMIT 5";
    $collectionDetails = mysqli_query($conn, $selectcollection); ?>
    <div class=" mt-3 d-flex justify-content-between">
        <div style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
            <h3 class="ms-3 p-2 pb-0 rounded-1">New In Art</h3>
        </div>
        <div>
            <a href="<?php echo BASE_URL ?>Collection/categorizeCollection.php?collectioncategory=art" class="me-3 btn btn-outline-primary ">See Category</a>
        </div>
    </div>
    <?php if ($collectionDetails && $collectionDetails->num_rows > 0) { ?>
        <div class="container-fluid nft-collection">
            <div class="faq-body justify-content-start d-flex flex-wrap">
                <?php
                while ($categorizecollection = mysqli_fetch_assoc($collectionDetails)) {
                    $collectionid = $categorizecollection['collectionid'];
                    $enCollectionid = base64_encode($collectionid); ?>
                    <!-- Collection CARD -->
                    <div class="col-md-2-5">
                        <a class="card faq-card p-2" href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" style="height:auto; width:100%; background:#121212;">
                            <div class="collection-nft-image d-flex rounded-1 justify-content-center align-items-center" style="width:100%; height:200px; overflow:hidden; text-shadow:none;">
                                <img loading="lazy" src="<?php echo $categorizecollection['collectionimage']; ?>" style="object-fit:cover; height:100%; width:100%;" loading="lazy">
                            </div>
                            <div class="category-nft-details" style="padding: 10px;">
                                <div class="collection-name" style="font-size:18px;">
                                    <?php echo $categorizecollection['collectionname']; ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <small class="caption">
                                            Floor Price
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = {$categorizecollection['collectionid']}";
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
                                            ?> INR</p>
                                    </div>
                                    <div>
                                        <small class="caption">
                                            Total Volume
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid =" . $categorizecollection['collectionid'];
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
                                            ?> INR</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12">
            <div class="collection-offers">
                <div class="container-fluid">
                    <div class="no-offers">
                        <div>Collections Not Available In ART</div>
                        <div><a href="<?php echo BASE_URL ?>creation.php" class="btn btn-outline-danger mt-2">Create Yours</a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>



    <!-- Display In Gaming categories NFT Collections -->

    <?php
    $selectcollection = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND collectioncategory = 'gaming' ORDER BY collectionid DESC LIMIT 5";
    $collectionDetails = mysqli_query($conn, $selectcollection); ?>
    <div class=" mt-3 d-flex justify-content-between">
        <div style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
            <h3 class="ms-3 p-2 pb-0 rounded-1">New In Gaming</h3>
        </div>
        <div>
            <a href="<?php echo BASE_URL ?>Collection/categorizeCollection.php?collectioncategory=gaming" class="me-3 btn btn-outline-primary ">See Category</a>
        </div>
    </div>
    <?php if ($collectionDetails && $collectionDetails->num_rows > 0) { ?>
        <div class="container-fluid nft-collection">
            <div class="faq-body justify-content-start d-flex flex-wrap">
                <?php
                while ($categorizecollection = mysqli_fetch_assoc($collectionDetails)) {
                    $collectionid = $categorizecollection['collectionid'];
                    $enCollectionid = base64_encode($collectionid); ?>
                    <!-- Collection CARD -->
                    <div class="col-md-2-5">
                        <a class="card faq-card p-2" href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" style="height:auto; width:100%;">
                            <div class="collection-nft-image d-flex rounded-1 justify-content-center align-items-center" style="width:100%; height:220px; overflow:hidden; text-shadow:none;">
                                <img loading="lazy" src="<?php echo $categorizecollection['collectionimage']; ?>" style="object-fit:cover; height:100%; width:100%;">
                            </div>
                            <div class="category-nft-details" style="padding: 10px;">
                                <div class="collection-name" style="font-size:18px;">
                                    <?php echo $categorizecollection['collectionname']; ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <small class="caption">
                                            Floor Price
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = {$categorizecollection['collectionid']}";
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
                                            ?> INR</p>
                                    </div>
                                    <div>
                                        <small class="caption">
                                            Total Volume
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid =" . $categorizecollection['collectionid'];
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
                                            ?> INR
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12">
            <div class="collection-offers">
                <div class="container-fluid">
                    <div class="no-offers">
                        <div>Collections Not Available In Gaming</div>
                        <div><a href="<?php echo BASE_URL ?>/creation.php" class="btn btn-outline-danger">Create Contract</a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- Display In photography categories NFT Collections-->

    <?php
    $selectcollection = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND collectioncategory = 'photography' ORDER BY collectionid DESC LIMIT 5";
    $collectionDetails = mysqli_query($conn, $selectcollection); ?>
    <div class=" mt-3 d-flex justify-content-between">
        <div style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
            <h3 class="ms-3 p-2 pb-0 rounded-1">New In Photography</h3>
        </div>
        <div>
            <a href="<?php echo BASE_URL ?>Collection/categorizeCollection.php?collectioncategory=photography" class="me-3 btn btn-outline-primary ">See Category</a>
        </div>
    </div>
    <?php if ($collectionDetails && $collectionDetails->num_rows > 0) { ?>
        <div class="container-fluid nft-collection">
            <div class="faq-body justify-content-start d-flex flex-wrap">
                <?php
                while ($categorizecollection = mysqli_fetch_assoc($collectionDetails)) {
                    $collectionid = $categorizecollection['collectionid'];
                    $enCollectionid = base64_encode($collectionid); ?>
                    <!-- Collection CARD -->
                    <div class="col-md-2-5">
                        <a class="card faq-card p-2" href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" style="height:auto; width:100%">
                            <div class="collection-nft-image d-flex rounded-1 justify-content-center align-items-center" style="width:100%; height:200px; overflow:hidden; text-shadow:none;">
                                <img loading="lazy" src="<?php echo $categorizecollection['collectionimage']; ?>" style="object-fit:cover; height:100%; width:100%;">
                            </div>
                            <div class="category-nft-details" style="padding: 10px;">
                                <div class="collection-name" style="font-size:18px;">
                                    <?php echo $categorizecollection['collectionname']; ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <small class="caption">
                                            Floor Price
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = {$categorizecollection['collectionid']}";
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
                                            ?> INR</p>
                                    </div>
                                    <div>
                                        <small class="caption">
                                            Total Volume
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid =" . $categorizecollection['collectionid'];
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
                                            ?> INR
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12">
            <div class="collection-offers">
                <div class="container-fluid">
                    <div class="no-offers">
                        <div>Collections Not Available In Photography</div>
                        <div><a href="<?php echo BASE_URL ?>creation.php" class="btn btn-outline-danger mt-2">Create Yours</a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- Display In PFP categories NFT Collections-->

    <?php
    $selectcollection = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND collectioncategory = 'pfp' ORDER BY collectionid DESC LIMIT 5";
    $collectionDetails = mysqli_query($conn, $selectcollection); ?>
    <div class=" mt-3 d-flex justify-content-between">
        <div style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
            <h3 class="ms-3 p-2 pb-0 rounded-1">New In PFP</h3>
        </div>
        <div>
            <a href="<?php echo BASE_URL ?>Collection/categorizeCollection.php?collectioncategory=pfp" class="me-3 btn btn-outline-primary ">See Category</a>
        </div>
    </div>
    <?php if ($collectionDetails && $collectionDetails->num_rows > 0) { ?>
        <div class="container-fluid nft-collection">
            <div class="faq-body justify-content-start d-flex flex-wrap">
                <?php
                while ($categorizecollection = mysqli_fetch_assoc($collectionDetails)) {
                    $collectionid = $categorizecollection['collectionid'];
                    $enCollectionid = base64_encode($collectionid); ?>
                    <!-- Collection CARD -->
                    <div class="col-md-2-5">
                        <a class="card faq-card p-2" href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" style="height:auto; width:100%">
                            <div class="collection-nft-image d-flex rounded-1 justify-content-center align-items-center" style="width:100%; height:200px; overflow:hidden; text-shadow:none;">
                                <img loading="lazy" src="<?php echo $categorizecollection['collectionimage']; ?>" style="object-fit:cover; height:100%; width:100%;">
                            </div>
                            <div class="category-nft-details" style="padding: 10px;">
                                <div class="collection-name" style="font-size:18px;">
                                    <?php echo $categorizecollection['collectionname']; ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <small class="caption">
                                            Floor Price
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = {$categorizecollection['collectionid']}";
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
                                            ?> INR</p>
                                    </div>
                                    <div>
                                        <small class="caption">
                                            Total Volume
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid =" . $categorizecollection['collectionid'];
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
                                            ?> INR
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12">
            <div class="collection-offers">
                <div class="container-fluid">
                    <div class="no-offers">
                        <div>Collections Not Available In PFP</div>
                        <div><a href="<?php echo BASE_URL ?>creation.php" class="btn btn-outline-danger mt-2">Create Yours</a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- Display In Other categories NFT Collections-->

    <?php
    $selectcollection = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND collectioncategory = 'other' ORDER BY collectionid DESC LIMIT 5";
    $collectionDetails = mysqli_query($conn, $selectcollection); ?>
    <div class=" mt-3 d-flex justify-content-between">
        <div style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
            <h3 class="ms-3 p-2 pb-0 rounded-1">New In Other</h3>
        </div>
        <div>
            <a href="<?php echo BASE_URL ?>Collection/categorizeCollection.php?collectioncategory=other" class="me-3 btn btn-outline-primary ">See Category</a>
        </div>
    </div>
    <?php if ($collectionDetails && $collectionDetails->num_rows > 0) { ?>
        <div class="container-fluid nft-collection">
            <div class="faq-body justify-content-start d-flex flex-wrap">
                <?php
                while ($categorizecollection = mysqli_fetch_assoc($collectionDetails)) {
                    $collectionid = $categorizecollection['collectionid'];
                    $enCollectionid = base64_encode($collectionid); ?>
                    <!-- Collection CARD -->
                    <div class="col-md-2-5">
                        <a class=".morphism-card faq-card p-2" href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" style="height:auto; width:100%">
                            <div class="collection-nft-image d-flex rounded-1 justify-content-center align-items-center" style="width:100%; height:200px; overflow:hidden; text-shadow:none;">
                                <img loading="lazy" src="<?php echo $categorizecollection['collectionimage']; ?>" style="object-fit:cover; height:100%; width:100%;">
                            </div>
                            <div class="category-nft-details" style="padding: 10px;">
                                <div class="collection-name" style="font-size:18px;">
                                    <?php echo $categorizecollection['collectionname']; ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <small class="caption">
                                            Floor Price
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = {$categorizecollection['collectionid']}";
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
                                            ?> INR</p>
                                    </div>
                                    <div>
                                        <small class="caption">
                                            Total Volume
                                        </small>
                                        <p class="m-0">
                                            <?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid =" . $categorizecollection['collectionid'];
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
                                            ?> INR
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12">
            <div class="collection-offers">
                <div class="container-fluid">
                    <div class="no-offers">
                        <div>Collections Not Available In Other</div>
                        <div><a href="<?php echo BASE_URL ?>creation.php" class="btn btn-outline-danger mt-2">Create Yours</a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- FAQs Section -->
    <?php
    // Fetch FAQs from the database
    $query = "SELECT * FROM faqs";
    $result = mysqli_query($conn, $query);
    ?>
    <div class="container-fluid mt-3">
        <h3 class="ms-2">NFT Market</h3>
    </div>
    <div class="faq-body container-fluid d-flex flex-nowrap" style="justify-content: flex-start; align-items: center; overflow-X:scroll;">
        <?php if (!$result) {
            echo 'FAQs Not Available';
        } else { ?>
            <?php
            // Loop through each FAQ and display it in a card
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="faq-card col-md-3" style="width:300px;">
                    <div class="card-image">
                        <img loading="lazy" src="Assets/FAQs/<?php echo $row['faqimage']; ?>" alt="">
                    </div>
                    <div class="card-detail">
                        <div class="card-title">
                            <?php echo $row['faqtitle']; ?>
                        </div>
                        <div class="card-description caption">
                            <?php echo $row['faqdescription']; ?>
                        </div>
                        <div class="card-link">
                            <button class="btn read-more" onclick="openfaq(<?php echo $row['faqid']; ?>)">Read More</button>
                        </div>
                    </div>
                </div>
                <div id="faq_<?php echo $row['faqid']; ?>" class="modal">
                    <div class="modal-content col-md-12">
                        <span class="close" onclick="closefaq(<?php echo $row['faqid']; ?>)">&times;</span>
                        <div class="faq-modal-info">
                            <div class="faq-modal-image col-md-5">
                                <img src="Assets/FAQs/<?php echo $row['faqimage']; ?>">
                            </div>
                            <div class="faq-modal-details col-md-7">
                                <div class="faq-modal-detail">
                                    <h2><?php echo $row['faqtitle']; ?> <span class="faq-modal-description caption"><?php echo $row['created_date']; ?> | <?php echo $row['created_time']; ?></span></h2>
                                    <p class="faq-modal-description mt-1 caption"><?php echo $row['faqdescription']; ?></p>
                                </div>
                                <div class="faqs-edit-btn d-flex justify-content-center">
                                    <?php if ($userrole == 'admin') { ?>
                                        <!-- Edit form -->
                                        <a href="Functions/editFAQ.php?faqid=<?php echo $row['faqid']; ?>" class="btn edit me-2">Edit</a>
                                        <a href="Functions/deleteFAQ.php?faqid=<?php echo $row['faqid']; ?>" onclick="return confirm('Are you sure you want to delete this FAQ? - <?php echo $row['faqtitle']; ?>');" class="btn delete ms-2">Delete</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        <?php
        }
        ?>

        <script>
            function openfaq(faqid) {
                document.getElementById("faq_" + faqid).style.display = "block";
                document.body.classList.add('modal-open');
            }

            function closefaq(faqid) {
                document.getElementById("faq_" + faqid).style.display = "none";
                document.body.classList.remove('modal-open');
            }
        </script>
    </div>

</body>
<?php
require_once("footer.php"); ?>

</html>