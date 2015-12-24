<?php

class UserModel extends EntityModel {
  const CRYPTO_HASH_LENGTH = 64;
  const CRYPTO_ITERATIONS = 10000;
  const CRYPTO_SALT_BYTE_LENGTH = 32;
  const MIN_PASSWORD_LENGTH = 4;
  const REG_ERROR_CRYPTO_UNSAFE = 7;
  const REG_ERROR_EMPTY_FIELD = 2;
  const REG_ERROR_EXISTING_USER = 4;
  const REG_ERROR_INVALID_EMAIL = 8;
  const REG_ERROR_INVALID_INPUT_TYPE = 10;
  const REG_ERROR_INVALID_USERNAME = 9;
  const REG_ERROR_MISSING_FIELD = 1;
  const REG_ERROR_PASSWORD_MISMATCH = 3;
  const REG_ERROR_PASSWORD_TOO_SHORT = 6;
  const REG_ERROR_UNEXPECTED_ERROR = 5;

  // The credential can be email or username.
  public function getUserByCredentials($credential, $password) {
    $user = $this->findFirst(array('email' => $credential));

    if ($user == null)
      $user = $this->findFirst(array('username' => $credential));

    // Non existing credential.
    if ($user == null)
      return null;

    $authOk = $this->isValidPassword($user->toArray(),
                                     $password);

    if (!$authOk)
      return false;

    return $user;
  }

  // Register a new user.
  public function register($registrationData,
                           $confirmed = false,
                           $admin = false,
                           $now = null) {

    if (!is_array($registrationData))
      throw new Exception("The registration data must be an array.",
                          self::REG_ERROR_INVALID_INPUT_TYPE);

    if ($now === null)
      $now = now();

    // Filter out required fields.
    $expected_fields = array('username',
                             'name',
                             'surname',
                             'email',
                             'password',
                             'repeated_password');
    $registrationData = array_pick($registrationData, $expected_fields);

    // Check for missing and empty.
    foreach ($expected_fields as $field) {
      if (!array_key_exists($field, $registrationData))
        throw new Exception(
            "Missing expected field: $field for user registation.",
            self::REG_ERROR_MISSING_FIELD);

      if (empty($registrationData[$field]))
        throw new Exception("Required field '$field' is empty.",
                            self::REG_ERROR_EMPTY_FIELD);
    }

    // Check username.
    $username = trim(strtolower($registrationData['username']));
    if (!preg_match('/([a-z0-9_\.\-]){3,}/', $username)) {
      throw new  Exception("Username is in invalid format.",
                           self::REG_ERROR_INVALID_USERNAME);
    }

    // Check email.
    $email = trim(strtolower($registrationData['email']));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception('Invalid e-mail provided.',
                          self::REG_ERROR_INVALID_EMAIL);
    }

    // Check for password length.
    $min_length = self::MIN_PASSWORD_LENGTH;
    if (strlen(trim($registrationData['password'])) < $min_length) {
      throw new Exception(
          "Password is to short. Use at least $min_length chars.",
          self::REG_ERROR_PASSWORD_TOO_SHORT);
    }

    // Check for password match.
    if ($registrationData['repeated_password'] !=
        $registrationData['password']) {
      throw new Exception("Mismatch in provided passwords.",
                          self::REG_ERROR_PASSWORD_MISMATCH);
    }

    // TODO: Customize validating name and surname by preference.
    $name = $registrationData['name'];
    $surname = $registrationData['surname'];

    // Check for existing users.
    $search_filters = array('username' => $username,
                            'email' => $email);
    foreach ($search_filters as $field => $value) {
      $existing_count = $this->find(array($field => $value))->affected();

      if ($existing_count > 0)
        throw new Exception("User with $field already exists.",
                            self::REG_ERROR_EXISTING_USER);
    }

    $crypto_strong = false;
    $salt = bin2hex(openssl_random_pseudo_bytes(self::CRYPTO_SALT_BYTE_LENGTH,
                                                $crypto_strong));

    if ($crypto_strong === false) {
      throw new Exception(
          "Seems like openssl_random_pseudo_bytes is old on this system.",
          self::REG_ERROR_CRYPTO_UNSAFE);
    }
    $iterations = self::CRYPTO_ITERATIONS;

    $password_hash = $this->hashPassword($registrationData['password'],
                                         $salt,
                                         $iterations);

    $userData = array('username' => $username,
                      'name' => $name,
                      'email' => $email,
                      'surname' => $surname,
                      'password' => $password_hash,
                      'salt' => $salt,
                      'iterations' => $iterations,
                      'regdate' => $now,
                      'lastactive' => $now,
                      'confirmed' => intval($confirmed),
                      'admin' => intval($admin),
                      'approved' => 1);

    $id = $this->insert($userData);

    if ($id < 0)
      throw new Exception("Unable to register user",
                          self::REG_ERROR_UNEXPECTED_ERROR);

    return $this->findById($id);
  }

  private function hashPassword($password, $salt, $iterations) {
    if (strlen($salt) < 64 || $iterations < 1000)
      throw new Exception("Hash error.");

    return hash_pbkdf2('sha256', $password, $salt, $iterations,
                       self::CRYPTO_HASH_LENGTH);
  }

  private function isValidPassword($userData, $password) {
    $storedPasswordHash = $userData['password'];
    $enteredPasswordHash = $this->hashPassword($password,
                                               $userData['salt'],
                                               $userData['iterations']);

    return hash_equals($storedPasswordHash, $enteredPasswordHash);
  }

}
