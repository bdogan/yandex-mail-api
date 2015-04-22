<?php
header('Content-type: text/plain');

require_once "autoload.php";

$Domain = new YandexMail\Domain("");

$domain = "deneme.com";

try {
  
  echo "Adding $domain\n";
  $result = $Domain->register($domain);
  print_r($result);

  echo "Status $domain\n";
  $result = $Domain->status($domain);
  print_r($result);

  echo "Details $domain\n";
  $result = $Domain->details($domain);
  print_r($result);

  echo "Country Set $domain\n";
  $result = $Domain->set_country($domain, 'tr');
  print_r($result);

  echo "Logo Set $domain\n";
  $result = $Domain->set_logo($domain, 'image_upload_test.jpg');
  print_r($result);

  echo "Logo Check $domain\n";
  $result = $Domain->check_logo($domain);
  print_r($result);

  echo "Logo Remove $domain\n";
  $result = $Domain->remove_logo($domain);
  print_r($result);

  echo "Delete $domain\n";
  $result = $Domain->delete($domain);
  print_r($result);
  
} catch (Exception $e) {

  print_r(array('success' => 'error', 'error' => $e->getMessage()));

} 