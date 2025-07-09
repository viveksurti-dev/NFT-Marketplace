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

// Check if the form is submitted for deleting the account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    // Account deletion logic
    $enteredPhone = $_POST['phone_for_verification'];
    $enteredPassword = $_POST['password_for_verification'];

    // Check if the entered phone number and password match the logged-in user's information
    $checkLoggedInUserInfo = "SELECT id, password FROM auth WHERE phone = ? AND username = ? AND password IS NOT NULL";

    $stmt = $conn->prepare($checkLoggedInUserInfo);
    $stmt->bind_param("ss", $enteredPhone, $loggedInUsername);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();

        // Verify the entered password
        if (password_verify($enteredPassword, $hashedPassword)) {

            $deactivationDate = date('Y-m-d H:i:s', strtotime('+30 days'));
            $updateStmt = $conn->prepare("UPDATE auth SET status = 'maintenance', deactivationdate = ? WHERE id = ?");
            $updateStmt->bind_param("si", $deactivationDate, $userId);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                session_destroy(); // Log out the user after updating the account
                echo "<script>window.location.href='index.php';</script>";
                exit();
            } else {
                $errorMessages[] = "Error updating account: " . $conn->error;
            }

            $updateStmt->close();
        } else {
            $errorMessages[] = "Incorrect Password.";
        }
    } else {
        $errorMessages[] = "Phone Number Not Match.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Account Settings</title>
    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

</head>


<div class="container-fluid col-md-4 mt-5 mb-5">
    <div class="card">
        <div class="dash-about-title mb-3">
            <center>
                <h4>Account Settings</h4>
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
            <!-- Add fields for account deletion -->
            <div class="mb-3">
                <label for="phone_for_verification" class="form-label">Phone Number</label>
                <input type="text" name="phone_for_verification" class="form-control input" placeholder="Enter Your Verified Phone Number" required>
            </div>
            <div class="mb-3">
                <label for="password_for_verification" class="form-label">Password for Verification</label>
                <input type="password" name="password_for_verification" placeholder="Enter Your Password" class="form-control input" required>
            </div>
            <!-- Add a hidden field to indicate that the user wants to delete the account -->
            <input type="hidden" name="delete_account" value="1">
            <button type="submit" class="btn btn-danger w-100 mb-2 mt-2">Delete Account</button>
        </form>

        <div class="instruction mt-2">
            <small class="caption">1. Enter Your current phone number on the application.</small><br />
            <small class="caption">2. Your Account will be deactivate with in 30 Days.</small><br />
            <small class="caption">3. If you logged-in again in 30 days then deactivation cancel.</small><br />
        </div>
    </div>
</div>
<?php
include("footer.php"); ?>