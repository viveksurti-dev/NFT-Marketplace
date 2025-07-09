<?php
include '../config.php';

session_start(); // Start the session

if (!isset($_SESSION['username']) || $USER['user_role'] !== 'admin') {
    // Proceed with the delete operation
    if (isset($_GET['username'])) {
        $username = $conn->real_escape_string($_GET['username']); // Sanitize input

        $selectUser = "SELECT * FROM auth WHERE username = '$username'";
        $userdata = mysqli_query($conn, $selectUser);

        if ($userdata) {
            $user = mysqli_fetch_assoc($userdata);
            $strike = $user['strikes'];
        }

        if ($strike == '1') {
            $deactivationDate = date('Y-m-d', strtotime('+7 days'));
            $deleteSql = "UPDATE auth SET strikes = '2', deactivationdate = '$deactivationDate', status = 'strike' WHERE username = '$username'";
        } else if ($strike == '2') {
            $deactivationDate = date('Y-m-d', strtotime('+14 days'));
            $deleteSql = "UPDATE auth SET strikes = '3', deactivationdate = '$deactivationDate', status = 'strike' WHERE username = '$username'";
        } else if ($strike == '3') {
            $deleteSql = "UPDATE auth SET strikes = '4', status = 'deactivate' WHERE username = '$username'";
        } else {
            $deactivationDate = date('Y-m-d', strtotime('+3 days'));
            $deleteSql = "UPDATE auth SET strikes = '1', deactivationdate = '$deactivationDate', status = 'strike' WHERE username = '$username'";
        }

        // Execute the UPDATE query
        if (mysqli_query($conn, $deleteSql)) {
            echo "<script>window.location.href='../AdminPanel.php';</script>";
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid user ID";
    }
} else {
    echo "Unauthorized access. You need to be an admin to delete users.";
}

// Close the database connection
mysqli_close($conn);
