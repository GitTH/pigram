<?php
include("../setup.php");

//how many images should we get?
if (isset($_REQUEST['images_to_get'])) {
	$images_to_get = $_REQUEST['images_to_get'];
} else {
	$images_to_get = 84;
}

//get the feed
$db = newDB();
$feed_sql = "SELECT `i`.* FROM `social_instagram` as `i` WHERE `i`.`active` = '1' AND `i`.`type` = 'image' ORDER BY `i`.`created_time` DESC LIMIT 0,$images_to_get";
$feed = $db->query($feed_sql);
//print_r($feed);

//lets loop through to see if they exist
$cnt = 0;
foreach($feed as $f) {
	$pigram[$cnt]['url'] = $f['images_low_resolution'];
	$pigram[$cnt]['url_lg'] = $f['images_high_resolution'];
	$pigram[$cnt]['instagram_shortcode'] = $f['instagram_shortcode'];
	$cnt++;
}

//echo the json feed
header('Content-Type: application/json');
echo json_encode($pigram);
?>
