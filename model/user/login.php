#!/usr/bin/env php
<?php

include_once(dirname(__FILE__) . "/../../project.php");

function login_cli($command, $args, $cli, $userModel) {
  $credential = $cli->input("Username or email: ");
  $password = $cli->input("Password: ");
  $user = $userModel->getUserByCredentials($credential, $password);

  if ($user === null) {
    $cli->errorLine("No such user.");

    return 1;
  }

  if ($user === false) {
    $cli->errorLine("Invalid password.");

    return 2;
  }

  $cli->writeJson($user->toArray());

  return 0;
}

if (realpath($argv[0]) === __FILE__) {
  $userModel = UserModel::getInstance();
  ShellClient::create($argv, $userModel)->start('login_cli');
}
