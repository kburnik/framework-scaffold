#!/usr/bin/env php
<?php

include_once(dirname(__FILE__) . '/project.php');

function initdb_cli($command, $args, $cli, $fs) {
  $usage = "Usage: $command " .
        "[username=myapp] [database=myapp] " .
        "[mysql-username=root] [mysql-password=] [mysql-host=localhost]";

  if (count(array_intersect($args, array("-h", "--help", "-?")))) {
    $cli->errorLine($usage);

    return 0;
  }

  list($username, $database, $mysql_username, $mysql_password, $mysql_host) =
      $args;

  if (empty($username))
    $username = "myapp";

  if (empty($database))
    $database = "myapp";

  if (empty($mysql_username))
    $mysql_username = "root";

  if (empty($mysql_host))
    $mysql_host = "localhost";

  $settings_filename = dirname(__FILE__) . "/project-settings.php";

  $contents = $fs->file_get_contents($settings_filename);

  $password = bin2hex(openssl_random_pseudo_bytes(8));

  $replacements = array(
      "define('PROJECT_MYSQL_USERNAME', '');" =>
          "define('PROJECT_MYSQL_USERNAME', '$username');",
      "define('PROJECT_MYSQL_PASSWORD', '');" =>
          "define('PROJECT_MYSQL_PASSWORD', '$password');",
      "define('PROJECT_MYSQL_DATABASE', '');" =>
          "define('PROJECT_MYSQL_DATABASE', '$database');");

  $conn = new mysqli($mysql_host, $mysql_username, $mysql_password);

  $user_query = "CREATE USER '$username'@'$mysql_host' " .
                "IDENTIFIED BY '$password';";

  $db_query = "CREATE DATABASE `$database` " .
              "CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

  $grant_query = "GRANT ALL PRIVILEGES ON $database.* " .
                 "TO '$username'@'$mysql_host' WITH GRANT OPTION;";

  $queries = array($user_query, $db_query, $grant_query);

  foreach ($queries as $query) {
    $result = $conn->query($query);

    $cli->writeLine($query);

    if (!$result) {
      $cli->errorLine("ERROR", ShellClient::COLOR_RED);
      $cli->errorLine($conn->error);

      return 1;
    }

    $cli->writeLine("OK", ShellClient::COLOR_GREEN);
  }

  $fs->file_put_contents($settings_filename, strtr($contents, $replacements));
}

if (realpath($argv[0]) === __FILE__) {
  ShellClient::create($argv, new FileSystem())->start('initdb_cli');
}
