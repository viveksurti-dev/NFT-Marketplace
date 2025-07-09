<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $check_email = "SELECT * FROM auth WHERE email = '$email'";
    $result_email = $conn->query($check_email);

    if ($result_email->num_rows > 0) {
        echo "<small class='text-danger p-0 m-0'>'$email' is not availble</small>";
    } else if ($email == '') {
    } else if (!preg_match("/^[\w-]+(\.[\w-]+)*@(gmail|yahoo|hotmail|outlook|aol|icloud|protonmail)\.([a-z]{2,})$/i", $email)) {
        echo "<small class='text-danger p-0 m-0'>Please enter valid email</small>";
    } else {
        echo "<small class='text-success p-0 m-0'>'$email' is availble</small>";
    }
}
