<?php
require_once '../Navbar.php';
require_once '../config.php';

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../error-001.php?allowRedirect=true';</script>";
    exit();
}
if (!isset($_SESSION['wallet_token'])) {
    echo "<script>window.location.href='" . BASE_URL . "Trans/WalletLogin.php';</script>";
    exit();
}

?>

<?php
// Display error message if it exists
if (isset($_SESSION['alert'])) {
    echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert' id='myAlert'>
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
                    {$_SESSION['alert']}
                    </div>
                </div>
            </div>";
    unset($_SESSION['alert']);
}

// Get the username from the session
$username = $_SESSION['username'];

// Retrieve user details from the database
$sql = "SELECT * FROM auth WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// get Wallet Details
$query = "SELECT * FROM wallet
          INNER JOIN auth ON wallet.userid = auth.id
          WHERE auth.username = '$username'";


$result = $conn->query($query);

// Initialize $userDetails as an empty array
$userDetails = array();

if ($result && mysqli_num_rows($result) > 0) {
    $userDetails = mysqli_fetch_assoc($result);
}


// Define variables for user details
$firstname = isset($userDetails['firstname']) ? $userDetails['firstname'] : '';
$lastname = isset($userDetails['lastname']) ? $userDetails['lastname'] : '';
$phonenumber = isset($userDetails['phone']) ? $userDetails['phone'] : '';
$gender = isset($userDetails['gender']) ? $userDetails['gender'] : '';
$email = isset($userDetails['email']) ? $userDetails['email'] : '';
$role = isset($userDetails['user_role']) ? $userDetails['user_role'] : '';
$userimage = isset($userDetails['userimage']) ? $userDetails['userimage'] : '';
$userbackimage = isset($userDetails['userbackimage']) ? $userDetails['userbackimage'] : '';
$balance = isset($userDetails['balance']) ? $userDetails['balance'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Wallet</title>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/wallet.css">


</head>

<body>

    <?php
    // Display error message if it exists
    if (isset($_SESSION['create'])) {
        echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert' id='myAlert'>
                    <div class='cust_alert-header'>
                        <div class='brand-info'>
                            <div class='Header-image me-2'>
                            <img src='../Assets/illu/web-logo.png' alt='Brand Image'/>
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



    <div class="container-wallet d-flex">
        <div class="wallet-menus ">
            <div class="head mb-3">
                <?php if (!empty($userDetails)) { ?>
                    <?php if (!empty($userimage)) { ?>
                        <img src="<?php echo BASE_URL . $userimage; ?>" alt="User Image" class="img-fluid user-image">

                    <?php } ?>
                    <?php if (empty($userimage)) { ?>
                        <img src="<?php echo BASE_URL; ?>Assets/auth/unkown.png" alt="User Image" class="img-fluid rounded-2">
                    <?php } ?>

                <?php }  ?>

            </div>
            <div class="menus">
                <button id="wm1" onclick="showContent('wc1', 'wm1')" class="btn btn-menu mt-3 active"><i class="bi bi-wallet2"></i></button>
                <button id="wm2" onclick="showContent('wc2', 'wm2')" class="btn btn-menu mt-1"><i class="bi bi-activity"></i></button>
                <button id="wm3" onclick="showContent('wc3', 'wm3')" class="btn btn-menu mt-1"><i class="bi bi-arrow-left-right"></i></button>
                <button id="wm4" class="btn btn-menu mt-1" onclick="showContent('wc4', 'wm4')"><i class="bi bi-cash-stack"></i></i></button>
                <button id="wm6" onclick="showContent('wc6', 'wm6')" class="btn btn-menu mt-1"><i class="bi bi-bank"></i></button>
                <button id="wm5" onclick="showContent('wc5', 'wm5')" class="btn btn-menu mt-1"><i class="bi bi-gear"></i></button>
            </div>

        </div>
        <div class="wallet-content">

            <style>
                .processing {
                    width: 70px;
                    height: 70px;
                    border-radius: 10px;
                    background-color: #202020;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border: 2px solid #232323;
                }

                .contract-details {
                    width: 100%;
                    height: 100%;
                    border-radius: 5px;
                    background-color: #202020;
                    padding: 10px;
                    display: flex;
                    flex-wrap: wrap;
                }

                .contract-details p {
                    margin: 0;
                    padding: 2px;
                    font-size: 15px;
                    text-transform: capitalize;
                }

                .contract-image {
                    height: 100px;
                    width: 100px;
                    overflow: hidden;
                    display: flex;
                    justify-content: center;
                    border-radius: 5px;
                }

                .contract-image img {
                    height: 100%;
                    width: auto;
                    object-fit: contain;
                }

                .payment-alert {
                    background-color: #202020;
                    padding: 10px;
                    border-radius: 5px;
                    margin-bottom: 10px;
                }
            </style>

            <div id="wc1" class="content wc1">
                <?php if (isset($_SESSION['collection_details'])) {
                    $collectionDetails = $_SESSION['collection_details'];
                ?>
                    <div class="container-fluid">
                        <div class="payment-alert">
                            <div class="contract-details d-flex flex-wrap ">
                                <div class="contract-image col-md-3">
                                    <img src="<?php echo BASE_URL; ?><?php echo $collectionDetails['collectionimage']; ?>" loading="lazy">
                                </div>
                                <div class=" col-md-2 d-flex flex-column justify-content-center">
                                    <p>Contract :
                                        <span class="caption">
                                            <?php echo $collectionDetails['collectionname']; ?>
                                        </span>
                                    </p>
                                    <p>Blockchain :
                                        <span class="caption">
                                            <?php echo $collectionDetails['collectionblockchain']; ?>
                                        </span>
                                    </p>
                                    <p>Deployment :
                                        <span class="caption">
                                            ₹ <?php echo $collectionDetails['collectionDeployCharge']; ?>
                                        </span>
                                    </p>
                                </div>
                                <div class=" col-md-7 d-flex flex-column justify-content-center">
                                    <small class="caption">
                                        To proceed with your creation contract, kindly submit the required payment. Completing this transaction ensures the finalization of our agreement, allowing us to commence the planned creative project. Your prompt payment is crucial for the timely and successful execution of the envisioned creation. Thank you for your cooperation.
                                    </small>
                                </div>
                                <div class=" col-md-2 d-flex flex-column justify-content-center">
                                    <button class="btn btn-profile" onclick="showContent('wc4', 'wm4')"><i class="bi bi-cart3"></i> Proceed</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php include "WalletDashboard.php" ?>
                <?php include '../footer.php' ?>
            </div>

            <div id="wc2" class=" content wc-2 hidden">
                <?php include "transactions.php" ?>
            </div>
            <div id="wc3" class=" content wc-2 hidden">
                <?php include "./MoneyTransfer.php" ?>
                <?php include '../footer.php' ?>
            </div>
            <div id="wc4" class=" content wc-2 hidden">
                <?php include './DuePay.php' ?>
                <?php include '../footer.php' ?>
            </div>
            <div id="wc5" class=" content wc-2 hidden">
                <?php include './walletSetting.php' ?>
                <?php include '../footer.php' ?>
            </div>
            <div id="wc6" class=" content wc-2 hidden">
                <?php include './withdrawFund.php' ?>
                <?php include '../footer.php' ?>
            </div>

        </div>
    </div>
</body>

</html>


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

        // Store the active button in local storage
        localStorage.setItem('activeButtonId', buttonId);
    }

    // Function to load the last active menu from local storage
    document.addEventListener("DOMContentLoaded", function() {
        var activeButtonId = localStorage.getItem('activeButtonId');

        if (activeButtonId) {
            // Check if the last active menu is 'sm5', if yes, refresh with the same menu
            if (activeButtonId === 'wm1') {
                showContent('wc1', 'wm1');
            } else if (activeButtonId === 'wm2') {
                showContent('wc2', 'wm2');
            } else if (activeButtonId === 'wm3') {
                showContent('wc3', 'wm3');
            } else if (activeButtonId === 'wm4') {
                showContent('wc4', 'wm4');
            } else if (activeButtonId === 'wm5') {
                showContent('wc5', 'wm5');
            } else if (activeButtonId === 'wm6') {
                showContent('wc6', 'wm6');
            } else {
                showContent('wc1', 'wm1');
            }
        } else {
            showContent('wc1', 'wm1');
        }
    });
</script>


<!-- Custom Alerts -->
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