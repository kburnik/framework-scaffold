<?php

$dependencies = array('userModel' => 'UserModel');

return array(
   '/' => array('IndexController', array_merge($dependencies, array())),

    '\/login\/' => array('AccountController', array(
      'username' => $_POST['username'],
      'password' => $_POST['password'],
      'redirect' => $_POST['redirect'],
      'userModel' => 'UserModel'
    ),
    $_POST['redirect']
   ),

   '\/logout\/' => array('AccountController', array_merge($dependencies, array(
      'logout' => true,
      'redirect' => $_GET['redirect'],
    )),
    ($_GET['redirect']) ? $_GET['redirect'] : "/"
   ),
);
