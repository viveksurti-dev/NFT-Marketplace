<?php
require_once '../Navbar.php';
require_once '../config.php';

if (isset($_GET['token'])) {
    $enEmail = $_GET['token'];
    $deEmail = base64_decode(base64_decode($enEmail));
    $error = array();
?>

    <head>
        <title>Reset Credential</title>
    </head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <div class="container-fluid d-flex flex-wrap justify-content-center">
        <div class="col-md-4 mt-5">
            <div class="card">
                <h4 class="text-center">RESET CREDENTIAL</h4>
                <div>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-reset'])) {
                        $newPassword = $_POST['new-password'];
                        $confirmNewPassword = $_POST['confirm-new-password'];

                        if (strlen($newPassword) >= 8 && strlen($newPassword) <= 16) {
                            if ($newPassword == $confirmNewPassword) {
                                if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $newPassword)) {

                                    $updatePassword = $conn->prepare("UPDATE auth SET password = ? WHERE email = ?");
                                    $updatePassword->bind_param("ss", $hashedPassword, $deEmail);

                                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                                    $updatePassword->execute();

                                    if ($updatePassword->affected_rows > 0) {
                                        $safeEmail = mysqli_real_escape_string($conn, $deEmail);
                                        $selectUser = "SELECT * FROM auth WHERE email = '$safeEmail'";
                                        $userdata = mysqli_query($conn, $selectUser);

                                        if ($userdata && mysqli_num_rows($userdata) > 0) {
                                            $user = mysqli_fetch_assoc($userdata);
                                            $username = $user['username'];

                                            require_once '../mailpage/resetPassword.php';

                                            $_SESSION['create'] = "Password Update Successfully";
                                            echo "<script>window.location.href='" . BASE_URL . "login.php';</script>";
                                            exit();
                                        }
                                    } else {
                                        $error = 'Error updating password';
                                    }

                                    $updatePassword->close();
                                } else {
                                    $error = 'Password must include at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long';
                                }
                            } else {
                                $error = 'Password and confirm password do not match';
                            }
                        } else {
                            $error = "Password length must be between 8 and 16 characters";
                        }
                    }
                    ?>

                    <?php

                    if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small> <?php echo $error ?></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <!-- Reset password form -->
                    <form method="POST">
                        <div class="input-group mt-3">
                            <input type="password" name="new-password" class="form-control input" placeholder="New password" id="passwordInput">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-link toggle-password input">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="password" name="confirm-new-password" class="form-control input" placeholder="Confirm New password" id="confirmPasswordInput">
                        </div>
                        <button type="submit" name="btn-reset" class="btn btn-primary w-100">Submit</button>
                    </form>
                    <div class="mt-3">
                        <div class="mt-3">
                            <small class="caption">
                                <ul>
                                    <li>Include a mix of uppercase and lowercase letters</li>
                                    <li>Use at least one special character (e.g., !, @, #, $)</li>
                                    <li>Include numbers</li>
                                    <li>Avoid using easily guessable information, such as your name or birthday</li>
                                    <li>Make it at least 8 characters long</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else {
    echo '0';
} ?>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            var input = $('#passwordInput');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>