<?php
header('Content-type: text/plain');

require_once "autoload.php";

$Mailbox = new YandexMail\Mailbox("");

$domain = "platinbox.org";

try {
  
  echo "Add Mailbox deneme@$domain\n";
  $result = $Mailbox->add($domain, 'deneme', '1postmaster23');
  if ($result['success'] == "ok") $uid = $result['uid'];
  print_r($result);  
  
  echo "List Mailbox $domain\n";
  $result = $Mailbox->get_list($domain);
  if (!isset($uid)) {
    foreach ($result['accounts'] as $key => $account) {
      if ($account['login'] == "deneme@$domain") {
        $uid = $account['uid'];
        break;
      }
    }
  }
  print_r($result);  

  echo "Uid: $uid\n";

  echo "Mailbox Counter deneme@$domain\n";
  $result = $Mailbox->counters($domain, 'deneme', $uid);
  print_r($result);  

  echo "Mailbox Edit deneme@$domain\n";
  $result = $Mailbox->edit($domain, 'deneme', $uid, array('iname' => 'Deneme', 'fname' => 'Deneme'));
  print_r($result);  

  echo "Mailbox Del deneme@$domain\n";
  $result = $Mailbox->del($domain, 'deneme', $uid);
  print_r($result);  
  
} catch (Exception $e) {

  print_r(array('success' => 'error', 'error' => $e->getMessage()));

} 