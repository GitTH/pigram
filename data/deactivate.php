<?php
if (isset($_GET['instagram_id'])) {
	include("../setup.php");
	$sql_deactivate = "UPDATE `social_instagram` SET `active` = 'N' WHERE `instagram_id` = '".$_GET['instagram_id']."'";
	$db = newDB();
	$db->query($sql_deactivate);
	echo $sql_deactivate;
}
?>
