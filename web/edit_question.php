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
  $question_valid = true;
  
  if(isset($_GET['thread_id']) || isset($_POST['thread_id'])){
    if(isset($_GET['thread_id'])) $question_id = $_GET['thread_id'];
    if(isset($_POST['thread_id'])){
      $question_id = $_POST['thread_id'];
      include_once('system/security.php');
    
      if(!empty($_POST['question_title'])){
        $question_title = sql_injection_filter($_POST['question_title']);
      }else{
        $msg .= "Bitte geben Sie einen Fragetitel an.<br>";
        $question_valid = false;
      }
      
      if(!empty($_POST['question_content'])){
        $question_content = sql_injection_filter($_POST['question_content']);
      }else{
        $msg .= "Bitte geben Sie einen Fragetext ein.<br>";
        $question_valid = false;
      }  
      
      
      
      // Daten in die Datenbank schreiben ******************************************************
      
      if($question_valid){
        if($logged_in){
          $result = update_question($question_title, $question_content, $question_id);
          
          if($result){
            $msg .= "Sie haben die Frage erfolgreich editiert.</br>";
          }else{
            $msg .= "Es gibt ein Problem mit der Datenbankverbindung.</br>";
          }
        }else{
          $msg .= "Sie haben nicht die erforderliche Berechtigung diese Frage zu beantworten.</br>";
        }
      }
    }
    $question = get_question_by_id($question_id);
    $question = mysqli_fetch_assoc($question);
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
    <title>Frage bearbeiten</title>

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
      
      <!-- Einleitung -->
      <div class="page-header">
        <h1>Frage bearbeiten</h1>
      </div> 
      <!-- Einleitung ENDE --> 
      
      <!-- Inhalt -->
      <!-- Formular für neue Frage -->  
      <section>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <input type="hidden" name="thread_id" value="<?php echo $question_id ?>">
          <div class="form-group">
            <label for="form_title">Titel der Frage </label>
            <input type="text" name="question_title" class="form-control" id="form_title" value="<?php echo $question['title'] ?>">
          </div>
          <div class="form-group">
            <label for="form_content">Inhalt der Frage </label>
            <textarea type="text" name="question_content" class="form-control" id="form_content"><?php echo $question['content'] ?></textarea>
          </div>
          <input type="submit" name="question_submit" class="btn btn-default" value="Frage aktualisieren">
        </form>
      </section>
      <!-- Formular für neue Frage ENDE -->
      
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