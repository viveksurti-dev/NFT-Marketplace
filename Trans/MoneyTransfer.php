<?php
include '../config.php';
// include '../Navbar.php';

// Get the username from the session
$username = $_SESSION['username'];

// Retrieve user details including 'balance' and 'walletPassword' from the 'wallet' table
$sql = "SELECT auth.id, auth.username, wallet.balance, wallet.walletPassword
        FROM auth
        LEFT JOIN wallet ON auth.id = wallet.userid
        WHERE auth.username = '$username'";

$result = mysqli_query($conn, $sql);

// Check for query execution error
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// the time zone for India
date_default_timezone_set("Asia/Kolkata");

// Get the current date and time
$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");


// Check if any rows are returned
if (mysqli_num_rows($result) > 0) {
    // Assume you have fetched the user details and stored them in $userDetails
    $userDetails = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send-money'])) {
        $phoneNumber = $_POST['phone'];
        $amount = $_POST['amount'];
        $walletPasswordInput = $_POST['walletPassword'];

        // Check amount constraints
        if ($amount < 50 || $amount > 1000) {
            echo "Amount must be between 50 and 1000.";
            exit;
        }

        // Check if the recipient exists
        $recipientQuery = "SELECT * FROM auth WHERE phone = '$phoneNumber'";
        $recipientResult = mysqli_query($conn, $recipientQuery);

        if ($recipientResult && mysqli_num_rows($recipientResult) > 0) {
            // Recipient exists, check if they are not the same as the sender
            $recipientDetails = mysqli_fetch_assoc($recipientResult);
            $recipientUserID = $recipientDetails['id'];

            if ($recipientUserID != $userDetails['id']) {
                // Perform the money transfer
                $recipientWalletQuery = "SELECT * FROM wallet WHERE userid = '$recipientUserID'";
                $recipientWalletResult = mysqli_query($conn, $recipientWalletQuery);

                if ($recipientWalletResult && mysqli_num_rows($recipientWalletResult) > 0) {
                    // Recipient has a wallet, check sender's wallet balance
                    if (isset($userDetails['balance']) && $userDetails['balance'] >= $amount) {
                        // Sender's wallet balance is sufficient, check wallet password
                        $hashedPassword = $userDetails['walletPassword'];

                        if (password_verify($walletPasswordInput, $hashedPassword)) {
                            // Wallet password matches, perform the money transfer
                            $updateSenderBalanceQuery = "UPDATE wallet SET balance = balance - $amount WHERE userid = '{$userDetails['id']}'";
                            $updateRecipientBalanceQuery = "UPDATE wallet SET balance = balance + $amount WHERE userid = '$recipientUserID'";

                            // Perform the updates in a transaction to ensure consistency
                            mysqli_begin_transaction($conn);

                            try {
                                mysqli_query($conn, $updateSenderBalanceQuery);
                                mysqli_query($conn, $updateRecipientBalanceQuery);

                                // Retrieve the receiver's username
                                $receiverUsernameQuery = "SELECT username FROM auth WHERE id = '$recipientUserID'";
                                $receiverUsernameResult = mysqli_query($conn, $receiverUsernameQuery);

                                if ($receiverUsernameResult && mysqli_num_rows($receiverUsernameResult) > 0) {
                                    $receiverUsername = mysqli_fetch_assoc($receiverUsernameResult)['username'];

                                    // Insert transaction record for sender
                                    $transactionQuerySender = "INSERT INTO transactions (userid, transactuser, debitamount, transactionreason ,transactiondate, transactiontime) VALUES ('{$userDetails['id']}', '$receiverUsername', $amount, 'Fund Transfer', '$currentDate', '$currentTime')";
                                    mysqli_query($conn, $transactionQuerySender);

                                    // Insert transaction record for receiver
                                    $transactionQueryReceiver = "INSERT INTO transactions (userid, transactuser, creditamount, transactionreason,transactiondate, transactiontime) VALUES ('$recipientUserID', '$username', $amount, 'Fund Transfer','$currentDate', '$currentTime')";
                                    mysqli_query($conn, $transactionQueryReceiver);

                                    // Commit the transaction
                                    mysqli_commit($conn);
                                    $_SESSION['alert'] = "Money Transfer Successfully To $receiverUsername.";
                                    echo "<script>window.location.href='Wallet.php';</script>";
                                    exit();
                                } else {
                                    // Rollback the transaction and show an error if receiver's username is not found
                                    mysqli_rollback($conn);
                                    $error = "Error: Receiver's username not found.";
                                }
                            } catch (Exception $e) {
                                // Rollback the transaction in case of an error
                                mysqli_rollback($conn);
                                $error = "Error: " . $e->getMessage();
                            }
                        } else {
                            $_SESSION['alert'] = "Incorrect wallet password.";
                            echo "<script>window.location.href='Wallet.php';</script>";
                            exit();
                        }
                    } else {
                        $_SESSION['alert'] = "Insufficient balance in the sender's wallet.";
                        echo "<script>window.location.href='Wallet.php';</script>";
                        exit();
                    }
                } else {
                    $_SESSION['alert'] = "Recipient does not have an active wallet.";
                    echo "<script>window.location.href='Wallet.php';</script>";
                    exit();
                }
            } else {
                $_SESSION['alert'] = "You cannot transfer money to your own account.";
                echo "<script>window.location.href='Wallet.php';</script>";
                exit();
            }
        } else {
            $_SESSION['alert'] = "Recipient does not exist.";
            echo "<script>window.location.href='Wallet.php';</script>";
            exit();
        }
    }
} else {
    $error = "User not found.";
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
?>
<div class="w-info">
    <h4>Fund Transfer</h4>
    <p>Welcome! <span><?php echo $username ?></span></p>
</div>
<div class="container-fluid d-flex justify-content-center flex-wrap  mt-1">
    <div class="card col-md-4 col-sm-6 d-flex text-center">
        <h4 class="mb-3">Transfer Your Friend</h4>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form autocomplete="off" action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <input type="text" name="phone" class="input form-control" placeholder="Recipient Phone Number" required />
            </div>
            <div class="form-group">
                <input type="number" name="amount" class="input form-control" placeholder="Enter Amount" min="50" max="1000" required />
            </div>
            <div class="form-group">
                <input type="password" name="walletPassword" class="input form-control" placeholder="Your Wallet Password" required />
            </div>
            <div class="form-group">
                <button type="submit" name="send-money" class="btn w-100 btn-danger">Send Money</button>
            </div>
        </form>
    </div>
</div>