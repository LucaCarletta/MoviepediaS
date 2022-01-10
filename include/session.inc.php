<?php
  include_once '../vendor/owasp/csrf-protector-php/libs/csrf/csrfprotector.php';
  csrfProtector::init();
  session_start();
  session_regenerate_id(true);

  function loginUser($username, $mod, $id) {
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
    session_destroy();
  }
?>