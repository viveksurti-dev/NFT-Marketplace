<?php
include '../config.php';
if (!isset($_SESSION['username']) || $USER['user_role'] !== 'admin') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize inputs
        $username = $_POST['username'];
        $userRole = $_POST['userRole'];

        // Update user role in the database
        $updateSql = "UPDATE auth SET user_role = ? WHERE username = ?";
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            $stmt->bind_param("ss", $userRole, $username);
            $stmt->execute();
            $stmt->close();

            // Redirect back to the page where the user list is displayed
            header("Location: ../adminPanel.php");
            exit();
        } else {
            echo "Error updating user role: " . $conn->error;
        }
    } else {
        echo "Invalid request";
    }

    // Close the database connection
    $conn->close();
}
