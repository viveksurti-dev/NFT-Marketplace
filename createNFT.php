<?php
require_once("Navbar.php");

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

include 'config.php';

// Fetch user_id based on the username
$username = $_SESSION['username'];
$userQuery = "SELECT * FROM auth WHERE username = '$username'";
$result = $conn->query($userQuery);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userid = $row['id'];

    //     $sqlCreateTable = "
    //     CREATE TABLE IF NOT EXISTS nft (
    //         nftid INT AUTO_INCREMENT PRIMARY KEY,
    //         userid INT,
    //         collectionid INT,
    //         royaltyid INT NOT NULL,
    //         nftimage VARCHAR(255) NOT NULL,
    //         nftname VARCHAR(255) NOT NULL,
    //         nftsupply INT NOT NULL,
    //         nftprice DECIMAL(10, 2) NOT NULL,
    //         nftfloorprice DECIMAL(10, 2) NOT NULL,
    //         nftdescription TEXT NOT NULL,
    //         nftstatus VARCHAR(255) NOT NULL,
    //         nftcreated_date DATE NOT NULL,
    //         nftcreated_time TIME NOT NULL,
    //         FOREIGN KEY (userid) REFERENCES auth(id),
    //         FOREIGN KEY (collectionid) REFERENCES nftcollection(collectionid)
    //     )
    // ";
    //     // Execute the CREATE TABLE query
    //     if ($conn->query($sqlCreateTable) === TRUE) {
    //     } else {
    //         echo "Error creating table: " . $conn->error;
    //     }

    // Fetch user's collections
    $collectionQuery = "SELECT collectionname FROM nftcollection WHERE userid = '$userid' AND collectionStatus = 'active'";
    $collectionResult = $conn->query($collectionQuery);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $supply = $_POST["supply"];
        $description = $_POST["description"];
        $nftprice = $_POST["nftprice"];
        $nftstatus = 'pending';
        $selectedCollection = $_POST["selectedCollection"];

        // Fetch collection ID based on the selected collection name
        $collectionIdQuery = "SELECT collectionid FROM nftcollection WHERE collectionname = '$selectedCollection'";
        $collectionIdResult = $conn->query($collectionIdQuery);
        $collectionIdRow = $collectionIdResult->fetch_assoc();
        $selectedCollectionId = $collectionIdRow['collectionid'];

        // the time zone for India
        date_default_timezone_set("Asia/Kolkata");

        // Get the current date and time
        $currentDate = date("y-m-d");
        $currentTime = date("H:i");


        // File upload handling
        $targetDir = "Assets/NFTs/";
        $targetFile = $targetDir . basename($_FILES["imageInput"]["name"]);
        $imagePath = $targetFile;

        // Check if file is an image
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "svg") {
            echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, and SVG files are allowed.";
            exit();
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["imageInput"]["tmp_name"], $targetFile)) {
            // SQL query to insert data into the 'nft' table
            $sql = "INSERT INTO nft (userid, collectionid, nftname, nftsupply, nftprice, nftfloorprice, nftstatus, nftdescription, nftimage, nftcreated_date, nftcreated_time) 
            VALUES ('$userid', '$selectedCollectionId', '$name', $supply, '$nftprice', '$nftprice', '$nftstatus', '$description', '$imagePath', '$currentDate', '$currentTime')";
            // Execute the query
            if ($conn->query($sql) === TRUE) {
                $_SESSION['create'] = "Make Your Payment From Wallet.";
                $_SESSION['nft_details'] = [
                    'nftimage' => $imagePath,
                    'nftname' => $name,
                    'nftStatus' => 'pending',
                    'nftDeployCharge' => '99',
                ];
                echo "<script>window.location.href='" . BASE_URL . "Trans/Wallet.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Error: User not found.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Create NFT</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php
        require_once("Styles/nft.css");
        require_once("Styles/main.css");
        require_once("Styles/setting.css");
        ?>
    </style>
</head>

<body>




    <div class="container-fluid d-flex flex-wrap">
        <!-- Back Button -->
        <div class="back-botton col-md-6 mt-3 mb-2">
            <a href="<?php echo BASE_URL; ?>creation.php">
                <p><i class="bi bi-arrow-left me-2"></i> /
                    <a href="<?php echo BASE_URL; ?>creation.php">Creation</a> /
                    <span class="caption">NFT</span>
                </p>
            </a>
        </div>
        <div class="back-button col-md-6 text-center mt-1 mb-2">
            <h4>Create An NFT</h4>
            <small class="caption">Once Your Item Is Minted You will Not Be Able To Change Any Of Its Information</small>
        </div>
    </div>
    <div class="container-fluid d-flex flex-wrap">
        <div class="col-md-6 col-sm-12">
            <!-- Image Preview -->
            <div class="nft-preview">
                <div id="imageMessage">
                    <div>
                        <h3>NFT Preview</h3>
                    </div>
                    <p class="caption">Select an image</p>
                    <small class="caption">Max Filesize: 100MB</small> <br />
                    <p class="caption">jpg, jpeg, png, gif, mp4, svg</p>
                </div>
                <img src="#" alt="Preview" id="imagePreview" style="display:none;">
            </div>
        </div>
        <div class="col-md-6 col-sm-12" style="overflow-y: scroll; height: 550px;">
            <div class="mt-3">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group d-flex flex-column">
                        <a href="<?php echo BASE_URL; ?>createNFTcollection.php" class="createcollection">
                            <div class="collection-icons col-md-2 col-sm-2">
                                <i class="bi bi-plus-square"></i>
                            </div>
                            <div class="col-md-10 col-sm-10">Create a New Collection</div>
                        </a>
                        <div class="col-md-12"> <small>Not all collections are eligible. <a href="" class="link"> Learn more</a></small></div>
                    </div>

                    <!-- NFT Image selection -->
                    <div class="form-group">
                        <label for="imageInput">Select NFT Image</label>
                        <input type="file" class="form-control-file input" id="imageInput" name="imageInput" placeholder="Select NFT Image" accept="image/*" onchange="previewImage()" required>
                    </div>
                    <!-- NFT Name -->
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" class="form-control input" name="name" placeholder="Name Your NFT" required>
                    </div>

                    <div class="form-group d-flex">
                        <!-- NFT supply/Quantity -->
                        <div class="w-50 p-1">
                            <label>Supply *</label>
                            <input type="number" class="form-control input" name="supply" placeholder="Quantity" required>
                        </div>
                        <!-- Select NFT Collection  -->
                        <div class="w-50 p-1">
                            <label for="selectedCollection">Select Contract</label>
                            <select name="selectedCollection" id="selectedCollection" class="form-select input" required>
                                <option value="" selected disabled>-- Select Contract --</option>
                                <?php
                                while ($collectionRow = $collectionResult->fetch_assoc()) {
                                    $collectionname = $collectionRow['collectionname']; ?>

                                    <option value="<?php echo $collectionname ?>"><?php echo $collectionname ?></option>
                                <?php  }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- Set NFT Price -->
                    <div class="form-group">
                        <label>Price *</label>
                        <input type="number" class="form-control input" name="nftprice" placeholder="Create Your Price" required>
                        <small class="caption">Note - Chargies May Applicable</small>
                    </div>
                    <!-- NFT Description -->
                    <div class="form-group">
                        <label>Description *</label>
                        <textarea class="form-control input" name="description" rows="3" placeholder="Enter a description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100 p-2 mt-2">Mint NFT</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script>
        function previewImage() {
            var input = document.getElementById('imageInput');
            var preview = document.getElementById('imagePreview');
            var message = document.getElementById('imageMessage');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    message.style.display = 'none';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#'; // Clear the preview
                preview.style.display = 'none';
                message.style.display = 'block';
            }
        }
    </script>

    <!-- alert Loader -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertContainer = document.getElementById('cust_alertContainer');

            setTimeout(function() {
                alertContainer.style.right = '20px';

                setTimeout(function() {
                    alertContainer.style.right = '-400px';
                }, 3000);
            }, 50);
        });
    </script>
</body>

</html>