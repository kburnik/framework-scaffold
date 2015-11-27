<?php

abstract class TemplateController extends WebController {
  protected $template_data;
  protected $redirect_url;
  protected $session;

  public abstract function main();

  public function initialize() {
    $this->redirect_url = constant('REQUEST_URI');

    $this->session = new UserSession( $this->userModel );
    $this->session->start();
  }

  protected static function JoinTitle() {
    return implode(" - ", func_get_args());
  }

  // @override
  public function offsetGet($offset) {
    // Support for direct binding of plain views (no produce).
    if (!parent::offsetExists($offset))
      return $this->getViewProvider()->getTemplate($offset);

    return parent::offsetGet($offset);
  }

   public function getDependencies() {
    return array(
      'userModel' => "UserModel"
    );
  }

  public function loggedIn() {
    return $this->session->isLoggedin();
  }

  public function user() {
    return $this->session->getUser()->toArraySafe();
  }

  public function title() {
    return constant('PROJECT_TITLE');
  }

  public function meta_description() {
    return constant('PROJECT_DESCRIPTION');
  }

}
