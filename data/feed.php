<?php
include("../setup.php");

//function to check if img exists
function checkRemoteFile($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch)!==FALSE) {
        return true;
    } else {
        return false;
    }
}

//how many images should we get?
if ($_REQUEST['images_to_get'] != '') {
	$images_to_get = $_REQUEST['images_to_get'];
} else {
	$images_to_get = 84;
}

//lets get some more in case some images have been deleted
$images_to_get_buffered = $images_to_get + round($images_to_get/2);

//get the feed
$db = newDB();
$feed_sql = "SELECT `i`.`images_low_resolution` FROM `social_instagram` as `i` ORDER BY `i`.`time_subscription_unix` DESC LIMIT 0,$images_to_get_buffered";
$feed = $db->GetCol($feed_sql);
//print_r($feed);

//lets loop through to see if they exist
$cnt = 0;
foreach($feed as $f) {
	//I CAN'T GET CURL TO WORK LOCALLY RIGHT NOW..  WORKING ON IT
	//if (checkRemoteFile($f) && $cnt+1 <= $images_to_get) {
		$pigram[$cnt] = $f;
		$cnt++;
	//}
}

//echo the json feed
header('Content-Type: application/json');
echo json_encode($pigram);
?>