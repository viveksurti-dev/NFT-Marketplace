<?php
require_once("Navbar.php");
include 'config.php';

// $create_table_query = "CREATE TABLE IF NOT EXISTS auth (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     userimage VARCHAR(255),
//     userbackimage VARCHAR(255),
//     username VARCHAR(255) UNIQUE,
//     userabout VARCHAR(255),
//     firstname VARCHAR(255),
//     lastname VARCHAR(255),
//     phone VARCHAR(15) UNIQUE,
//     gender VARCHAR(10),
//     email VARCHAR(255) UNIQUE,
//     password VARCHAR(255),
//     user_role VARCHAR(20) DEFAULT 'user',
//     joindate DATE NOT NULL,
//     jointime TIME NOT NULL,
//     deactivationdate DATE NOT NULL,
//     status VARCHAR(255),
//     accept_terms BOOLEAN
// )";
// $conn->query($create_table_query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $register_code = $_POST["registercode"];
    $user_role = "user"; // Default role
    $accept_terms = isset($_POST["accept_terms"]) ? 1 : 0;

    $errorMessages = array();

    // Password validation
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
        $errorMessages[] = "Password must contain at least one number, one uppercase letter, one lowercase letter, and at least 8 characters.";
    }

    // Phone number validation
    if (!preg_match("/^\d{10}$/", $phone)) {
        $errorMessages[] = "Invalid phone number format. Please enter a valid 10-digit phone number.";
    }

    // Check if username, email, and phone are unique
    $check_username = "SELECT * FROM auth WHERE username = '$username'";
    $check_email = "SELECT * FROM auth WHERE email = '$email'";
    $check_phone = "SELECT * FROM auth WHERE phone = '$phone'";

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
    if ($password !== $confirm_password) {
        $errorMessages[] = "Password or confirm password not match.";
    }

    if (!isset($_SESSION['otp']) || empty($_SESSION['otp']) || $_SESSION['otp'] != $register_code) {
        $errorMessages[] = "Incorrect or expired OTP.";
    }

    if (empty($errorMessages)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO auth (username, gender, email, phone, password, user_role, accept_terms, joindate, jointime)
                        VALUES ('$username', '$gender', '$email', '$phone', '$hashed_password', '$user_role', '$accept_terms', NOW(), NOW())";

        if ($conn->query($insert_query) === TRUE) {
            require_once './mailpage/registerSuccess.php';
            echo  '<script> window.location.href = "' . BASE_URL . 'login.php";</script>';
            exit();
        } else {
            $errorMessages[] = "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Registration Form</title>
    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">
</head>

<body>

    <div class="container mt-2 mb-1">
        <div class="row justify-content-center">
            <div class="card col-md-5">
                <div class="">
                    <div class="text-center text-uppercase">
                        <h4> Registration Form</h4>
                    </div>
                    <di v class="card-body">
                        <?php
                        if (!empty($errorMessages)) {
                            foreach ($errorMessages as $errorMessage) {
                                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                            }
                        }
                        ?>
                        <form id="registrationForm" action="register.php" method="post" enctype="multipart/form-data"
                            autocomplete="off">
                            <div class="form-group">
                                <input id="username" type="text" class="form-control input" name="username"
                                    placeholder="Enter Username" required
                                    value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>"
                                    oninput="this.value = this.value.toLowerCase()">

                                <span id="usernameAvailability"></span>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" class="form-control input" name="email"
                                    placeholder="Enter Mail" required
                                    value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"
                                    oninput="this.value = this.value.toLowerCase()">
                                <span id="emailAvailability"></span>
                            </div>
                            <div class="form-group">
                                <input id="phone" type="tel" class="form-control input" name="phone"
                                    placeholder="Enter Phone Number" required
                                    value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
                                <span id="phoneAvailability"></span>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control input new-password" name="password"
                                    placeholder="Enter Password" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input new-password" name="confirm_password"
                                    placeholder="Confirm Your Password" required>
                                <div class="mt-2 text-right d-flex justify-content-end align-items-center">
                                    <input type="checkbox" id="show-password" checked> <small class="ms-2">Show
                                        Passsword</small>
                                </div>
                            </div>
                            <div class="form-group d-flex">
                                <input type="text" id="registercode" name="registercode"
                                    class="form-control input col-9" placeholder="Enter Code"
                                    value="<?php echo isset($_POST['registercode']) ? $_POST['registercode'] : '' ?>"
                                    required>
                                <button id="generateCodeBtn" type="button" name="getcode"
                                    class="btn btn-outline-primary col-3 ms-1">
                                    <span id="sendcode">
                                        Get Code
                                    </span>
                                    <span id="spinner" style="display:none;">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </span>

                                </button>
                            </div>
                            <div class="form-group d-flex">
                                <label>Gender :</label>
                                <div class="form-check ms-3">
                                    <input type="radio" class="form-check-input input" name="gender" value="male"
                                        required checked>
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check ms-3">
                                    <input type="radio" class="form-check-input input" name="gender" value="female"
                                        required>
                                    <label class="form-check-label">Female</label>
                                </div>
                                <div class="form-check ms-3">
                                    <input type="radio" class="form-check-input input" name="gender" value="other"
                                        required>
                                    <label class="form-check-label">Other</label>
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="accept_terms" required>
                                <label class="form-check-label caption"><small class="me-2">I accept the terms and
                                        conditions</small><a href="./Terms.php" class="link"></a></label>
                            </div>
                            <button type="submit" class="btn btn-profile w-100 mt-3">Register</button>
                            <a href='" . $client->createAuthUrl() . "' class='btn btn-profile w-100 mt-3 disabled'><i
                                    class='bi bi-google me-2'></i> Signup With Google</a>


                            <!-- <a href="" class="btn btn-profile w-100 mt-3 " disabled><i class="bi bi-google me-2"></i> Signup With Google</a> -->
                            <br /><br />
                            <span>Already have an account? <a href="<?php echo BASE_URL ?>login.php">Sign In
                                    Here</a></span>
                        </form>

                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script>
        document.getElementById('generateCodeBtn').addEventListener('click', function() {
            var email = document.getElementById('email').value;
            var username = document.getElementById('username').value;
            var xhr = new XMLHttpRequest();
            if (!email) {
                alert('Please enter a valid email');
                document.getElementById('email').focus();
                return false;
            }
            if (!username) {
                alert('Please enter a username');
                document.getElementById('username').focus();
                return false;
            }

            document.getElementById('generateCodeBtn').setAttribute('disabled', 'disabled');
            document.getElementById('sendcode').style.display = 'none';
            document.getElementById('spinner').style.display = 'block';

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    document.getElementById('generateCodeBtn').removeAttribute('disabled');
                    document.getElementById('sendcode').style.display = 'block';
                    document.getElementById('spinner').style.display = 'none';

                    if (xhr.status === 200) {
                        alert('OTP sent successfully via email!');
                    } else {
                        alert('Failed to send OTP via email.');
                    }
                }
            };
            xhr.open('POST', 'mailpage/regicode.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var requestData = 'email=' + encodeURIComponent(email) + '&username=' + encodeURIComponent(username);
            xhr.send(requestData);
        });
    </script>

    <!-- check availability -->
    <script>
        // AJAX function to check email availability
        function checkEmailAvailability() {
            var email = document.getElementById('email').value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('emailAvailability').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error checking email availability');
                    }
                }
            };

            xhr.open('POST', './ajaxValidation/checkEmail.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var requestData = 'email=' + encodeURIComponent(email);
            xhr.send(requestData);
        }

        // AJAX function to check phone number availability
        function checkPhoneAvailability() {
            var phone = document.getElementById('phone').value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('phoneAvailability').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error checking phone availability');
                    }
                }
            };

            xhr.open('POST', './ajaxValidation/checkPhone.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var requestData = 'phone=' + encodeURIComponent(phone);
            xhr.send(requestData);
        }

        // AJAX function to check username availability
        function checkUsernameAvailability() {
            var username = document.getElementById('username').value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('usernameAvailability').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error checking username availability');
                    }
                }
            };

            xhr.open('POST', './ajaxValidation/checkUser.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var requestData = 'username=' + encodeURIComponent(username);
            xhr.send(requestData);
        }

        // Event listeners for input fields
        document.getElementById('email').addEventListener('input', checkEmailAvailability);
        document.getElementById('phone').addEventListener('input', checkPhoneAvailability);
        document.getElementById('username').addEventListener('input', checkUsernameAvailability);

        // Function to show or hide elements on focus or blur
        function toggleVisibility(elementId, isVisible) {
            var element = document.getElementById(elementId);
            element.style.display = isVisible ? 'block' : 'none';
        }

        // Event listeners for focusing and blurring input fields
        document.getElementById('email').addEventListener('focus', function() {
            toggleVisibility('emailAvailability', true);
        });
        document.getElementById('email').addEventListener('blur', function() {
            toggleVisibility('emailAvailability', false);
        });

        document.getElementById('phone').addEventListener('focus', function() {
            toggleVisibility('phoneAvailability', true);
        });
        document.getElementById('phone').addEventListener('blur', function() {
            toggleVisibility('phoneAvailability', false);
        });

        document.getElementById('username').addEventListener('focus', function() {
            toggleVisibility('usernameAvailability', true);
        });
        document.getElementById('username').addEventListener('blur', function() {
            toggleVisibility('usernameAvailability', false);
        });
    </script>


</body>

</html>