<?php
  include_once '../vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';
  csrfProtector::init();
  session_start();
  session_regenerate_id(true);

  function loginUser($username, $mod, $id) {
    //Logger 
    logger('User logged in',$username);
    $_SESSION['username'] = $username;
    $_SESSION['mod'] = $mod;
    $_SESSION['id'] = $id;
  }

  function isLoggedIn() {
    return isset($_SESSION['username']);
  }

  function isMod() {
    return isset($_SESSION['mod'])&&$_SESSION['mod']?true:false;
  }

  function logOut() {
    logger('User logged out',$_SESSION['username']);
    session_destroy();
  }
?>