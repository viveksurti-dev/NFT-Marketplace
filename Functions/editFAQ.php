<?php
require_once("../Navbar.php");
include '../config.php';

if (isset($_GET['faqid'])) {
    $faqid = $_GET['faqid'];

    $query = "SELECT * FROM faqs WHERE faqid = $faqid";
    $result = $conn->query($query);

    if (!$result) {
        die("Query error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $faq = $result->fetch_assoc();
    } else {
        echo "FAQ not found.";
        exit();
    }
} else {
    echo "FAQ Details Not Available.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_faq"])) {
    $faqTitle = $_POST["faqtitle"];
    $faqDescription = $_POST["faqdescription"];

    // Initialize $faqImage with the current image path
    $faqImage = $faq['faqimage'];

    // Handle image upload
    if (isset($_FILES["new-faq-image"]) && $_FILES["new-faq-image"]["error"] == UPLOAD_ERR_OK) {
        $targetDirectory = "../Assets/FAQs/";
        $targetFile = basename($_FILES["new-faq-image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES["new-faq-image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        // Check file size (adjust as needed)
        if ($_FILES["new-faq-image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            exit();
        }

        // Allow certain file formats
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["new-faq-image"]["tmp_name"], $targetFile)) {
            // Update the image path in the database
            $faqImage = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    // Update the FAQ in the database
    $updateQuery = "UPDATE faqs SET 
        faqimage = '$faqImage',
        faqtitle = '$faqTitle',
        faqdescription = '$faqDescription'
        WHERE faqid = $faqid";

    $updateResult = $conn->query($updateQuery);

    if (!$updateResult) {
        die("Update error: " . $conn->error);
    }

    echo "<script>window.location.href='../FAQs.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit FAQ</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add CSS link -->
    <style>
        <?php include '../Styles/main.css'; ?>
    </style>

</head>

<body>
    <div class="container card mt-5">
        <h2 class="text-center mb-2">Edit FAQ</h2>

        <!-- Edit form -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="d-flex flex-wrap">
                <div class="col-md-6">
                    <input type="hidden" name="faqid" value="<?php echo $faq['faqid']; ?>">

                    <div class="form-group d-flex justify-content-center align-itemd:center">
                        <label for="faq-image"></label>
                        <img src="../Assets/FAQs/<?php echo $faq['faqimage']; ?>" alt="FAQ Image" height="350" width="100%" class="object-fit-cover rounded-2">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="new-faq-image">New Image</label>
                        <input type="file" class="form-control input" id="new-faq-image" name="new-faq-image">
                    </div>

                    <div class="form-group mt-2">
                        <label for="faqtitle">FAQ Title:</label>
                        <input type="text" class="form-control input" id="faqtitle" name="faqtitle" value="<?php echo $faq['faqtitle']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="faqdescription">FAQ Description:</label>
                        <textarea class="form-control input" id="faqdescription" rows="5" name="faqdescription"><?php echo $faq['faqdescription']; ?></textarea>
                    </div>
                </div>

            </div>
            <center calss="faq-edit-btn">
                <button type="submit" class="btn edit btn-profile w-50" name="edit_faq">Save Changes</button>
            </center>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>