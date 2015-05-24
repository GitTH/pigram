<?php
if (isset($_GET['instagram_shortcode'])) {
	include("../setup.php");
	$sql_deactivate = "UPDATE `social_instagram` SET `active` = '0' WHERE `instagram_shortcode` = '".$_GET['instagram_shortcode']."'";
	$db = newDB();
	$db->query($sql_deactivate);
	echo $sql_deactivate;
}
?>
