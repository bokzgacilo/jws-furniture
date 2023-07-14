<?php
  session_start();
  $_SESSION['payment_method'] = "GCASH";
  include('connection.php');
  include('env.php');

  use Xendit\Xendit;
  require '../../vendor/autoload.php';
  $amount = $_POST['amount'];
  
  $user = $conn -> query("SELECT * FROM user WHERE uid='".$_SESSION['client']."'");
  $address = $conn -> query("SELECT * FROM address WHERE uid='".$_SESSION['client']."'");

  $user = $user -> fetch_assoc();
  $address = $address -> fetch_assoc();

  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $reference_id = '';

  for ($i = 0; $i < 16; $i++) {
    $reference_id .= $characters[rand(0, strlen($characters) - 1)];
  }

  $phone = $address['contact'];
  $description = $user['cart'];
  $_SESSION['gcash_reference_number'] = $reference_id;

  Xendit::setApiKey('xnd_development_KrH2sC5EUvrbDsCElxsQKUFhzRozuFg9zlJVu6Gln0wPpLqPluvFJqSEv2WSPKC5');

  $params = [
    'reference_id' => $reference_id,
    'currency' => 'PHP',
    'amount' => (int)$amount,
    'checkout_method' => 'ONE_TIME_PAYMENT',
    'channel_code' => 'PH_GCASH',
    'phone' => $phone,
    'channel_properties' => [
      'success_redirect_url' => $success_url_local,
      'failure_redirect_url' => 'https://www.youtube.com/',
    ],
    'description' => $description,
    'metadata' => [
      'branch_code' => 'tree_branch'
    ]
  ];

  $charge = \Xendit\EWallets::createEWalletCharge($params);
  
  $status = \Xendit\EWallets::getEWalletChargeStatus(
    $charge['id']
  );

  if($charge){
    $checkoutURL = $charge['actions']['desktop_web_checkout_url'];

    $add_to_transaction = $conn -> query("INSERT INTO transactions(transaction_id,mode,reference_number,checkout_url,amount,orders,status) VALUES (
      '".$charge['id']."',
      'GCASH',
      '$reference_id',
      '$checkoutURL',
      '$amount',
      '".$user['cart']."',
      '".$status['status']."'
    )");
    
    if($add_to_transaction){
      print_r($charge);
      $_SESSION['payment_status'] = $status['status'];
      $_SESSION['transaction_id'] = $charge['id'];

      header("location: $checkoutURL");
    }else {
      echo "Creating transaction failed";
    }
  } 

  $conn -> close();
?>