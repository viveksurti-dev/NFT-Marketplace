<?php
require_once("Navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

// Database connection details
include 'config.php';

// Fetch user data based on the username from the session
$loggedInUsername = $_SESSION['username'];

// Initialize variables
$errorMessages = array();

// Check if the form is submitted for updating the password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $enteredPhone = $_POST['phone_for_verification'];

    // Validate the data
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = "Password Not Match.";
        echo "<script>window.location.href='settings.php';</script>";
        exit();
    }

    // Check if the entered phone number matches the logged-in user's phone number
    $checkLoggedInUserPhone = "SELECT id FROM auth WHERE phone = '$enteredPhone' AND username = '$loggedInUsername'";
    $resultLoggedInUserPhone = $conn->query($checkLoggedInUserPhone);

    if ($resultLoggedInUserPhone->num_rows === 0) {
        $_SESSION['error_message'] = "Phone Number Not Match.";
        echo "<script>window.location.href='settings.php';</script>";
        exit();
    }

    if (empty($errorMessages)) {
        // Update the password in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateStmt = $conn->prepare("UPDATE auth SET password = ? WHERE username = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $loggedInUsername);
        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            $_SESSION['success_message'] = "Password updated successfully.";
            echo "<script>window.location.href='settings.php';</script>";
            exit();
        } else {
            $errorMessages[] = "Error updating password: " . $conn->error;
        }


        $updateStmt->close();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Update Password</title>
    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

</head>

<div class="container-fluid col-md-4 mt-2 mb-5">
    <div class="card">
        <div class="dash-about-title mb-3">
            <center>
                <h4>Reset Password </h4>
            </center>
        </div>
        <?php
        // Check for success message
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        // Check for error message
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }

        ?>

        <?php
        if (!empty($errorMessages)) {
            echo '<div class="alert alert-danger" role="alert">';
            foreach ($errorMessages as $errorMessage) {
                echo $errorMessage . '<br>';
            }
            echo '</div>';
        }

        echo '<script>
                setTimeout(function() {
                    var alerts = document.querySelectorAll(".alert");
                    alerts.forEach(function(alert) {
                        alert.style.display = "none";
                    });
                }, 3000);
            </script>';

        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="phone_for_verification" class="form-label">Phone Number</label>
                <input type="text" name="phone_for_verification" class="form-control input" placeholder="Enter Your Verified Phone Number" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" placeholder="Enter New Password" class="form-control input" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" class="form-control input" required>
            </div>


            <button type="submit" class="btn btn-profile w-100 mb-2 mt-2">Update Password</button>
        </form>

        <div class="instruction mt-2">
            <small class="caption">1. Enter Your current phone number on the application</small><br />
            <small class="caption">2. Password Must Be 6 to 16 Characters</small>
        </div>
    </div>
</div>

<?php
include("footer.php"); ?>