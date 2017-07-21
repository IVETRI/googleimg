<?php
	date_default_timezone_set('Asia/Calcutta');
	setlocale(LC_MONETARY, 'en_IN');
	header('charset=utf-8');

	if(isset($_REQUEST['d'])){
		if($_REQUEST['d'] == 1){
			ini_set('display_errors', 1);
			error_reporting(-1);
		}
	}

	$server = "localhost";
	$sqlid = "USERNAME";
	$sqlpass = "PASSWORD";
	$dbase = "DATABASENAME";
	$mysqli = new mysqli($server, $sqlid, $sqlpass, $dbase);
	if (mysqli_connect_errno()){
		echo "ERROR: <br>Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$DB_TABLE_NAME = "TUPLENAME";

	$GLOBALS["GOOGLE_CSE_API_CX"] = "";
	$GLOBALS["GOOGLE_CSE_API_KEY"] = "";

	$GLOBALS["TG_BOT_TOKEN"] = "";

	$GLOBALS["TG_ADMIN_IDS"] = array(
		"",
		"",
		""
	);

	require_once __DIR__ . '/Telegram.php';
	require_once __DIR__ . '/functions.php';
?>
