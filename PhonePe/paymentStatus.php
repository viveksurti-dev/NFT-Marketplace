<?php
require_once "../PhonePe/PayConfig.php";

if (defined('API_STATUS')) {
    if (isset($_POST['merchantId']) && isset($_POST['transactionId'])) {

        $merchantId = $_POST['merchantId'];
        $merchantTransactionId = $_POST['transactionId'];

        if (API_STATUS == "LIVE") {
            $url = LIVESTATUSCHECKURL . '/' . $merchantId . '/' . $merchantTransactionId;
            $saltKey = SALTKEYLIVE;
            $saltIndex = SALTKEYINDEX;
        } else {
            $url = STATUSCHECKURL . '/' . $merchantId . '/' . $merchantTransactionId;
            $saltKey = SALTKEYUAT;
            $saltIndex = SALTKEYINDEX;
        }

        $status = "/pg/v1/status" . '/' . $merchantId . '/' . $merchantTransactionId . $saltKey;
        $datasha256 = hash('sha256', $status);
        $checksum = $datasha256 . '###' . $saltIndex;

        // GET API CALLING
        $headers = array(
            'Content-Type: application/json',
            'X-VERIFY: ' . $checksum,
            'X-MERCHANT-ID: ' . $merchantId,
            'Accept: application/json'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);

        $responsePayment = json_decode($response, true);
        $merchantId = $responsePayment['data']['merchantId'];
        $merchantTransactionId = $responsePayment['data']['merchantTransactionId'];
        $trans_Id = $responsePayment['data']['transactionId'];
        $amount = $responsePayment['data']['amount'];
        $state = $responsePayment['data']['state'];
        $responseCode = $responsePayment['data']['responseCode'];
        $paymentInstrument = $responsePayment['data']['paymentInstrument'];

        if ($response) {
            $_SESSION['merchantId'] = $merchantId;
            setcookie('merchantId', $merchantId, time() + 60, '/');
            $_SESSION['merchantTransactionId'] = $merchantTransactionId;
            setcookie('merchantTransactionId', $merchantTransactionId, time() + 60, '/');
            $_SESSION['transactionId'] = $trans_Id;
            setcookie('transactionId', $trans_Id, time() + 60, '/');
            $_SESSION['amount'] = $amount;
            setcookie('amount', $amount, time() + 60, '/');
            $_SESSION['state'] = $state;
            setcookie('state', $state, time() + 60, '/');
            $_SESSION['responseCode'] = $responseCode;
            setcookie('responseCode', $responseCode, time() + 60, '/');
            $_SESSION['paymentInstrument'] = $paymentInstrument;
            setcookie('paymentInstrument', $paymentInstrument['type'], time() + 60, '/');


            if (isset($_SESSION['username'])) {
                $loggedIn = true;
                $username = $_SESSION['username'];
            }
            echo  '<script> window.location.href = "' . BASE_URL . 'PhonePe/success.php";</script>';
        }
    }
} else {
    echo "API_STATUS constant is not defined.";
}
