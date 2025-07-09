<?php
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['user_role'] !== 'admin') {
    if (isset($_GET['faqid'])) {
        $faqid = $_GET['faqid'];

        // Handle product deletion
        $query = "DELETE FROM faqs WHERE faqid = $faqid";
        $result = $conn->query($query);

        // Check for errors in the query execution
        if (!$result) {
            die("Query error: " . $conn->error);
        }

        echo "<script>window.location.href='../FAQs.php';</script>";
        exit();
    } else {
        echo "<h2 style='background:#202020; color:white; font-family: Akshar, sans-serif; font-family: Fira Sans, sans-serif;letter-spacing: 0.5px; text-align:center; padding:37px 0px'> FAQ is details provided.</h2>";
        exit();
    }
}
