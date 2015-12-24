<?php

include_once(dirname(__FILE__) . '/project-settings.php');
include_once(constant('PATH_TO_FRAMEWORK') . '/base/Base.php');

$mysql = new MySQLProvider('localhost',
                           constant('PROJECT_MYSQL_USERNAME'),
                           constant('PROJECT_MYSQL_PASSWORD'),
                           constant('PROJECT_MYSQL_DATABASE');

$project = Project::Create(constant('PROJECT_NAME'),
                           constant('PROJECT_TITLE'),
                           constant('PROJECT_AUTHOR'),
                           constant('PROJECT_DIR'),
                           constant('PROJECT_TIMEZONE'));

$application = Application::getInstance();
$project->setQueriedDataProvider($mysql);
$application->Start();
$mysql->connect();

SurogateDataDriver::SetRealDataDriver(new MySQLDataDriver());

include_once(dirname(__FILE__) . '/functions.php');
