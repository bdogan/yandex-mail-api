<?php
header('Content-type: text/plain');

require_once "autoload.php";

$Dkim = new YandexMail\Dkim("");

$domain = "platinbox.org";

try {
  
  echo "Status Dkim $domain\n";
  $result = $Dkim->status($domain);
  print_r($result);  
  
  echo "Enable Dkim $domain\n";
  $result = $Dkim->enable($domain);
  print_r($result);  

  echo "Disable Dkim $domain\n";
  $result = $Dkim->disable($domain);
  print_r($result);
  
} catch (Exception $e) {

  print_r(array('success' => 'error', 'error' => $e->getMessage()));

} 