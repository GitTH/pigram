<?php
//adodb
$path_to_adodb = "PATH_TO_ADODB";
if ($path_to_adodb != "" && $path_to_adodb != "PATH_TO_ADODB") {
	include($path_to_adodb);
}

//connections
$connect = array(
	"host" => "HOST",
	"login" => "LOGIN",
	"pass" => "PASS",
	"db" => "DB"
);
function newDB() {
	$conn = &ADONewConnection('mysqlt');
	if ( ! $conn->Connect($connect['host'],$connect['login'],$connect['pass'],$connect['db']) ) {
		exit;
		return false;
	} else {
		return $conn;
	}
}
?>