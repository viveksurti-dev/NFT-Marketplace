<div>
    <button id="btn-collect" class="btn btn-universal me-2 active" name="collected" onclick="showBlock('collected_block', 'sell_block', 'btn-collect')"><small><i class="bi bi-collection me-2"></i> Collected</small></button>

    <button id="btn-sell" class="btn btn-universal me-2" name="sell" onclick="showBlock('sell_block', 'collected_block', 'btn-sell')"><small><i class="bi bi-receipt-cutoff me-2"></i> Selled</small></button>

</div>
<div>
    <style>
        .collected-item {
            padding: 15px;
            background-color: #191919;
            border-radius: 5px;
        }

        .collected-item .item-card {
            background-color: #232323;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .collected-item .item-card:hover {
            transform: translateY(-5px);
        }

        .collected-item .item-card a {
            text-decoration: none;
            text-shadow: none;
            color: white;
        }

        .item-card .item-image {
            width: 100%;
            height: auto;
            max-height: 250px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
        }

        .item-card .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <!-- Collected Block -->
    <div class="collected_block">
        <?php
        $selectItem = "SELECT * FROM nftcollected WHERE collectstatus = 'collected' AND autherid = {$USER['id']}";
        $itemDetail = mysqli_query($conn, $selectItem);

        if ($itemDetail && mysqli_num_rows($itemDetail) > 0) {
        ?>
            <div class="collected-item mt-2 d-flex flex-wrap">
                <?php
                while ($item = mysqli_fetch_assoc($itemDetail)) {
                    $selectnft = "SELECT * FROM nft WHERE nftid = {$item['nftid']} ";
                    $nftdetails = mysqli_query($conn, $selectnft);

                    if ($nftdetails && mysqli_num_rows($nftdetails) > 0) {
                        while ($nftItem = mysqli_fetch_assoc($nftdetails)) {
                            $enNFTid = base64_encode($item['nftid']);
                ?>
                            <div class="col-md-2-5">
                                <div class="item-card">
                                    <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                        <div class="item-image">
                                            <img src="<?php echo BASE_URL . $nftItem['nftimage'] ?>" alt="NFT Image">
                                        </div>
                                        <div class="item-details p-3">
                                            <div>
                                                <?php echo $nftItem['nftname'] ?>
                                            </div>
                                            <div class="mt-3 d-flex justify-content-between">
                                                <div>
                                                    <small class="caption">Floorprice</small><br />
                                                    <div><?php echo $nftItem['nftfloorprice'] ?> INR</div>
                                                </div>
                                                <div class="text-end">
                                                    <small class="caption">Collected Price</small><br />
                                                    <div><?php echo $item['nftprice'] ?> INR</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <div class="col-md-12">
                <div class="collection-offers">
                    <div class="container-fluid">
                        <div class="no-offers">
                            <div>No Items Collected</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>




    <!-- Sell Block -->
    <div class="sell_block" style="display:none;">
        <?php
        $selectItem = "SELECT * FROM nftcollected WHERE collectstatus = 'saled' AND autherid = {$USER['id']}";
        $itemDetail = mysqli_query($conn, $selectItem);

        if ($itemDetail && mysqli_num_rows($itemDetail) > 0) {
        ?>
            <div class="collected-item mt-2 d-flex flex-wrap">
                <?php
                while ($item = mysqli_fetch_assoc($itemDetail)) {
                    $selectnft = "SELECT * FROM nft WHERE nftid = {$item['nftid']} ";
                    $nftdetails = mysqli_query($conn, $selectnft);

                    if ($nftdetails && mysqli_num_rows($nftdetails) > 0) {
                        while ($nftItem = mysqli_fetch_assoc($nftdetails)) {
                            $enNFTid = base64_encode($item['nftid']);
                ?>
                            <div class="col-md-2-5">
                                <div class="item-card">
                                    <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>">
                                        <div class="item-image">
                                            <img src="<?php echo BASE_URL . $nftItem['nftimage'] ?>" alt="NFT Image">
                                        </div>
                                        <div class="item-details p-3">
                                            <div>
                                                <?php echo $nftItem['nftname'] ?>
                                            </div>
                                            <div class="mt-3 d-flex justify-content-between">
                                                <div>
                                                    <small class="caption">Floorprice</small><br />
                                                    <div><?php echo $nftItem['nftfloorprice'] ?> INR</div>
                                                </div>
                                                <div class="text-end">
                                                    <small class="caption">Selled Price</small><br />
                                                    <div><?php echo $item['nftprice'] ?> INR</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <div class="col-md-12">
                <div class="collection-offers">
                    <div class="container-fluid">
                        <div class="no-offers">
                            <div>No Items has been Saled</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<script>
    // Function to show/hide blocks based on the clicked button
    function showBlock(showBlock, hideBlock, buttonId) {
        document.querySelector('.' + showBlock).style.display = 'block';
        document.querySelector('.' + hideBlock).style.display = 'none';

        var buttonElements = document.getElementsByTagName('button');
        for (var i = 0; i < buttonElements.length; i++) {
            buttonElements[i].classList.remove('active');
        }
        document.getElementById(buttonId).classList.add('active');
        // Store the active button in localStorage
        localStorage.setItem('activeButton', buttonId);
    }

    // Retrieve the active button from localStorage or default to 'btn-collect'
    const activeButton = localStorage.getItem('activeButton') || 'btn-collect';
    showBlock(activeButton, activeButton === 'btn-collect' ? 'btn-sell' : 'btn-collect', activeButton);
</script>