<?php
require_once '../Navbar.php';
require_once '../config.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-forgot'])) {
    $forgotemail = $_POST['forgot-email'];

    $selectUser = "SELECT * FROM auth where email = '$forgotemail'";
    $userData = mysqli_query($conn, $selectUser);

    if ($userData && mysqli_num_rows($userData) > 0) {
        $ForgetUser = mysqli_fetch_assoc($userData);
        $email = $ForgetUser['email'];
        $username = $ForgetUser['username'];
        $enEmail = base64_encode(base64_encode($email));
        $_SESSION['reset-password'] = $enEmail;

        require_once '../mailpage/walletPassword.php';

        $_SESSION['create'] = "Password reset request has been sent to your email. Please allow some time for delivery.";
        echo "<script>window.location.href='';</script>";
        exit();
    } else {
        $_SESSION['create'] = "This email is not registered. Please verify the email address entered.";
        echo "<script>window.location.href='';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - NFT Marketplace</title>
</head>

<body>
    <div class="container-fluid">
        <div class="container container-notlogin">
            <img src="<?php echo BASE_URL ?>Assets/illu/forgotpassword.png" loading="lazy" />
            <div class="mt-3 col-md-5 text-center">
                Secure your wallet access by initiating a password reset through your registered email.
            </div>
            <div class="col-md-4 mt-3">
                <form method="post" class="mt-2" autocomplete="off">
                    <div class="form-group">
                        <input type="mail" class="input form-control" name="forgot-email" placeholder="Enter Registered Email" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btn-forgot" class="btn btn-outline-primary w-100">Send Mail</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>

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