<?php
require 'connect-php-sdk-master/vendor/autoload.php';

//$access_token = 'EAAAEMcfW2lcGKP3P8-VAyhHthX3T1QNjVncV3s1VD7UxK19BW1HacONWPEYXwij';
$access_token = 'EAAAEdyoM-XFoSxXr__8bEndTveToz9UkYFp0S5_h57SSQgB_e0IBDwK3URcykin';
# setup authorization
\SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($access_token);
# create an instance of the Transaction API class
$transactions_api = new \SquareConnect\Api\TransactionsApi();
//$location_id = "LBNZ908X60PNH";
$location_id = "LNKEEYEJ5RA9G";
$nonce = $_POST['nonce'];

$request_body = array (
"card_nonce" => $nonce,
# Monetary amounts are specified in the smallest unit of the applicable currency.
# This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
"amount_money" => array (
"amount" => (int) $_POST['amount'],
"currency" => "USD"
),
# Every payment you process with the SDK must have a unique idempotency key.
# If you're unsure whether a particular payment succeeded, you can reattempt
# it with the same idempotency key without worrying about double charging
# the buyer.
"idempotency_key" => uniqid()
);

try {
$result = $transactions_api->charge($location_id,  $request_body);
// print_r($result);

// echo '';
if($result['transaction']['id']){
echo 'Payment success!';
echo "Transation ID: ".$result['transaction']['id']."";
}
} catch (\SquareConnect\ApiException $e) {
echo "Exception when calling TransactionApi->charge:";
var_dump($e->getResponseBody());
}
?>