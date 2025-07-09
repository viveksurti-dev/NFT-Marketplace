<?php
// session_start();
require_once("Navbar.php");

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

require_once './config.php';

// $createActivityTable =  "CREATE TABLE IF NOT EXISTS activity (
//     activityid INT AUTO_INCREMENT PRIMARY KEY,
//     userid INT NOT NULL, 
//     collectionid INT NOT NULL,
//     nftid INT NOT NULL,
//     activityicon VARCHAR(255),
//     activityitem VARCHAR(255),
//     activtyquantity INT NOT NULL,
//     activityfrom VARCHAR(255),
//     activityto VARCHAR(255),
//     activity_date DATE NOT NULL,
//     activity_time TIME NOT NULL
// )";
// $conn->query($createActivityTable);


?>

<style>
    .nft-options a {
        text-shadow: none;
    }
</style>

<div class="nft-options">
    <div class="container-fluid d-flex flex-wrap">
        <div class="col-md-6  option-left">
            <!-- Back Button -->
            <div class="back-botton mb-5 ms-5">
                <a href="<?php echo BASE_URL; ?>">
                    <p><i class="bi bi-arrow-left me-2"></i>
                        <a href="<?php echo BASE_URL; ?>">Home</a> /
                        <span class="caption">Creation</span>
                    </p>
                </a>
            </div>
            <div class="left-body">

                <div class="left-head col-md-10">
                    <img src="<?php echo BASE_URL ?>Assets/illu/web-logo.png" alt="">
                    <h1>Market is Yours</h1>
                </div>

                <a href="<?php echo BASE_URL ?>createNFTcollection.php" class="col-md-10 drop-collection">
                    <div class="create-option ">
                        <div class="option-detail">
                            <p class="option-title"><i class="bi bi-collection me-3"></i><span>Drop a collection</span></p>
                            <p class="caption option-info">Launch Your NFT Collection For Others To Mint</p>

                        </div>
                        <div class="option-navigate">
                            <i class="bi bi-arrow-bar-right"></i>
                        </div>
                    </div>
                </a>
                <a href="<?php echo BASE_URL; ?>createNFT.php" class="col-md-10">
                    <div class="create-option ">
                        <div class="option-detail">
                            <p class="option-title"><i class="bi bi-image me-3"></i><span>Mint An NFT</span></p>

                            <p class="caption option-info">Create An Collection & Mint NFTs Directly To Your wallet</p>

                        </div>
                        <div class="option-navigate">
                            <i class="bi bi-arrow-bar-right"></i>
                        </div>
                    </div>
                </a>
                <div class="col-md-10 mt-3">
                    <p><a href="" class="link">Learn more </a><span class="caption">about each option.</span></p>
                </div>
            </div>

        </div>
        <div class="col-md-6 option-right">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="Assets/NFTCollection/Forza Horizon 5 - background.jpg" class="d-block w-100" loading="lazy">
                    </div>
                    <div class="carousel-item">
                        <img src="Assets/NFTs/NFT007.png" class="d-block w-100" loading="lazy">
                    </div>
                    <div class="carousel-item">
                        <img src="Assets/NFTs/NFT003.png" class="d-block w-100" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>