<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nftfinal";

$conn = new mysqli($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!function_exists('createDatabase')) {
    function createDatabase($conn, $dbname)
    {
        $query = "CREATE DATABASE IF NOT EXISTS $dbname";
        if (mysqli_query($conn, $query)) {
        } else {
            echo "Error creating database: " . mysqli_error($conn) . "<br>";
        }
    }
}
createDatabase($conn, $dbname);
mysqli_close($conn);

$conn = mysqli_connect($servername, $username, $password, $dbname);

// auth table
$create_auth = "CREATE TABLE IF NOT EXISTS auth (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userimage VARCHAR(255),
    userbackimage VARCHAR(255),
    username VARCHAR(255) UNIQUE,
    userabout VARCHAR(255),
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    phone VARCHAR(15) UNIQUE,
    gender VARCHAR(10),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    user_role VARCHAR(20) DEFAULT 'user',
    joindate DATE NOT NULL,
    jointime TIME NOT NULL,
    deactivationdate DATE NOT NULL,
    status VARCHAR(255),
    accept_terms BOOLEAN
)";

$conn->query($create_auth);

// login history
$createLogin = "CREATE TABLE IF NOT EXISTS loginhistory (
    loginid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    logindate DATE NOT NULL,
    logintime TIME NOT NULL
)";
$conn->query($createLogin);

// wallet
$createWalletQuery = "CREATE TABLE IF NOT EXISTS wallet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userid INT UNIQUE,
    walletPassword VARCHAR(255),
    balance DECIMAL(10, 2) DEFAULT 0.00,
    FOREIGN KEY (userid) REFERENCES auth(id)
)";

$conn->query($createWalletQuery);

// transaction table
$createTransactionQuery = "CREATE TABLE IF NOT EXISTS transactions (
    transactionid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT,
    transactuser varchar(255),
    creditamount DECIMAL(10, 2),
    debitamount DECIMAL(10, 2),
    transactionreason varchar(255),
    transactiondate DATE NOT NULL,
    transactiontime TIME NOT NULL,
    FOREIGN KEY (userid) REFERENCES auth(id)
)";

$conn->query($createTransactionQuery);

//Create nftcollection table if it doesn't exist
$sqlCreatecollection = "CREATE TABLE IF NOT EXISTS nftcollection (
    collectionid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    collectionimage VARCHAR(255) NOT NULL,
    collectionbackground VARCHAR(255) NOT NULL,
    collectionname VARCHAR(255) NOT NULL,
    collectiondescription VARCHAR(255) NOT NULL,
    collectionblockchain VARCHAR(50) NOT NULL,
    collectioncategory VARCHAR(50) NOT NULL,
    collectionStatus VARCHAR(255) DEFAULT 'pending',
    collectionDeployCharge DECIMAL(10, 2) DEFAULT '149',
    collection_created_date DATE NOT NULL,
    collection_created_time TIME NOT NULL
)";

$conn->query($sqlCreatecollection);


// nft table
$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS nft (
    nftid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT,
    collectionid INT,
    royaltyid INT NOT NULL,
    nftimage VARCHAR(255) NOT NULL,
    nftname VARCHAR(255) NOT NULL,
    nftsupply INT NOT NULL,
    nftprice DECIMAL(10, 2) NOT NULL,
    nftfloorprice DECIMAL(10, 2) NOT NULL,
    nftdescription TEXT NOT NULL,
    nftstatus VARCHAR(255) NOT NULL,
    nftcreated_date DATE NOT NULL,
    nftcreated_time TIME NOT NULL,
    FOREIGN KEY (userid) REFERENCES auth(id),
    FOREIGN KEY (collectionid) REFERENCES nftcollection(collectionid)
)
";
if ($conn->query($sqlCreateTable) === TRUE) {
} else {
    echo "Error creating table: " . $conn->error;
}

// collection activity table
$createActivityTable =  "CREATE TABLE IF NOT EXISTS activity (
    activityid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL, 
    collectionid INT NOT NULL,
    nftid INT NOT NULL,
    activityicon VARCHAR(255),
    activityitem VARCHAR(255),
    activtyquantity INT NOT NULL,
    activityfrom VARCHAR(255),
    activityto VARCHAR(255),
    activity_date DATE NOT NULL,
    activity_time TIME NOT NULL
)";

$conn->query($createActivityTable);

// nft activity table
$nftTable = "CREATE TABLE IF NOT EXISTS nftactivity (
    transferid INT AUTO_INCREMENT PRIMARY KEY,
    autherid INT NOT NULL,
    currentautherid INT NOT NULL,
    nftid INT NOT NULL,
    nftprice DECIMAL(10, 2) NOT NULL,
    nftsupply VARCHAR(255) NOT NULL,
    activitydate DATE NOT NULL,
    activitytime TIME NOT NULL,
    nftactivitystatus VARCHAR(255) NOT NULL
    )";
$conn->query($nftTable);

// collected & sale table
$nftTable = "CREATE TABLE IF NOT EXISTS nftcollected (
    collectid INT AUTO_INCREMENT PRIMARY KEY,
    autherid INT NOT NULL,
    currentautherid INT NOT NULL,
    nftid INT NOT NULL,
    nftprice DECIMAL(10, 2) NOT NULL,
    nftsupply VARCHAR(255) NOT NULL,
    collectdate DATE NOT NULL,
    collecttime TIME NOT NULL,
    collectstatus VARCHAR(255) NOT NULL
    )";
$conn->query($nftTable);


// bidding table
$BidTable = "CREATE TABLE IF NOT EXISTS bidding (
    biddingid INT AUTO_INCREMENT PRIMARY KEY,
    bidderid INT NOT NULL,
    auctionid INT NOT NULL,
    nftid INT NOT NULL,
    bidprice DECIMAL(10, 2) NOT NULL,
    biddate DATE NOT NULL,
    bidtime TIME NOT NULL,
    bidstatus VARCHAR(255) NOT NULL
    )";
$conn->query($BidTable);

// offer table
$BidTable = "CREATE TABLE IF NOT EXISTS nftoffers (
    offerid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    collectionid INT NOT NULL,
    nftid INT NOT NULL,
    offerprice DECIMAL(10, 2) NOT NULL,
    offersupply VARCHAR(255) NOT NULL,
    offerdate DATE NOT NULL,
    offertime TIME NOT NULL,
    offerenddate DATE NOT NULL,
    offerendtime TIME NOT NULL,
    offerstatus VARCHAR(255) NOT NULL
    )";
$conn->query($BidTable);

// Create nftcollection table if it doesn't exist
$sqlCreateAuction = "CREATE TABLE IF NOT EXISTS auction (
    auctionid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    nftid INT NOT NULL,
    auctioncreatedate DATE NOT NULL,
    auctioncreatetime TIME NOT NULL,
    auctionenddate DATE NOT NULL,
    auctionendtime TIME NOT NULL,
    auctionstatus VARCHAR(255) NOT NULL
    )";
$conn->query($sqlCreateAuction);

// create sale table
$createSaleTable = "CREATE TABLE IF NOT EXISTS nftsale (
    saleid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    nftid INT NOT NULL,
    saleprice DECIMAL(10, 2) NOT NULL,
    salecreatedate DATE NOT NULL,
    salecreatetime TIME NOT NULL,
    saleenddate DATE NOT NULL,
    saleendtime TIME NOT NULL,
    salestatus VARCHAR(255) NOT NULL
    )";
$conn->query($createSaleTable);

// create article table
$createArticle = "CREATE TABLE IF NOT EXISTS articles (
    articleid INT AUTO_INCREMENT PRIMARY KEY,
    articleimage VARCHAR(255) NOT NULL,
    articlename VARCHAR(255) NOT NULL,
    articlecategory VARCHAR(255) NOT NULL,
    articlestandard VARCHAR(255) NOT NULL,
    articleabout LONGTEXT NOT NULL,
    articledate DATE NOT NULL,
    articletime TIME NOT NULL
)";

$conn->query($createArticle);

// faq
$faqs = "CREATE TABLE IF NOT EXISTS faqs (
    faqid INT AUTO_INCREMENT PRIMARY KEY,
    faqimage VARCHAR(255) NOT NULL UNIQUE,
    faqtitle VARCHAR(255) NOT NULL UNIQUE,
    faqdescription TEXT NOT NULL,
    created_date DATE NOT NULL,
    created_time TIME NOT NULL
)";

mysqli_query($conn, $faqs);

$createFavorite = "CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nftid INT NOT NULL,
    userid INT NOT NULL
)";

$conn->query($createFavorite);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
