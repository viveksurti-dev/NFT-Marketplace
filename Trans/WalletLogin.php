<?php
require_once '../Navbar.php';
require_once '../config.php';


// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../error-001.php?allowRedirect=true';</script>";
    exit();
}
if (isset($_SESSION['wallet_token'])) {
    echo "<script>window.location.href='Wallet.php';</script>";
    exit();
}

// Fetch the userid associated with the current username from the auth table
$username = $_SESSION['username'];
$query = "SELECT * FROM auth WHERE username = '$username'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userid = $row['id'];
    $username = $row['username'];
    $phone = $row['phone'];
    $email = $row['email'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validate and sanitize the input data
        $passwordAttempt = isset($_POST['wallet_password']) ? $_POST['wallet_password'] : '';

        // Retrieve the hashed password from the wallet table
        $walletQuery = "SELECT walletPassword FROM wallet WHERE userid = $userid";
        $walletResult = $conn->query($walletQuery);

        if ($walletResult && $walletResult->num_rows > 0) {
            $walletRow = $walletResult->fetch_assoc();
            $hashedPassword = $walletRow['walletPassword'];

            // Verify the entered password against the hashed password
            if (password_verify($passwordAttempt, $hashedPassword)) {
                $_SESSION['alert'] = "Wallet Login Successfuly!.";
                $_SESSION['wallet_token'] = 'userid';
                echo "<script>window.location.href='Wallet.php';</script>";
                exit();
            } else {
                // Incorrect password
                $_SESSION['error'] = "Incorrect wallet password.";
                echo "<script>window.location.href='WalletLogin.php';</script>";
                exit();
            }
        } else {
            // Handle the case where the wallet data is not found
            echo "Wallet data not found.";
        }
    }
} else {
    // Handle the case where the username is not found in the auth table
    echo "User not found.";
}

// Close the database connection
$conn->close();
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Wallet Login</title>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center mt-3">
        <div class="col-md-3">
            <div class="card">
                <center>
                    <h4>Wallet Login</h4>
                </center>
                <div class="activewallet-container">
                    <img src="<?php echo BASE_URL ?>Assets/illu/NFTWallet.png" />
                </div>
                <form action="" method="post" class="mt-2">
                    <!-- Add your form fields -->
                    <div class="form-group">
                        <input type="password" name="wallet_password" class="form-control input" placeholder="Wallet Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2 w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

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