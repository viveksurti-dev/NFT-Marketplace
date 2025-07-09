<style>
    /* User Dashboard Menu : creation */
    .btn-universal {
        background-color: #181818;
        color: white;
        padding: 9px 15px;
        font-size: 18px;
    }

    .btn-universal:hover {
        background-color: #202020;
        color: white;
        font-size: 18px;
    }

    .user-collections {
        background-color: #151515;
        width: 100%;
        padding: 5px;
        border-radius: 5px;
        min-height: 250px;
        height: 100%;
        max-height: auto;
        border: 1px solid #252525;
        position: relative;
        z-index: 0;
        display: flex;
    }

    .collections-menus {
        display: flex;
        flex-wrap: nowrap;
        top: 125px;
        padding: 10px;
        z-index: 1;
        background: #131313;
    }

    .user-collections .container-collections {
        padding: 2px;
        width: 100%;
        height: auto;
        background-color: #202020;
        display: flex;
        justify-content: center;
        border-radius: 5px;
        flex-direction: column;
    }

    .user-collections .container-collections:hover {
        transform: translateY(-5px);
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        background-color: #212121;
    }

    .user-collections .container-collections:hover img {
        scale: 1.01;
    }

    .user-collections a:hover {
        text-shadow: none;
    }

    .user-collections .container-collections .collections-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px;
        border-radius: 5px;
    }

    .user-collections .container-collections .collections-image img {
        border-radius: 5px;
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: all 0.3s ease-in-out;
    }

    .user-collections .container-collections .collections-detail {
        padding: 10px;
    }

    .collections-detail .collections-name {
        font-size: 18px;
        color: white;
        font-weight: 500;
    }

    .collections-detail .collections-volume {
        font-size: 18px;
        color: white;
        display: flex;
        justify-content: space-between;
        padding: 0px 10px;
    }

    .collections-detail .collections-volume p {
        padding: 0;
        margin: 0;
    }
</style>
<div>
    <div class="collections-menus relative sticky-top mt-2 mb-2">
        <button class="btn btn-universal me-2"> <i class="bi bi-filter"></i></button>
        <div class="btn-group me-2">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Status
            </button>
            <ul class="dropdown-menu p-2">
                <li>
                    <p class="dropdown-item">New</p>
                    <p class="dropdown-item">On Auction</p>
                </li>
            </ul>
        </div>
        <div class="btn-group me-2">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Chains
            </button>
            <ul class="dropdown-menu p-2">
                <li>
                    <p class="dropdown-item" href="#">₹ INR</p>
                </li>
            </ul>
        </div>

        <input type="text" class="input w-50" placeholder="Search By Name">
        <div class="d-flex align-items-center ms-3">
            <?php
            // fetch userdata
            $userDetail = "SELECT * FROM auth WHERE username = '$username'";
            $getUserDetails = mysqli_query($conn, $userDetail);

            if ($getUserDetails && $getUserDetails->num_rows > 0) {

                // userdata variables
                $row = mysqli_fetch_assoc($getUserDetails);
                $userid = $row['id'];
                // Fetch user Collection
                $collectionDetails = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND nftcollection.userid = '$userid'";
                $userCollections = mysqli_query($conn, $collectionDetails);

                // Check if the query was successful
                if ($userCollections) {
                    // Count the total number of rows (collections)
                    $totalCollections = mysqli_num_rows($userCollections);

                    // Output or use the $totalCollections as needed
                    echo " $totalCollections items";
                } else {
                    // Handle the case where the query fails
                    echo "Error retrieving user collections: " . mysqli_error($conn);
                }
            } ?>
        </div>
    </div>
    <div class="user-collections d-flex flex-wrap " id="users-Collections">
        <?php

        // fetch userdata
        $userDetail = "SELECT * FROM auth WHERE username = '$username'";
        $getUserDetails = mysqli_query($conn, $userDetail);

        if ($getUserDetails && $getUserDetails->num_rows > 0) {

            // userdata variables
            $row = mysqli_fetch_assoc($getUserDetails);
            $userid = $row['id'];

            //fetch user Collection
            $collectionDetails = "SELECT * FROM nftcollection WHERE collectionStatus = 'active' AND nftcollection.userid = '$userid'";
            $userCollections = mysqli_query($conn, $collectionDetails);

            if ($userCollections && $userCollections->num_rows > 0) {


                while ($row = mysqli_fetch_assoc($userCollections)) {
                    $collectionid = $row['collectionid'];
                    $enCollectionid = base64_encode($collectionid);
        ?>

                    <a href="<?php echo BASE_URL; ?>Collection/collectionDetails.php?collectionid=<?php echo $enCollectionid; ?>" class="container-collections col-md-2 m-1">
                        <div class="collections-image">
                            <img src="<?php echo BASE_URL . $row['collectionimage'] ?>" alt="Collection Image" loading="lazy">
                        </div>
                        <div class="collections-detail">
                            <div class="collections-name">
                                <p><?php echo $row['collectionname']; ?></p>
                            </div>
                            <div class="collections-volume">
                                <div>
                                    <small class="caption">Floor</small><br />
                                    <small>
                                        <?php
                                        $getTotalPrice = "SELECT MIN(nftfloorprice) as nftfloorprice 
                                            FROM nft 
                                            WHERE nftstatus = 'active' 
                                            AND collectionid = $collectionid";
                                        $volume = mysqli_query($conn, $getTotalPrice);
                                        $volume = mysqli_query($conn, $getTotalPrice);
                                        if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                            if ($totalVolume['nftfloorprice'] <= 0) {
                                                echo '00';
                                            } else if ($totalVolume['nftfloorprice'] <= 9) {
                                                echo '0' . $totalVolume['nftfloorprice'];
                                            } else {
                                                echo $totalVolume['nftfloorprice'];
                                            }
                                        }
                                        ?> INR
                                    </small>
                                </div>
                                <div class="text-end">
                                    <small class="caption">Total Volume</small>
                                    <br />
                                    <small><?php
                                            $getTotalPrice = "SELECT SUM(nftprice) as nftprice FROM nft WHERE nftstatus = 'active' AND collectionid = $collectionid";
                                            $volume = mysqli_query($conn, $getTotalPrice);
                                            if ($totalVolume = mysqli_fetch_assoc($volume)) {
                                                if ($totalVolume['nftprice'] <= 0) {
                                                    echo '00';
                                                } else if ($totalVolume['nftprice'] < 9) {
                                                    echo '0' . $totalVolume['nftprice'];
                                                } else {
                                                    echo $totalVolume['nftprice'];
                                                }
                                            }
                                            ?> INR
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>

                <?php  }
            } else { ?>

                <div class="d-flex flex-column w-100 justify-content-center  align-items-center" style="height: 250px;">
                    <p>Collections Not Found</p>
                    <a href="<?php echo BASE_URL; ?>creation.php" class="btn btn-primary">Create Yours</a>
                </div>
        <?php }
        } else {
            echo 'user not found';
        }

        ?>
    </div>
</div>