<?php
require_once './PayConfig.php';

if (isset($_POST['fundAmount']) && isset($_POST['paymentMethod'])) {
    function idGenerate($length = 18)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    $merchantId = 'PGTESTPAYUAT';
    $merchantTransactionId = 'MTI' . idGenerate();
    $merchantUserId = 'UI' . idGenerate();
    $Amount = $_POST['fundAmount'];
    $paymentMethod = $_POST['paymentMethod'];

    $payLoad = array(
        "merchantId" => $merchantId,
        "merchantTransactionId" => $merchantTransactionId,
        "merchantUserId" => $merchantUserId,
        "amount" => $Amount * 100,
        "redirectUrl" => REDIRECTURL,
        "redirectMode" => "POST",
        "callbackUrl" => REDIRECTURL,
        "mobileNumber" => "1234567890",
        "paymentInstrument" => array(
            "type" => "PAY_PAGE"
        )
    );

    $saltKey = SALTKEYUAT;
    $saltIndex = SALTKEYINDEX;

    $jsonencode = json_encode($payLoad);
    $payloadbase64 = base64_encode($jsonencode);

    $payloaddata = $payloadbase64 . "/pg/v1/pay" . $saltKey;
    $sha256 = hash("sha256", $payloaddata);

    $checksum = $sha256 . '###' . $saltIndex;
    $request = json_encode(array('request' => $payloadbase64));

    $curl = curl_init();
    $url = '';
    if (API_STATUS == "LIVE") {
        $url = LIVEURLPAY;
    } else {
        $url = UATURLPAY;
    }

    echo "<br/>" . $url;

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'X-VERIFY: ' . $checksum,
            'Accept: application/json'
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if ($err) {
        echo "curl error: " . $err;
    } else {
        $res = json_decode($response);
    }

    // User This For Debugging
    // print_r($res);

    if (isset($res->success) && $res->success == '1') {
        if (isset($_SESSION['username'])) {
            $loggedIn = true;
            $username = $_SESSION['username'];
        }
        $redirectUrl = urldecode($res->data->instrumentResponse->redirectInfo->url);
        // echo  '<script> window.location.href = "' . $redirectUrl . '";</script>';
        header("Location: " . $redirectUrl);
    }
}
