<div class="d-flex flex-wrap deals-content">
    <style>
        @media screen and (max-width: 760px) {
            .deal-btns {
                flex-direction: row !important;
                overflow-x: scroll;
            }

            .deal-btns .btn {
                margin-left: 5px;
            }
        }
    </style>
    <div class="col-md-3 d-flex flex-column deal-btns">
        <button id="bd1" class="btn btn-deals btn-universal mt-2 active"
            onclick="showDealContent('active', 'bd1')">Active</button>
        <button id="bd2" class="btn btn-deals btn-universal mt-2"
            onclick="showDealContent('accepted', 'bd2')">Accepted</button>
        <button id="bd3" class="btn btn-deals btn-universal mt-2"
            onclick="showDealContent('canceled', 'bd3')">Canceled</button>
        <button id="bd4" class="btn btn-deals btn-universal mt-2"
            onclick="showDealContent('inactive', 'bd4')">Inactive</button>
        <button id="bd5" class="btn btn-deals btn-universal mt-2"
            onclick="showDealContent('expired', 'bd5')">Expired</button>
    </div>

    <div class="col-md-9 p-2">
        <div id="active" class="sub-content Active" style="max-height:275px; overflow:scroll;">
            <?php
            $selectOffer = "SELECT * FROM nftoffers 
                    WHERE offerstatus = 'pending' 
                    AND userid = {$USER['id']} ORDER BY offerid DESC";
            $offerDetail = mysqli_query($conn, $selectOffer);

            if ($offerDetail && mysqli_num_rows($offerDetail) > 0) {
            ?>
                <table class="w-100">
                    <tr>
                        <td class="p-2 text-center caption">Item</td>
                        <td class="p-2 text-center caption">Offer Id</td>
                        <td class="p-2 text-center caption">Price</td>
                        <td class="p-2 text-center caption">Supply</td>
                        <td class="p-2 text-center caption">Date & Time</td>
                    </tr>
                    <?php
                    while ($OFFERS = mysqli_fetch_assoc($offerDetail)) {
                        $OfferUser = "SELECT * FROM auth WHERE id = {$OFFERS['userid']}";
                        $UserDetail = mysqli_query($conn, $OfferUser);
                        if ($UserDetail) {
                            $userOffer = mysqli_fetch_assoc($UserDetail);
                        }
                        $selectNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND nftid = {$OFFERS['nftid']}";
                        $nftDetails = mysqli_query($conn, $selectNFT);
                        $NFT = mysqli_fetch_assoc($nftDetails);
                        $enNFTid = base64_encode($NFT['nftid']);

                    ?>
                        <tr style="border-top: 1px solid #252525;">
                            <td class="p-2 text-center">
                                <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                    <img src="<?php echo BASE_URL . $NFT['nftimage']; ?>" alt="User Image" height="75px"
                                        width="75px" class="rounded-1 object-fit-cover">
                                    <small class="text-capitalize ms-2"><?php echo $NFT['nftname']; ?></small>
                                </a>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php
                                    $offerid = $OFFERS['offerid'];
                                    $enOfferid = md5($offerid);
                                    echo $enOfferid;
                                    ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offerprice']; ?> INR</small>
                            </td>


                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offersupply']; ?></small>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php echo date("d F Y", strtotime($OFFERS['offerdate'])); ?> |
                                    <?php echo date("H : i", strtotime($OFFERS['offertime'])); ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel-offer'])) {
                                    $updatestatus = "UPDATE nftoffers SET offerstatus = 'cancel' WHERE offerid = {$OFFERS['offerid']}";
                                    if ($conn->query($updatestatus) === TRUE) {
                                        $_SESSION['create'] = "Dear $USER[username], Your Offer For $NFT[nftname] has been Withdrawn!";
                                        echo "<script>window.location.href='';</script>";
                                        exit();
                                    }
                                }
                                ?>
                                <form action="" method="post">
                                    <button type="submit" class="btn btn-outline-danger" name="cancel-offer">
                                        <i class="bi bi-hurricane me-2"></i> Withdraw
                                    </button>
                                </form>


                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>No Items To Display</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div id="accepted" class="sub-content Accepted hidden">
            <?php
            $timezone = new DateTimeZone('Asia/Kolkata');
            $currentTime = new DateTime('now', $timezone);
            $currentTimestamp = $currentTime->format('Y-m-d H:i:s');

            $selectOffer = "SELECT * FROM nftoffers 
            WHERE offerstatus = 'accept' 
            AND userid = {$USER['id']} 
            AND CONCAT(offerenddate, ' ', offerendtime) > CONVERT_TZ(NOW(), '+00:00', '+05:30')
            ORDER BY offerid DESC";

            $offerDetail = mysqli_query($conn, $selectOffer);

            if ($offerDetail && mysqli_num_rows($offerDetail) > 0) {
            ?>
                <table class="w-100">
                    <tr>
                        <td class="p-2 text-center caption">Item</td>
                        <td class="p-2 text-center caption">Offer Id</td>
                        <td class="p-2 text-center caption">Price</td>
                        <td class="p-2 text-center caption">Supply</td>
                        <td class="p-2 text-center caption">Date & Time</td>
                    </tr>
                    <?php
                    while ($OFFERS = mysqli_fetch_assoc($offerDetail)) {
                        $OfferUser = "SELECT * FROM auth WHERE id = {$OFFERS['userid']}";
                        $UserDetail = mysqli_query($conn, $OfferUser);
                        if ($UserDetail) {
                            $userOffer = mysqli_fetch_assoc($UserDetail);
                        }
                        $selectNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND nftid = {$OFFERS['nftid']}";
                        $nftDetails = mysqli_query($conn, $selectNFT);
                        $NFT = mysqli_fetch_assoc($nftDetails);
                        $enNFTid = base64_encode($NFT['nftid']);
                        $NFTAutherId = $NFT['userid']

                    ?>
                        <tr style="border-top: 1px solid #252525;">
                            <td class="p-2 text-center">
                                <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                    <img src="<?php echo BASE_URL . $NFT['nftimage']; ?>" alt="User Image" height="75px"
                                        width="75px" class="rounded-1 object-fit-cover">
                                    <small class="text-capitalize ms-2"><?php echo $NFT['nftname']; ?></small>
                                </a>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php
                                    $offerid = $OFFERS['offerid'];
                                    $enOfferid = md5($offerid);
                                    echo $enOfferid;
                                    ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offerprice']; ?> INR</small>
                            </td>


                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offersupply']; ?></small>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php echo date("d F Y", strtotime($OFFERS['offerdate'])); ?> |
                                    <?php echo date("H : i", strtotime($OFFERS['offertime'])); ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <?php
                                if (isset($_POST['make-buy-offer']) && $_SERVER["REQUEST_METHOD"] == "POST") {
                                    $selectcollection = "SELECT * FROM nftcollection WHERE collectionid = {$NFT['collectionid']}";
                                    $collectionDetail = mysqli_query($conn, $selectcollection);
                                    if ($collection = mysqli_fetch_assoc($collectionDetail)) {
                                        $_SESSION['BUY_NFT'] = [
                                            'collectionid' => $collection['collectionid'],
                                            'collectionname' => $collection['collectionname'],
                                            'currentNFTPrice' => $OFFERS['offerprice'],
                                            'buysupply' => $OFFERS['offersupply'],
                                            'nftid' => $NFT['nftid'],
                                            'nftname' => $NFT['nftname'],
                                            'nftautherid' => $NFTAutherId,
                                            'nftimage' => $NFT['nftimage'],
                                            'authid' => $USER['id'],
                                            'authusername' => $USER['username'],
                                            'buydate' => $currentDate,
                                            'buytime' => $currentTime
                                        ];

                                        echo $NFT['userid'];
                                        if ($_SESSION['BUY_NFT']) {
                                            echo "<script>window.location.href='" . BASE_URL . "Trans/Wallet.php';</script>";
                                            exit();
                                        }
                                    } else {
                                        echo 'Collection not found';
                                    }
                                }
                                ?>
                                <form action="" method="post">
                                    <button type="submit" class="btn btn-outline-success" name="make-buy-offer">
                                        <i class="bi bi-amd me-2"></i> Purchase
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>No Items To Display</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div id="canceled" class="sub-content Canceled hidden">
            <?php
            $selectOffer = "SELECT * FROM nftoffers 
                    WHERE offerstatus = 'cancel' 
                    AND userid = {$USER['id']} ORDER BY offerid DESC";
            $offerDetail = mysqli_query($conn, $selectOffer);

            if ($offerDetail && mysqli_num_rows($offerDetail) > 0) {
            ?>
                <table class="w-100">
                    <tr>
                        <td class="p-2 text-center caption">Item</td>
                        <td class="p-2 text-center caption">Offer Id</td>
                        <td class="p-2 text-center caption">Price</td>
                        <td class="p-2 text-center caption">Supply</td>
                        <td class="p-2 text-center caption">Date & Time</td>
                    </tr>
                    <?php
                    while ($OFFERS = mysqli_fetch_assoc($offerDetail)) {
                        $OfferUser = "SELECT * FROM auth WHERE id = {$OFFERS['userid']}";
                        $UserDetail = mysqli_query($conn, $OfferUser);
                        if ($UserDetail) {
                            $userOffer = mysqli_fetch_assoc($UserDetail);
                        }
                        $selectNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND nftid = {$OFFERS['nftid']}";
                        $nftDetails = mysqli_query($conn, $selectNFT);
                        $NFT = mysqli_fetch_assoc($nftDetails);
                        $enNFTid = base64_encode($NFT['nftid']);

                    ?>
                        <tr style="border-top: 1px solid #252525;">
                            <td class="p-2 text-center">
                                <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                    <img src="<?php echo BASE_URL . $NFT['nftimage']; ?>" alt="User Image" height="75px"
                                        width="75px" class="rounded-1 object-fit-cover">
                                    <small class="text-capitalize ms-2"><?php echo $NFT['nftname']; ?></small>
                                </a>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php
                                    $offerid = $OFFERS['offerid'];
                                    $enOfferid = md5($offerid);
                                    echo $enOfferid;
                                    ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offerprice']; ?> INR</small>
                            </td>


                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offersupply']; ?></small>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php echo date("d F Y", strtotime($OFFERS['offerdate'])); ?> |
                                    <?php echo date("H : i", strtotime($OFFERS['offertime'])); ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <div class="status">
                                    <p class="text-danger">Canceled</p>
                                </div>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>No Items To Display</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div id="inactive" class="sub-content Inactive hidden">
            <?php
            $selectOffer = "SELECT * FROM nftoffers 
                    WHERE offerstatus = 'inactive' 
                    AND userid = {$USER['id']} ORDER BY offerid DESC";
            $offerDetail = mysqli_query($conn, $selectOffer);

            if ($offerDetail && mysqli_num_rows($offerDetail) > 0) {
            ?>
                <table class="w-100">
                    <tr>
                        <td class="p-2 text-center caption">Item</td>
                        <td class="p-2 text-center caption">Offer Id</td>
                        <td class="p-2 text-center caption">Price</td>
                        <td class="p-2 text-center caption">Supply</td>
                        <td class="p-2 text-center caption">Date & Time</td>
                    </tr>
                    <?php
                    while ($OFFERS = mysqli_fetch_assoc($offerDetail)) {
                        $OfferUser = "SELECT * FROM auth WHERE id = {$OFFERS['userid']}";
                        $UserDetail = mysqli_query($conn, $OfferUser);
                        if ($UserDetail) {
                            $userOffer = mysqli_fetch_assoc($UserDetail);
                        }
                        $selectNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND nftid = {$OFFERS['nftid']}";
                        $nftDetails = mysqli_query($conn, $selectNFT);
                        $NFT = mysqli_fetch_assoc($nftDetails);
                        $enNFTid = base64_encode($NFT['nftid']);

                    ?>
                        <tr style="border-top: 1px solid #252525;">
                            <td class="p-2 text-center">
                                <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                    <img src="<?php echo BASE_URL . $NFT['nftimage']; ?>" alt="User Image" height="75px"
                                        width="75px" class="rounded-1 object-fit-cover">
                                    <small class="text-capitalize ms-2"><?php echo $NFT['nftname']; ?></small>
                                </a>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php
                                    $offerid = $OFFERS['offerid'];
                                    $enOfferid = md5($offerid);
                                    echo $enOfferid;
                                    ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offerprice']; ?> INR</small>
                            </td>


                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offersupply']; ?></small>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php echo date("d F Y", strtotime($OFFERS['offerdate'])); ?> |
                                    <?php echo date("H : i", strtotime($OFFERS['offertime'])); ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>No Items To Display</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div id="expired" class="sub-content Expired hidden">
            <?php
            $selectOffer = "SELECT * FROM nftoffers 
                    WHERE offerstatus = 'expired' 
                    AND userid = {$USER['id']} ORDER BY offerid DESC";
            $offerDetail = mysqli_query($conn, $selectOffer);

            if ($offerDetail && mysqli_num_rows($offerDetail) > 0) {
            ?>
                <table class="w-100">
                    <tr>
                        <td class="p-2 text-center caption">Item</td>
                        <td class="p-2 text-center caption">Offer Id</td>
                        <td class="p-2 text-center caption">Price</td>
                        <td class="p-2 text-center caption">Supply</td>
                        <td class="p-2 text-center caption">Date & Time</td>
                    </tr>
                    <?php
                    while ($OFFERS = mysqli_fetch_assoc($offerDetail)) {
                        $OfferUser = "SELECT * FROM auth WHERE id = {$OFFERS['userid']}";
                        $UserDetail = mysqli_query($conn, $OfferUser);
                        if ($UserDetail) {
                            $userOffer = mysqli_fetch_assoc($UserDetail);
                        }
                        $selectNFT = "SELECT * FROM nft WHERE nftstatus = 'active' AND nftid = {$OFFERS['nftid']}";
                        $nftDetails = mysqli_query($conn, $selectNFT);
                        $NFT = mysqli_fetch_assoc($nftDetails);
                        $enNFTid = base64_encode($NFT['nftid']);

                    ?>
                        <tr style="border-top: 1px solid #252525;">
                            <td class="p-2 text-center">
                                <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                    <img src="<?php echo BASE_URL . $NFT['nftimage']; ?>" alt="User Image" height="75px"
                                        width="75px" class="rounded-1 object-fit-cover">
                                    <small class="text-capitalize ms-2"><?php echo $NFT['nftname']; ?></small>
                                </a>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php
                                    $offerid = $OFFERS['offerid'];
                                    $enOfferid = md5($offerid);
                                    echo $enOfferid;
                                    ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offerprice']; ?> INR</small>
                            </td>


                            <td class="p-2 text-center">
                                <small><?php echo $OFFERS['offersupply']; ?></small>
                            </td>
                            <td class="p-2 text-center">
                                <small>
                                    <?php echo date("d F Y", strtotime($OFFERS['offerdate'])); ?> |
                                    <?php echo date("H : i", strtotime($OFFERS['offertime'])); ?>
                                </small>
                            </td>
                            <td class="p-2 text-center">
                                <span class="text-danger">Expired</span>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } else { ?>
                <div class="col-md-12">
                    <div class="collection-offers">
                        <div class="container-fluid">
                            <div class="no-offers">
                                <div>No Items To Display</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    // Function to activate the correct menu
    function showDealContent(contentId, buttonId) {
        // Hide all content 
        var contentDivs = document.getElementsByClassName('sub-content');
        for (var i = 0; i < contentDivs.length; i++) {
            contentDivs[i].classList.add('hidden');
        }

        // Deactivate all buttons
        var buttonElements = document.getElementsByClassName('btn-deals');
        for (var i = 0; i < buttonElements.length; i++) {
            buttonElements[i].classList.remove('active');
        }

        // Show the selected content and activate the corresponding button
        document.getElementById(contentId).classList.remove('hidden');
        document.getElementById(buttonId).classList.add('active');

        // Store the active button in local storage
        localStorage.setItem('activeButtonsId', buttonId);
    }

    // Function to load the last active menu from local storage
    document.addEventListener("DOMContentLoaded", function() {
        var activeButton = localStorage.getItem('activeButtonsId');

        if (activeButton) {
            // Activate the last active button
            document.getElementById(activeButton).click();
        }
    });
</script>