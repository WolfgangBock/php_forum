<?php
  // Prüfung aller Formularfelder auf Inhalt. **********************************************
  // Die Datenbank erlaubt keine NULL-Werte.
  
  $msg = "";
  $register_valid = true;
  
  if(isset($_POST['register_submit'])){
    include_once('system/security.php');
    
    if(!empty($_POST['username'])){
      $username = sql_injection_filter($_POST['username']);
    }else{
      $msg .= "Bitte geben Sie einen Username ein.<br>";
      $register_valid = false;
    }
    
    if(!empty($_POST['password'])){
      $password = sql_injection_filter($_POST['password']);
    }else{
      $msg .= "Bitte geben Sie ein Passwort ein.<br>";
      $register_valid = false;
    }  
    
    if(!empty($_POST['confirm_password'])){
      $confirm_password = sql_injection_filter($_POST['confirm_password']);
    }else{
      $msg .= "Bitte bestätigen Sie das Passwort.<br>";
      $register_valid = false;
    } 
  
    if(!empty($_POST['email'])){
      $email = sql_injection_filter($_POST['email']);
    }else{
      $msg .= "Bitte geben Sie Ihre E-Mail-Adresse ein.<br>";
      $register_valid = false;
    } 
  
    if(!empty($_POST['firstname'])){
      $firstname = sql_injection_filter($_POST['firstname']);
    }else{
      $msg .= "Bitte geben Sie Ihren Vornamen ein.<br>";
      $register_valid = false;
    }
  
    if(!empty($_POST['lastname'])){
      $lastname = sql_injection_filter($_POST['lastname']);
    }else{
      $msg .= "Bitte geben Sie Ihren Nachnamen ein.<br>";
      $register_valid = false;
    }
    
    if(isset($password) && isset($confirm_password) && $password != $confirm_password){
      $msg .= "Passwort und Passwortbestätigung stimmen nicht überein.<br>";
      $register_valid = false;
    }
    
    // Daten in die Datenbank schreiben ******************************************************
    
    if($register_valid){
      include_once('system/data.php');
      $result = register($username , $password, $email, $firstname, $lastname);
      
      if($result){
        $msg = "Sie haben erfolgreich registriert.</br>
        <a href='login.php'>Bitte loggen Sie sich jetzt ein.</a></br>";
      }else{
        $msg .= "Es gibt ein Problem mit der Datenbankverbindung.</br>";
      }
    }
    
  }
  
  
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Anmeldung</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- eigene CSS -->
    <link href="css/forum.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Inhalt mit Navigation -->
    <div class="container">
      <!-- Menü -->
      <nav>
        <ul class="nav nav-tabs">
          <li role="presentation"><a href="index.php">Fragenübersicht</a></li>
          <li role="presentation"><a href="login.php">Login</a></li>
          <li role="presentation" class="active"><a href="register.php">Anmeldung</a></li>
        </ul>
      </nav>
      <!-- Menü ENDE -->
      
      <section class="msg">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group">
            <label for="id_username">Username: </label>
            <input type="text" name="username" id="id_username" class="form-control" value="<?php if(isset($username)) echo $username; ?>">
          </div>
          <div class="form-group">
            <label for="id_password">Passwort: </label>
            <input type="password" name="password" id="id_password" class="form-control" >
          </div>
          <div class="form-group">
            <label for="id_confirm_password">Passwort bestätigen: </label>
            <input type="password" name="confirm_password" id="id_confirm_password" class="form-control" >
          </div>
          <div class="form-group">
            <label for="id_email">E-Mail: </label>
            <input type="email" name="email" id="id_email" class="form-control" value="<?php if(isset($email)) echo $email; ?>">
          </div>
          <div class="form-group">
            <label for="id_firstname">Vorname: </label>
            <input type="text" name="firstname" id="id_firstname" class="form-control" value="<?php if(isset($firstname)) echo $firstname; ?>"> 
            </div>
          <div class="form-group">
            <label for="id_lastname">Nachname: </label>
            <input type="text" name="lastname" id="id_lastname" class="form-control" value="<?php if(isset($lastname)) echo $lastname; ?>">
          </div>
          <input type="submit" name="register_submit" class="btn btn-default" value="registrieren">
        </form>
      </section>
  
      <!-- optionale Nachricht (mit angepasster CSS) -->
    <?php if(!empty($msg)){ ?>
        <div class="alert alert-info msg" role="alert">
          <p><?php echo $msg ?></p>
        </div>
    <?php } ?>
      <!-- optionale Nachricht ENDE -->
      <!-- Inhalt ENDE -->
    </div>
    <!-- Inhalt mit Navigation ENDE -->

       
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>