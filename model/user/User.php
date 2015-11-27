<?php

class User extends Entity {

  public
      /** Integer(4) Unsigned() PrimaryKey() **/
      $id,

      /** VarChar(64) **/
      $username,

      /** VarChar(64) **/
      $name,

      /** VarChar(64) **/
      $surname,

      /** VarChar(64) **/
      $email,

      /** Integer(1) Unsigned() **/
      $zatemas_admin,

      /** Integer(1) Unsigned() **/
      $zatemas_contest_admin;

  // Whether user can access all data.
  public function isSuperUser() {
    return $this->zatemas_admin && $this->zatemas_contest_admin;
  }

  public function isContestAdmin() {
      return $this->zatemas_contest_admin == 1;
  }

  public function toArraySafe() {
    return array(
      "id" => $this->id,
      "username" => $this->username,
      "name" => $this->name,
      "surname" => $this->surname,
      "email" => $this->email);
  }
}
