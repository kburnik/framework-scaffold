<?php

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_WARNING, false);
assert_options(ASSERT_CALLBACK, function($script, $line, $message ){
  echo "Assert failed: $script:$line\n$message\n";
  file_put_contents("php://stdout", "Assert failed: $script:$line\n$message\n");
  exit(1);
});

define('PATH_TO_FRAMEWORK', dirname(__FILE__) . "/third_party/framework");
include_once(constant('PATH_TO_FRAMEWORK') . '/base/Base.php');
include_once(dirname(__FILE__) . '/project-config.php');

$mysql = new MySQLProvider('localhost',
                           constant('PROJECT_MYSQL_USERNAME'),
                           constant('PROJECT_MYSQL_PASSWORD'),
                           constant('PROJECT_MYSQL_DATABASE'));

$project = Project::Create(constant('PROJECT_NAME'),
                           constant('PROJECT_TITLE'),
                           constant('PROJECT_AUTHOR_NAME'),
                           constant('PROJECT_DIR'),
                           constant('PROJECT_TIMEZONE'));

$application = Application::getInstance();
$project->setQueriedDataProvider($mysql);
$application->Start();

if (!empty(constant('PROJECT_MYSQL_DATABASE')))
  $mysql->connect();

SurogateDataDriver::SetRealDataDriver(new MySQLDataDriver());

include_once(dirname(__FILE__) . '/functions.php');
include_once(dirname(__FILE__) . '/compat/compat_pbkdf2.php');
include_once(dirname(__FILE__) . '/compat/hash_equals.php');
