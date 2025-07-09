<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $check_username = "SELECT * FROM auth WHERE username = '$username'";
    $result_username = $conn->query($check_username);


    if ($result_username->num_rows > 0) {
        echo "<small class='text-danger p-0 m-0'>'$username' Username is not availble</small>";
    } else if ($username == '') {
    } else {
        echo "<small class='text-success p-0 m-0'>'$username' Username is availble</small>";
    }
}