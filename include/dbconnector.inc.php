<?php 
  $host = 'localhost';
  $username = 'moviepedia_user';
  $password = 'M0vi3p3di@';
  $database = 'moviepedia';
  
  $mysqli = new mysqli($host, $username, $password, $database);
 
  if ($mysqli->connect_error) {  
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
  }
?>