<?php

class UserSession extends Session {
  private $userModel;

  public function __construct( $userModel = null ) {
    if ($userModel === null)
      $userModel = UserModel::getInstance();

    $this->userModel = $userModel;
    parent::__construct();
  }

  public function attemptLogin($credential, $password) {
    $user = $this->userModel->getUserByCredentials($credential, $password);

    if (!($user instanceof User))
      return false;

    $this->setUserData( $user->toArray() );

    return true;
  }

  public function getUser() {
    $userdata = $this->getUserData();
    $user = $this->userModel->findById( $userdata['id'] );

    return $user;
  }

}
