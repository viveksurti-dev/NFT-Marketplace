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
    <title> NFT Marketplace - Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

</head>

<body>

    <div class="container-fluid">
        <div class="dashboard">

            <div class="dash-sec-profile col-md-8">
                <div class="profile-background">
                    <div class="user-back-images"> <?php if (!empty($userDetails)) { ?>
                            <?php if (!empty($userbackimage)) { ?>
                                <img src="<?php echo $userbackimage; ?>" alt="User Image" class="img-fluid user-back-image">

                            <?php } ?>
                            <?php if (empty($userbackimage)) { ?>

                            <?php } ?>
                            <div class="edit-back-icon" onclick="openProfileBackImage()">
                                <img src="Assets/icons/pencil-fill.svg" class="mb-1">
                            </div>
                        <?php } else { ?>
                            <p>User details not found.</p>
                        <?php } ?>

                    </div>
                </div>
                <!-- Update User Image modal -->
                <div id="ProfileBackImage" class="modal">

                    <div class="modal-content col-md-4">
                        <span class="close" onclick="closeProfileBackImage()">&times;</span>

                        <p>Edit Backgound Image</p>
                        <?php
                        // Check if the form is submitted for updating
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Check if a new image is provided
                            if ($_FILES['new_image_back']['name'] != '') {
                                $newImageName = $_FILES['new_image_back']['name'];
                                $newImageTemp = $_FILES['new_image_back']['tmp_name'];
                                $uploadPath = 'Assets/background/';

                                // Move the uploaded image to the desired directory
                                if (move_uploaded_file($newImageTemp, $uploadPath . $newImageName)) {

                                    // Update Background Image in the database with the new image
                                    $query = "UPDATE auth SET userbackimage='$uploadPath$newImageName' WHERE username='$username'";

                                    if ($conn->query($query) === TRUE) {
                                        echo "<div class='alert alert-success mt-3'>Image updated successfully.</div>";
                                        echo "<script>window.location.href='Dashboard.php';</script>";
                                        exit();
                                    } else {
                                        echo "<div class='alert alert-danger mt-3'>Error updating record: " . $conn->error . "</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>Error uploading file. Check if the directory has the correct permissions.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-warning mt-3'>No new image provided.</div>";
                            }
                        }
                        ?>

                        <!-- Form for updating the profile image -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="new_image_back">New Image:</label>
                                <input type="file" name="new_image_back" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-profile w-100">Update Image</button>
                        </form>
                    </div>
                </div>

                <script>
                    function openProfileBackImage() {
                        document.getElementById("ProfileBackImage").style.display = "block";
                        document.body.classList.add('modal-open');
                    }

                    function closeProfileBackImage() {
                        document.getElementById("ProfileBackImage").style.display = "none";
                        document.body.classList.remove('modal-open');
                    }
                </script>
                <div class="profile-front container">
                    <div class="user-image"> <?php if (!empty($userDetails)) { ?>
                            <?php if (!empty($userimage)) { ?>
                                <img src="<?php echo $userimage; ?>" alt="User Image" class="img-fluid user-image">

                            <?php } ?>
                            <?php if (empty($userimage)) { ?>
                                <img src="Assets/auth/unkown.png" alt="User Image" class="img-fluid rounded-2">
                            <?php } ?>
                            <div class="edit-icon" onclick="openProfileImage()">
                                <img src="Assets/icons/pencil-fill.svg" class="mb-1">
                            </div>
                        <?php } else { ?>
                            <p>User details not found.</p>
                        <?php } ?>

                    </div>
                    <!-- Update User Image modal -->
                    <div id="ProfileImage" class="modal">

                        <div class="modal-content col-md-4">
                            <span class="close" onclick="closeProfileImage()">&times;</span>

                            <p>Edit User Image</p>
                            <?php
                            // Check if the form is submitted for updating
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Check if a new image is provided
                                if ($_FILES['new_image']['name'] != '') {
                                    $newImageName = $_FILES['new_image']['name'];
                                    $newImageTemp = $_FILES['new_image']['tmp_name'];
                                    $uploadPath = 'Assets/Auth/'; // Replace with your desired upload directory

                                    // Move the uploaded image to the desired directory
                                    if (move_uploaded_file($newImageTemp, $uploadPath . $newImageName)) {
                                        // Update data in the database with the new image
                                        $query = "UPDATE auth SET userimage='$uploadPath$newImageName' WHERE username='$username'";

                                        if ($conn->query($query) === TRUE) {
                                            echo "<div class='alert alert-success mt-3'>Image updated successfully.</div>";
                                            echo "<script>window.location.href='Dashboard.php';</script>";
                                            exit();
                                        } else {
                                            echo "<div class='alert alert-danger mt-3'>Error updating record: " . $conn->error . "</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger mt-3'>Error uploading file. Check if the directory has the correct permissions.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-warning mt-3'>No new image provided.</div>";
                                }
                            }
                            ?>

                            <!-- Form for updating the profile image -->
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="new_image">New Image:</label>
                                    <input type="file" name="new_image" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-profile w-100">Update Image</button>
                            </form>
                        </div>
                    </div>

                    <script>
                        function openProfileImage() {
                            document.getElementById("ProfileImage").style.display = "block";
                            document.body.classList.add('modal-open');
                        }

                        function closeProfileImage() {
                            document.getElementById("ProfileImage").style.display = "none";
                            document.body.classList.remove('modal-open');
                        }
                    </script>

                    <!-- Profile - User Detail -->
                    <div class="user-info col-md-4">
                        <div class="user-name">@<?php echo $username; ?></div>
                        <div class="name"><?php echo $firstname; ?>&nbsp;<?php echo $lastname; ?></div>
                        <div class="user-mail mt-2"><?php echo $email; ?></div>
                        <div class="gender mt-2"><?php
                                                    if ($gender == 'male') {
                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-male" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8"/>
              </svg>';
                                                    } elseif ($gender == 'female') {
                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-female" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5"/>
              </svg>';
                                                    } else {
                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-ambiguous" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.5 1a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-3.45 3.45A4 4 0 0 1 8.5 10.97V13H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V14H6a.5.5 0 0 1 0-1h1.5v-2.03a4 4 0 1 1 3.471-6.648L14.293 1zm-.997 4.346a3 3 0 1 0-5.006 3.309 3 3 0 0 0 5.006-3.31z"/>
              </svg>';
                                                    } ?> <?php echo $gender; ?></div>
                    </div>
                </div>
                <div class="user-about container">
                    <h4>About Me</h4>
                    <p class="caption"> <?php echo $USER['userabout']; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dash-sec-profile">
                    <div class="dash-about-title">
                        <center>
                            <h4>More Details</h4>
                        </center>
                    </div>
                    <div class="dash-abt-info">
                        <div class="info">
                            <div class="info-title">User Name</div>
                            <div class="info-detail"><?php echo $username; ?></div>
                        </div>
                        <div class="info">
                            <div class="info-title">Email</div>
                            <div class="info-detail"><?php echo $email; ?></div>
                        </div>
                        <div class="info">
                            <div class="info-title">Phone</div>
                            <div class="info-detail">
                                <?php
                                if ($phonenumber) {
                                    echo $phonenumber;
                                } else {
                                    echo '<br/>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="info">
                            <div class="info-title">Gender</div>
                            <div class="info-detail"><?php echo $gender; ?></div>
                        </div>
                        <div class="info">
                            <a class="btn btn-profile w-100" href="editProfile.php?username=<?php echo urlencode($userDetails['username']); ?>">Edit Profile</a>

                            <!-- <a href=" ?logout" class="btn btn-logout">Logout</a> -->
                        </div>
                    </div>
                </div>
                <div class="dash-sec-profile">
                    <div class="dash-about-title">
                        <center>
                            <h4>Wallet</h4>
                        </center>
                    </div>
                    <div class="dash-abt-info">
                        <?php require_once 'Trans/DashWallet.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- dashboard Menus -->
    <div class="container-fluid">

        <?php require_once 'Account/dashMenus.php' ?>

    </div>


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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<?php
include("footer.php");
?>

</html>
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