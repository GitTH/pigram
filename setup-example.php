<?php
//Edit this file and rename it "setup.php"

//adodb
$path_to_adodb = "PATH_TO_ADODB";
if ($path_to_adodb != "" && $path_to_adodb != "PATH_TO_ADODB") {
	include($path_to_adodb);
}

//database
function newDB() {
	$conn = ADONewConnection('mysqlt');
	if (!$conn->Connect("HOST","LOGIN","PASSWORD","DATABASE")) {
		exit;
		return false;
	} else {
		return $conn;
	}
}
?>