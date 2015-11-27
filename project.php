<?php

include_once(dirname(__FILE__) . "/project-settings.php");
include_once(constant("PATH_TO_FRAMEWORK") . "/base/Base.php");

$mysql = new MySQLProvider("localhost",
                           PROJECT_MYSQL_USERNAME,
                           PROJECT_MYSQL_PASSWORD,
                           PROJECT_MYSQL_DATABASE);

// create the project
$project = Project::Create(constant("PROJECT_NAME"),        // name
                           constant("PROJECT_TITLE"),       // title
                           constant("PROJECT_AUTHOR"),      // author
                           constant("PROJECT_DIR"),         // root
                           constant("PROJECT_TIMEZONE"));   // timezone

$application = Application::getInstance();
$project->setQueriedDataProvider($mysql);
$application->Start();
$mysql->connect();

SurogateDataDriver::SetRealDataDriver(new MySQLDataDriver());

include_once(dirname(__FILE__) . "/functions.php");
