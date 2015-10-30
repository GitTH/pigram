<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>pigram import</title>
	<link href="../css/bootstrap-3.3.4.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
  <div class="container">
  <h1>Import Instagram Account</h1>
  <ul>
    <li>Find your Instagram account ID number at <a href="http://www.otzberg.net/iguserid/index.php">Otzberg.net</a> or <a href="http://jelled.com/instagram/lookup-user-id">jelled.com</a></li>
    <li>Paste the ID number into the form and click submit</li>
    <li>NOTE: if you want to scrape the entire account, tick the checkbox</li>
    <li>Results will be displayed on the page including how many and which images were imported. This URL can be copied and added as a cron job</li>
  </ul>
  <hr />

<?php
include("../setup.php");
function importMedia($resultObject) {
  $db = newDB();
  $sql="INSERT INTO social_instagram(instagram_shortcode,user_id,images_low_resolution,images_high_resolution,type,created_time)
  VALUES (:shortcode,:userID,:imagelo,:imagehi,:type,:time)
  ON DUPLICATE KEY UPDATE images_low_resolution=:imagelo,images_high_resolution=:imagehi";
  $s = $db->prepare($sql);
  echo "<ol>";
  foreach ($resultObject->data as $media) {
    $shortcode=explode('/',$media->link);
    // enforce square media by requesting resized thumbnails
    $square = $media->images->thumbnail->url;
    $imagelo = str_replace("/s150x150/","/s320x320/",$square); // formerly $media->images->low_resolution->url
    $imagehi = str_replace("/s150x150/","/s640x640/",$square); // formerly $media->images->standard_resolution->url

    try {
      $s->bindValue(':userID', $media->user->id);
      $s->bindValue(':shortcode', $shortcode[4]);
      $s->bindValue(':imagelo', $imagelo);
      $s->bindValue(':imagehi', $imagehi);
      $s->bindValue(':type', $media->type);
      $s->bindValue(':time', $media->created_time);
      $s->execute();
      echo "<li>Imported image ".$shortcode[4]."</li>";
    }
    catch (PDOException $e)	{
      $error = "Error adding images<br />";
      echo $error;
      //echo $e->getMessage();
      exit();
    }
  }
  echo "</ol>";
}

if (isset($_GET['userid']) && is_numeric($_GET['userid'])) {
  //todo: add username lookup from $instagram->searchUser($username);
  $result = $instagram->getUserMedia($_GET['userid']);
  if (isset($_GET['history']) && $_GET['history']=="grab") {
    //recurse through account history on intial import
    do {
      set_time_limit(0);
      importMedia($result);
      $result = $instagram->pagination($result);
    }
    while (isset($result->pagination));
    } else {
    importMedia($result);
  }
  echo '<p><a href="import.php" class="btn btn-success">Click here to start again</a></p>';
} elseif (isset($_GET['userfeed']) && $_GET['userfeed']==1) {
  //todo: document this feature - if ?userfeed=1, latest 66 images from users the authenticated account follows will be imported
  $result = $instagram->getUserFeed(33);
  importMedia($result);
  importMedia($instagram->pagination($result,33));
} else {
  //display form if it has not been submitted or ID was not a number
  echo '<form class="form-inline" role="form">
        <input type="text" class="form-control" name="userid" placeholder="Instagram User ID #" style="width:150px;">
        <div class="checkbox">
          <label><input type="checkbox" name="history" value="grab" /> Import entire account</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>';
}
?>
  </div>
	</body>
</html>