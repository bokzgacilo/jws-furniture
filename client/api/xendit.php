<?php
  session_start();

  use Xendit\Xendit;

  require '../../vendor/autoload.php';
  include('connection.php');
  $reference_id = rand(10000,99999);
  $ref = "00000" . $reference_id;
  $amount = $_GET['amount'];
  $_SESSION['reference'] = $ref;
  $_SESSION['uid'] = $_GET['uid'];

  Xendit::setApiKey('xnd_development_KrH2sC5EUvrbDsCElxsQKUFhzRozuFg9zlJVu6Gln0wPpLqPluvFJqSEv2WSPKC5');

  $params = [
    'reference_id' => $ref,
    'currency' => 'PHP',
    'amount' => (int)$amount,
    'checkout_method' => 'ONE_TIME_PAYMENT',
    'channel_code' => 'PH_GCASH',
    'phone' => '639762220951',
    'channel_properties' => [
      'success_redirect_url' => 'http://localhost/jws-furniture/success.php',
      'failure_redirect_url' => 'https://capstone-d51c8.web.app/failed.html',
    ],
    'items' => [
      [
        'id' => 'ITEM_ID',
        'name' => 'Item Name',
        'price' => (int)$amount,
        'quantity' => 1
      ]
    ],
    "description" => "Payment for your order",
    'customer_details' => [
      'email' => 'bokzgacilo@gmail.com',
      'first_name' => 'John',
      'last_name' => 'Doe'
  ]
  ];

 
  $charge = \Xendit\EWallets::createEWalletCharge($params);

  $getEWalletChargeStatus = \Xendit\EWallets::getEWalletChargeStatus(
    $charge['id']
  );
  
  $postTransaction = $conn -> query("INSERT INTO transactions(transaction_id, reference_number, amount, orders) VALUES (
      '".$charge['id']."', '$ref', $amount, 'sample cart'
    ) 
  ");
  
  echo "<a class='w-100 btn btn-success' href=".$charge['actions']['desktop_web_checkout_url'].">Make Payment</a>";

  $conn -> close();
?>