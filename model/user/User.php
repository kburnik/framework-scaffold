<?php

class User extends Entity {

public
      /** Integer(4) Unsigned() PrimaryKey() **/
      $id
    ,
      /** VarChar(32) **/
      $username
    ,
      /** VarChar(32) **/
      $name
    ,
      /** VarChar(32) **/
      $surname
    ,
      /** VarChar(128) **/
      $email
    ,
      /** DateTime() **/
      $regdate
    ,
      /** DateTime() **/
      $lastactive
    ,
      /** Integer(1) **/
      $confirmed
    ,
      /** Integer(1) **/
      $approved
    ,
      /** Integer(1) **/
      $admin
    ,
      /** VarChar(64) **/
      $salt
    ,
      /** Integer(4) **/
      $iterations
    ,
      /** VarChar(64) **/
      $password
  ;

  // Whether user can access all data.
  public function isSuperUser() {
    return $this->admin;
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
