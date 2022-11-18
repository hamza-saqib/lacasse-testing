<?php
require_once('paymentwall/lib/paymentwall.php');
/*Paymentwall_Config::getInstance()->set(array(
    'public_key' => 't_adb0dbfbc2d22767f99502c3c1faa1',
    'private_key' => 't_a02af752cbfdd821d7de7444d933d2'
));*/

Paymentwall_Config::getInstance()->set(array(
    'public_key' => '973cc57f4d88eedc6390d7dcaae4db93',
    'private_key' => '8419ec323cb8150badf13a949f982a6b'
));
$parameters = $_POST;
//print_r($_POST);
$cardInfo = array(
    'email' => $parameters['email'],
    'amount' => 9.99,
    'currency' => 'USD',
    'token' => $parameters['brick_token'],
    'fingerprint' => isset($parameters['brick_fingerprint'])?$parameters['brick_fingerprint']:'',
    'description' => 'Order #123'
);

if (isset($parameters['brick_charge_id']) AND isset($parameters['brick_secure_token'])) {
    $cardInfo['charge_id'] = $parameters['brick_charge_id'];
    $cardInfo['secure_token'] = $parameters['brick_secure_token'];
}

$charge = new Paymentwall_Charge();
$charge->create($cardInfo);
$responseData = json_decode($charge->getRawResponseData(),true);
$response = $charge->getPublicData();
//print_r($response);
if ($charge->isSuccessful() AND empty($responseData['secure'])) {
    if ($charge->isCaptured()) {
        // deliver a product
        //die('captured');
        $response = json_encode(array('captured' => 1));
    } elseif ($charge->isUnderReview()) {
        // decide on risk charge
        $response = json_encode(array('isUnderReview' => 1));
    }
} elseif (!empty($responseData['secure'])) {
    $response = json_encode(array('secure' => $responseData['secure']));
} else {
    $errors = json_decode($response, true);
}

echo $response;
//print_r($errors);