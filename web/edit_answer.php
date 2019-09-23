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
  $answer_valid = true;
  
  if(isset($_GET['thread_id']) || isset($_POST['thread_id'])){
    if(isset($_GET['thread_id'])) $question_id = $_GET['thread_id'];
    if(isset($_POST['thread_id'])){
      $question_id = $_POST['thread_id'];
      include_once('system/security.php');
    
      if(!empty($_POST['answer_title'])){
        $answer_title = sql_injection_filter($_POST['answer_title']);
      }else{
        $msg .= "Bitte geben Sie einen Antworttitel an.<br>";
        $answer_valid = false;
      }
      
      if(!empty($_POST['answer_content'])){
        $answer_content = sql_injection_filter($_POST['answer_content']);
      }else{
        $msg .= "Bitte geben Sie einen Antworttext ein.<br>";
        $answer_valid = false;
      }  
      
      
      
      // Daten in die Datenbank schreiben ******************************************************
      
      if($answer_valid){
        if($logged_in){
          $result = update_question($answer_title, $answer_content, $question_id);
          
          if($result){
            $msg .= "Sie haben die Antwort erfolgreich editiert.</br>";
          }else{
            $msg .= "Es gibt ein Problem mit der Datenbankverbindung.</br>";
          }
        }else{
          $msg .= "Sie haben nicht die erforderliche Berechtigung diese Antwort zu beantworten.</br>";
        }
      }
    }
    $answer_result = get_question_by_id($question_id);
    $answer = mysqli_fetch_assoc($answer_result);
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
    <title>Antwort bearbeiten</title>

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
        <h1>Antwort bearbeiten</h1>
      </div> 
      <!-- Einleitung ENDE --> 
      
      <!-- Inhalt -->
      <!-- Formular für editieren einer Frage -->  
      <section>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <input type="hidden" name="thread_id" value="<?php echo $question_id ?>">
          <div class="form-group">
            <label for="form_title">Titel der Antwort </label>
            <input type="text" name="answer_title" class="form-control" id="form_title" value="<?php echo $answer['title'] ?>">
          </div>
          <div class="form-group">
            <label for="form_content">Inhalt der Antwort </label>
            <textarea type="text" name="answer_content" class="form-control" id="form_content"><?php echo $answer['content'] ?></textarea>
          </div>
          <input type="submit" name="answer_submit" class="btn btn-default" value="Antwort aktualisieren">
        </form>
      </section>
      <!-- Formular für editieren einer Frage ENDE -->
      
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