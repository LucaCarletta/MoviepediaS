<?php
  include("../include/session.inc.php");
  include("../include/dbconnector.inc.php");
  //auf null setztn
  $error = '';
  $title = $content = '';
  if(!isLoggedIn()){
    //auf login page wenn nicht eingelogt
    header('Location:./login.php');
  }
//ob gepostet worden sit, methode überprüfen
if($_SERVER['REQUEST_METHOD'] == "POST"){

  // title is set, min 1 + max 60 chars long
  if(isset($_POST['title']) && !empty(trim($_POST['title'])) && strlen(trim($_POST['title'])) <= 60){
    // escape spezial chars -> prohibit Script incection
    $title = htmlspecialchars(trim($_POST['title']));
  } else {
    $error .= "Please Enter a Valid Title.<br />";
  }

  // content is set, min 80 Chars long
  if(isset($_POST['content']) &&  strlen(trim($_POST['content'])) >= 80){
    // escape spezial chars -> prohibit Script incection
    $content = htmlspecialchars(trim($_POST['content']));
  } else {
    $error .= "Please Enter a Valid Text.<br />";
  }
  //wenn kein fehler
  if(empty($error)){
    $approved = true;
    //user von session
    $id = $_SESSION['id'];
    //schreibt in datenbank
    $query = "INSERT INTO PAGES (title, text, approved, author) VALUE (?,?,?,?)"; 
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssii', $title, $content, $approved, $id);
    $stmt->execute();
    $stmt->close();
    header('Location:./home.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/header.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/yourcode.js"></script>
  <title>Moviepedia</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
  <a class="navbar-brand" href="../sites/home.php">Moviepedia</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
      if(isLoggedIn()){
        $tabs='<li class="nav-item active">
          <a class="nav-link" href="../sites/create.php">Create Page<span class="sr-only">(current)</span></a>
          </li>';
        if(isMod()){
          $tabs.='<li class="nav-item active">
            <a class="nav-link" href="../sites/sign.php">Sign Pages<span class="sr-only">(current)</span></a>
            </li>';
        }
        $tabs.='<li class="nav-item active">
          <a class="nav-link" href="../sites/account.php">Account<span class="sr-only">(current)</span></a>
          </li>';
        echo $tabs;
      } else {
        echo('<li class="nav-item active">
        <a class="nav-link" href="../sites/login.php">Log In <span class="sr-only">(current)</span></a>
        </li>');
      }

      ?>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
  <main>
    <h1>Create</h1>
    <div class="container">
      <?php
      //errormeldungen wenn nicht richtig eingabe in feld
        if(!empty($error)){
          echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
        }
      ?>
      <form action="./create.php" method="post">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" name="title" class="form-control" id="title"
                  value="<?php echo $title ?>"
                  placeholder="Enter a Title"
                  maxlength="60"
                  required="true">
        </div>
        <div class="form-group">
          <label for="content">Content</label>
          <textarea class="form-control" name="content" id="content" cols="70" minlength="80" rows="8" required><?php echo $content?></textarea>
        </div>
        
        <button type="submit" name="button" value="submit" class="btn btn-dark btn-outline">Senden</button>
      </form>
    </div>


  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>