<?php
//Edit this file and rename it "setup.php"

//Initialise Instagram class
require 'include/Instagram.php';
use MetzWeb\Instagram\Instagram;

$instagram = new Instagram(""); //insert Instagram Client ID here from https://instagram.com/developer/clients/manage/

/*
//accesstoken is not required for public accounts
$accesstoken=""; //insert Instagram OAuth token
$instagram->setAccessToken($accesstoken);
*/

//Initialise database connection
function newDB() {
  try {
    $dbname = "";
    $user = "";
    $pass = "";
    $dsn = "mysql:host=localhost;dbname=$dbname";

    $conn = new PDO($dsn,$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec('SET NAMES "utf8"');
    return $conn;
  }
  catch (PDOException $e) {
    $error = 'Unable to connect to the database server. ';
    echo $error;
    echo $e->getMessage();
    exit();
  }
}
?>
