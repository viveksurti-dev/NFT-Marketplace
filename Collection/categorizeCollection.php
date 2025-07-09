<?php
require_once '../Navbar.php';
require_once '../config.php';

// Sanitize input
$collectioncategory = mysqli_real_escape_string($conn, $_GET['collectioncategory']);

// Prepare statement to avoid SQL injection
$SelectCollection = "SELECT * FROM nftcollection WHERE collectioncategory = ?";
$stmt = mysqli_prepare($conn, $SelectCollection);
mysqli_stmt_bind_param($stmt, 's', $collectioncategory);
mysqli_stmt_execute($stmt);
$CollectionDetail = mysqli_stmt_get_result($stmt);

// Check if collections exist for the given category
if (mysqli_num_rows($CollectionDetail) > 0) { ?>
    <div>
        <div class="col-md-3 mt-1 z-1" style="background: linear-gradient(270deg, rgba(18,18,18,1) 0%, rgba(54,9,121,1) 50%); position:fixed;">
            <h3 class="ms-3 p-2 rounded-1 text-capitalize">Category : <?php echo $collectioncategory ?></h3>
        </div>
    </div>
    <div class="p-1"></div>
    <div class="nft-collection mt-5">
        <div class="faq-body justify-content-start d-flex flex-wrap">
            <?php
            while ($categorizecollection = mysqli_fetch_assoc($CollectionDetail)) {
                $collectionid = $categorizecollection['collectionid'];
                $enCollectionid = base64_encode($collectionid); ?>
                <!-- Collection CARD -->
                <div class="col-md-2-5">
                    <a class="card faq-card p-2" href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" style="height:auto; width:95%; background:#191919;">
                        <div class="collection-nft-image d-flex rounded-1 justify-content-center align-items-center" style="width:100%; height:200px; overflow:hidden; text-shadow:none;">
                            <img src="<?php echo BASE_URL . $categorizecollection['collectionimage']; ?>" style="object-fit:cover; height:100%; width:100%;">
                        </div>
                        <div class="category-nft-details" style="padding: 10px;">
                            <div class="collection-name" style="font-size:18px;">
                                <?php echo $categorizecollection['collectionname']; ?>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <small class="caption">
                                        Floor Price
                                    </small>
                                    <p class="m-0">
                                        <?php
                                        $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice FROM nft WHERE nftstatus = 'active' AND collectionid = ?";
                                        $stmt = mysqli_prepare($conn, $getTotalPrice);
                                        mysqli_stmt_bind_param($stmt, 's', $collectionid);
                                        mysqli_stmt_execute($stmt);
                                        $volume = mysqli_stmt_get_result($stmt);
                                        if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                            if ($totalVolume['nftfloorprice'] <= 0) {
                                                echo '00';
                                            } else if ($totalVolume['nftfloorprice'] <= 9) {
                                                echo '0' . $totalVolume['nftfloorprice'];
                                            } else {
                                                echo $totalVolume['nftfloorprice'];
                                            }
                                        }
                                        ?> INR</p>
                                </div>
                                <div>
                                    <small class="caption">
                                        Total Volume
                                    </small>
                                    <p class="m-0">
                                        <?php
                                        $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid = ?";
                                        $stmt = mysqli_prepare($conn, $getTotalPrice);
                                        mysqli_stmt_bind_param($stmt, 's', $collectionid);
                                        mysqli_stmt_execute($stmt);
                                        $volume = mysqli_stmt_get_result($stmt);
                                        if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                            if ($totalVolume['nftprice'] <= 0) {
                                                echo '00';
                                            } else if ($totalVolume['nftprice'] < 9) {
                                                echo '0' . $totalVolume['nftprice'];
                                            } else {
                                                echo $totalVolume['nftprice'];
                                            }
                                        }
                                        ?> INR</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

<?php } else { ?>

    <div class="container container-notlogin">
        <img src="<?php echo BASE_URL ?>Assets/illu/noDataFound.png" loading="lazy" />
        <h3 class="mt-3">No Collection Found For Given Category</h3>
        <p>You Can Create Your own Contract For This Category</p>
        <a href="<?php echo BASE_URL ?>">Go To Home</a>
    </div>
<?php } ?>