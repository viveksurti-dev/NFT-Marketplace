     <!-- css : nft.css | Line : 580 -->
     <style>
         .container-fav-nft {
             background-color: #151515;
             border-radius: 5px;
             padding: 10px;
             border: 2px solid #303030;
             display: flex;
             overflow-x: scroll;
         }

         .container-fav-nft .fav-nft-card {
             background-color: #202020;
             border-radius: 5px;
             transition: all 0.3s ease-in-out;
         }

         .container-fav-nft .fav-nft-card:hover {
             transform: translateY(-5px);
             box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
         }

         .container-fav-nft .fav-nft-card .fav-nft-details {
             padding: 20px;
         }

         .container-fav-nft a {
             color: white;
         }

         .container-fav-nft a:hover {
             text-shadow: none;
         }

         .container-fav-nft .fav-nft-image {
             background-color: #181818;
             overflow: hidden;
             width: 100%;
             aspect-ratio: 1;
             height: auto;
             display: flex;
             justify-content: center;
             align-items: center;
             border-radius: 5px;
             position: relative;
         }


         .container-fav-nft .fav-nft-image .nft-blockchain {
             position: absolute;
             top: 10px;
             left: 10px;
             font-size: 18px;
             background-color: rgba(128, 128, 128, 0.4);
             width: 35px;
             height: 35px;
             display: flex;
             justify-content: center;
             align-items: center;
             border-radius: 10px;
             visibility: hidden;
             transition: all 0.3s ease-in-out;
         }

         .container-fav-nft .fav-nft-card:hover .nft-blockchain {
             visibility: visible;
             transition: all 0.3s ease-in-out;
         }

         .container-fav-nft .fav-nft-image .nft-blockchain span {
             animation: round-rs 2s infinite;
         }

         @keyframes round-rs {
             from {
                 transform: rotateY(0deg);
             }

             to {
                 transform: rotateY(360deg);
             }
         }


         .container-fav-nft .fav-nft-image img {
             width: 100%;
             height: 100%;
             object-fit: cover;
         }
     </style>
     <?php

        $selectfav = "SELECT n.* FROM nft n
          JOIN favorites f ON n.nftid = f.nftid
          WHERE nftstatus = 'active' AND f.userid = '{$USER['id']}' AND f.nftid = n.nftid";
        $favDetails = mysqli_query($conn, $selectfav);

        if ($favDetails) {
            // Check if there are results
            if (mysqli_num_rows($favDetails) > 0) { ?>
             <div class="container-fav-nft">
                 <?php while ($favitem = mysqli_fetch_assoc($favDetails)) {
                        $enNFTid = base64_encode($favitem['nftid']); ?>
                     <a href="<?php echo BASE_URL ?>Collection/NFTDetails.php?nftid=<?php echo $enNFTid ?>" class="fav-nft-card col-md-2-5 m-1">
                         <div class="fav-nft-image">
                             <div class="nft-blockchain">
                                 <?php
                                    if ($row['collectionblockchain'] = 'inr') {
                                        echo '<span> ₹ </span>';
                                    } ?>
                             </div>
                             <img src="<?php echo BASE_URL . $favitem['nftimage'] ?>" alt="">
                         </div>
                         <div class="fav-nft-details">
                             <div class="nft-name">
                                 <?php echo $favitem['nftname'] ?>
                             </div>
                             <div class="nft-price mt-2">
                                 <?php echo  $favitem['nftprice'] ?> INR
                             </div>
                         </div>
                     </a>
                 <?php } ?>
             </div>
         <?php } else { ?>
             <div class="col-md-12">
                 <div class="collection-offers">
                     <div class="container-fluid">
                         <div class="no-offers">
                             <div>No Favorite Items Available</div>
                         </div>
                     </div>
                 </div>
             </div>
         <?php }
        } else { ?>
         <div class="col-md-12">
             <div class="collection-offers">
                 <div class="container-fluid">
                     <div class="no-offers">
                         <div>No Favorite Items Available</div>
                     </div>
                 </div>
             </div>
         </div>
     <?php } ?>