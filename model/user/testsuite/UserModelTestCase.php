<?php

class UserModelTestCase extends TestCase {
  private $userModel;

  public function __construct() {
    $this->userModel = new UserModel(new InMemoryDataDriver());
  }

  public function register_invalidInput_throws() {
    $this->assertRegisterThrows(UserModel::REG_ERROR_INVALID_INPUT_TYPE,
                                null);
  }

  public function register_emptyArray_throws() {
    $this->assertRegisterThrows(UserModel::REG_ERROR_MISSING_FIELD,
                                array());
  }

  private function assertRegisterThrows($exceptionCode, $registrationData){
    try {
      $this->userModel->register($registrationData);
   } catch (Exception $ex) {
     $this->assertEqual($exceptionCode,
                        $ex->getCode(),
                        "Invalid exception code thrown.");
     return;
   }

   $this->assertTrue(false, "Should have thrown exception.");
  }
}
