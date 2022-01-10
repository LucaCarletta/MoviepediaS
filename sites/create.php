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
    $id = $_SESSION['id'];
    if(isset($_FILES['image'])){
      echo($_FILES);
      $output_dir = "../upload/";
      $randomNum = time();
	    $ImageName = str_replace(' ','-',strtolower($_FILES['image']['name'][0]));
	    $ImageType = $_FILES['image']['type'][0];
 
	    $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
	    $ImageExt       = str_replace('.','',$ImageExt);
	    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
	    $NewImageName = $ImageName.'-'.$randomNum.'.'.$ImageExt;
      $ret[$NewImageName]= $output_dir.$NewImageName;
	
	    /* Try to create the directory if it does not exist */
	    if (!file_exists($output_dir)){
		    @mkdir($output_dir, 0777);
	    }
      move_uploaded_file($_FILES["image"]["tmp_name"][0],$output_dir."/".$NewImageName );
      $query = "INSERT INTO PAGES (title, text, image) VALUE (?,?,?)"; 
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('sss', $title, $content, $NewImageName);
	  } else{
      $query = "INSERT INTO PAGES (title, text) VALUE (?,?)"; 
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('ss', $title, $content );
    }
    $stmt->execute();
    $stmt->close();
    //header('Location:./home.php');
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
      <form action="./create.php" method="post" enctype="multipart/form-data">
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
         <div class="form-group">
          <label for="image">Image</label>
          <input type="file" name="image[]" class="form-control" id="image">
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