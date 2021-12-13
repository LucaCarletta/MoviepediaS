<?php
  include("../include/dbconnector.inc.php");

  $page = "";
  // ob get abfrage ist
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    $query = "DELETE FROM pages WHERE id = ?"; 
    $id = $_GET['id'];
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
  } 
  header("Location:./home.php");
?>