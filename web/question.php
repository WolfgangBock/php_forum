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
  
  if(isset($_GET['thread_id'])){
    $question_id = $_GET['thread_id'];
    $question = get_question_by_id($question_id);
    $question = mysqli_fetch_assoc($question);
    
    $answers = get_answers($question_id);
    $row_count = mysqli_num_rows($answers);
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
    <title>Frage und Antworten</title>

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
      
      <!-- Einleitung mit Frage -->
      <div class="page-header">
        <h1><?php echo $question['title'] ?></h1>
        <p><?php echo $question['content'] ?></p>
        <?php if($logged_in && $question['owner'] == $user_id){ ?>
          <p>
            <a href="edit_question.php?thread_id=<?php echo $question['thread_id'] ?>">Frage editieren</a> / 
            <a href="delete_question.php?thread_id=<?php echo $question['thread_id'] ?>">Frage löschen</a>
          </p>
        <?php }?>
      </div> 
      <!-- Einleitung ENDE -->
        
      <!-- Inhalt -->
      <!-- Antworten -->  
      
      <?php
        if($row_count > 0){
      ?>
      <section class="list-group">
        <h3>Antworten <span class="badge"><?php echo $row_count ?></span></h3>
      <?php
          while ($answer = mysqli_fetch_assoc($answers)) { 
      ?>
        <!-- einzelne Antwort -->
        <article class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $answer['title'] ?></h4>
            <p class="list-group-item-text"><?php echo $answer['content'] ?></p>
            <?php if($logged_in && $answer['owner'] == $user_id){ ?>
              <p>
                <a href="edit_answer.php?thread_id=<?php echo $answer['thread_id'] ?>">Antwort editieren</a> / 
                <a href="delete_answer.php?thread_id=<?php echo $answer['thread_id'] ?>">Antwort löschen</a>
              </p>
            <?php }?>
          </article>
          <!-- einzelne Antwort ENDE -->
      <?php } ?>
      </section>
      <?php }else{ ?>
      <div class="alert alert-info" role="alert">
        <p>Zu dieser Frage gibt es noch keine Antwort.</p>  
      </div>    
      <?php } ?>
      <!-- Antworten ENDE -->
      <p><a href="write_answer.php?thread_id=<?php echo $question['thread_id'] ?>">Antwort hinzufügen</a></p>
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