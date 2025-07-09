<?php // session_start();
require_once "Navbar.php";
include 'config.php';

// // Create 'Faqs' table if not exists
// $query = "CREATE TABLE IF NOT EXISTS faqs (
//     faqid INT AUTO_INCREMENT PRIMARY KEY,
//     faqimage VARCHAR(255) NOT NULL UNIQUE,
//     faqtitle VARCHAR(255) NOT NULL UNIQUE,
//     faqdescription TEXT NOT NULL,
//     created_date DATE NOT NULL,
//     created_time TIME NOT NULL
// )";

// mysqli_query($conn, $query);
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-faqs'])) {
    $faqDescription = $_POST["faqdescription"];
    $faqTitle = $_POST["faqtitle"];

    // Get the current date and time
    $currentDate = date("y-m-d");
    $currentTime = date("H:i");

    $targetDir = "Assets/FAQs/";
    $targetFile =  basename($_FILES["faqimage"]["name"]);

    // Create the directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($_FILES["faqimage"]["tmp_name"], $targetDir . $targetFile)) {
        $query = "INSERT INTO faqs (faqimage, faqtitle, faqdescription, created_date, created_time) 
              VALUES ('$targetFile', '$faqTitle', '$faqDescription', '$currentDate', '$currentTime')";
        mysqli_query($conn, $query);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NFT Marketplace - Create FAQs</title>

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">
</head>

<body>

    <div class="row mt-5 container-fluid">
        <div class="container col-md-5">
            <div>
                <div class="card ">
                    <h2 class="mb-4">Create FAQs</h2>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="faqimage">FAQ Image:</label>
                            <input type="file" class="form-control input" id="faqimage" name="faqimage" accept="image/*">
                        </div>

                        <div class="form-group mt-3">
                            <label for="faqtitle">FAQ Title:</label>
                            <input class="form-control input" placeholder="FAQ Title" id="faqtitle" name="faqtitle" required></input>
                        </div>
                        <div class="form-group mt-3">
                            <label for="faqdescription">FAQ Caption:</label>
                            <textarea class="form-control input" placeholder="FAQ Description" id="faqdescription" name="faqdescription" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="create-faqs" class="btn btn-profile mt-3 w-100">Create FAQs</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>