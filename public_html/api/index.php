<?php

try
{
	include_once( dirname(__FILE__) . '/../../project.php'  );
	$prefix = preg_quote( constant('URL_ROOT') . '/' . basename(dirname(__FILE__)) , '/'  );
	$url = preg_replace("/^{$prefix}/" , '' , $_SERVER['REQUEST_URI'] );

	##

	$routes = include( dirname(__FILE__) .'/routes.php' );
	$viewProviderMap = include( dirname(__FILE__) .'/viewproviders.php' );
	$viewProviderFactory = new DefaultViewProviderFactory( $viewProviderMap );
	$router = new EntityModelResponderRouter( $routes , $viewProviderFactory );

	##
	$params = $_REQUEST;

	$input = file_get_contents("php://input");
	$json = json_decode($input, true);

	if (is_array($json))
		$params = array_merge($params, $json);

	$params['entityModelFactory'] = new EntityModelFactory();
	$responder = $router->route($url, $params);
	$responder->addEventHandler( new EntityModelXHRResponderEventHandler() );

	echo $responder->respond();
}
catch ( Exception $ex )
{
	header('HTTP/1.1 400 Bad Request');
	header('Content-type: text/plain');

	echo "$url\n( {$ex->getMessage()} )";

	throw $ex;
}
