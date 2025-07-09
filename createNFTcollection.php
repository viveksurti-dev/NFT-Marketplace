<?php
require_once("Navbar.php");

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

include 'config.php';

// Get user ID based on the session username
$Username = $_SESSION['username'];
$sqlUserId = "SELECT id FROM auth WHERE username = '$Username'";
$resultUserId = mysqli_query($conn, $sqlUserId);

if ($resultUserId) {
    $row = mysqli_fetch_assoc($resultUserId);
    $userId = $row['id'];
} else {
    die("Error fetching user ID: " . mysqli_error($conn));
}

// Create nftcollection table if it doesn't exist
// $sqlCreateTable = "CREATE TABLE IF NOT EXISTS nftcollection (
//     collectionid INT AUTO_INCREMENT PRIMARY KEY,
//     userid INT NOT NULL,
//     collectionimage VARCHAR(255) NOT NULL,
//     collectionbackground VARCHAR(255) NOT NULL,
//     collectionname VARCHAR(255) NOT NULL,
//     collectiondescription VARCHAR(255) NOT NULL,
//     collectionblockchain VARCHAR(50) NOT NULL,
//     collectioncategory VARCHAR(50) NOT NULL,
//     collectionStatus VARCHAR(255) DEFAULT 'pending',
//     collectionDeployCharge DECIMAL(10, 2) DEFAULT '149',
//     collection_created_date DATE NOT NULL,
//     collection_created_time TIME NOT NULL
// )";
// $conn->query($sqlCreateTable);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $collectionname = $_POST["contractName"];
    $collectiondescription = $_POST["collectiondescription"];
    $collectionblockchain = $_POST["blockchain"];
    $collectioncategory = $_POST["collectionCategory"];
    $collectionStatus = "pending";
    $collectionDeployCharge = "149";
    // the time zone for India
    date_default_timezone_set("Asia/Kolkata");

    // Get the current date and time
    $currentDate = date("y-m-d");
    $currentTime = date("H:i");

    // Check if the collection name already exists for the user
    $sqlCheckDuplicate = "SELECT COUNT(*) as count FROM nftcollection WHERE userid = '$userId' AND collectionname = '$collectionname'";
    $resultCheckDuplicate = mysqli_query($conn, $sqlCheckDuplicate);

    if ($resultCheckDuplicate) {
        $row = mysqli_fetch_assoc($resultCheckDuplicate);
        $count = $row['count'];

        if ($count > 0) {
            // Collection with the same name already exists for the user
            $_SESSION['error'] = "You Already Created This Contract .";
            echo "<script>window.location.href='createNFTCollection.php';</script>";
            exit();
        } else {
            // File upload handling
            $targetDir = "Assets/NFTCollection/";
            $targetFile = $targetDir . basename($_FILES["imageInput"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if file is an image or video
            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "svg") {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Sorry, only JPG, JPEG, PNG, GIF, and SVG files are allowed.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
                exit();
            }

            if (move_uploaded_file($_FILES["imageInput"]["tmp_name"], $targetFile)) {
                $collectionimage = $targetFile;

                // Insert data into nftcollection table
                $sqlInsert = "INSERT INTO nftcollection (userid, collectionimage, collectionname,collectiondescription, collectionblockchain,collectioncategory,collectionStatus , collection_created_date, collection_created_time) VALUES ('$userId', '$collectionimage', '$collectionname', '$collectiondescription','$collectionblockchain','$collectioncategory','$collectionStatus' ,'$currentDate','$currentTime')";

                // Execute the query
                $result = mysqli_query($conn, $sqlInsert);

                // Check for success
                if ($result) {
                    $_SESSION['collection_details'] = [
                        'collectionimage' => $collectionimage,
                        'collectionname' => $collectionname,
                        'collectionblockchain' => $collectionblockchain,
                        'collectionStatus' => 'pending',
                        'collectionDeployCharge' => '149.00',
                    ];
                    $_SESSION['create'] = "After successfully creating your collection, the next step is to process the payment to finalize your order.";
                    echo "<script>window.location.href='" . BASE_URL . "Collection/Deploy.php';</script>";
                    exit();
                } else {
                    $_SESSION['error'] = "Error creating NFT collection.";
                    echo "<script>window.location.href='createNFTCollection.php';</script>";
                    exit();
                }
            } else {
                $_SESSION['error'] = "Error uploading file.";
                echo "<script>window.location.href='createNFTCollection.php';</script>";
                exit();
            }
        }
    } else {
        die("Error checking for duplicate collection name: " . mysqli_error($conn));
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Marketplace - Create NFT Collecton</title>
</head>

<body>
    <?php
    // Display error message if it exists
    if (isset($_SESSION['error'])) {
        echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert alert-danger' id='myAlert'>
                    <div class='cust_alert-header'>
                        <div class='brand-info'>
                            <div class='Header-image me-2'>
                            <img src='Assets/illu/web-logo.png' alt='Brand Image'/>
                            </div>
                            <div class='header-name'>NFT Marketplace</div>
                        </div>
                        <div class='time'>
                            Just Now
                        </div>
                    </div>
                    <div class='cust_alert-body'>
                    {$_SESSION['error']}
                    </div>
                </div>
            </div>";
        unset($_SESSION['error']);
    }
    ?>
    <!-- Back Button -->
    <div class="back-botton col-md-6 mt-3 ms-3">
        <a href="<?php echo BASE_URL; ?>createNFT.php">
            <p><i class="bi bi-arrow-left me-2"></i> /
                <a href="<?php echo BASE_URL; ?>createNFT.php">NFT</a> /
                <span class="caption">Collection</span>
            </p>
        </a>
    </div>
    <div class="container-fluid container-collection d-flex justify-content-center mt-2">
        <div class="col-md-5">
            <h4 class="mt-1 mb-3">First, you’ll need to create a collection for your NFT</h4>
            <p class="caption mb-4">You’ll need to deploy an ERC-1155 contract on the blockchain to create a collection for your NFT. <a href="FAQs.php">What is a contract?</a></p>

            <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <!-- Image Selection -->
                <div class="form-group col-md-12">
                    <label for="imageInput">Select NFT Image</label>
                    <div class="collection-image d-flex flex-wrap">
                        <!-- Priview Icon -->
                        <div class="collecton-image-priview col-md-3 col-sm-12  pre-1">
                            <div class="priview-icons d-flex flex-column ">
                                <i class="bi bi-image"></i>
                                <i class="bi bi-upload"></i>
                            </div>
                        </div>

                        <div class="collecton-image-priview col-md-3 col-sm-12 pre-2 align-items-center" style="display:none;">
                            <img src="#" alt="Preview" class="image-priview " id="imagePreview">
                        </div>

                        <div class="col-md-9 col-sm-12 mt-1 mb-1">
                            <small>Drop Your Image</small><br />
                            <small class="caption">You May Change This After Deploying Your contract</small><br />
                            <small class="caption">File Types: jpg, jpeg, png, svg, gif</small> <br />
                            <small class="caption">Recommended Size: 350 X 350</small>
                            <input type="file" class="form-control-file input" id="imageInput" name="imageInput" placeholder="Select NFT Image" accept="image/*" onchange="previewImage()" required>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label>Contract Name <small><i class="bi bi-info-circle" onclick="openContractName('ContractName')"></i></small></label>
                    <input type="text" class="form-control input" name="contractName" placeholder="Collection Name" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Description *</label>
                    <textarea class="form-control input" name="collectiondescription" rows="3" placeholder="Enter a description" required></textarea>
                </div>
                <div class="form-group col-md-12">
                    <label>Blockchain <small><i class="bi bi-info-circle" onclick="openContractName('blockchain')"></i></small></label>
                    <select class="form-select input" id="blockchain" name="blockchain" required>
                        <option value="" disabled selected>-- Select Blockchain Type --</option>
                        <option value="inr">₹ INR</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Category </label>
                    <select class="form-select input" id="collectionCategory" name="collectionCategory" required>
                        <option class="p-2" value="" disabled selected>-- Select Category --</option>
                        <option class="p-2" value="art">ART</option>
                        <option class="p-2" value="gaming">Gaming</option>
                        <option class="p-2" value="photography">Photography</option>
                        <option class="p-2" value="pfp">PFP</option>
                        <option class="p-2" value="other">Other</option>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-secondary w-100 p-2 mt-2" onclick="validateAndCreateContact()">Create Contact</button>
                </div>
            </form>


            <div id="ContractName" class="modal">
                <div class="modal-content col-md-5">
                    <span class="close" onclick="closeContractName('ContractName')">&times;</span>
                    <h3>Contract name</h3>
                    <p class="caption">The contract name is the name of your NFT collection, which is visible on chain. This is usually your project or collection name.
                    </p>
                    <p class="caption">Contract names cannot be changed after your contract is deployed.
                    </p>
                </div>
            </div>
            <div id="blockchain" class="modal">
                <div class="modal-content col-md-5">
                    <span class="close" onclick="closeContractName('blockchain')">&times;</span>
                    <h3>Blockchain</h3>
                    <p class="caption">A blockchain is a digitally distributed ledger that records transactions and information across a decentralized network. There are different types of blockchains, which you can choose to drop on.
                    </p>
                    <p class="caption">You cannot change the blockchain once you deploy your contract.

                    </p>
                </div>
            </div>

            <!-- Form validation -->
            <script>
                function validateForm() {
                    var blockchainSelect = document.getElementById("blockchain");
                    var categorySelect = document.getElementById("collectionCategory");
                    if (blockchainSelect.value === "") {
                        alert("Please select a valid blockchain type.");
                        return false;
                    }
                    if (actegorySelect.value === "") {
                        alert("Please select a valid Category.");
                        return false;
                    }
                    return true;
                }
            </script>

            <!-- Payment Process -->
            <script>
                function validateAndCreateContact() {
                    if (validateForm()) {
                        openCreateContact();
                    }
                }

                function validateForm() {
                    var imageInput = document.getElementById("imageInput").value;
                    var contractName = document.getElementsByName("contractName")[0].value;
                    var blockchain = document.getElementsByName("blockchain")[0].value;
                    var category = document.getElementsByName("collectionCategory")[0].value;

                    // Check if the selected option is not disabled
                    var selectedBlockchain = blockchain.options[blockchain.selectedIndex];
                    if (!selectedBlockchain.disabled) {
                        // Add additional validation logic as needed
                        if (imageInput && contractName && blockchain.value && category.value) {
                            return true;
                        }
                    }
                    return false;
                }

                function openCreateContact() {
                    openMinimizedWindow();
                    openDeployContract();
                }

                function openMinimizedWindow() {
                    var url = 'https://example.com'; // Replace with your desired URL
                    var features = 'width=800,height=600,minimized=yes,resizable=no,scrollbars=no,toolbar=no,status=no';

                    var newWindow = window.open(url, '_blank', features);
                    newWindow.focus();
                }

                function openDeployContract() {
                    document.getElementById("DeployContract").style.display = "block";
                    document.body.classList.add('modal-open');
                }

                function closeDeployContract() {
                    document.getElementById("DeployContract").style.display = "none";
                    document.body.classList.remove('modal-open');
                }
            </script>


            <!-- Modal Script -->
            <script>
                function openContractName(modalId) {
                    document.getElementById(modalId).style.display = "block";
                    document.body.classList.add('modal-open');
                }

                function closeContractName(modalId) {
                    document.getElementById(modalId).style.display = "none";
                    document.body.classList.remove('modal-open');
                }
            </script>
            <!-- Priview Image script -->
            <script>
                function previewImage() {
                    var imageInput = document.getElementById("imageInput");
                    var previewDiv1 = document.querySelector(".pre-1");
                    var previewDiv2 = document.querySelector(".pre-2");
                    var imagePreview = document.getElementById("imagePreview");

                    if (imageInput.files && imageInput.files[0]) {
                        // Image selected
                        previewDiv1.style.display = "none";
                        previewDiv2.style.display = "block";

                        var reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                        };
                        reader.readAsDataURL(imageInput.files[0]);
                    } else {
                        // No image selected
                        previewDiv1.style.display = "block";
                        previewDiv2.style.display = "none";
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
                        }, 5000);
                    }, 50);
                });
            </script>



        </div>
    </div>
</body>

</html>

<?php
require_once("footer.php");
?>