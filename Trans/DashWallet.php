<?php
require_once 'Navbar.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// $createWalletQuery = "CREATE TABLE IF NOT EXISTS wallet (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     userid INT UNIQUE,
//     walletPassword VARCHAR(255),
//     balance DECIMAL(10, 2) DEFAULT 0.00,
//     FOREIGN KEY (userid) REFERENCES auth(id)
// )";

// $conn->query($createWalletQuery);

// $createTransactionQuery = "CREATE TABLE IF NOT EXISTS transactions (
//     transactionid INT AUTO_INCREMENT PRIMARY KEY,
//     userid INT,
//     transactuser varchar(255),
//     creditamount DECIMAL(10, 2),
//     debitamount DECIMAL(10, 2),
//     transactionreason varchar(255),
//     transactiondate DATE NOT NULL,
//     transactiontime TIME NOT NULL,
//     FOREIGN KEY (userid) REFERENCES auth(id)
// )";
// $conn->query($createTransactionQuery);

// Query to check if the user has a wallet
$query = "SELECT * FROM wallet
          INNER JOIN auth ON wallet.userid = auth.id
          WHERE auth.username = '$username'";


$result = $conn->query($query);

// if ($result === FALSE) {
//     die("Error executing wallet query: " . $conn->error);
// }

if ($result->num_rows > 0) {
    // User has an active wallet, fetch and display details
    while ($row = $result->fetch_assoc()) {
        $walletId = $row['id'];
        $balance = $row['balance'];
?>

        <p>Available Balance : ₹ <?php echo $balance; ?></p>
        <a href="<?php BASE_URL ?>Trans/wallet.php" class="btn btn-profile w-100">Wallet Activity</a>

    <?php    }
} else { ?>

    <center>
        <p class="caption">Hello <?php echo $username ?>, Your Wallet Is Not Activate Click On Below 'Activate' Button To Activate Wallet</p>
    </center>

    <p> Wallet Benifits </p>
    <p class="caption">
        1. Send and Receive Money in Seconds. <br />
        2. Track Expenses and See Where Your Money is Going. <br />
        3. Create Wallet Easily Using Phone Number. <br />
    </p>
    <a href="<?php BASE_URL ?>Trans/ActivateWallet.php" class="btn btn-profile w-100"> Activate Wallet</a>
<?php } ?>