<?php
include '../Navbar.php';
include '../config.php';

if (!isset($_SESSION['username']) || $USER['user_role'] !== 'admin') {
    echo "<script>window.location.href='../error-002.php?allowRedirect=true';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ads - NFT Marketplace</title>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card">
                
                <form action="">
                    <input type="file" class="form-control">
                </form>
            </div>
        </div>
    </div>
</body>

</html>