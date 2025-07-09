<?php
// session_start();
require_once("Navbar.php");

// Database connection details
include 'config.php';


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

    <div class="container-user container-fluid mt-2">
        <?php
        // Database connection details
        include 'config.php';

        $query = "SELECT * FROM auth";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) :
        ?>

            <div class="user-card col-md-3 col-xs-6 col-sm-4">
                <div class="user-image mt-2">
                    <?php
                    $userImage = $row['userimage'];
                    if (!empty($userImage) && file_exists("$userImage")) {
                        // User has set an image, display it
                        echo "<img src='$userImage' class='img-fluid' style='object-fit:cover; aspect-ratio:1;' />";
                    } else {
                        // User has not set an image, display default image
                        echo "<img src='Assets/auth/unkown.png' class='img-fluid' />";
                    }
                    ?>
                </div>

                <div class="user-info mt-1">
                    <p class="user-name">@<?= $row['username'] ?>
                        <span class="gender">
                            <?php
                            if ($row['gender'] == 'male') {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-male" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8"/>
              </svg>';
                            } elseif ($row['gender'] == 'female') {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-female" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5"/>
              </svg>';
                            } else {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gender-ambiguous" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.5 1a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-3.45 3.45A4 4 0 0 1 8.5 10.97V13H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V14H6a.5.5 0 0 1 0-1h1.5v-2.03a4 4 0 1 1 3.471-6.648L14.293 1zm-.997 4.346a3 3 0 1 0-5.006 3.309 3 3 0 0 0 5.006-3.31z"/>
              </svg>';
                            }
                            ?></span>
                    </p>
                    <div class="name"><?php
                                        if (($row['firstname'] == '') && ($row['lastname'] == '')) {
                                            echo 'Unkonwn';
                                        } else {
                                        }
                                        ?><?= $row['firstname'] ?> <?= $row['lastname'] ?></div>

                    <div class="mt-2 mb-2">
                        <a href="userDashboard.php?username=<?= $row['username'] ?>">See User</a>
                    </div>

                </div>
            </div>

        <?php endwhile; ?>
    </div>

</body>

</html>

<?php
include("footer.php"); ?>