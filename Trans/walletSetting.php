<div class="w-info">
    <h4>Wallet Settings</h4>
    <p>Welcome! <span><?php echo $username ?></span></p>
</div>

<div class="d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div>
                <h4 class="text-center">Change Password</h4>
            </div>
            <?php

            if (isset($_POST['change-password']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                // Assuming $conn is your mysqli connection object

                $selectPassword = "SELECT walletPassword FROM wallet WHERE userid = '{$USER['id']}'";
                $passwordData = mysqli_query($conn, $selectPassword);

                if ($passwordData) {
                    $row = mysqli_fetch_assoc($passwordData);
                    $storedPassword = $row['walletPassword'];
                    $enteredPassword = $_POST['current-password'];

                    if (!password_verify($enteredPassword, $storedPassword)) {
                        $_SESSION['create'] = "Current password is incorrect.";
                        echo  '<script> window.location.href = "";</script>';
                        exit();
                    } else {
                        $newPassword = $_POST['new-password'];
                        $confirmNewPassword = $_POST['confirm-new-password'];
                        if (empty($newPassword) || empty($confirmNewPassword)) {
                            $_SESSION['create'] = "New password fields are required.";
                            echo  '<script> window.location.href = "";</script>';
                            exit();
                        } elseif ($newPassword !== $confirmNewPassword) {
                            $_SESSION['create'] = "New passwords do not match.";
                            echo  '<script> window.location.href = "";</script>';
                            exit();
                        } elseif (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $newPassword)) {
                            $_SESSION['create'] = "New password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.";
                            echo  '<script> window.location.href = "";</script>';
                            exit();
                        } else {
                            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            $updateQuery = "UPDATE wallet SET walletPassword = '$hashedPassword' WHERE userid = '{$USER['id']}'";
                            if (mysqli_query($conn, $updateQuery)) {
                                $_SESSION['create'] = "Password updated successfully.";
                                echo  '<script> window.location.href = "";</script>';
                                exit();
                            } else {
                                $_SESSION['create'] = "Error updating password: " . mysqli_error($conn);
                                echo  '<script> window.location.href = "";</script>';
                                exit();
                            }
                        }
                    }
                } else {
                    $_SESSION['create'] = "Error retrieving password data.";
                }
            }
            ?>
            <form method="post">
                <div class="form-group mt-3">
                    <input type="password" name="current-password" class="input form-control" placeholder="Current Password">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="new-password" class="input form-control new-password" placeholder="New Password">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="confirm-new-password" class="input form-control new-password" placeholder="Confirm New Password">
                    <div class="mt-2 text-right d-flex justify-content-end align-items-center">
                        <input type="checkbox" id="show-password" checked> <small class="ms-2">Show Passsword</small>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-outline-primary w-100 p-2" name="change-password">Change Password</button>
                </div>
            </form>
            <form method="post">
                <small>Forgot Password ?<a href="<?php echo BASE_URL ?>Trans/RecoverPassword.php" class="link ms-2">Recover It</a>.</small>
            </form>
        </div>
    </div>
</div>