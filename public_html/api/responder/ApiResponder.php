<?php

class ApiResponder extends EntityModelXHRResponder {

  protected $userModel;

  protected function init() {
     $this->userModel = UserModel::GetInstance();
  }

  // Assume all methods are unauthorized.
  protected function isAuthorized($method, $params) {
    return false;
  }

}
