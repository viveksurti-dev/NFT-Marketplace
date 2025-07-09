<?php
require_once '../Navbar.php';
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-fund'])) {
    function idGenerate($length = 18)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // Fund Data
    $merchantUserId = $USER['id'];
    $merchantId = 'MI' . idGenerate();
    $merchantTransactionId = 'MTI' . idGenerate();
    $amount = $_POST['fundAmount'];
    $paymentMethod = $_POST['paymentMethod'];
    $transactionReason = 'The funds amount ' . $amount . ' INR have been successfully added to your wallet';

    $currentDateTime = new DateTime("now", new DateTimeZone("Asia/Kolkata"));
    $currentDate = $currentDateTime->format("Y-m-d");
    $currentTime = $currentDateTime->format("H:i:s");

    define("MERCHANTID", $merchantId);

    if (preg_match("/^\d+$/", $amount)) {
        if ($amount > 99) {
            $_SESSION['username'] = $USER['username'];
            setcookie('username', $username, time() + (120), "/");

            // Redirect payment Method
            if ($paymentMethod == 'PhonePe') {
                echo "<script>window.location.href='" . BASE_URL . "PhonePe/phonePe.php';</script>";
                exit();
            } elseif ($paymentMethod == 'RazorPay') {
            }
        } else {
            $_SESSION['create'] = "Add minimum 100 INR";
            echo "<script>window.location.href='';</script>";
            exit();
        }
    } else {
        $_SESSION['create'] = "Enter Valid Amount";
        echo "<script>window.location.href='';</script>";
        exit();
    }
}
?>

<div class="container-fluid mt-2">
    <form method="post" action="../PhonePe/pay.php">
        <div class="form-group mt-2">
            <input type="text" id="fundAmount" name="fundAmount" placeholder="Amount" class="form-control input" required>
        </div>
        <div class=" form-group d-flex">
            <button type="button" class="btn btn-outline-secondary me-2" onclick="addAmount(100)">+ 100</button>
            <button type="button" class="btn btn-outline-secondary me-2" onclick="addAmount(500)">+ 500</button>
            <button type="button" class="btn btn-outline-secondary" onclick="addAmount(1000)">+ 1000</button>
        </div>
        <div class="form-group mt-4 mb-5 d-flex flex-wrap">
            <select class="form-select w-100 input" name="paymentMethod" required>
                <option value="" selected disabled>-- Payment Method --</option>
                <option value="PhonePe">PhonePe</option>
                <option value="RazorPay">RazorPay</option>
            </select>

        </div>
        <div class="form-group mt-3">
            <small class="d-flex align-content-center">
                <input type="checkbox" class="me-2" required> I agree Terms & Conditions.
            </small>
        </div>
        <div class="form-group mt-3 d-flex">
            <button class="btn btn-primary w-100" name="add-fund"><i class="bi bi-plus"></i> Add</button>
        </div>
    </form>

    <script>
        function addAmount(amount) {
            var inputElement = document.getElementById("fundAmount");
            var currentValue = parseFloat(inputElement.value) || 0;
            inputElement.value = currentValue + amount;
        }
    </script>
</div>

<?php
// Display error message if it exists
if (isset($_SESSION['create'])) {
    echo "<div class='cust_alert-container' id='cust_alertContainer'>
                <div class='cust_alert alert-danger' id='myAlert'>
                    <div class='cust_alert-header'>
                        <div class='brand-info'>
                            <div class='Header-image me-2'>
                            <img src='" . BASE_URL . "Assets/illu/web-logo.png' alt='Brand Image'/>
                            </div>
                            <div class='header-name'>NFT Marketplace</div>
                        </div>
                        <div class='time'>
                            Just Now
                        </div>
                    </div>
                    <div class='cust_alert-body'>
                    {$_SESSION['create']}
                    </div>
                </div>
            </div>";
    unset($_SESSION['create']);
}
?>
<!-- alert Loader -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertContainer = document.getElementById('cust_alertContainer');

        setTimeout(function() {
            alertContainer.style.right = '20px';

            setTimeout(function() {
                alertContainer.style.right = '-400px';
            }, 5000);
        }, 50);
    });
</script>