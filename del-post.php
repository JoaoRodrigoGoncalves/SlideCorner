<?php
session_start();
require('mysqli_connect.php');

if(isset($_GET['id'])){
	if(is_numeric($_GET['id'])){
		$post = $_GET['id'];
		$post = htmlspecialchars($post);
		$userid = $_SESSION['userid'];

		$check = "SELECT * FROM posts WHERE id='$post' AND author='$userid' LIMIT 1";
		$run_check = @mysqli_query($dbcon, $check);
		if($run_check){
			if(mysqli_num_rows($run_check) != 1){
				echo 'Não és dono deste post';
			}else{
				while($postinfo = mysqli_fetch_array($run_check, MYSQLI_ASSOC)){
					$path = $postinfo['path'];
					$title = $postinfo['title'];
				}
				$del = "DELETE FROM posts WHERE id='$post' AND author='$userid'";
				$run_delete = @mysqli_query($dbcon, $del);
				if($run_delete){
					unlink($path);
					$track = "O utilizador removeu " . $title . "(id " . $post . ")";
					$time = date("Y-m-d H:i:s");
					$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$userid', '$post', '$track', '$time')";
					$run_track = @mysqli_query($dbcon, $set_track);
					echo 'Publicação Removida';
					mysqli_free_result($run_check);
				}else{
					echo mysqli_error($dbcon);
					mysqli_free_result($run_check);
				}
			}
		}else{
			echo mysqli_error($dbcon);
			mysqli_free_result($run_check);
		}
	}else{
		echo 'No numeric<br>';
		echo $_GET['id'];
		echo '<br>';
		echo $_GET['userid'];
	}
}else{
	echo 'No post or user id';
}
?>
