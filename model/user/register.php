#!/usr/bin/env php
<?php

include_once(dirname(__FILE__) . "/../../project.php");

function register_cli($command, $args, $cli, $userModel) {

  $registrationData = array();
  $registrationData['name'] = $cli->input("First name: ");
  $registrationData['surname'] = $cli->input("Last name: ");
  $registrationData['email'] = $cli->input("E-mail: ");
  $registrationData['username'] = $cli->input("Username: ");
  $registrationData['password'] = $cli->input("Password: ");
  $registrationData['repeated_password'] = $cli->input("Repeat password: ");

  $user = $userModel->register($registrationData, true, true);

  $cli->writeJson($user->toArray());

  return 0;
}

if (realpath($argv[0]) === __FILE__) {
  $userModel = new UserModel(new InMemoryDataDriver());
  ShellClient::create($argv, $userModel)->start('register_cli');
}
