<?php
  session_start();
	if(isset($_SESSION['userid'])){
    $user_id = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $logged_in = true;
    $log_in_out_text = "Logout";
	}else{
    $logged_in = false;
    $log_in_out_text = "Login";
  }
  include_once('system/data.php');
  
  $msg = "";
  $thread_deleted = false;
  
  if(isset($_GET['thread_id']) || isset($_POST['delete_id'])){
    
    if(isset($_GET['thread_id'])){ 
      $question_id = $_GET['thread_id'];
      $question = get_question_by_id($question_id);
      $question = mysqli_fetch_assoc($question);
    }
    
        
  }else{
    header("Location: index.php");
  }
  
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Frage löschen</title>

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
          <li role="presentation"><a href="login.php"><?php echo $log_in_out_text ?></a></li>
        </ul>
      </nav>
      <!-- Menü ENDE -->

    <?php if(!$thread_deleted){ ?>  
      <!-- Einleitung mit Frage -->
      <div class="page-header">
        <h1>Sie möchten folgende Frage und alle zugehörigen Antworten löschen</h1>
        <h2><?php echo $question['title'] ?></h2>
        <p><?php echo $question['content'] ?></p>
      </div> 
      <!-- Einleitung ENDE -->
      <!-- Formular zum löschen der Antwort -->
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="delete_id" value="<?php echo $question['thread_id'] ?>">
        <input type="submit" name="question_delete" class="btn btn-danger" value="Frage und alle zugehörigen Antworten löschen">
      </form>
      <!-- Formular zum löschen der Antwort ENDE -->
    <?php }?>
      
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

    <!-- Fusszeile (mit angepasster CSS) -->
    <footer class="footer">
      <div class="container">
    <?php if($logged_in){ ?>
          Hallo <?php echo $username ?>, du kannst Fragen und Antworten bearbeiten. | 
          Eingeloggt als <?php echo $firstname . " " . $lastname ?>.
    <?php }else{ ?>
          Um Fragen oder Antworten zu bearbeiten <a href='login.php'>loggen Sie sich bitte ein</a>.
    <?php }?>
      </div>
    </footer>
    <!-- Fusszeile ENDE -->
    
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>