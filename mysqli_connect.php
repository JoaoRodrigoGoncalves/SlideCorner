<?php
	define('db_host', 'localhost');
	define('db_user', 'root');
	define('db_password', '');
	define('db_name', 'webdata');

	//faz a ligação

	$dbcon = @mysqli_connect (db_host, db_user, db_password, db_name) or die ('Não foi possivel ligar á database: '. mysqli_connect_error() );

	//charset

	mysqli_set_charset($dbcon, 'utf8');

?>
