<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["phone"];

    $check_phone = "SELECT * FROM auth WHERE phone = '$phone'";
    $result_phone = $conn->query($check_phone);

    if ($result_phone->num_rows > 0) {
        echo "<small class='text-danger p-0 m-0'>'$phone' is already exist</small>";
    } else if ($phone == '') {
    } else if (!preg_match("/^\d{10}$/", $phone)) {
        echo "<small class='text-danger p-0 m-0'>Please enter valid phone number</small>";
    }
}
