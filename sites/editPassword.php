<?php
include("../include/dbconnector.inc.php");
include("../include/session.inc.php");
include("../include/logger.inc.php");
if(isLoggedIn()){
$error="";
$oldPassword=$newPassword="";
$username = $_SESSION['username'];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      // oldPassword
      if(isset($_POST['oldPassword'])){
        $oldPassword = $_POST['oldPassword'];
        // passwort gültig?
      } else {
        $error .= "Fill out your current password.<br />";
      }

      // newPassword
      if(isset($_POST['newPassword'])){
        $newPassword = $_POST['newPassword'];
        // passwort gültig?
        if(empty($oldPassword) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $newPassword)){
          $error .= "The new password is not in the right format.<br />";
        }
      } else {
        $error .= "Fill out new password.<br />";
      }
      
      // kein fehler
      if(empty($error)){
      
        $query = "SELECT * FROM users WHERE username =?";
        $loginstmt = $mysqli->prepare($query);
        $loginstmt->bind_param('s', $username);
        $loginstmt->execute();
    
        //get_result: bekommt resultat von statemant zurück
        $result = $loginstmt->get_result();
        if($result->num_rows){
          while ($row = $result->fetch_assoc()){
            //überprüft ob Passswort übereinstimmt
            //password_verify: $passwoerd wo man in loginpage eingegeben hat $row... das wo in datenbank steht(gehashed ). passowrt überprüfen
            if(password_verify($oldPassword, $row['password'])){
                $loginstmt->close();
                $id = $_SESSION['id'];
                $changeQuery = "UPDATE users SET password=? WHERE id = ?";
                $newPassword=password_hash($newPassword, PASSWORD_BCRYPT);
                $changestmt = $mysqli->prepare($changeQuery);
                $changestmt->bind_param('si', $newPassword, $id);
                $changestmt->execute();
                $changestmt->close();
                logger('Password changed', $username);
                header("Location:./account.php");
            }
            else{
              $error .= "Login is wrong";
              logger($error, $username);
            }
          } 
        }else{
          $error .= "Login is wrong";
          logger($error, $username);
        }
      }else{
        logger($error, $username);
      }
    }
  } else{
    logger('Loggout User tried edit Password', '');
    header("Location:./login.php");
  }
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
    <h1>Change Password</h1>
    <?php
        if(!empty($error)){
          echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
        }
      ?>
    <form action="./editPassword.php" method="post">
        <div class="form-group">
					<label for="oldPassword">Current Password</label>
					<input type="password" name="oldPassword" class="form-control" id="oldPassword"
						placeholder="Current Password"
						title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
						maxlength="255"
						required="true">
				</div>
        <div class="form-group">
					<label for="newPassword">New Password</label>
					<input type="password" name="newPassword" class="form-control" id="newPassword"
						placeholder="capital- and lowercase letters, numbers, special letters, min. 8 charachter"
						pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
						title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
						maxlength="255"
						required="true">
				</div>

        <button type="submit" name="button" value="submit" class="btn btn-info">Change Password</button>
</form>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>