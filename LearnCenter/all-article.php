<?php
require_once "../Navbar.php";
require_once "../config.php";

$selectArticle = "SELECT * FROM articles";
$articleData = mysqli_query($conn, $selectArticle);

if ($articleData) {
    $ARTICLE = mysqli_fetch_assoc($articleData);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Center - NFT Marketplace</title>
    <style>
        .help-main-1 {
            /* overflow-x: hidden; */
            height: 95vh;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            position: relative;
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
            left: -150px;
            bottom: -100px;
        }

        .purple-glow-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background-color: blueviolet;
            border-radius: 50%;
            opacity: 0.3;
            mix-blend-mode: exclusion;
            filter: blur(130px);
            right: -125px;
            top: -200px;
        }

        .help-main-1 img {
            user-select: none;
            filter: drop-shadow(0px 0px 10px black);
            width: 100%;
            object-fit: contain;
            height: auto;
        }

        .help-main-1 .waves {
            position: absolute;
            z-index: -2;
            user-select: none;
            mix-blend-mode: overlay;
            width: 100%;
            object-fit: contain;
            height: auto;
        }



        .help-main-1 .waves img {
            user-select: none;
            width: 100%;
            object-fit: contain;
            height: auto;
        }

        .morphism-card {
            overflow: hidden;
            backdrop-filter: blur(4px) saturate(200%);
            -webkit-backdrop-filter: blur(4px) saturate(200%);
            background-color: rgba(17, 25, 40, 0.65);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        .morphism-card img {
            width: 100%;
            aspect-ratio: 1;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            filter: drop-shadow(0px 5px 5px rgba(0, 0, 0, 0.3));
        }

        .help-main-2 {
            position: relative;
        }

        .green-glow-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background-color: springgreen;
            border-radius: 50%;
            opacity: 0.15;
            mix-blend-mode: screen;
            filter: blur(100px)drop-shadow(0px 0px 100px springgreen);
            right: -100px;
            top: 150px;
        }

        /* sec 3 */
        .article-card-image {
            position: relative;
            width: 100%;
            height: 250px;
            overflow: hidden;
            display: flex;
            border-radius: 5px;
        }

        .article-card-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .article-standard {
            position: absolute;
            z-index: 1;
            top: 5%;
            left: 3%;
            padding: 5px 10px;
            border-radius: 7px;
        }

        .card-description {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .article-category {
            border: 1px solid gray;
            width: fit-content;
            padding: 5px 15px;
            border-radius: 5px;
        }

        a {
            color: white;
        }

        a:hover {
            text-shadow: none;
        }
    </style>
</head>

<body>

    <!-- all articles  -->
    <div class="container help-main-4 mt-4">
        <div class="col-md-12 d-flex justify-content-between">
            <h3 class="text-left">
                All Articles
            </h3>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-filter me-2"></i>Filter
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li><span class="dropdown-item">Recent</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <?php
            $selectFeturedarticle = "SELECT * FROM articles ORDER BY articleid DESC";
            $Feturedarticle = mysqli_query($conn, $selectFeturedarticle);

            if ($Feturedarticle && mysqli_num_rows($Feturedarticle) > 0) {
                while ($ARTICLE = mysqli_fetch_assoc($Feturedarticle)) {
                    $enArticleId = base64_encode(base64_encode(base64_encode(base64_encode($ARTICLE['articleid']))));
            ?>
                    <div class="col-md-4 mt-2 mb-2">
                        <a href="<?php echo BASE_URL ?>LearnCenter/article.php?article=<?php echo $enArticleId ?>">
                            <div class="morphism-card align-items-center mt-3 " style="font-size:12px;">
                                <div class="article-card-image">
                                    <img src="<?php echo BASE_URL . $ARTICLE['articleimage'] ?>">
                                    <span class="article-standard text-uppercase" style="background-color: 
                            <?php if ($ARTICLE['articlestandard'] == 'beginner') {
                                echo '#34C77B';
                            } else if ($ARTICLE['articlestandard'] == 'intermediate') {
                                echo '#15B2E5';
                            } else {
                                echo '#5D32E9';
                            } ?>">
                                        <small>
                                            <?php echo $ARTICLE['articlestandard']; ?>
                                        </small>
                                    </span>
                                </div>
                                <div class="p-3">
                                    <div class="card-title">
                                        <h4> <?php echo $ARTICLE['articlename']; ?></h4>
                                    </div>
                                    <div class="card-description">
                                        <samll class="caption"> <?php echo $ARTICLE['articleabout']; ?></samll>
                                    </div>
                                    <div class="article-category mt-3 text-uppercase">
                                        <small> <?php echo $ARTICLE['articlecategory']; ?></small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>

    </div>

</body>

</html>