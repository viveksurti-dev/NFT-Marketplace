<?php
require_once '../Navbar.php';

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../error-001.php?allowRedirect=true';</script>";
    exit();
}

// Database connection details
require_once('../config.php');

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user already has an active wallet
$username = $_SESSION['username'];
$checkWalletQuery = "SELECT wallet.id FROM wallet INNER JOIN auth ON wallet.userid = auth.id WHERE auth.username = ?";
$stmt = $conn->prepare($checkWalletQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result === FALSE) {
    die("Error checking wallet status: " . $stmt->error);
}

if ($result->num_rows > 0) {
    echo "<script>window.location.href='" . BASE_URL . "Trans/CreateWalletPassword.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch user ID from the auth table
    $getUserIDQuery = "SELECT id FROM auth WHERE username = ?";
    $stmt = $conn->prepare($getUserIDQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userIDResult = $stmt->get_result();

    if ($userIDResult === FALSE) {
        die("Error fetching user ID: " . $stmt->error);
    }

    if ($userIDResult->num_rows > 0) {
        $userData = $userIDResult->fetch_assoc();
        $userID = $userData['id'];

        // Insert into the wallet table
        $activeWalletQuery = "INSERT INTO wallet (userid, balance) VALUES (?, '100')";
        $stmt = $conn->prepare($activeWalletQuery);
        $stmt->bind_param("i", $userID);


        // the time zone for India
        date_default_timezone_set("Asia/Kolkata");

        // Get the current date and time
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i");

        $TransactUser = "NFT Marketplace";
        $Reason = "Joining Bonus";

        $transactionWalletQuery = "INSERT INTO transactions (userid,transactuser, creditamount, transactionreason , transactiondate, transactiontime) VALUES (?,'$TransactUser', '100', '$Reason', '$currentDate', '$currentTime')";
        $stmtTransaction = $conn->prepare($transactionWalletQuery);
        $stmtTransaction->bind_param("i", $userID);

        // Execute both queries within a transaction
        $conn->begin_transaction();
        if ($stmt->execute() === FALSE || $stmtTransaction->execute() === FALSE) {
            $conn->rollback();
            // Check for duplicate entry error
            if ($stmt->errno == 1062) {
                $_SESSION['error'] = "Your Wallet Is Already Active!";
                echo "<script>window.location.href='" . BASE_URL . "Trans/ActivateWallet.php';</script>";
                exit();
            } else {
                die("Error inserting into wallet table: " . $stmt->error);
            }
        } else {
            $conn->commit();
            $_SESSION['activate'] = "Congratulation!, Your Wallet Activated Successfully. Create Your NFT Collections";
            sleep(5);
            echo "<script>window.location.href='" . BASE_URL . "Trans/CreateWalletPassword.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}

?>

<?php
// Display error message if it exists
if (isset($_SESSION['error'])) {
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
                    {$_SESSION['error']}
                    </div>
                </div>
            </div>";
    unset($_SESSION['error']);
}

?>

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Activate Wallet</title>
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/wallet.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>Styles/main.css">
</head>

<body class="activeWallet">
    <div class="container-fluid d-flex flex-wrap align-items-center">
        <div class="col-md-6">
            <div class="activewallet-container">
                <img src="<?php echo BASE_URL ?>Assets/illu/Wallet.png" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="container-active-detail">
                <h1>Activate Wallet</h1>
                <p class="caption mt-3">An easy and safe way to activate an account by your phone number. You can use your digital wallet to make purchases, check balances, and transfer money.</p>
                <small class="caption mt-3">Once you’ve unlocked your wallet, you will receive a public address and corresponding private key. This is found within ‘Receive’ under ‘Settings’. Your private key should never be shared with anyone, as it gives access to your account and with it your money. With your public address, you can share this information freely, as it does not give the receiver control over your account and funds. To confirm that you are indeed the owner of the account associated with this address, you will need to enter a message that was sent from this address. The transaction history within the app allows users to see past transactions made from this public address and confirm if they came from them or not.</small>
                <form action="" method="POST">
                    <button class="btn btn-wallet w-50 mt-5">Activate Wallet</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
require_once '../Footer.php';
?>
