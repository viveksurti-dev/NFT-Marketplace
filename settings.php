<?php
// session_start();
require_once("Navbar.php");

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}
// Database connection details
include 'config.php';

// Get the username from the session
$username = $_SESSION['username'];

// Retrieve user details from the database
$sql = "SELECT * FROM auth WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Initialize $userDetails as an empty array
$userDetails = array();

if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the user details
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>NFT Marketplace - Settings</title>

</head>

<body>
    <div class="settings ">
        <div class="setting-options ">
            <div class="head">
                <h5>Settings</h5>
            </div>
            <div class="settings-body">
                <div class="setting-menu d-flex flex-column">
                    <button id="sm6" class="btn active" onclick="showContent('so6', 'sm6')">
                        <i class="bi bi-person me-2"></i> Dashboard
                    </button>
                    <button id="sm1" class="btn" onclick="showContent('so1', 'sm1')">
                        <i class="bi bi-list-nested me-2"></i>Login History
                    </button>
                    <button id="sm4" class="btn" onclick="showContent('so4', 'sm4')">
                        <i class="bi bi-exclamation-diamond me-2"></i> Strike Status
                    </button>
                    <!-- Help And Support Section -->
                    <center class="mt-2 caption"><small>More Info & Support</small></center>
                    <button id="sm3" class="btn" onclick="showContent('so3', 'sm3')">
                        <i class="bi bi-file-earmark-person me-2"></i>About
                    </button>
                    <button id="sm2" class="btn" onclick="showContent('so2', 'sm2')">
                        <i class="bi bi-book me-2"></i>Terms & Condition
                    </button>
                    <center class="mt-2 caption"><small>Login</small></center>
                    <button id="sm5" class="btn" onclick="showContent('so5', 'sm5')">
                        <i class="bi bi-x-diamond me-2"></i> Reset Password</button>
                    <a class="btn" href="deactivateAccount.php">
                        <i class="bi bi-sign-dead-end me-2"></i>Dactivate Account
                    </a>
                </div>
            </div>
            <div class="bottom">
                <div class="user-image ">
                    <?php
                    $userImage = $userDetails['userimage'];
                    $defaultImage = "Assets/auth/unkown.png"; // Replace with the actual path to your default image

                    if (!empty($userImage) && file_exists($userImage)) {
                        // User has set an image, display it
                        echo "<img src='$userImage' alt='UserImage'>";
                    } else {
                        // User has not set an image, display default image
                        echo "<img src='$defaultImage' alt='DefaultImage'>";
                    }
                    ?>
                </div>
                <div class="info ms-2">
                    <div class="user-name">@<?php echo $username; ?></div>
                    <div class="name caption"><?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?></div>
                </div>
                <div class="logout w-100">
                    <a href="<?php echo BASE_URL ?>?logout" class="btn w-100 btn-danger mt-2">Logout</a>

                </div>
            </div>
        </div>
        <div class="setting-option">
            <div id="so1" class="content hidden"><?php include  'Account/loginhistory.php' ?></div>
            <div id="so2" class="content hidden"><?php include 'Terms.php'; ?></div>
            <div id="so3" class="content hidden"> <?php include 'userAbout.php'; ?> </div>
            <div id="so4" class="content hidden"> <?php include 'Account/strikes.php'; ?> </div>
            <div id="so5" class="content hidden">
                <?php include 'updatePassword.php'; ?>
            </div>
            <div id="so6" class="content"><?php include 'dash.php'; ?></div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>



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
            if (activeButtonId === 'sm5') {
                showContent('so5', 'sm5');
            } else if (activeButtonId === 'sm7') {
                showContent('so7', 'sm7');
            } else if (activeButtonId === 'sm1') {
                showContent('so1', 'sm1');
            } else if (activeButtonId === 'sm4') {
                showContent('so4', 'sm4');
            } else {
                // If it's any other menu, show the 'dashboard' menu on refresh
                showContent('so6', 'sm6');
            }
        } else {
            // If no active menu found in local storage, default to 'dashboard'
            showContent('so6', 'sm6');
        }
    });
</script>



</html>