<?php

namespace YandexMail;

class Mailbox extends Process {

  public function add($domain, $login, $password) {
    $url = $this->api_url('email', 'add');
    $params = array('domain' => $domain, 'login' => $login, 'password' => $password);
    return $this->send($url, $params, 'POST');
  }

  public function get_list($domain, $page = 1, $on_page = 10) {
    $url = $this->api_url('email', 'list');
    $params = array('domain' => $domain, 'page' => $page, 'on_page' => $on_page);
    return $this->send($url, $params);
  }

  public function edit($domain, $login, $uid, $optional_parameters = array()) {
    $url = $this->api_url('email', 'edit');
    $params = array('domain' => $domain, 'login' => $login, 'uid' => $uid);
    $params = array_merge($params, $optional_parameters);
    return $this->send($url, $params, 'POST');
  }

  public function del($domain, $login, $uid) {
    $url = $this->api_url('email', 'del');
    $params = array('domain' => $domain, 'login' => $login, 'uid' => $uid);
    return $this->send($url, $params, 'POST');
  }

  public function counters($domain, $login, $uid) {
    $url = $this->api_url('email', 'counters');
    $params = array('domain' => $domain, 'login' => $login, 'uid' => $uid);
    return $this->send($url, $params);
  }

}