<?php
if(!isset($_GET['key'])){
	echo '<html><head><title>Forbidden</title></head><body>';
	echo '<h1>Forbidden</h1>Access is denied.';
	echo 'Retrying will not help. Please verify your <pre>key=</pre> parameter.</body></html>';
	exit();
}elseif (!isset($_GET['id'])) {
	echo '<html><head><title>Forbidden</title></head><body>';
	echo '<h1>Forbidden</h1>Access is denied.';
	echo 'Retrying will not help. Please verify your <pre>id=</pre> parameter.</body></html>';
	exit();
}else{
	require('../../mysqli_connect.php');
	$key = htmlspecialchars($_GET['key']);
	$key = mysqli_real_escape_string($dbcon, $key);
	$id = htmlspecialchars($_GET['id']);
	$id = mysqli_real_escape_string($dbcon, $id);

	$keys = "SELECT * FROM API_keys WHERE api_key='$key'";
	$get_key = @mysqli_query($dbcon, $keys);
	if($get_key){
		if(mysqli_num_rows($get_key) != 1){
			echo '<html><head><title>Forbidden</title></head><body>';
			echo '<h1>Forbidden</h1>Access is denied.';
			echo 'Retrying will not help. Please verify your <pre>key=</pre> parameter.</body></html>';
			exit();
		}else{
			if(!is_numeric($id)){
				echo '<html><head><title>Forbidden</title></head><body>';
				echo '<h1>Forbidden</h1>Access is denied.';
				echo 'Retrying will not help. Please verify your <pre>id=</pre> parameter.</body></html>';
				exit();
			}else{
				$posts = "SELECT id, title, description, cat, author, pub_time FROM posts WHERE id='$id'";
				$get_posts = @mysqli_query($dbcon, $posts);
				if($get_posts){
					if(mysqli_num_rows($get_posts) != 1){
						echo '<html><head><title>Forbidden</title></head><body>';
						echo '<h1>Forbidden</h1>Access is denied.';
						echo 'Retrying will not help. Please verify your <pre>id=</pre> parameter.</body></html>';
						exit();
					}else{
						//information displayer
						$data = array();
						while($info = mysqli_fetch_array($get_posts, MYSQLI_ASSOC)){
							//$info = array_map('utf8_encode', $info); //this screws up the output...
    						$data['posts'][] = $info;
							echo json_encode($data);
						}
						//end information displayer
					}
				}else{
					echo '<html><head><title>Internal Server Error 500</title></head><body>';
					echo '<h1>Internal Server Error 500</h1>The server encountered an unexpected condition that prevented it from fulfilling the request.</body></html>';
					exit();
				}
			}
		}
	}else{
		echo '<html><head><title>Internal Server Error 500</title></head><body>';
		echo '<h1>Internal Server Error 500</h1>The server encountered an unexpected condition that prevented it from fulfilling the request.</body></html>';
		exit();
	}
}
?>
