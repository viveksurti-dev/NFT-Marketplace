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
$userjoindate = isset($userDetails['joindate']) ? $userDetails['joindate'] : '';
$userjointime = isset($userDetails['jointime']) ? $userDetails['jointime'] : '';
?>

<style>
    .user-about {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .user-about .card {
        display: flex;
        margin: 10px;
        flex-wrap: wrap;
        justify-content: space-around;
        text-align: center;
        flex-direction: row;
    }

    .user-about .card .user-image {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        border-radius: 10px;
        overflow: hidden;
        width: auto;
        height: 350px;
    }

    .user-about .terms {
        display: flex;
        margin: 10px;
        flex-wrap: wrap;


        flex-direction: row;
    }

    @media screen and (max-width: 800px) {
        .user-about .card {
            display: flex;
            align-items: center;
            align-content: center;
            justify-content: center;
            flex-direction: column;
        }
    }


    .user-about .card .user-name {
        font-size: 20px;
    }

    .user-about .card .date-info {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-about .card .date {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
</style>

<div class="container user-about">
    <div class="col-md-8 pb-3 row card mt-5">
        <div class="caption mb-3 col-md-12">About Your Account</div>
        <div class="user-image col-md-6">
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
        <div class="info col-md-6">
            <div class="user-name">@<?php echo $username; ?></div>
            <div class="name caption"><small><?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?></small></div>
            <hr class="solid">
            <div class="caption mb-2 col-md-12"><small>To help keep our community authentic, We're showing accounts on this plateform. Pepole can see your account</small></div>
            <hr class="solid">
            <div class="date-info col-md-12 d-flex">

                <div class="calender-icon col-md-2"> <img src="Assets/icons/calendar.svg"></div>
                <div class="date ms-2 col-md-10">
                    Joined Date
                    <small class="caption"><?php echo $userjoindate ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php"); ?>