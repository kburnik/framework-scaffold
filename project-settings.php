<?php

# DIR.
define('PROJECT_DIR', dirname(__FILE__));
define('PATH_TO_FRAMEWORK', constant('PROJECT_DIR') . '/third_party/framework');

# REGIONAL.
define('PROJECT_LANGUAGE', 'hr');
define('PROJECT_TIMEZONE', 'Europe/Zagreb');

# NAME.
define('PROJECT_NAME', 'myapp');
define('PROJECT_TITLE', 'My App');
define('PROJECT_DESCRIPTION', 'An empty project for scaffolding.');
define('PROJECT_DEVELOPMENT_DOMAIN', 'dev.myapp.com');

# COMPANY.
define('PROJECT_COMPANY', 'Acme');
define('PROJECT_COMPANY_URL', 'https://www.example.com/');
define('PROJECT_COPYRIGHT', 'All rights reserved');

# AUTHOR.
define('PROJECT_AUTHOR', 'John Doe');
define('PROJECT_AUTHOR_URL', 'https://www.example.com/');
define('PROJECT_AUTHOR_MAIL', 'johndoe@example.com');

# DB.
define('PROJECT_MYSQL_USERNAME', 'myapp');
define('PROJECT_MYSQL_PASSWORD', '0e32241fa64323cc');
define('PROJECT_MYSQL_TEST_DATABASE', '');

# ENV.
if (PHP_OS == 'WINNT') {
  define('ENV', 'dev');
  define('APP_DOMAIN', 'dev.myapp.com');
  define('APP_DEFAULT_PROTOCOL', 'http');
  define('PROJECT_MYSQL_DATABASE', 'myapp');
} else if (preg_match('/test(.*)/', PROJECT_DIR)) {
  define('ENV', 'canary');
  define('PRODUCTION_MODE', true);
  define('APP_DOMAIN', 'test.myapp.com');
  define('APP_DEFAULT_PROTOCOL', 'https');
  define('PROJECT_MYSQL_DATABASE', 'myapp');
} else {
  define('ENV', 'prod');
  define('PRODUCTION_MODE', true);
  define('APP_DOMAIN', 'www.myapp.com');
  define('APP_DEFAULT_PROTOCOL', 'https');
  define('PROJECT_MYSQL_DATABASE', 'myapp');
}

# VIEW.
define('PROJECT_VIEW_DIR', constant('PROJECT_DIR') . '/view');
define('URL_ROOT', '');
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('HTTP_HOST', $_SERVER['HTTP_HOST']);
define('SERVER_PROTOCOL', $_SERVER['SERVER_PROTOCOL']);
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('URL_QUERY', ($_SERVER['QUERY_STRING']) ?
                    '?' . $_SERVER['QUERY_STRING'] : '');

define('PDF_OUTPUT_DIR', constant('PROJECT_DIR') . '/gen/pdf');
define('PROJECT_DATA_DIR', constant('PROJECT_DIR') . '/data');
