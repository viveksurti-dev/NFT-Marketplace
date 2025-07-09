<!-- Found Total Volume For collection Analytics -->
<?php
require_once '../config.php';

$currentDate = date('Y-m-d');

if (isset($_POST['timePeriod'])) {
    $timePeriod = $_POST['timePeriod'];

    switch ($timePeriod) {
        case 'last7days':
            $startDate = date('Y-m-d', strtotime('-7 days'));
            break;
        case 'lastmonth':
            $startDate = date('Y-m-d', strtotime('-1 month'));
            break;
        case 'lastyear':
            $startDate = date('Y-m-d', strtotime('-1 year'));
            break;
        case 'alltime':
            $startDate = '1970-01-01'; // or any other suitable start date
            break;
        default:
            $startDate = date('Y-m-d');
    }

    $sql = "SELECT SUM(nft.nftprice) AS nftprice 
        FROM nft 
        WHERE nft.collectionid IN (SELECT collectionid FROM nftcollection)
        AND nft.nftcreated_date BETWEEN '$startDate' AND '$currentDate'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing the query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalPrice = $row['nftprice'];
        echo number_format($totalPrice, 2) . '&nbsp;INR';
    } else {
        echo "No data found";
    }
}
