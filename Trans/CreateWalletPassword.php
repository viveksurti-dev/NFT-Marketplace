<?php
require_once '../Navbar.php';
require_once '../config.php';


// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
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
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        if (empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = "Password and Confirm Password cannot be empty.";
            echo "<script>window.location.href='CreateWalletPassword.php';</script>";
            exit();
        } elseif ($password !== $confirmPassword) {
            $_SESSION['error'] = "Password and Confirm Password must match.";
            echo "<script>window.location.href='CreateWalletPassword.php';</script>";
            exit();
        } elseif (strlen($password) < 8) {
            $_SESSION['error'] = "Password must be at least 8 characters long.";
            echo "<script>window.location.href='CreateWalletPassword.php';</script>";
            exit();
        } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $_SESSION['error'] = "Password must contain One Uppercase And Lowercase letters and numbers.";
            echo "<script>window.location.href='CreateWalletPassword.php';</script>";
            exit();
        } else {
            // Insert the password into the wallet table
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE wallet SET walletPassword = '$hashedPassword' WHERE userid = $userid";

            if ($conn->query($updateQuery)) {
                $_SESSION['error'] = "Wallet Password Set Successfully!";
                echo "<script>window.location.href='WalletLogin.php';</script>";
                exit();
            } else {
                // Handle the error - display an error message or log it
                echo "Error updating password. Please try again.";
            }
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
    <title>NFT Marketplace - Wallet Password</title>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center flex-wrap mt-3">
        <div class="col-md-6">
            <div class="activewallet-container">
                <img src="<?php echo BASE_URL ?>Assets/illu/secure.png" loading="lazy" class="walletPassword" />
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-center flex-wrap">
            <div class=" col-md-7 card" style="font-size: 18px;">
                <center>
                    <h4>Your Details</h4>
                </center>
                <p><i class="bi bi-person-check"></i> <span class="caption"><?php echo $username ?></span></p>
                <p><i class="bi bi-telephone"></i> <span class="caption"><?php echo $phone ?></p>
                <p><i class="bi bi-envelope-at"></i> <span class="caption"><?php echo $email ?></p>
            </div>
            <div class=" col-md-7 card mt-2">
                <center>
                    <h3>Secure Your Wallet</h3>
                </center>
                <form action="" method="post" class="mt-2">
                    <div class="form-group">
                        <input type="password" name="password" class="form-control input" placeholder="Create Wallet Password" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="confirm_password" class="form-control input" placeholder="Confirm Wallet Password" required>
                    </div>

                    <input type="checkbox" required> <small>I Accepts Term & Conditions</small>
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