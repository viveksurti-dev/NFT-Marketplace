<div class="collection-background w-100" style="background-image: url('<?php echo BASE_URL . $row['collectionimage'] ?>')">
    <div class="collection-background w-100 d-flex justify-content-center align-items-center overflow-hidden" style="height: 100%; max-height:500px; ">
        <?php
        $backgroundPath = BASE_URL . $row['collectionbackground'];
        $fileExtension = pathinfo($backgroundPath, PATHINFO_EXTENSION);

        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
            // Display an image if the file extension is an image format
        ?>
            <img class="w-100" src="<?php echo $backgroundPath ?>" alt="Background Image">
        <?php
        } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mkv'])) { ?>
            <video autoplay loop muted playsinline>
                <source src="<?php echo $backgroundPath ?>" type="video/<?php echo $fileExtension ?>">
            </video>
        <?php
        } else {
        ?>

        <?php
        }
        ?>
    </div>
    <div class="container-fluid collections-details d-flex justify-content-between align-items-end">
        <div class="col-md-2">
            <div class="collections-image">
                <img src="<?php echo BASE_URL . $row['collectionimage'] ?>" alt="">
            </div>
            <div class="collection-holder mt-2">
                <p>
                    <?php echo $row['collectionname'] ?>
                </p>
                <small class="caption">
                    <?php echo $userRow['username']; ?>
                </small>
            </div>
        </div>
        <div class="col-md-6 d-flex mb-3 justify-content-between" style="overflow-x:auto;">
            <div>
                <p class="text-center">₹ 0.00</p>
                <small class="caption">Total Volume</small>
            </div>
            <div>
                <p class="text-center">₹ 0.00</p>
                <small class="caption">Floor Price</small>
            </div>
            <div>
                <p class="text-center">₹ 0.00</p>
                <small class="caption">Best Offer</small>
            </div>
            <div>
                <p class="text-center">
                    <!-- get Total Nfts Of Collection -->
                    <?php
                    $getNFT = "SELECT * FROM nft WHERE collectionid = " . $row['collectionid'];
                    $NFTDetails = mysqli_query($conn, $getNFT);
                    if ($NFTDetails && $NFTDetails->num_rows > 0) {
                        $totalNFT = mysqli_num_rows($NFTDetails);
                        if ($totalNFT <= 9) {
                            echo "0" . $totalNFT;
                        } else {
                            echo $totalNFT;
                        }
                    } else {
                        echo '00';
                    }

                    ?>
                </p>
                <small class="caption">Items</small>
            </div>
            <div>
                <p class="text-center">0(0%)</p>
                <small class="caption">Owners</small>
            </div>
        </div>
    </div>
</div>