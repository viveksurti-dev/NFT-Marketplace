<?php
require_once "../Navbar.php";
require_once "../config.php";
?>
<style>
    .morphism-card {
        padding: 10px;
        overflow: hidden;
        backdrop-filter: blur(4px) saturate(200%);
        -webkit-backdrop-filter: blur(4px) saturate(200%);
        background-color: rgba(17, 25, 40, 0.65);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.125);
    }

    .search-user-image {
        width: 100%;
        height: auto;
        max-height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .search-user-image img {
        width: 100%;
        height: 100%;
        aspect-ratio: 1;
        object-fit: cover;
    }

    .search-user {
        width: 0;
        left: -10%;
        overflow: hidden;
        position: absolute;
        z-index: 1;
        text-transform: capitalize;
        font-size: 20px;
        bottom: 0;
        transition: 0.5s all ease-in-out;
        overflow: hidden;
    }

    .search-results .morphism-card:hover {
        .search-user {
            width: 100%;
            left: 0%;
            overflow: hidden;
        }

    }

    .search-results a {
        color: white;
    }

    .search-results a:hover {
        text-shadow: none;
    }
</style>
<?php if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $search_query = $_GET['query'];

    $query_auth = "SELECT * FROM auth WHERE username LIKE '%$search_query%'";
    $query_nft = "SELECT * FROM nftcollection WHERE collectionname LIKE '%$search_query%'";

    $result_auth = mysqli_query($conn, $query_auth);
    $result_nft = mysqli_query($conn, $query_nft);

    if (mysqli_num_rows($result_auth) > 0) { ?>
        <div class="search-results container-fluid mt-3 d-flex flex-wrap">
            <h4 class="col-md-12 mb-3">Search For '<small> <?php echo $search_query; ?></small> '</h4>
            <div class="col-md-12 p-0">
                <div class="col-md-2" style="background: linear-gradient(270deg, rgba(18,18,18,0) 0%, rgba(54,9,121,0.8) 50%); ">
                    <h4 class=" p-2 rounded-1">Users</h4>
                </div>
            </div>
            <?php while ($serUser = mysqli_fetch_assoc($result_auth)) { ?>
                <div class="col-md-3">
                    <a href="<?php echo BASE_URL ?>userDashboard.php?username=<?php echo $serUser['username']; ?>">
                        <div class="morphism-card p-0">
                            <div class="search-user-image">
                                <img src="<?php echo BASE_URL . $serUser['userimage'] ?>">
                            </div>
                            <div class="search-user col-md-12" style="background: linear-gradient(270deg, rgba(18,18,18,0) 0%, rgba(54,9,121,0.8) 50%); ">
                                <h4 class=" p-2 pb-0 rounded-1"><?php echo $serUser['username'] ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (mysqli_num_rows($result_nft) > 0) { ?>
        <div class="search-results container-fluid mt-3 d-flex flex-wrap mb-5">
            <div class="col-md-12 p-0">
                <div class="col-md-2" style="background: linear-gradient(270deg, rgba(18,18,18,0) 0%, rgba(54,9,121,0.8) 50%); ">
                    <h4 class=" p-2 rounded-1">NFT Collections</h4>
                </div>
            </div>
            <?php while ($serCollection = mysqli_fetch_assoc($result_nft)) {
                $enCollectionid = base64_encode($serCollection['collectionid']); ?>
                <div class="col-md-3 mt-2">
                    <a href="<?php echo BASE_URL ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid ?>">
                        <div class="morphism-card p-0">
                            <div class="search-user-image">
                                <img src="<?php echo BASE_URL . $serCollection['collectionimage'] ?>">
                            </div>
                            <div class="search-user col-md-12" style="background: linear-gradient(270deg, rgba(18,18,18,0) 0%, rgba(54,9,121,0.8) 50%); ">
                                <small class=" p-2 pb-0 rounded-1 overflow-hidden"><?php echo $serCollection['collectionname'] ?></small>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

<?php mysqli_free_result($result_auth);
    mysqli_free_result($result_nft);
}

mysqli_close($conn);
