<?php

class ApiAuthResponder extends ApiResponder {
  protected $userSession;

  // Assume all methods are unauthorized if not logged in.
  protected function isAuthorized($method, $params) {
    // TODO: This is a bit of a hack. Should actually be called in a lower level.
    parent::init();

    $this->userSession = new UserSession($this->userModel);
    $this->userSession->start();

    return $this->userSession->isloggedIn();
  }

  protected function isLoggedIn() {
    return $this->userSession != null && $this->userSession->isloggedIn();
  }

  protected function getCurrentUser() {
    return ($this->isLoggedIn()) ? $this->userSession->getUser() : null;
  }

}
