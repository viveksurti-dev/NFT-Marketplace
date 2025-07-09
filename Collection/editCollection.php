<?php
require_once '../Navbar.php';
require_once '../config.php';

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../error-001.php?allowRedirect=true';</script>";
    exit();
}
?>

<?php
// Display error message if it exists
if (isset($_SESSION['create'])) {
    echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert alert-danger' id='myAlert'>
                    <div class='cust_alert-header'>
                        <div class='brand-info'>
                            <div class='Header-image me-2'>
                            <img src='" . BASE_URL . "Assets/illu/web-logo.png' alt='Brand Image'/>
                            </div>
                            <div class='header-name'>NFT Marketplace</div>
                        </div>
                        <div class='time'>
                            Just Now
                        </div>
                    </div>
                    <div class='cust_alert-body'>
                    {$_SESSION['create']}
                    </div>
                </div>
            </div>";
    unset($_SESSION['create']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection - NFT Marketplace</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Styles/nft.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Styles/main.css">
    <!-- CSS : nft.css | Line : 266 -->
    <style>
        .collection-side {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: space-between;
        }

        .collection-side {
            position: absolute;
            height: 91.5vh;
            width: 300px;
            background-color: #181818;
            right: 0;
        }

        .collection-content {
            width: calc(100% - 320px);
            height: 91.5vh;
            overflow-y: scroll;
        }

        .collection-side .menu-head {
            background-color: #222222;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
        }

        .collection-side .collection-tail {
            background-color: #222222;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
        }

        .collection-tail .collection-profile {
            width: 75px;
            height: 75px;
            border-radius: 5px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .collection-tail .collection-profile img {
            object-fit: cover;
            width: 100%;
            height: auto;
        }

        .collection-content .collection-backimage {
            height: 400px;
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #151515;
            position: relative;
        }

        .collection-content .collection-backimage img {
            height: auto;
            object-fit: cover;
            width: 100%;
        }

        .collection-content .collection-profile {
            height: 550px;
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #151515;
            position: relative;
            border-radius: 5px;
        }

        .collection-content .collection-profile img {
            height: auto;
            object-fit: cover;
            width: 100%;

        }

        .collection-content .collection-edits {
            height: 550px;
            width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #151515;
            position: relative;
            border-radius: 5px;
        }

        .collection-content .collection-edits img {
            height: 100%;
            object-fit: cover;
            width: 100%;

        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['collectionid'])) {
        $enCollectionid = $_GET['collectionid'];
        $deId = base64_decode($enCollectionid);

        $collectionDetails = "SELECT * FROM nftcollection WHERE collectionid = '$deId'";
        $getCollection = mysqli_query($conn, $collectionDetails);


        if ($getCollection && $getCollection->num_rows > 0) {
            $row = mysqli_fetch_assoc($getCollection);
            $enCollectionid = base64_encode($row['collectionid']);

            $collectionUserDetails = "SELECT * FROM auth WHERE id = " . $row['userid'];
            $collectionUser = mysqli_query($conn, $collectionUserDetails);

            if ($collectionUser && $collectionUser->num_rows > 0) {
                $userRow = mysqli_fetch_assoc($collectionUser);

    ?>

                <div class="container-fluid m-0 p-0 overflow-hidden collection-edit">
                    <div class="collection-side">
                        <div class="menu-head text-center">
                            <small>Collection Edit</small>
                        </div>
                        <div class="collection-menus p-2 text-center">
                            <button id="col-menu-1" onclick="showContent('col-content-1','col-menu-1')" class="btn btn-profile w-100">Background Image</button>
                            <button id="col-menu-2" onclick="showContent('col-content-2','col-menu-2')" class="btn btn-profile w-100 mt-2">Image</button>
                            <button id="col-menu-3" onclick="showContent('col-content-3','col-menu-3')" class="btn btn-profile w-100 mt-2">Details</button>
                        </div>
                        <a href="<?php echo BASE_URL ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid ?>">
                            <div class="collection-tail d-flex align-items-center">

                                <div class="collection-profile">
                                    <img src="<?php echo BASE_URL . $row['collectionimage'] ?>" alt="">
                                </div>
                                <div class="ms-3">
                                    <small><?php echo $row['collectionname'] ?></small>
                                    <div class="caption">~ <?php echo $userRow['username'] ?></div>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="collection-content">
                        <div id="col-content-1" class="content background-image">
                            <div class="col-md-4" style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
                                <h3 class="ms-3 p-3 rounded-1">
                                    Collection Background
                                </h3>
                            </div>

                            <div class="collection-backimage">
                                <img src="<?php echo BASE_URL . $row['collectionbackground']; ?>" alt="">
                                <div style="position:absolute; bottom:20px; left:20px">
                                    | Current NFT Background Image
                                </div>
                            </div>
                            <div class="mt-2 container text-center">
                                "Explore a digital universe where creativity knows no bounds. Immerse yourself in a realm where art meets innovation, where each pixel tells a unique story. Join us in the journey through the ever-evolving landscape of blockchain-powered art. Welcome to our NFT collection, where imagination takes flight and authenticity reigns supreme. Discover, collect, and be part of the revolution."
                            </div>
                            <div class="mt-3 mb-4 container d-flex justify-content-center">
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-background'])) {
                                    $targetDir = "../Assets/NFTCollection/";
                                    $targetFile = $targetDir . basename($_FILES["NewBackground"]["name"]);
                                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                                    if (move_uploaded_file($_FILES["NewBackground"]["tmp_name"], $targetFile)) {
                                        $collectionimage = str_replace('../', '', $targetDir . basename($_FILES["NewBackground"]["name"]));
                                        $UpdateCollection = "UPDATE nftcollection SET collectionbackground = '$collectionimage' WHERE collectionid = {$row['collectionid']}";
                                        $updateData = mysqli_query($conn, $UpdateCollection);

                                        if ($updateData) {
                                            $_SESSION['create'] = "Collection Profile Updated Successfully";
                                            echo "<script>window.location.href='';</script>";
                                            exit();
                                        } else {
                                            $_SESSION['create'] = "Error updating collection profile.";
                                            echo "<script>window.location.href='';</script>";
                                            exit();
                                        }
                                    } else {
                                        $_SESSION['create'] = "Error uploading image.";
                                        echo "<script>window.location.href='';</script>";
                                        exit();
                                    }
                                }
                                ?>

                                <form method="post" enctype="multipart/form-data">
                                    <!-- Image Selection -->
                                    <div class="form-group col-md-12">
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
                                                <small class="caption">File Types: jpg, jpeg, png, svg, gif</small> <br />
                                                <input type="file" class="form-control-file input mt-2" id="imageInput" name="NewBackground" placeholder="Select NFT Image" accept="image/*" onchange="previewImage()" required>

                                                <div class="text-center">
                                                    <button class="btn btn-outline-primary mt-2 w-100" type="submit" name="update-background">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div id="col-content-2" class="content forground-image hidden">
                            <div class="col-md-4" style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
                                <h3 class="ms-3 p-3 rounded-1">
                                    Collection Profile
                                </h3>
                            </div>
                            <div class="container-fluid d-flex flex-wrap">
                                <div class="col-md-5">
                                    <div class="collection-profile">
                                        <img src="<?php echo BASE_URL . $row['collectionimage'] ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h4>Update Image</h4>
                                    <div class="text-left">
                                        <div>
                                            For size, you'll want to adhere to the guidelines provided by the specific NFT marketplace where you plan to list your collection. These guidelines typically include dimensions in pixels, such as 1080x1920 or 2048x2048.
                                        </div>
                                        <div class="mt-3">
                                            As for the type of image, you'll typically want to use a high-resolution JPEG or PNG file, as these formats are widely supported and provide good image quality while keeping file sizes manageable. Additionally, make sure the image file size meets the requirements of the marketplace to ensure smooth uploading and viewing experiences for potential collectors.
                                        </div>
                                    </div>
                                    <div class="mt-5 mb-4 container d-flex justify-content-center">
                                        <?php
                                        if (isset($_POST['update-foreground']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                                            $targetDir = "../Assets/NFTCollection/";
                                            $targetFile = $targetDir . basename($_FILES["NewForeground"]["name"]);
                                            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                                            if (move_uploaded_file($_FILES["NewForeground"]["tmp_name"], $targetFile)) {
                                                $collectionimage = str_replace('../', '', $targetDir . basename($_FILES["NewForeground"]["name"]));
                                                $UpdateCollection = "UPDATE nftcollection SET collectionimage = '$collectionimage' WHERE collectionid = {$row['collectionid']}";
                                                $updateData = mysqli_query($conn, $UpdateCollection);

                                                if ($updateData) {
                                                    $_SESSION['create'] = "Image Update Successfully";
                                                    echo "<script>window.location.href='';</script>";
                                                    exit();
                                                } else {
                                                    $_SESSION['create'] = "Error uploading image.";
                                                    echo "<script>window.location.href='';</script>";
                                                    exit();
                                                }
                                            } else {
                                                $_SESSION['create'] = "Error uploading image.";
                                                echo "<script>window.location.href='';</script>";
                                                exit();
                                            }
                                        }
                                        ?>

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group col-md-12">
                                                <div class="collection-image d-flex flex-wrap">
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
                                                        <small class="caption">File Types: jpg, jpeg, png, svg, gif</small> <br />
                                                        <input type="file" class="form-control-file input mt-2" id="imageInput" name="NewForeground" placeholder="Select NFT Image" accept="image/*" onchange="previewImage()" required>

                                                        <div class="text-center">
                                                            <button class="btn btn-outline-primary mt-2 w-100" name="update-foreground">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="col-content-3" class="content edit-collection-image hidden">
                            <div class="col-md-4" style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,0.5) 50%); ">
                                <h3 class="ms-3 p-3 rounded-1">
                                    Collection Details
                                </h3>
                            </div>
                            <div class="container-fluid d-flex flex-wrap">
                                <div class="col-md-5">
                                    <div class="collection-edits">
                                        <img src="<?php echo BASE_URL ?>Assets/illu/edit-2.png" style="object-fit:cover;">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h4>Update Details</h4>
                                    <div class="text-left">
                                        <div>
                                            To update collection details such as name and description, please refer to the editing options provided by the specific NFT marketplace where you plan to list your collection. Typically, you can access these options through your account dashboard or profile settings.
                                        </div>
                                    </div>
                                    <div class="mt-5 mb-4 ">
                                        <?php
                                        if (isset($_POST['update-collection-info']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                                            $newName = $_POST['edit-name'];
                                            $newDescription = $_POST['edit-description'];

                                            // Assuming $conn is your database connection
                                            $UpdateCollection = "UPDATE nftcollection SET collectionname = '$newName',
                                            collectiondescription = '$newDescription' WHERE collectionid = {$row['collectionid']}";
                                            $updateData = mysqli_query($conn, $UpdateCollection);

                                            if ($updateData) {
                                                $_SESSION['create'] = "Collection Details Updated Successfully";
                                                echo "<script>window.location.href='';</script>";
                                                exit();
                                            } else {
                                                $_SESSION['create'] = mysqli_error($conn);
                                                echo "<script>window.location.href='';</script>";
                                                exit();
                                            }
                                        }
                                        ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group w-100">
                                                <input type="text" name="edit-name" class="form-control input" placeholder="New Name" value="<?php echo $row['collectionname'] ?>">
                                            </div>
                                            <div class="form-group w-100">
                                                <textarea name="edit-description" class="form-control input" cols="auto" rows="7" placeholder="New Description"><?php echo $row['collectiondescription']; ?></textarea>
                                            </div>
                                            <button class="btn btn-outline-primary w-100 p-2" name="update-collection-info">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


    <?php
            } else {
                echo 'User not found';
            }
        }
    } else {
        echo "Collection ID not set.";
    }
    ?>
</body>

</html>

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

<script>
    function showContent(contentId, buttonId) {
        var contentDivs = document.getElementsByClassName('content');
        for (var i = 0; i < contentDivs.length; i++) {
            contentDivs[i].classList.add('hidden');
        }

        var buttonElements = document.getElementsByTagName('button');
        for (var i = 0; i < buttonElements.length; i++) {
            buttonElements[i].classList.remove('active');
        }

        document.getElementById(contentId).classList.remove('hidden');
        document.getElementById(buttonId).classList.add('active');

        localStorage.setItem('activeButtonId', buttonId);
    }

    document.addEventListener("DOMContentLoaded", function() {
        var activeButtonId = localStorage.getItem('activeButtonId');

        if (activeButtonId) {
            if (activeButtonId === 'col-menu-1' || activeButtonId === 'col-menu-2' || activeButtonId === 'col-menu-3') {
                showContent('col-content-' + activeButtonId.split('-')[2], activeButtonId);
            } else {
                showContent('col-content-1', 'col-menu-1');
            }
        } else {
            showContent('col-content-1', 'col-menu-1');
        }
    });
</script>


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