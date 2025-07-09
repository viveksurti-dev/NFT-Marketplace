<?php
// $createArticle = "CREATE TABLE IF NOT EXISTS articles (
//     articleid INT AUTO_INCREMENT PRIMARY KEY,
//     articleimage VARCHAR(255) NOT NULL,
//     articlename VARCHAR(255) NOT NULL,
//     articlecategory VARCHAR(255) NOT NULL,
//     articlestandard VARCHAR(255) NOT NULL,
//     articleabout LONGTEXT NOT NULL,
//     articledate DATE NOT NULL,
//     articletime TIME NOT NULL
// )";

// $conn->query($createArticle);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-create-article'])) {
    if (isset($_FILES["article-image"]) && $_FILES["article-image"]["error"] == 0) {
        $targetDir = "Assets/articles/";
        $targetFile = $targetDir . basename($_FILES["article-image"]["name"]);
        if (move_uploaded_file($_FILES["article-image"]["tmp_name"], $targetFile)) {

            $articleImage = $targetFile;
            $articleTitle = $_POST['article-title'];
            $articleCategory = $_POST['article-category'];
            $articleStandard = $_POST['article-standard'];
            $articleDescription = $_POST['article-description'];
            $articleDate = date("Y-m-d");
            $articleTime = date("H:i:s");


            $sql = "INSERT INTO articles (articleimage, articlename, articlecategory, articlestandard, articleabout, articledate, articletime) 
                        VALUES ('$articleImage', '$articleTitle', '$articleCategory', '$articleStandard', '$articleDescription', '$articleDate', '$articleTime')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['create'] = "New record created successfully";
                echo "<script>window.location.href='';</script>";
                exit();
            } else {
                $_SESSION['create'] = "Error: " . $sql . "<br>" . $conn->error;
                echo "<script>window.location.href='';</script>";
                exit();
            }
        } else {
            $_SESSION['create'] = "Sorry, there was an error uploading your file.";
            echo "<script>window.location.href='';</script>";
            exit();
        }
    } else {
        $_SESSION['create'] = "Please select a file.";
        echo "<script>window.location.href='';</script>";
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article - NFT Marketplace</title>
    <style>
        .morphism-input {
            background: rgba(0, 0, 0, 0.3) !important;
            border: none !important;
            color: white !important;
            padding: 12px;
        }

        .morphism-input::placeholder {
            color: gray;
        }

        .waves {
            user-select: none;
            position: absolute;
            z-index: 0;
            user-select: none;
            mix-blend-mode: overlay;
            width: 100%;
            object-fit: contain;
            height: auto;
        }

        .purple-glow-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            background-color: blueviolet;
            border-radius: 50%;
            opacity: 0.3;
            mix-blend-mode: hard-light;
            filter: blur(125px);
            right: -10%;
            bottom: -10%;
            z-index: 1;
        }

        .waves img {
            user-select: none;
            width: 100%;
            object-fit: contain;
            height: auto;

        }
    </style>
</head>

<body class=" overflow-hidden">
    <div class="container relative d-flex justify-content-center mt-3">
        <div class="col-md-5">
            <div class="morphism-card p-4">
                <div>
                    <h4 class="text-center">
                        A Beginner's Guide
                    </h4>
                </div>
                <form method="post" class="mt-4" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <input type="file" name="article-image" class="form-control morphism-input" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="article-title" class="form-control morphism-input" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <style>
                            select option {
                                background: rgba(0, 0, 0, 0.8) !important;
                                margin: 25px 5px !important;
                            }
                        </style>
                        <select name="article-category" class="form-select morphism-input" required>
                            <option value="" selected disabled><small>-- SELECT CATEGORY --</small></option>
                            <option value="nft"><small>NFT</small></option>
                            <option value="blockchain"><small>BLOCKCHAIN</small></option>
                            <option value="web3"><small>WEB 3</small></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="article-standard" class="form-select morphism-input" required>
                            <option value="" selected disabled><small>-- SELECT STANDARD --</small></option>
                            <option value="beginner"><small>Beginner</small></option>
                            <option value="intermediate"><small>Intermediate</small></option>
                            <option value="advanced"><small>Advanced</small></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="article-description" class="form-control morphism-input" cols="auto" rows="5" placeholder="Description" required></textarea>
                    </div>

                    <button name="btn-create-article" class="btn btn-outline-primary w-100 p-2">Create Article</button>

                </form>
            </div>
        </div>
    </div>
</body>

</html>