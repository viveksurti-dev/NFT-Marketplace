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
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>NFT Marketplace - Settings</title>

</head>

<body>
    <div class="settings ">
        <div class="setting-options ">
            <div class="head">
                <h5>Admin Panel</h5>
            </div>
            <div class="settings-body">
                <div class="setting-menu d-flex flex-column">
                    <button id="am1" class="btn active" onclick="showContent('ao1', 'am1')"><i class="bi bi-person-gear me-2"></i>Dashboard</button>
                    <hr class="mt-2 mb-2">
                    <small class="text-center caption"><i class="bi bi-app-indicator me-2"></i>Manager</small>
                    <button id="am2" class="btn" onclick="showContent('ao2', 'am2')"><i class="bi bi-people me-2"></i>Manage Users</button>
                    <button id="am3" class="btn" onclick="showContent('ao3', 'am3')"><i class="bi bi-activity me-2"></i>Transactions</button>
                    <hr class="mt-2 mb-2">
                    <small class="text-center caption"><i class="bi bi-node-plus me-2"></i>Creator</small>
                    <button id="am7" class="btn" onclick="showContent('ao7', 'am7')"><i class="bi bi-journal-richtext me-2"></i>Create FAQs</button>
                    <button id="am8" class="btn" onclick="showContent('ao8', 'am8')"><i class="bi bi-book me-2"></i>Create Articles</button>
                </div>
            </div>
            <div class="bottom">
                <div class="user-image ">
                    <?php
                    $userImage = $userDetails['userimage'];
                    $defaultImage = "Assets/auth/unkown.png";

                    if (!empty($userImage) && file_exists($userImage)) {

                        echo "<img src='$userImage' alt='UserImage'>";
                    } else {

                        echo "<img src='$defaultImage' alt='DefaultImage'>";
                    }
                    ?>
                </div>
                <div class="info ms-2">
                    <div class="user-name">@<?php echo $username; ?></div>
                    <div class="name caption"><?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?></div>
                </div>
                <div class="logout w-100">
                    <a href="?logout" class="btn w-100 btn-danger mt-2">Logout</a>
                </div>
            </div>
        </div>
        <div class="setting-option">
            <div class="setting-option">
                <div id="ao1" class="content"><?php include 'dash.php'; ?></div>
                <div id="ao2" class="content hidden"><?php include 'AdminmanageUser.php'; ?></div>
                <div id="ao3" class="content hidden"><?php include './Admin/Transactions.php'; ?></div>
            </div>
            <div id="ao7" class="content hidden"><?php require_once './Admin/createFAQs.php'; ?></div>
            <div id="ao8" class="content hidden"><?php include './Admin/createArticle.php'; ?></div>
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
            if (activeButtonId === 'am1') {
                showContent('ao1', 'am1');
            } else if (activeButtonId === 'am2') {
                showContent('ao2', 'am2');
            } else if (activeButtonId === 'am3') {
                showContent('ao3', 'am3');
            } else if (activeButtonId === 'am7') {
                showContent('ao7', 'am7');
            } else if (activeButtonId === 'am8') {
                showContent('ao8', 'am8');
            } else {
                // If it's any other menu, show the 'dashboard' menu on refresh
                showContent('ao1', 'am1');
            }
        } else {
            // If no active menu found in local storage, default to 'dashboard'
            showContent('ao1', 'am1');
        }
    });
</script>



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
<!-- alert Loader -->
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