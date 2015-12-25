<?php

class DefaultRouter extends WebApplicationRouter {

  protected function CreateViewProvider($viewMap) {
    return new FileViewProvider($viewMap);
  }

  // @override
  protected function produceView($viewFilename, $controller) {

    // Since WebViewProvider::getTemplate can throw an exception
    // do not try to use it if the headers are alreadys sent.
    // Instead use default implementation.
    if (count($this->getSentHeaders()) > 0)
      return parent::produceView($viewFilename, $controller);

    // Use the WebViewProvider to match any [@!css] or [@!javascript]
    // directives.
    $pageViewProvider = new WebViewProvider(array(
        "page_template" => $viewFilename));

    $template = $pageViewProvider->getTemplate("page_template");

    return parent::produce($template, $controller);
  }

  public function __construct( $routes = null , $viewProviders = null ) {
    if ( $routes === null )
      $routes = include( dirname(__FILE__) . '/routes.php' );

    if ( $viewProviders === null )
      $viewProviders = include( dirname(__FILE__) . '/viewproviders.php' );

    $this->routes = $routes;

    $this->viewProviders = $viewProviders;
  }

  public function getViewProvider( $controllerClassName ) {
    $viewProviders = $this->viewProviders;
    $className = $controllerClassName;
    $classInheritanceList = array();
    $class = $className;

    while ($class) {
      array_unshift( $classInheritanceList , $class );
      $class = get_parent_class( $class );
    }

    $viewMap = array();

    foreach ($classInheritanceList as $class) {
      if ( array_key_exists( $class , $viewProviders ) ) {
        $viewMap = array_merge( $viewMap , $viewProviders[ $class ] );
      }
    }

    return $this->CreateViewProvider($viewMap);
  }
}
