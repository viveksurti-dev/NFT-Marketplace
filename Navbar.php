<?php
session_start();

require_once 'config.php';
define('BASE_URL', 'http://localhost/nft/');
require_once 'mailStructure.php';

if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];

    if (!isset($_COOKIE['username'])) {
        $expiryTime = time() + (10 * 365 * 24 * 60 * 60);
        setcookie('username', "$username", "$expiryTime", '/');
    }
} elseif (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    $_SESSION['username'] = $username;
    $loggedIn = true;
    echo  '<script> window.location.href = "";</script>';
    exit();
} else {
    $loggedIn = false;
}

if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
    $loggedUser = "SELECT * FROM auth WHERE username = '$username'";
    $userDetails = mysqli_query($conn, $loggedUser);

    if ($userDetails) {
        $USER = mysqli_fetch_assoc($userDetails);

        // if ($USER['status'] == 'deactivate') {
        //     echo "<script>window.location.href='error-002.php?allowRedirect=true';</script>";
        //     exit();
        // }
        $userrole = $USER['user_role'];
    }
} else {
    $userrole = "";
    $loggedIn = false;
}


// expire accepted offers if more then 24 hours of accepted
$timezone = new DateTimeZone('Asia/Kolkata');
$currentTime = new DateTime('now', $timezone);
$currentTimestamp = $currentTime->format('Y-m-d H:i:s');

$updateExpiredOffers = "UPDATE nftoffers 
                        SET offerstatus = 'expired' 
                        WHERE offerstatus = 'accept' 
                        AND CONCAT(offerenddate, ' ', offerendtime) <= '{$currentTimestamp}'";
$conn->query($updateExpiredOffers);
// Close Auctions
$updateExpiredAuction = "UPDATE auction 
                        SET auctionstatus = 'close' 
                        WHERE auctionstatus = 'active' 
                        AND CONCAT(auctionenddate, ' ', auctionendtime) <= '{$currentTimestamp}'";
// Perform the query to update expired auctions
if ($conn->query($updateExpiredAuction)) {
    $closedAuctionsQuery = "SELECT * FROM auction WHERE auctionstatus = 'close' AND CONCAT(auctionenddate, ' ', auctionendtime) <= '{$currentTimestamp}'";
    $closedAuctionsResult = $conn->query($closedAuctionsQuery);

    while ($closeAuctions = mysqli_fetch_assoc($closedAuctionsResult)) {
        $auctionId = $closeAuctions['auctionid'];

        $lastBidderQuery = "SELECT * FROM bidding 
                            WHERE auctionid = $auctionId 
                            AND bidstatus = 'bidded' 
                            ORDER BY biddingid DESC 
                            LIMIT 1";
        $result = $conn->query($lastBidderQuery);

        if ($result && $result->num_rows > 0) {
            $bidData = $result->fetch_assoc();
            $lastBidId = $bidData['biddingid'];
            $lastBidderId = $bidData['bidderid'];
            $bidNftId = $bidData['nftid'];
            $bidNftPrice = $bidData['bidprice'];
            $bidDate = $bidData['biddate'];
            $bidTime = $bidData['bidtime'];

            $updateBidStatus = "UPDATE bidding SET bidstatus = 'accept' WHERE biddingid = $lastBidId";
            $conn->query($updateBidStatus);

            $offerEndDate = date('Y-m-d H:i:s', strtotime('+24 hours'));
            $createOffer = "INSERT INTO nftoffers (userid, nftid, offerprice, offersupply, offerdate, offertime, offerenddate, offerstatus) 
                            VALUES ('$lastBidderId', '$bidNftId', '$bidNftPrice', '1', '$bidDate', '$bidTime', '$offerEndDate', 'accept')";
            if ($conn->query($createOffer)) {
                $selectlastBidders = "SELECT * FROM auth WHERE id = $lastBidderId";
                $lastBiddersResult = $conn->query($selectlastBidders);
                if ($lastBiddersResult && $lastBiddersResult->num_rows > 0) {
                    $lastBidders = $lastBiddersResult->fetch_assoc();
                    include('mailpage/bid.php');
                }
            }
        }
    }
}


// Update strikes
$updatedUsersQuery = "SELECT * FROM auth WHERE status = 'strike' AND deactivationdate <= '{$currentTimestamp}'";
$updatedUsersResult = mysqli_query($conn, $updatedUsersQuery);

if ($updatedUsersResult) {
    // Fetch the users whose strikes were updated
    $updateStrikeQuery = "UPDATE auth SET deactivationdate = '', status = NULL WHERE status = 'strike' AND deactivationdate <= '{$currentTimestamp}'";
    $strikeUpdateResult = mysqli_query($conn, $updateStrikeQuery);

    if ($strikeUpdateResult) {
        while ($strike = mysqli_fetch_assoc($updatedUsersResult)) {
            $email = $strike['email'];
            $username = $strike['username'];
            require_once './mailpage/strike.php';
        }
    } else {
        echo "Error updating strikes: " . mysqli_error($conn);
    }
} else {
    echo "Error fetching users with updated strikes: " . mysqli_error($conn);
}


if (isset($_GET['logout'])) {

    $expiryTimeTenYearsAgo = time() - (10 * 365 * 24 * 60 * 60);
    setcookie('username', '', $expiryTimeTenYearsAgo, '/');

    $_SESSION = array();
    unset($_SESSION['wallet_token']);
    session_destroy();

    header('Location:' . BASE_URL . 'login.php');
    exit();
}

if (isset($_GET['buy_cancel'])) {
    unset($_SESSION['BUY_NFT']);
    header('Location:' . BASE_URL . 'Trans/Wallet.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap cdn -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- web logo -->
    <link rel="icon" href="<?php echo BASE_URL ?>Assets/illu/web-logo.png" type="image/x-icon" />
    <!-- jqury cdn -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- pdf file cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <!-- Excel File cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <!-- chart cdn -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/nft.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/wallet.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/payProcess.css">
</head>

<body>

    <nav class="navbar main-nav container-fluid navbar-expand-lg relative sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php BASE_URL; ?>">NFT Marketplace</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a aria-current="page" href="<?php echo BASE_URL; ?>">Home</a>
                        <a aria-current="page" href="<?php echo BASE_URL; ?>UserList.php">Users</a>
                        <a aria-current="page" href="<?php echo BASE_URL; ?>creation.php">Create</a>

                    </li>
                </ul>
                <form class="d-flex" id="search_query" action="<?php echo BASE_URL ?>Functions/search.php" method="GET">
                    <input class="form-control search me-2" name="query" type="search" placeholder="Search"
                        aria-label="Search">
                </form>
                <?php if ($loggedIn) { ?>
                <style>
                .dropdown-item:hover {
                    color: none !important;
                }
                </style>
                <div class="dropdown">
                    <a href="#" class="btn p-2 ms-3 dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-person-square me-2"></i> Dashboard
                    </a>
                    <div class="dropdown-menu mt-3 p-3" aria-labelledby="adminDropdown">
                        <a class="dropdown-item p-2" href="<?php echo BASE_URL ?>Dashboard.php"> <i
                                class="bi bi-person-fill me-2"></i> Dashboard</a>
                        <a class="dropdown-item p-2" href="<?php echo BASE_URL ?>"><i class="bi bi-heart-fill me-2"></i>
                            Wishlist</a>
                        <li class="dropdown-divider mt-2 mb-2"></li>
                        <center class="mt-2 caption"><small>Manager</small></center>
                        <?php if ($USER['user_role'] == 'admin') : ?>
                        <a class="dropdown-item p-2 mt-2" href="<?php echo BASE_URL ?>AdminPanel.php"><i
                                class="bi bi-key-fill me-2"></i> Admin Panel</a>
                        <?php endif; ?>
                        <a class="dropdown-item p-2 mt-2" href="<?php echo BASE_URL ?>settings.php"><i
                                class="bi bi-gear me-2"></i> Setting</a>
                        <li class="dropdown-divider mt-2 mb-2"></li>
                        <center class="mt-2 caption"><small>Help Center</small></center>
                        <a class="dropdown-item p-2 mt-2" href="<?php echo BASE_URL ?>LearnCenter/learn.php"><i
                                class="bi bi-journal-text me-2"></i> Learn</a>
                        <a class="dropdown-item p-2 mt-2" href="<?php echo BASE_URL ?>FAQs.php"><i
                                class="bi bi-question-diamond-fill me-2"></i> Help Center</a>
                    </div>
                </div>
                <div class="ms-3">
                    <?php
                        $selectwallet = "SELECT * FROM wallet WHERE userid = {$USER['id']}";
                        $detailWallet = mysqli_query($conn, $selectwallet);

                        if ($detailWallet && mysqli_num_rows($detailWallet)) {
                            $useWallet = mysqli_fetch_assoc($detailWallet);
                            $logbalance = $useWallet['balance'];
                            echo '<a href="' . BASE_URL . 'Trans/wallet.php" class="btn btn-outline-primary">' . $logbalance . ' INR | ';

                            // function getUSDRate()
                            // {
                            //     $apikey = "UJW7Q7JAW5M2GGAX";
                            //     $url = "https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=USD&to_currency=INR&apikey=$apikey";

                            //     $response = file_get_contents($url);
                            //     $data = json_decode($response, true);

                            //     if (isset($data['Realtime Currency Exchange Rate']['5. Exchange Rate'])) {
                            //         return $data['Realtime Currency Exchange Rate']['5. Exchange Rate'];
                            //     } else {
                            //         return false;
                            //     }
                            // }
                            // $usd_rate = getUSDRate();
                            // if ($usd_rate !== false) {
                            //     $balance_in_usd = $useWallet['balance'] / $usd_rate;
                            //     echo number_format($balance_in_usd, 2) . ' USD';
                            // } else {
                            //     echo "Unable to fetch USD rate.";
                            // }

                            echo '0.00 USD';
                            echo '</a>';
                        } else {
                            echo '<a href="' . BASE_URL . 'Trans/ActivateWallet.php" class="btn btn-outline-primary"><i class="bi bi-wallet2 me-2"></i>Login</a>';
                        }
                        ?>
                </div>
                <?php } else { ?>
                <a href="<?php echo BASE_URL; ?>login.php" class="ms-3">Login</a>
                <?php } ?>
            </div>

        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>

<!-- password show -->
<script>
$(document).ready(function() {
    $('#show-password').click(function() {
        var input = $('.new-password');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
});
</script>