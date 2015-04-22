<?php

namespace YandexMail;

class Domain extends Process {

  public function get_list($page = 1, $on_page = 10) {
    $url = $this->api_url('domain', 'domains');
    $params = array('page' => $page, 'on_page' => $on_page);
    return $this->send($url, $params);
  }

  public function register($domain) {
    $url = $this->api_url('domain', 'register');
    $params = array('domain' => $domain);
    return $this->send($url, $params, 'POST');
  }

  public function status($domain) {
    $url = $this->api_url('domain', 'registration_status');
    $params = array('domain' => $domain);
    return $this->send($url, $params);
  }

  public function details($domain) {
    $url = $this->api_url('domain', 'details');
    $params = array('domain' => $domain);
    return $this->send($url, $params);
  }

  public function delete($domain) {
    $url = $this->api_url('domain', 'delete');
    $params = array('domain' => $domain);
    return $this->send($url, $params, 'POST');
  }

  public function set_country($domain, $language = "en") {
    $url = $this->api_url('domain', 'settings/set_country');
    $params = array('domain' => $domain, 'country' => $language);
    return $this->send($url, $params, 'POST');
  }

  public function set_logo($domain, $fileName) {
    if (!file_exists($fileName)) return array('success' => 'error', 'error' => 'File \'' . $fileName . '\' not exists');
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $fileName);
    finfo_close($finfo);
    if (strrpos($type, 'image') === false) return array('success' => 'error', 'error' => 'File \'' . $fileName . '\' not valid image');

    $url = $this->api_url('domain', 'logo/set');
    $params = array('domain' => $domain, 'file' => curl_file_create($fileName, $type, 'logo'));
    return $this->send($url, $params, 'MULTIPART');
  }

  public function check_logo($domain) {
    $url = $this->api_url('domain', 'logo/check');
    $params = array('domain' => $domain);
    return $this->send($url, $params);
  }

  public function remove_logo($domain) {
    $url = $this->api_url('domain', 'logo/del');
    $params = array('domain' => $domain);
    return $this->send($url, $params, 'POST');
  }

}