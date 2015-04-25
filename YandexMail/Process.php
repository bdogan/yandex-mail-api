<?php

namespace YandexMail;

use Exception;

class Process {

  //api url
  protected $host = 'api.kurum.yandex.com.tr';

  //use ssl
  protected $use_ssl = true;

  //api root url
  protected $api_root_url = '/api2/admin';

  //token
  protected $pdd_token = '';

  //last request for debug
  protected $last_request = array();
  public function get_last_request(){
    return $this->last_request;
  }

  //generate api url
  protected function api_url($command, $action) {
    return ($this->use_ssl ? 'https:' : 'http') . '//' . $this->host . $this->api_root_url . '/' . $command . '/' . $action;
  }

  // General Construct
  public function __construct($pdd_token) {
    $this->pdd_token = $pdd_token;
  }

  //generate headers
  protected function headers($headers = array()) {
    $headers = array_merge(
      array(
        'Host: ' . $this->host,
        'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'],
        'PddToken: ' . $this->pdd_token,
        "Accept: text/xml,application/json"
      ),
      $headers
    );
    return $headers;
  }

  //send request global method
  protected function send($url, $params = array(), $method = 'GET', $headers = array()) {
    $this->last_request = array();
    $curl_options = $this->get_curl_options($url, $params, $method, $headers);

    $this->last_request['curl_options'] = $curl_options;

    $ch = curl_init();
    curl_setopt_array($ch, $curl_options);
    $result = curl_exec($ch);
    $this->last_request['result'] = $result;

    if ($result === false) throw new YandexMailException("Error occured when make request to: '" . $url . "'", 0, new Exception(curl_error($ch)));
    
    $info = curl_getinfo($ch);
    $this->last_request['curl_info'] = $info;
    $status = $info['http_code'];
    $content_type = $info['content_type'];
    curl_close($ch);

    if ($status == 404) throw new YandexMailException("Command not found '" . $url . "'");
    
    if (strrpos($content_type, 'application/json') === false) return $result;
    
    try {
      $result = json_decode($result, TRUE);
    } catch (Exception $e) {
      throw new YandexMailException("Response parse error", 0, new Exception($e));
    }

    return $result;
  }

  //generate curl options
  private function get_curl_options($url, $params = array(), $method = 'GET', $headers = array()){
    $headers = $this->headers($headers);

    if ($method == 'GET') $url = $url . '?' . http_build_query($params);
    if ($method == 'MULTIPART') $headers = array_merge($headers, array('Content-Type: multipart/form-data'));

    $this->last_request['url'] = $url;
    $this->last_request['method'] = $method;
    $this->last_request['params'] = $params;
    $this->last_request['headers'] = $headers;

    $options = array(
      CURLOPT_URL => $url,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTPHEADER => $headers
    );

    if ($method == 'POST' || $method == 'MULTIPART') {
      foreach ($params as $key => $value) if ($key != "file") $params[$key] = urlencode($value);
      $options[CURLOPT_POST] = 1;
      $options[CURLOPT_POSTFIELDS] = $params;
    }

    return $options;
  }

}
