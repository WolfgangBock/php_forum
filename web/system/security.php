<?php 
  require_once("data.php");
	
	function sql_injection_filter($input){
		$db = get_db_connection();
		
		// HTML- und PHP-Codes wegfiltern: strip_tags(variable)
		// http://php.net/manual/de/function.strip-tags.php
		$input = strip_tags($input);
		// Leerzeichen am Anfang und Ende der Zeichenkette entfernen
		// http://php.net/manual/de/function.trim.php
		$input = trim($input);
		// SQL-Injection (einschmggeln von SQL-Befehlen) verhindern
		// http://php.net/manual/de/mysqli.real-escape-string.php
		$input = mysqli_real_escape_string($db, $input);
		mysqli_close($db);
		return $input;
	}
?>