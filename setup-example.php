<?php
//Copy this file to setup.php for your local configuration

//basic Javascript config section
$jsconfig = "<script>
var minFade = 0.45; //minimum desired opacity of images (0 to 1)
var fadeDuration = 500; //time taken by fade effect (milliseconds)
var brightDuration = 15000; //time each image will be at 100% opacity (milliseconds)
var nextDelay = 400; //delay between animations (milliseconds)
var loadingTimeout = 7000; //time until images that have not loaded are disabled (milliseconds)
var refreshTimer = 180000; //time until feed refreshes (milliseconds)
var timeoutImage = 'images/no_image.svg';
</script>";

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
