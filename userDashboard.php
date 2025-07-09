<?php
require_once("Navbar.php");
// Database connection details
include 'config.php';

// Get the username from the URL
$username = $_GET['username'];

// Retrieve user details from the database
$sql = "SELECT * FROM auth WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful and at least one row was returned
if ($result && mysqli_num_rows($result) > 0) {
    $userDetails = mysqli_fetch_assoc($result);

    // Display user details using HTML
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Details</title>
        <!-- Add Bootstrap CSS link if needed -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- add css link -->
        <link rel="stylesheet" type="text/css" href="Styles/setting.css">
        <link rel="stylesheet" type="text/css" href="Styles/main.css">

    </head>

    <body>
        <div class="container-fluid userDashboard">
            <div class="userDashboard-back ">
                <div class="user-back-image ">
                    <?php
                    $userbackImage = $userDetails['userbackimage'];
                    $defaultImage = "Assets/auth/unkown.png"; // Replace with the actual path to your default image

                    if (!empty($userbackImage) && file_exists("$userbackImage")) {
                        // User has set an image, display it
                        echo "<img src='$userbackImage' alt='UserImage'>";
                    } else {
                    }
                    ?>
                </div>
            </div>
            <div class="userDashboard-front container-fluid">
                <div class="user-image ">
                    <?php
                    $userImage = $userDetails['userimage'];
                    $defaultImage = "Assets/auth/unkown.png"; // Replace with the actual path to your default image

                    if (!empty($userImage) && file_exists("$userImage")) {
                        // User has set an image, display it
                        echo "<img src='$userImage' alt='UserImage'>";
                    } else {
                        // User has not set an image, display default image
                        echo "<img src='$defaultImage' alt='DefaultImage'>";
                    }
                    ?>
                </div>
                <div class="user-info col-md-4">
                    <div class="user-name">
                        @<?= $userDetails['username'] ?>
                    </div>
                    <div class="name mt-2">
                        <?php
                        if (($userDetails['firstname'] == '') && ($userDetails['lastname'] == '')) {
                            echo 'Unkonwn';
                        } else {
                        }
                        ?>
                        <?= $userDetails['firstname'] ?> <?= $userDetails['lastname'] ?>
                    </div>
                    <div class="gender">
                        <?php
                        if ($userDetails['gender'] == 'male') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-male" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8"/>
                            </svg>';
                        } elseif ($userDetails['gender'] == 'female') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-female" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5"/>
                            </svg>';
                        } else {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-ambiguous" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.5 1a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-3.45 3.45A4 4 0 0 1 8.5 10.97V13H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V14H6a.5.5 0 0 1 0-1h1.5v-2.03a4 4 0 1 1 3.471-6.648L14.293 1zm-.997 4.346a3 3 0 1 0-5.006 3.309 3 3 0 0 0 5.006-3.31z"/>
                            </svg>';
                        } ?>
                        <?= $userDetails['gender'] ?>
                    </div>
                    <div class="mail mt-3">
                        <?= $userDetails['email'] ?>
                    </div>

                </div>
                <div class="user-info col-md-5 mt-2">
                    <h4>About Me</h4>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, iste assumenda natus, itaque fugiat hic dolore distinctio autem velit voluptatibus facere amet numquam. Eum odit molestiae ut impedit consequuntur doloribus explicabo accusantium sed ratione. Illo necessitatibus libero adipisci alias eius?
                </div>

            </div>
        </div>
        </div>
    </body>

    </html>
<?php
} else {
    // Handle the case where the user is not found
    echo "User not found.";
}

// Close the database connection
mysqli_close($conn);
?>

<?php
include("footer.php"); ?>