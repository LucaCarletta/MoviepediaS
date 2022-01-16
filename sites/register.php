<?php
include("../include/logger.inc.php");
include("../include/dbconnector.inc.php");
include("../include/session.inc.php");
$error="";
//"" damit es variabeln auf null setzt
$username=$firstname=$lastname=$email=$password=$moderator="";
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		// username
		if(isset($_POST['username'])){
			//trim
			$username =trim($_POST['username']);
			
			// prüfung benutzername
			if(empty($username)) {
				$error .= "The username is not in the right format.<br />";
			}
		} else {
			$error .= "Fill out a username.<br />";
		}

		if(isset($_POST['firstname'])){
			//trim
			$firstname = trim($_POST['firstname']);
			
			// prüfung vorname
			if(empty($firstname) || !preg_match("/(?=.*[a-z])[a-zA-Z]{3,30}/", $firstname)){
				$error .= "The firstname is not in the right format.<br />";
			}
		} else {
			$error .= "Fill out a firstname.<br />";
		}

		if(isset($_POST['lastname'])){
			//trim
			$lastname = trim($_POST['lastname']);
			
			// prüfung name
			if(empty($lastname) || !preg_match("/(?=.*[a-z])[a-zA-Z]{3,30}/", $lastname)){
				$error .= "The lastname is not in the right format.<br />";
			}
		} else {
			$error .= "Fill out a lastname.<br />";
		}

		if(isset($_POST['password'])){
			//trim
			$password = $_POST['password'];
			// passwort gültig?
			if(empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)){
				$error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
			}
		} else {
			$error .= "write your password.<br />";
		}

		if(isset($_POST['email'])){
			//trim
			$email = trim($_POST['email']);
			
			// prüfung email
			if(empty($email) || strlen($email)>100){
				$error .= "The email is not in the right format.<br />";
			}
		} else {
			$error .= "Fill out a email.<br />";
		}
			$moderator=false;
		$password=password_hash($password, PASSWORD_BCRYPT);
		if(empty($error)){
      
			$query = "INSERT INTO USERS (username, firstname,lastname, email, password, moderator) VALUE (?,?,?,?,?,?)"; 
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param('sssssi', $username, $firstname, $lastname, $email, $password, $moderator);
			$stmt->execute();
			$stmt->close();
			logger('User was created', $username);
			header('Location:./login.php');
		} else{
			logger($error, '');
		}
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
  <main><h1>
    Register
  </h1>
  <?php
  if(strlen($error)){
	  echo "<div class='alert alert-danger' role='alert' > ". $error." </div>";
  }
  ?>
  <form action="./register.php" method="post">

  <div class="form-group">
					<label for="username">Username *</label>
					<input type="text" name="username" class="form-control" id="username"
						value=""
						placeholder="capital- and lowercase letters, min 6 charachter. "
						title="capital- and lowercase letters, min 6 charachter."
						maxlength="30" 
						required="true">
				</div>

        <div class="form-group">
					<label for="firstname">firstname *</label>
					<input type="text" name="firstname" class="form-control" id="firstname"
						value=""
						placeholder="firstname"
						title="firstname"
						maxlength="30" 
						required="true">
				</div>

        <div class="form-group">
					<label for="lastname">Lastname *</label>
					<input type="text" name="lastname" class="form-control" id="lastname"
						value=""
						placeholder="lastname"			
						title="lastname"
						maxlength="30" 
						required="true">
				</div>

        <div class="form-group">
					<label for="password">Password *</label>
					<input type="password" name="password" class="form-control" id="password"
						placeholder="capital- and lowercase letters, numbers, specialsigns, min. 8 charachters. "
						pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
						title="capital- and lowercase letters, numbers, specialsigns, min. 8 charachters."
						maxlength="255"
						required="true">
				</div>

        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" name="email" class="form-control" id="email"
            placeholder="Enter yout Email adress."
            maxlength="100"
            required="true">
        </div>

		
		<button type="submit" name="button" value="submit" class="btn btn-info">Register</button>
		</form>
		</main>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>