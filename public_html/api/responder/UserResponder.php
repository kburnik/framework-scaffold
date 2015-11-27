<?php

class UserResponder extends ApiAuthResponder {

  // @override
  protected function isAuthorized($method, $params) {

    // TODO(kburnik): Fix this init hack in EntityModelXHRResponder.
    $result = parent::isAuthorized($method, $params);

    if (in_array($method, array("getCurrentUser"))) {
      return true;
    }

    return $result;
  }

  public function getCurrentUser() {
    // TODO(kburnik): This should be fixed in Session class.
    if (!$this->userSession->isLoggedIn())
      return null;

    return $this->userSession->getUser();
  }
}