<?php
	date_default_timezone_set('Asia/Calcutta');
	setlocale(LC_MONETARY, 'en_IN');
	header('charset=utf-8');

	$server = "localhost";
	$sqlid = "USERNAME";
	$sqlpass = "PASSWORD";
	$dbase = "DATABASENAME";
	$mysqli = new mysqli($server, $sqlid, $sqlpass, $dbase);
	if (mysqli_connect_errno()){
		echo "ERROR: <br>Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$DB_TABLE_NAME = "TUPLENAME";

	$GLOBALS["TG_BOT_TOKEN"] = "";

	$GLOBALS["TG_ADMIN_IDS"] = array(
		"",
		"",
		""
	);

	$GLOBALS["Welcome_MessAge"] = "";

?>
