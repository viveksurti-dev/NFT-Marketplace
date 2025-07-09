<div class="w-info">
    <h4>Widthdraw Funds</h4>
    <p>Welcome! <span><?php echo $username ?></span></p>
</div>

<div class="container-fluid d-flex flex-wrap justify-content-center mt-3 mb-5">
    <div class="col-md-4">
        <div class="card">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['withdraw-fund'])) {
                // Validate Account Number
                $accountNumber = $_POST['account-number'];
                $reAccountNumber = $_POST['re-account-number'];
                $amount = $_POST['amount'];
                if (empty($accountNumber) || empty($reAccountNumber)) {
                    $_SESSION['create'] = "Account number fields are required.";
                    echo  '<script> window.location.href = "";</script>';
                    exit();
                } elseif ($accountNumber !== $reAccountNumber) {
                    $_SESSION['create'] = "Account numbers do not match.";
                    echo  '<script> window.location.href = "";</script>';
                    exit();
                } else {
                    $ifscCode = $_POST['ifsc-code'];

                    if (empty($ifscCode)) {
                        $_SESSION['create'] = "IFSC code is required.";
                        echo  '<script> window.location.href = "";</script>';
                        exit();
                    } elseif (!preg_match("/^[A-Z]{4}0[0-9]{6}$/", $ifscCode)) {
                        $_SESSION['create'] = "Invalid IFSC code format.";
                        echo  '<script> window.location.href = "";</script>';
                        exit();
                    } else {
                        if ($balance >= $amount) {
                            echo $newBalance = $balance - $amount;

                            $updateBalance = "UPDATE wallet SET balance = '$newBalance' WHERE userid = '{$USER['id']}'";
                            $conn->query($updateBalance);
                            $userid = $USER['id'];
                            $createTransaction = "INSERT INTO transactions(userid, transactuser, debitamount, transactionreason, transactiondate, transactiontime) VALUES ('$userid','$userid','$amount','Fund withdraw using banking details',NOW(), NOW())";
                            $conn->query($createTransaction);
                            $_SESSION['create'] = "$amount INR Widthdraw Successful!";
                            echo  '<script> window.location.href = "";</script>';
                            exit();
                        } else {

                            $_SESSION['create'] = "Fund Insufficiant";
                            echo  '<script> window.location.href = "";</script>';
                            exit();
                        }
                    }
                }
            }
            ?>

            <form method="post" autocomplete="off">
                <h4 class="text-center"> Witdraw Funds</h4>
                <div class="mt-3 mb-3">
                    <input type="text" class="form-control input " name="account-number" placeholder="Account Number" required>
                </div>
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control input" name="re-account-number" placeholder="Re-enter Account Number" required>
                </div>
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control input text-uppercase" name="ifsc-code" placeholder="IFSC Code" required>
                </div>
                <div class="mb-3 d-flex">
                    <input type="number" class="form-control input" name="amount" placeholder="Withdrawal Amount" required>
                </div>
                <div class="mb-3 d-flex">
                    <button class="btn btn-outline-primary w-100" name="withdraw-fund">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>