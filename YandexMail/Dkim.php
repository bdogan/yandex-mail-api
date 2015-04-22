<?php

namespace YandexMail;

class Dkim extends Process {

  public function status($domain) {
    $url = $this->api_url('dkim', 'status');
    $params = array('domain' => $domain, 'secretkey' => 'yes');
    return $this->send($url, $params);
  }

  public function enable($domain) {
    $url = $this->api_url('dkim', 'enable');
    $params = array('domain' => $domain);
    return $this->send($url, $params, 'POST');
  }

  public function disable($domain) {
    $url = $this->api_url('dkim', 'disable');
    $params = array('domain' => $domain);
    return $this->send($url, $params, 'POST');
  }

}