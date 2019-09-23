<?php
  session_start();
  if(isset($_SESSION['userid'])) unset($_SESSION['userid']);
  session_destroy();
  
  if(isset($_POST['login_submit'])){
    include_once('system/security.php');
    
    $username = sql_injection_filter($_POST['username']);
    $password = sql_injection_filter($_POST['password']);
    
    include_once('system/data.php');
    $result = login($username , $password);
    
    $row_count = mysqli_num_rows($result);
    
    if($row_count == 1){
      session_start();
      $user = mysqli_fetch_assoc($result);
      $_SESSION['userid'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['firstname'] = $user['firstname'];
      $_SESSION['lastname'] = $user['lastname'];
      header('Location: index.php');
    }else{
      $msg = "leider falsch.";
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
    <title>Login</title>

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
          <li role="presentation" class="active"><a href="login.php">Login</a></li>
          <li role="presentation"><a href="register.php">Anmeldung</a></li>
        </ul>
      </nav>
      <!-- Menü ENDE -->
      
      
      <section class="msg">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group">
          <label for="id_username">Username: </label>
            <input type="text" name="username" class="form-control" id="id_username">
          </div>
          <div class="form-group">
          <label for="id_password">Passwort: </label> 
            <input type="password" name="password" class="form-control" id="id_password">
          </div>
          <input type="submit" name="login_submit" class="btn btn-default" value="einloggen">
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