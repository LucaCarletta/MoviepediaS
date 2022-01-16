<?php
  include("../include/logger.inc.php");
  include("../include/dbconnector.inc.php");
  include("../include/session.inc.php");
  if(isMod()){
    $page = "";
    // ob get abfrage ist
    if($_SERVER["REQUEST_METHOD"] == "GET"){
      $query = "DELETE FROM pages WHERE id = ?"; 
      $id = $_GET['id'];
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->close();
      logger('deleted a Page', $_SESSION['username']);
    } 
  } else {
    logger('tried to delete a Page', $_SESSION['username']);
  }
  header("Location:./home.php");
?>