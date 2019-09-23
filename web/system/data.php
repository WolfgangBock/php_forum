<?php
	/* *******************************************************************************************************
	/* data.php regelt die DB-Verbindung und fast den gesammten Datenverkehr der Site.
	/* So ist die gesammte Datenorganisation an einem Ort, was den Verwaltungsaufwand erheblich verringert.
	/*
	/* *******************************************************************************************************/

	/* *******************************************************************************************************
	/* get_db_connection()
	/*
	/* liefert als Rückgabewert die Datenbankverbindung
	/* hier werden für die gesammte Site die DB-Verbindungsparameter angegeben.
	/* 	"SET NAMES 'utf8'"  :	Sorgt dafür, dass alle Zeichen als UTF8 übertragen und gespeichert werden.
	/*							http://www.lightseeker.de/wunderwaffe-set-names-set-character-set/
	/* *******************************************************************************************************/
	function get_db_connection()
	{
    $db = mysqli_connect('localhost', 'root', '', 'forum');
    if (mysqli_connect_error()) {
        die('Verbindungsfehler (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    mysqli_query($db, "SET NAMES 'utf8'");
		return $db;
	}

	/* *******************************************************************************************************
	/* get_result($sql)
	/*
	/* Führt die SQL-Anweisung $sql aus, liefert das Ergebnis zurück und schliesst die DB-Verbindung
	/* Alle Weiteren Funktionen rufen get_result() auf.
	/* *******************************************************************************************************/
	function get_result($sql)
	{
		$db = get_db_connection();
    // echo $sql ."<br>";
		$result = mysqli_query($db, $sql);
		mysqli_close($db);
		return $result;
	}


	/* *********************************************************
	/* Login
	/* ****************************************************** */

	function login($username , $password){
		$sql = "SELECT * FROM user WHERE username='$username' AND password='$password';";
		return get_result($sql);
	}

	
	/* *********************************************************
	/* Register
	/* ****************************************************** */

	function register($username , $password, $email, $firstname, $lastname){
    $sql = "INSERT INTO user (username, password, email, firstname, lastname) VALUES ('$username', '$password', '$email', '$firstname', '$lastname');";
		return get_result($sql);
	}

	
	/* *********************************************************
	/* Fragen
	/* ****************************************************** */

	function show_all_questions(){
		$sql = "SELECT * FROM threads WHERE parent_thread_id = 0;;";
		return get_result($sql);
	}

	function get_question_by_id($id){
		$sql = "SELECT * FROM threads WHERE thread_id=$id;";
		return get_result($sql);
	}

	function get_answers($id){
		$sql = "SELECT * FROM threads WHERE parent_thread_id=$id;";
		return get_result($sql);
	}

	function write_question($title, $question){
    $sql = "INSERT INTO threads (title, content) VALUES ('$title', '$question');";
		return get_result($sql);
	}

	function write_answer($title, $answer_content, $parent_question_id){
    $sql = "INSERT INTO threads (title, content, parent_thread_id) VALUES ('$title', '$answer_content', $parent_question_id);";
		return get_result($sql);
	}

	function write_question_login($title, $question, $owner_id = 0){
    $sql = "INSERT INTO threads (title, content, owner) VALUES ('$title', '$question', $owner_id);";
		return get_result($sql);
	}

	function write_answer_login($title, $answer_content, $parent_question_id, $owner_id = 0){
    $sql = "INSERT INTO threads (title, content, parent_thread_id, owner) VALUES ('$title', '$answer_content', $parent_question_id, $owner_id);";
		return get_result($sql);
	}

	function update_question($title, $question, $thread_id){
    $sql = "UPDATE threads SET title='$title', content='$question' WHERE thread_id=$thread_id;";
		return get_result($sql);
	}

	function delete_thread($thread_id){
    $sql = "DELETE FROM threads WHERE thread_id=$thread_id;";
		return get_result($sql);
	}
	
	
	
	