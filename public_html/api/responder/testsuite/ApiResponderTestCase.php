<?php

class ApiResponderTestCase extends TestCase {

  private $indexScript;

  protected $headers;
  protected $output;

  public function __construct() {
    $this->indexScript = realpath(dirname(__FILE__) . "/../../") . "/index.php";
  }

  public function __ob_handler($output) {
    $this->output = $output;
  }

  protected function get($url) {
    $_SERVER['REQUEST_URI'] = $url;
    ob_start(array($this, "__ob_handler"));
    include($this->indexScript);
    ob_end_flush();
    $result = json_decode($this->output, true);
    unset($_SERVER['REQUEST_URI']);

    return $result;
  }

  protected function post($url, $data) {
    $_SERVER['REQUEST_URI'] = $url;
    $_REQUEST = $_POST = $data;
    ob_start(array($this, "__ob_handler"));
    include($this->indexScript);
    ob_end_flush();
    $result = json_decode($this->output, true);
    unset($_POST);
    unset($_REQUEST);
    unset($_SERVER['REQUEST_URI']);

    return $result;
  }

  protected function assertApiSuccess($response, $message = null) {
    $this->assertEqual("success", $response["status"], $message);
  }

  protected function assertApiError($response, $message = null) {
    $this->assertEqual("error", $response["status"], $message);
  }

  protected function assertApiResult($expectedResult,
                                     $response,
                                     $message = null) {
    $this->assertEqual($expectedResult, $response["result"], $message);
  }

  protected function assertApiMessage($expectedMessage,
                                      $response,
                                      $message = null) {
    $this->assertEqual($expectedMessage, $response["message"], $message);
  }

  protected function assertApiResultFields($fields,
                                           $response,
                                           $message = null) {
    $expectedFields = $fields;
    sort($expectedFields);
    $actualFields = array_keys($response["result"]);
    sort($actualFields);
    $this->assertEqual($expectedFields,
                       $actualFields,
                       "Result field mismatch!\n" . $message);
  }

}