<?php
require_once '../Navbar.php';
require_once '../config.php';

// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the session variable exists
if (isset($_SESSION['collection_details'])) {
    $collectionDetails = $_SESSION['collection_details'];
} else {
    echo "<script>window.location.href='" . BASE_URL . "error-002.php?allowRedirect=true';</script>";
    exit();
}




if (isset($_GET['payCancel'])) {

    $collectionDetails = $_SESSION['collection_details'];
    $collectionname = $collectionDetails['collectionname'];


    $query = "DELETE FROM nftcollection WHERE collectionname = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $collectionname);

    // Delete Query
    if ($stmt->execute()) {
        unset($_SESSION['collection_details']);
        echo "<script>window.location.href='" . BASE_URL . "createNFTcollection.php';</script>";
        exit();
    } else {
        // Error deleting record
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Proceesing - NFT Marketplace</title>
</head>


<style>
    .processing {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        background-color: #202020;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px solid #232323;
    }

    .contract-details {
        width: 100%;
        height: 100%;
        border-radius: 5px;
        background-color: #202020;
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
    }

    .contract-details p {
        margin: 0;
        padding: 2px;
        font-size: 15px;
        text-transform: capitalize;
    }

    .contract-image {
        height: 100px;
        width: 100px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        border-radius: 5px;
    }

    .contract-image img {
        height: 100%;
        width: auto;
        object-fit: contain;
    }
</style>

<body>
    <?php
    if ($collectionDetails['collectionStatus'] === 'pending') { ?>

        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="card col-md-4">
                <h4 class="text-center mb-3">Deploying Your Contract</h4>

                <div class="contract-details d-flex flex-nowrap">
                    <div class="contract-image col-md-3">
                        <img src="<?php echo BASE_URL; ?><?php echo $collectionDetails['collectionimage']; ?>" alt="">
                    </div>
                    <div class=" col-md-9 d-flex flex-column justify-content-center">
                        <p>Contract :
                            <span class="caption">
                                <?php echo $collectionDetails['collectionname']; ?>
                            </span>
                        </p>
                        <p>Blockchain :
                            <span class="caption">
                                <?php echo $collectionDetails['collectionblockchain']; ?>
                            </span>
                        </p>
                        <p>Deployment :
                            <span class="caption">
                                ₹ <?php echo $collectionDetails['collectionDeployCharge']; ?>
                            </span>
                        </p>
                    </div>

                </div>
                <!-- Deployment Detail -->
                <div class="d-flex flex-wrap justify-content-center mt-3"></div>
                <!-- Processing -->
                <div class="d-flex flex-wrap justify-content-center mt-2">
                    <div class="processing col-md-2 mt-2">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="col-md-10 mt-2"><small>Go to your wallet to finish deploying your contract</small><br /><small class="caption">you'll be asked to pay gas fees and sign in order to deploy your contract on the blockchain.</small>
                    </div>
                </div>
                <!-- Deploy Process -->
                <div class="d-flex flex-wrap justify-content-center mt-5">
                    <div class="processing col-md-2 mt-2"></div>
                    <div class="col-md-10 mt-2"><small>Deploying Your Contract</small><br /><small class="caption">Its make some time for the transactiion to be proceed.</small></div>
                </div>

                <!-- Payment Button -->
                <div class="process-button mt-5 d-flex" style="justify-content:space-around;">
                    <a href="?payCancel" class="btn btn-wallet col-md-5">Cancel</a>
                    <a href="<?php echo BASE_URL; ?>Trans/wallet.php" onclick="activateButtonAndShowContent()" class="btn btn-wallet col-md-5">Proceed</a>

                    <script>
                        function activateButtonAndShowContent() {
                            // Set a flag in localStorage
                            localStorage.setItem('activateButton', 'true');

                            // Call the showContent function with the desired parameters
                            showContent('wc4', 'wm4');
                        }
                    </script>


                </div>
            </div>
        </div>

    <?php } else { ?>

        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="card col-md-4">
                <h4 class="text-center mb-3">Deploying Your Contract</h4>
                <!-- Deployment Detail -->
                <div class="d-flex flex-wrap justify-content-center mt-3"></div>
                <!-- Processing -->
                <div class="d-flex flex-wrap justify-content-center mt-2">
                    <div class="processing col-md-2 mt-2">
                        <img src="<?php echo BASE_URL ?>Assets/illu/correct.png" height="30px" loading="lazy">
                    </div>
                    <div class="col-md-10 mt-2"><small>Go to your wallet to finish deploying your contract</small><br /><small class="caption">you'll be asked to pay gas fees and sign in order to deploy your contract on the blockchain.</small>
                    </div>
                </div>
                <!-- Deploy Process -->
                <div class="d-flex flex-wrap justify-content-center mt-5">
                    <div class="processing col-md-2 mt-2">

                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="col-md-10 mt-2"><small>Deploying Your Contract</small><br /><small class="caption">Its make some time for the transactiion to be proceed.</small></div>
                </div>
            </div>
        </div>


    <?php } ?>
</body>

</html>