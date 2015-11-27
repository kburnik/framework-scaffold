<?php

// TODO: Fix so this will not be needed or implement so it writes to db.
class Debug {}
class DebugModelDataDriver extends InMemoryDataDriver {}
class DebugModel extends EntityModel {}

class DebugResponder extends ApiResponder {

  // @override
  protected function isAuthorized( $method, $params ) {

    if (in_array($method, array('log')))
      return true;

    return false;
  }

  public function log() {
    $params = array();
    $params["server_date"] = now();
    $params = array_merge($params, $this->params);
    unset($params["entityModelFactory"]);
    unset($params["entity"]);
    unset($params["action"]);
    file_put_contents(constant('PROJECT_DIR') . "/gen/browser.log",
                      json_encode($params)."\n",
                      FILE_APPEND);
  }
}
