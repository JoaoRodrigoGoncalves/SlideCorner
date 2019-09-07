<?php
require('mysqli_connect.php');
session_start();
$p = $_GET['id'];
$title = $_GET['title'];
$userid = $_SESSION['userid'];
$filename = $_GET['filename'];

$track = "O utilizador transferiu " . $filename . " da publicação " . $title . "(id " . $p . ")";
$time = date("Y-m-d H:i:s");
$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$userid', '$p', '$track', '$time')";
$run_track = @mysqli_query($dbcon, $set_track);
?>
