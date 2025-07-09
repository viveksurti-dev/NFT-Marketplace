<?php
require_once "../Navbar.php";
require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Center - NFT Marketplace</title>
    <style>

    </style>
</head>

<body>
    <?php
    if (isset($_GET['article'])) {
        $deArticleId = base64_decode(base64_decode(base64_decode(base64_decode($_GET['article']))));

        $selectArticle = "SELECT * FROM articles WHERE articleid = $deArticleId";
        $articleData = mysqli_query($conn, $selectArticle);

        if ($articleData && $articleData->num_rows > 0 && $ARTICLE = mysqli_fetch_assoc($articleData)) { ?>
            <div class="container d-flex justify-content-center flew-wrap mt-5">
                <div class="col-md-7">
                    <!-- Article Head -->
                    <div class="article-category text-uppercase d-flex justify-content-between">
                        <h5 class="caption"> <?php echo $ARTICLE['articlecategory'] ?></h5>
                        <button class="btn btn-outline-info ps-3 pe-3">Share</button>
                    </div>
                    <!-- Article Title -->
                    <div>
                        <h2><?php echo $ARTICLE['articlename'] ?></h2>
                        <small>
                            <?php
                            $original_date = $ARTICLE['articledate'];
                            $timestamp = strtotime($original_date);
                            echo $formatted_date = date("F j, Y", $timestamp);
                            ?>
                        </small>
                    </div>
                    <!-- Article Image -->
                    <style>
                        .article-image {
                            user-select: none;
                            width: 100%;
                            height: auto;
                            max-height: 400px;
                            margin-top: 10px;
                            border-radius: 10px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }

                        .article-image img {
                            width: 100%;
                            height: auto;
                            object-fit: cover;
                        }
                    </style>
                    <div class="article-image w-100 overflow-hidden">
                        <img src="<?php echo BASE_URL . $ARTICLE['articleimage'] ?>">
                    </div>
                    <!-- Article Description -->
                    <div class="mt-4">
                        <?php
                        $paragraphs = nl2br($ARTICLE['articleabout']);
                        echo "<p>$paragraphs</p>"; ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>

            <div class="container container-notlogin">
                <img src="<?php echo BASE_URL ?>Assets/illu/noDataFound.png" loading="lazy" alt="No Data Found Illustration" class="img-fluid" />
                <h3 class="mt-3">No Articles Found for Given Category</h3>
                <p class="mt-3">We couldn't find any articles for the selected category.</p>
                <a href="<?php echo BASE_URL ?>" class="btn btn-primary mt-3">Go to Home</a>
            </div>
    <?php }
    } else {
        echo '0';
    }
    ?>

</body>

</html>
<?php require_once '../footer.php'; ?>