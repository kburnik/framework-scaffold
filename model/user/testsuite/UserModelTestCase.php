<?php

class UserModelTestCase extends TestCase {
  private $userModel;

  private $defaultRegistrationData;

  public function __construct() {
    $this->userModel = new UserModel(new InMemoryDataDriver());
    $this->defaultRegistrationData =
        array('username' => 'foo',
              'password' => 'barbaz',
              'repeated_password' => 'barbaz',
              'name' => 'Foo',
              'email' => 'foo@bar.org',
              'surname' => 'Bar');
  }

  public function register_invalidInput_throws() {
    $this->assertRegisterThrows(UserModel::REG_ERROR_INVALID_INPUT_TYPE,
                                null);
  }

  public function register_emptyArray_throws() {
    $this->assertRegisterThrows(UserModel::REG_ERROR_MISSING_FIELD,
                                array());
  }

  public function register_missingField_throws() {
    foreach ($this->defaultRegistrationData as $field => $value) {
      $used_fields = $this->defaultRegistrationData;
      unset($used_fields[$field]);
      $this->assertRegisterThrows(UserModel::REG_ERROR_MISSING_FIELD,
                                  $used_fields);
    }
  }

  public function register_emptyField_throws() {
    foreach ($this->defaultRegistrationData as $field => $value) {
      $used_fields = $this->defaultRegistrationData;
      $used_fields[$field] = "";
      $this->assertRegisterThrows(UserModel::REG_ERROR_EMPTY_FIELD,
                                  $used_fields);
    }
  }

  public function register_invalidUsername_throws() {
    $data = $this->defaultRegistrationData;
    $data["username"] = "fo";
    $this->assertRegisterThrows(UserModel::REG_ERROR_INVALID_USERNAME,
                                $data);
  }

  public function register_invalidEmail_throws() {
    $data = $this->defaultRegistrationData;
    $data["email"] = "not-an-email@x";
    $this->assertRegisterThrows(UserModel::REG_ERROR_INVALID_EMAIL,
                                $data);
  }

  public function register_tooShortPassword_throws() {
    $data = $this->defaultRegistrationData;
    $data["password"] = "sho";
    $this->assertRegisterThrows(UserModel::REG_ERROR_PASSWORD_TOO_SHORT,
                                $data);
  }

  public function register_passwordMismatch_throws() {
    $data = $this->defaultRegistrationData;
    $data["password"] = "ABCD";
    $data["repeated_password"] = "abcd";
    $this->assertRegisterThrows(UserModel::REG_ERROR_PASSWORD_MISMATCH,
                                $data);
  }

  private function registerValidUser() {
    $data = $this->defaultRegistrationData;
    $user = $this->userModel->register($data, false, false,
                                       '2015-12-24 19:31:30');
    $this->assertTrue(is_object($user), "Should be an object.");

    return $user;
  }

  public function register_valid_returnsNewUser() {
    $user = $this->registerValidUser();
    $actual = $user->toArray();
    $expected_partial = array ('id' => 1,
                               'username' => 'foo',
                               'name' => 'Foo',
                               'surname' => 'Bar',
                               'email' => 'foo@bar.org',
                               'regdate' => '2015-12-24 19:31:30',
                               'lastactive' => '2015-12-24 19:31:30',
                               'confirmed' => 0,
                               'approved' => 1,
                               'admin' => 0,
                               'iterations' => 10000);

    $actual_partial = array_intersect_key($actual, $expected_partial);
    $this->assertEqual($expected_partial, $actual_partial);
    $this->assertEqual(64, strlen($actual['salt']));
    $this->assertEqual(64, strlen($actual['password']));
  }

  public function getUserByCredentials_byUsernameValid_returnsUser() {
    $registered_user = $this->registerValidUser();
    $loggedin_user = $this->userModel->getUserByCredentials("foo", "barbaz");
    $this->assertTrue(is_object($loggedin_user));
    $this->assertEqual($registered_user->toArray(), $loggedin_user->toArray());
  }

  public function getUserByCredentials_byEmailValid_returnsUser() {
    $registered_user = $this->registerValidUser();
    $loggedin_user = $this->userModel->getUserByCredentials("foo@bar.org",
                                                            "barbaz");
    $this->assertTrue(is_object($loggedin_user));
    $this->assertEqual($registered_user->toArray(), $loggedin_user->toArray());
  }

  public function getUserByCredentials_invalidPassword_returnsNull() {
    $registered_user = $this->registerValidUser();
    $loggedin_user = $this->userModel->getUserByCredentials("foo", "barbazx");
    $this->assertEqual(null, $loggedin_user);
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
