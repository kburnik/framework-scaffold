<?php

include_once( dirname(__FILE__) . '/../project.php'  );

// Remove URL_ROOT prefix.
$prefix = preg_quote( constant('URL_ROOT') , '/' );
$url = preg_replace("/^{$prefix}/" , '' , $_SERVER['REQUEST_URI']);

// Remove query from URL
$query = parse_url($url, PHP_URL_QUERY);
$url = preg_replace('/\?.*$/', '', $url);

$router = new DefaultRouter();

echo
  $router->route(
    $url ,
    array(
      view('template.view.html'),
      view('404.view.html'),
      view('500.view.html'),
    )
  );
