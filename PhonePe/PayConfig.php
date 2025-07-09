<?php
// require_once "../Navbar.php";

// define("PAYUSERID", $USER['id']);
define("BASE_URL", "http://localhost/nft/");
define("API_STATUS", "UAT");
define("MERCHANTUDLIVE", "");
define("MERCHANTIDUAT", "PGTESTPAYUAT");
define("SALTKEYLIVE", "");
define("SALTKEYUAT", "099eb0cd-02cf-4e2a-8aca-3e6c6aff0399");
define("SALTKEYINDEX", "1");
define("REDIRECTURL", BASE_URL . "PhonePe/paymentStatus.php");
define("SUCCESSURL", "success.php");
define("FAILUREURL", "failure.php");
define("UATURLPAY", "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay");
define("LIVEURLPAY", "https://api.phonepe.com/apis/hermes/pg/v1/pay");
define("STATUSCHECKURL", "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status");
define("LIVESTATUSCHECKURL", "https://api.phonepe.com/apis/hermes/pg/v1/status");
