<?php

# FRAMEWORK PROJECT.
assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_WARNING, false);
assert_options(ASSERT_CALLBACK, function($script, $line, $message ){
  echo "Assert failed: $script:$line\n$message\n";
  file_put_contents("php://stdout", "Assert failed: $script:$line\n$message\n");
  exit(1);
});

# DIR
define('PROJECT_DIR', dirname(__FILE__));
define('PATH_TO_FRAMEWORK', constant('PROJECT_DIR') . '/third_party/framework');

# REGIONAL
define('PROJECT_LANGUAGE', 'hr');
define('PROJECT_TIMEZONE', "Europe/Zagreb");

# NAME
define('PROJECT_NAME', 'empty-framework-project');
define('PROJECT_TITLE', "Empty framework project");
define('PROJECT_DESCRIPTION',
       "@@PROJECT_DESCRIPTION@@");

# AUTHOR
define('PROJECT_AUTHOR', "Kristijan Burnik");
define('PROJECT_AUTHOR_MAIL', "kristijanburnik@gmail.com");

# MYSQL
define('PROJECT_MYSQL_USERNAME', "");
define('PROJECT_MYSQL_PASSWORD', "");
define('PROJECT_MYSQL_TEST_DATABASE', "");

# Environment
if (preg_match("/kristijan/", PROJECT_DIR) || PHP_OS == 'WINNT') {
  define('ENV', "dev");
  define('APP_DOMAIN', 'dev.myapp.com');
  define('APP_DEFAULT_PROTOCOL', 'http');
  define('PROJECT_MYSQL_DATABASE', "");
} else if (preg_match("/test(.*)/", PROJECT_DIR)) {
  define('ENV', "canary");
  define('PRODUCTION_MODE', true);
  define('APP_DOMAIN', 'test.myapp.com');
  define('APP_DEFAULT_PROTOCOL', 'https');
  define('PROJECT_MYSQL_DATABASE', "");
} else {
  define('ENV', "prod");
  define('PRODUCTION_MODE', true);
  define('APP_DOMAIN', 'www.myapp.com');
  define('APP_DEFAULT_PROTOCOL', 'https');
  define('PROJECT_MYSQL_DATABASE', "");
}

# VIEW
define('PROJECT_VIEW_DIR', constant('PROJECT_DIR') . '/view');
define("URL_ROOT", "");
define("REQUEST_URI", $_SERVER["REQUEST_URI"]);
define("HTTP_HOST", $_SERVER["HTTP_HOST"]);
define("SERVER_PROTOCOL", $_SERVER["SERVER_PROTOCOL"]);
define("REQUEST_METHOD", $_SERVER["REQUEST_METHOD"]);
define("URL_QUERY", ($_SERVER['QUERY_STRING']) ?
                    '?' . $_SERVER['QUERY_STRING'] : "");

define('PDF_OUTPUT_DIR', constant('PROJECT_DIR') . '/gen/pdf');
define('PROJECT_DATA_DIR', constant('PROJECT_DIR') . '/data');
