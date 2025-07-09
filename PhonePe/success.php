<?php
require_once "../Navbar.php";
require_once "../config.php";

if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
} elseif (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    $_SESSION['username'] = $username;
    $loggedIn = true;
    echo  '<script> window.location.href = "";</script>';
} else {
    $loggedIn = false;
}


// Use This For Debugging
// echo '<pre>';
// echo print_r($_COOKIE);
// echo '</pre>';
?>

<!-- Recipt start -->
<?php
if ($loggedIn) { ?>
    <?php
    if (
        isset($_COOKIE['merchantId']) &&
        isset($_COOKIE['merchantTransactionId']) &&
        isset($_COOKIE['transactionId']) &&
        isset($_COOKIE['amount']) &&
        isset($_COOKIE['state']) &&
        isset($_COOKIE['responseCode']) &&
        isset($_COOKIE['paymentInstrument'])
    ) {

        $merchantId = $_COOKIE['merchantId'];
        $merchantTransactionId = $_COOKIE['merchantTransactionId'];
        $transactionId = $_COOKIE['transactionId'];
        $TotalAmount = $_COOKIE['amount'] / 100;
        $state = $_COOKIE['state'];
        $responseCode = $_COOKIE['responseCode'];
        $paymentInstrument = $_COOKIE['paymentInstrument'];
        date_default_timezone_set("Asia/Kolkata");
        $currentDate = date("y-m-d");
        $originalDate = $currentDate;
        $TransactionDate = date('d M Y', strtotime($originalDate));
        $currentTime = date("H:i:s");
    ?>
        <div class="container-fluid d-flex justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="pay-icon">
                        <div class="payment-done text-center"><i class="bi bi-check2 "></i></div>
                    </div>
                    <div class="mt-4 text-center" style="font-size:20px;">
                        <div>Fund Add Successful</div>
                    </div>
                    <div class="mt-2 text-center">
                        <small class="caption">Your Payment Successfully Done!</small>
                    </div>
                    <hr class="mt-3 mb-3" />
                    <!-- Fund Details -->
                    <div>
                        <div class="text-center">
                            <small class="caption">
                                Total Amount
                            </small>
                        </div>
                        <div class="text-center" style="font-size:25px;">
                            <?php echo $TotalAmount; ?> INR
                        </div>
                    </div>
                    <!-- Transaction Details -->
                    <div class="d-flex flex-wrap mt-3">
                        <div class="col-md-6 mt-2">
                            <div class="trans-info">
                                <div>
                                    <small class="caption">
                                        Transaction ID
                                    </small>
                                </div>
                                <div style="font-size:15px;">
                                    <small><?php echo $transactionId ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="trans-info">
                                <div>
                                    <small class="caption">
                                        Transaction Time
                                    </small>
                                </div>
                                <div>
                                    <small><?php echo $TransactionDate . ', ' . $currentTime ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="trans-info">
                                <div>
                                    <small class="caption">
                                        Payment Method
                                    </small>
                                </div>
                                <div>
                                    <small><?php echo $paymentInstrument ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="trans-info">
                                <div>
                                    <small class="caption">
                                        Status
                                    </small>
                                </div>
                                <div>
                                    <small><?php echo $state ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Download Recipt -->
                    <div class="mt-5 mb-3 text-center ">
                        <button id="transpdf" class="btn btn-outline-success"><i class="bi bi-filetype-pdf me-3"></i>Download Recipt</button>
                    </div>
                    <hr class="mt-2 mb-2" />
                    <div class="text-center mt-2">
                        <small>You will be redirected to the Wallet in <span id="countdown">10</span> seconds.</small>
                        <script>
                            function redirectToDashboard() {
                                var countdownElement = document.getElementById('countdown');
                                var countdownValue = 10;

                                function updateCountdown() {
                                    countdownElement.textContent = countdownValue;

                                    if (countdownValue === 0) {
                                        // Redirect to Dashboard.php after 10 seconds
                                        window.location.href = '../Trans/Wallet.php';
                                    } else {
                                        countdownValue--;
                                        setTimeout(updateCountdown, 1000); // Update every 1000 milliseconds = 1 second
                                    }
                                }
                                updateCountdown();
                            }
                            window.onload = redirectToDashboard;
                        </script>

                    </div>
                </div>
            </div>
        </div>

    <?php

        $paymentStatus = true;
    } else {
        $paymentStatus = false;
    } ?>


    <?php
    if ($paymentStatus) {
        for ($i = 0; $i < 1; $i++) {

            echo   $userid = $USER['id'];
            echo   $transactionReason = "Funds have been successfully added to your wallet using $paymentInstrument.";

            // Create Transaction Record
            $createTransaction = "INSERT INTO transactions(userid, transactuser, creditamount, debitamount, transactionreason, transactiondate, transactiontime) VALUES ('$userid','$userid','$TotalAmount','','$transactionReason','$currentDate','$currentTime')";
            $conn->query($createTransaction);

            $selectwallet = "SELECT * FROM wallet WHERE userid = $userid";
            $walletdetails = mysqli_query($conn, $selectwallet);

            if ($walletdetails) {
                $wallet = mysqli_fetch_assoc($walletdetails);
                $balance = $wallet['balance'];

                echo $NewBalance = $balance + $TotalAmount;

                $updateBalance = "UPDATE wallet SET balance = $NewBalance WHERE userid = $userid";
                $conn->query($updateBalance);
            }
            sleep(3);
            require_once '../mailpage/addFund.php';
        }
    } else {
        echo "<script>window.location.href='../Trans/Wallet.php';</script>";
        exit();
    }
    ?>


<?php } ?>


<!------------------------------------------------------------ scripts  ------------------------------------------------------------>
<?php
$pdfheader = '<h4 class="text-center">Add Fund Recipt</h4>';
?>
<script>
    document.getElementById("transpdf").addEventListener("click", function() {
        var doc = new window.jspdf.jsPDF();
        // Add heading "TRANSACTION HISTORY"
        doc.setFontSize(20);
        doc.setFontSize(20);
        doc.text("Add Fund Receipt", doc.internal.pageSize.width / 2, 10, {
            align: "center"
        });

        // Add logged user's name
        doc.setFontSize(12);
        doc.text("Username: <?php echo $USER['username']; ?>", 10, 20);
        doc.text("Merchant Id: <?php echo $merchantId; ?>", 10, 30);
        doc.text("Merchant Transaction Id: <?php echo $merchantTransactionId; ?>", 10, 40);
        doc.text("Transaction Id: <?php echo $transactionId; ?>", 10, 50);
        doc.text("Total Amount: <?php echo $TotalAmount; ?> INR", 10, 60);
        doc.text("Payment Method: <?php echo $paymentInstrument; ?>", 10, 70);
        doc.text("Payment Status: <?php echo $state; ?>", 10, 80);
        doc.text("Payment Date: <?php echo $TransactionDate . ', ' . $currentTime; ?>", 10, 90);

        // Save the PDF
        doc.save("Fund Recipt <?php echo $transactionId; ?>.pdf");
    });
</script>