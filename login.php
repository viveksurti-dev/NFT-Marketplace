<?php
require_once("Navbar.php");
// Database connection details
include 'config.php';
error_reporting(E_ERROR | E_PARSE);
$createLogin = "CREATE TABLE IF NOT EXISTS loginhistory (
    loginid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    logindate DATE NOT NULL,
    logintime TIME NOT NULL
)";
$conn->query($createLogin);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the data (you can add more validation)
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Check the credentials
        $sql = "SELECT * FROM auth WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {

                date_default_timezone_set("Asia/Kolkata");
                $currentDate = date("y-m-d");
                $currentTime = date("H:i");

                // create login history
                $createHistory = "INSERT INTO loginhistory(userid, logindate, logintime) VALUES ('$row[id]','$currentDate','$currentTime')";
                $conn->query($createHistory);

                $_SESSION['username'] = $username;
                $expiryTime = time() + (10 * 365 * 24 * 60 * 60);
                setcookie('username', "$username", "$expiryTime", '/');


                if ($row['status'] == 'maintenance' || $row['deactivationdate'] > $currentDate) {
                    $updateStatus = "UPDATE auth SET `status` = '',deactivationdate = NULL WHERE id = {$row['id']}";
                    $conn->query($updateStatus);
                }
                $_SESSION['create'] = "Login Successfully";
                echo "<script>window.location.href='Dashboard.php';</script>";
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Invalid username.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Login</title>
    <!--  Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class=" card col-md-5">
                <h2 class="mb-4 text-center">Login</h2>
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">

                        <input type="text" class="form-control input text-lowercase" placeholder="Enter Username" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control input" id="password" name="password" placeholder="Enter Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 p-2">Login</button>
                    <br /><br />
                    Don't have an account yet?<a href="<?php BASE_URL ?>register.php"> Sign Up</a>
                    <br />
                    <!-- Forgot Password Direction -->
                    <a href="<?php BASE_URL ?>forgotpassword.php" class="btn btn-outline-danger p-2 mt-3 w-100">Forgot Password?</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

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