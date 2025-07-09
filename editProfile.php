<?php
require_once("Navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

// Database connection details
include 'config.php';

// Fetch user data based on the username from the URL
$usernameFromUrl = isset($_GET['username']) ? $_GET['username'] : '';
$loggedInUsername = $_SESSION['username'];

// Check if the logged-in user has the right to edit the profile
if ($usernameFromUrl !== $loggedInUsername) {
    // Redirect or show an error message
    echo "<script>window.location.href='error-002.php?allowRedirect=true';</script>";
    exit();
}

// Check if the form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $newUsername = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $user_role = $_POST['user_role'];

    // Validate the data
    $errorMessages = array();

    // Check if username, email, and phone are unique, excluding the current user's data
    $check_username = "SELECT * FROM auth WHERE username = '$newUsername' AND id != $id";
    $check_email = "SELECT * FROM auth WHERE email = '$email' AND id != $id";
    $check_phone = "SELECT * FROM auth WHERE phone = '$phone' AND id != $id";

    $result_username = $conn->query($check_username);
    $result_email = $conn->query($check_email);
    $result_phone = $conn->query($check_phone);

    if ($result_username->num_rows > 0) {
        $errorMessages[] = "Username already exists.";
    }

    if ($result_email->num_rows > 0) {
        $errorMessages[] = "Email already exists.";
    }

    if ($result_phone->num_rows > 0) {
        $errorMessages[] = "Phone number already exists.";
    }

    if (empty($errorMessages)) {
        // Update data in the database
        $query = "UPDATE auth SET
             username='$newUsername',
             firstname='$firstname',
             lastname='$lastname',
             phone='$phone',
             gender='$gender',
             email='$email',
             user_role='$user_role'
             WHERE id=$id";

        if ($conn->query($query) === TRUE) {
            // Update the session username without destroying the session
            $_SESSION['username'] = $newUsername;

            echo "<script>window.location.href='Dashboard.php';</script>";
            exit();
        } else {
            $errorMessages[] = "Error updating record: " . $conn->error;
        }
    }
}
// Fetch user data based on the username from the URL
$username = isset($_GET['username']) ? $_GET['username'] : '';

$query = "SELECT * FROM auth WHERE username='$username'";
$result = $conn->query($query);

if (!$result) {
    die("Error: " . $conn->error);
}

$row = $result->fetch_assoc();

if (!$row) {
    // Handle the case where no user data is found
    die("User not found");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">

    <style>
        .card {
            background-color: #202020;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }

        .input {
            background-color: #282828;
            border: #121212;
            color: rgba(255, 255, 255, 0.6);
            padding: 10px;
        }

        .input:focus {
            background-color: #353535;
            color: white;
        }
    </style>
</head>

<body>
    <div class="dash-sec1 container pt-3 col-md-6">
        <div class="container card col-md-10">
            <div class="dash-about-title mb-3">
                <center>
                    <h4>Edit Profile </h4>
                </center>
            </div>
            <?php
            if (!empty($errorMessages)) {
                foreach ($errorMessages as $errorMessage) {
                    echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                }

                echo '<script>
            setTimeout(function(){
                var alerts = document.querySelectorAll(".alert");
                alerts.forEach(function(alert) {
                    alert.style.display = "none";
                });
            }, 3000);
          </script>';
            }
            ?>


            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?username=' . urlencode($usernameFromUrl)); ?>" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control input">
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" class="form-control input">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" class="form-control input">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control input" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender:</label>
                    <select class="form-select input" name="gender">
                        <option value="male" <?php if ($row['gender'] == 'male') echo 'selected'; ?>>Male</option>
                        <option value="female" <?php if ($row['gender'] == 'female') echo 'selected'; ?>>Female</option>
                        <option value="other" <?php if ($row['gender'] == 'other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control input" readonly>
                </div>
                <input type="hidden" name="user_role" value="<?php echo $row['user_role']; ?>">
                <button type="submit" class="btn btn-profile w-100 mb-2 mt-2">Update</button>
            </form>
        </div>



        <!-- Bootstrap JS (optional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <?php
        // Close the database connection
        $conn->close();
        ?>
    </div>

    <script>
        function generateRandomValue() {
            var timestamp = new Date().getTime();
            var randomValue = timestamp + '_' + Math.random().toString(36).substr(2, 8);
            return randomValue;
        }

        function redirectToLogin() {
            var randomValue = generateRandomValue();

            // Update the random value
            var newUrl = window.location.href.replace(/\?.*$/, '') + '?allowRedirect=' + randomValue;
            window.history.replaceState(null, null, newUrl);
        }
        window.onload = redirectToLogin;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>