<?php

	define('DB_SERVER', '127.0.0.1');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'todolista');
	
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if($link === false){
		die("GREŠKA: Nije uspostavljena veza" . mysqli_connect_error());
	}
	mysqli_set_charset($link, "utf8");
	
	
?>
