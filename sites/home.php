<?php 
//Session brauchen wir für header ob eingeloggt
include("../include/session.inc.php");
//verbindung zu datenbank
include("../include/dbconnector.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Moviepedia</title>
</head>
<body>
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
  <a class="navbar-brand" href="../sites/home.php">Moviepedia</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
      //ist eingeloggt?
      if(isLoggedIn()){
        //tabs
        $tabs='<li class="nav-item active">
          <a class="nav-link" href="../sites/create.php">Create Page<span class="sr-only">(current)</span></a>
          </li>';
        $tabs.='<li class="nav-item active">
          <a class="nav-link" href="../sites/account.php">Account<span class="sr-only">(current)</span></a>
          </li>';
        echo $tabs;
        //weniger angezeigt wenn nicht eingeloggt
      } else {
        echo('<li class="nav-item active">
        <a class="nav-link" href="../sites/login.php">Log In <span class="sr-only">(current)</span></a>
        </li>');
      }

      ?>
    </ul>
  </div>
</nav>
  <main>
    <h1>Home</h1>
    <?php 
      //Datenbankverbindung
      $query = "SELECT * FROM pages"; 
      //vorbereiten
      $result = $mysqli->query($query);
      if($result->num_rows){
        //holt alle pages. fetch_assoc hot daten
        while ($page = $result->fetch_assoc()){
          //gibt link zu den webseiten an
          echo("<div class='container'>
                  <a href='./page.php?id=".$page['id']."'>".$page['title']."</a>
                </div>");
        }
      }
     
    ?>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>