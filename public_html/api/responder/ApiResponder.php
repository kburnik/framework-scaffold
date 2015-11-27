<?php

class ApiResponder extends EntityModelXHRResponder {

  protected $conceptModel;
  protected $problemModel;
  protected $userModel;
  protected $unboundedTextModel;

  protected function init() {
     $this->conceptModel = ConceptModel::GetInstance();
     $this->problemModel = ProblemModel::GetInstance();
     $this->userModel = UserModel::GetInstance();
     $this->unboundedTextModel = UnboundedTextModel::GetInstance();
  }

	// Assume all methods are unauthorized.
	protected function isAuthorized($method, $params) {
		return false;
	}

}
