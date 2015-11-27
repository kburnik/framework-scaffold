<?php

class AccountController extends TemplateController {
  public $error;

  private $loggedin, $loggedout;

  public function getDependencies() {
    return array_merge(parent::getDependencies(), array());
  }

  public function main() {
    return $this->bind('main', array(
      "redirect" => $this->redirect_url,
      "error" => $this->error,
      "continue" => $this->redirect_url != '/'
      ));
  }

  public function initialize() {
    parent::initialize();

    // Default redirect to avoid redirection loops.
    $this->redirect_url = ($this->params["redirect"]) ?
            $this->params["redirect"] : "/";

    // security check
    if ($this->params['request_secure']) {
      try {
        Security::CheckRequest( $this->params[ 'request_token' ] );
      } catch ( SecurityException $ex ) {

        $this->securityException = $ex->getMessage();

        return;
      }
    }

    $this->redirect = ( isset($this->params['redirect']) ) ?
        $this->params['redirect']  :  false;

    if (!empty($this->params['username'])) {
      $this->session->login($this->params['username'],
                            $this->params['password']);

      if ($this->session->isLoggedin()) {
        // reroute
        $this->abort( 'redirect' , $this->redirect_url , null ) ;
      } else {
        $this->error = true;
      }
    } else if (isset($this->params['logout']) && $this->session->isLoggedin()) {
      $this->session->logout();
      $this->loggedout = true;
      $this->abort( 'redirect' , $this->redirect_url , null ) ;
    }

    if ( $this->session->isLoggedin() )
      $this->loggedin = true;

  }

}
