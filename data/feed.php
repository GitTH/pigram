<?php
include("../setup.php");

//how many images should we get?
if ($_REQUEST['images_to_get'] != '') {
	$images_to_get = $_REQUEST['images_to_get'];
} else {
	$images_to_get = 84;
}

//get the feed
$db = newDB();
$feed_sql = "SELECT `i`.* FROM `social_instagram` as `i` WHERE `i`.`active` = 'Y' AND `i`.`type` = 'image' ORDER BY `i`.`time_subscription_unix` DESC LIMIT 0,$images_to_get";
$feed = $db->GetAll($feed_sql);
//print_r($feed);

//lets loop through to see if they exist
$cnt = 0;
foreach($feed as $f) {
	$pigram[$cnt]['url'] 			= $f['images_low_resolution'];
	$pigram[$cnt]['instagram_id'] 	= $f['instagram_id'];
	$cnt++;
}

//echo the json feed
header('Content-Type: application/json');
echo json_encode($pigram);
?>