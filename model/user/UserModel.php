<?php

class UserModel extends EntityModel {

  private $zatemasApi;

  public function __construct($dataDriver = null,
                              $sourceObjectName = null,
                              $dependencyResolver = null,
                              $zatemasApi = null) {
    parent::__construct($dataDriver, $sourceObjectName, $dependencyResolver);
    $this->zatemasApi = ($zatemasApi != null) ? $zatemasApi : new ZatemasAPI();
  }

  public function getUserByCredentials($credential, $password) {
    $ok = $this->zatemasApi->checkUserCredentials(
      $credential, $password, $response_details);

    if (!$ok)
      return false;

    $zatemasAuthResponse = new ZatemasAuthResponse($response_details);

    return $this->resolveUser($zatemasAuthResponse);
  }

  private function resolveUser(ZatemasAuthResponse $zatemasAuthResponse) {
    $resolvedUser = $this->findFirst(
      array('username' => $zatemasAuthResponse->account));

    if ($resolvedUser === null) {
      $sparseUser = $this->UserFromZatemasAuthResponse($zatemasAuthResponse);
      $id = $this->insert($sparseUser);
      $resolvedUser = $this->findById($id);
    }

    return $resolvedUser;
  }

  private  function UserFromZatemasAuthResponse(
      ZatemasAuthResponse $zatemasAuthResponse) {
    $user = new User();
    $user->username = $zatemasAuthResponse->account;
    $user->name = $zatemasAuthResponse->name;
    $user->surname = $zatemasAuthResponse->lname;
    $user->email = $zatemasAuthResponse->email;
    $user->zatemas_admin = intval($zatemasAuthResponse->isadmin);
    $user->zatemas_contest_admin = intval($zatemasAuthResponse->contestadmin);

    return $user;
  }
}
