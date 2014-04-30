<?php
//adodb
$path_to_adodb = "";
if ($path_to_adodb != "") {
	include($path_to_adodb);
}

//connections
$connect = array(
	"host" => "",
	"login" => "",
	"pass" => "",
	"db" => ""
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