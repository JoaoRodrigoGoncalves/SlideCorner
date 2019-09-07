<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: ./");
	exit();
}
require('mysqli_connect.php');
require('news.php');
require('hasher.php');
require('truncate.php');
require('footer.php');
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>Definições - SlideCorner</title>
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link rel="shortcut icon" href="./favicon.png">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
			<div class="container">
				<a class="navbar-brand" href="./">SlideCorner</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<?php include('subjects.php'); ?>
					</ul>
					<ul class="navbar-nav ml-auto">
						<?php include('user-status.php'); ?>
					</ul>
				</div>
			</div>
		</nav>
		<br><br><br>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10"><br>
					<div class="container">
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-5">
								<?php
								if(($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['application'] == "password")){
									if(!empty($_POST['password'])){
										$password = mysqli_real_escape_string($dbcon, $_POST['password']);
									}else{
										$password = false;
										$errors['password'] = "Por favor, escreve a tua palavra-passe!";
									}
									if(!empty($_POST['new_password'])){
										$new_password = mysqli_real_escape_string($dbcon, $_POST['new_password']);
									}else{
										$new_password = false;
										$errors['new_password'] = "Por favor, escreve uma nova palavra-passe";
									}
									if($password && $new_password){
										$userid = $_SESSION['userid'];

										$search_user = "SELECT * FROM users WHERE id='$userid'";
										$get_user = @mysqli_query($dbcon, $search_user);
										if($get_user){
											if(mysqli_num_rows($get_user) != 1){
												$errors[] = "Erro";
											}else{
												while($info = mysqli_fetch_array($get_user, MYSQLI_ASSOC)){
													$last_password = $info['password'];
												}
												$password = hasher($password);
												if($password != $last_password){
													$errors['password'] = "A antiga palavra-passe está errada!";
												}else{
													$new_password = hasher($new_password);
													$replace_password = "UPDATE users SET password='$new_password' WHERE id='$userid'";
													$run_replace = @mysqli_query($dbcon, $replace_password);
													if($run_replace){
														$_SESSION = array(); // Destroy the variables.
														session_destroy(); // Destroy the session
														header("location: ./login.php");
														exit();
													}else{
														$errors[] = "Erro ao alterar palavra-passe";
													}
												}
											}
										}else{
											$errors[] = mysqli_error($dbcon);
										}
									}
								}
								if((isset($_POST['application'])) && ($_POST['application'] == "password") && (isset($errors))){
									if((empty($errors['password'])) || (empty($errors['new_password']))){
										foreach ($errors as $error) {
											echo '<h6 style="color:red;">' . $error . '</h6><br>';
										}
									}
								}
								echo '
								<form action="./settings.php" method="POST">
									<input type="text" value="password" name="application" id="application" hidden>
									<div class="form-group">
										<label for="password">Palavra-passe atual:</label>';
								if((isset($errors['password'])) && (!empty($errors['password']))){echo '<h6 style="color:red;">' . $errors['password'] . '</h6>';}
								echo '	<input type="password" id="password" class="form-control" name="password" autocomplete="noteventry">
									</div>
									<div class="form-group">
										<label for="new_password">Nova palavra-passe:</label>';
								if((isset($errors['new_password'])) && (!empty($errors['new_password']))){
									echo '<h6 style="color:red;">' . $errors['new_password'] . '</h6>';
								}
								echo '	<input type="password" name="new_password" id="new_password" class="form-control" autocomplete="new-password">
									</div>
									<div class="form-group">
										<input type="submit" name="Atualizar palavra-passe!" class="form-control" style="cursor: pointer;">
									</div>
								</form>
								';
								?>
							</div>
							<div class="col-md-5">
								<?php
								if(($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['application'] == "avatarchange")){
									if(isset($_POST['remove_avatar'])){
										$default_path_avatar = "default/images/avatar.png";
										$userid = $_SESSION['userid'];
										$change_avatar = "UPDATE users SET avatar='$default_path_avatar' WHERE id='$userid'";
										$apply = @mysqli_query($dbcon, $change_avatar);
										if($apply){
											//done! now, jump to the displayer code and it should display a new avatar
										}else{
											$errors[] = "Ocurreu um erro ao redefenir o avatar!";
										}
									}else{
										if(!empty($_FILES['fileToUpload']['name'])){
											if ($_FILES["fileToUpload"]["size"] > 5242880) {
											    $errors['upload'] = "O ficheiro é muito pesado! (MAX 5MB)!";
											    $upload = false;
											}else{
												$filename = htmlspecialchars($_FILES["fileToUpload"]["name"]);
												$filename = mysqli_real_escape_string($dbcon, $filename);
												$target_dir = "files/images/user" . $_SESSION['userid'] . "/avatar/";
												list($originalName, $extension) = explode(".", $filename);
												//put the file extension in lowercase
												$extension = strtolower($extension);
												$target_file = $target_dir . "avatar." . $extension;
												//if file already exists, delete it
												if (file_exists($target_file)) {
													unlink($target_file);
												}
												//check if the file extension is allowed
												$fileType = $extension; //// HACK: geringonça
												if($fileType != "png" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "jpe" && $fileType != "jfif" && $fileType != "bmp" && $fileType != "gif") {
													$errors['upload'] = "Por favor, carrega um tipo de ficheiro diferente!";
													$upload = false;
												}else{
													if (!file_exists($target_dir)) {
													    mkdir($target_dir, 0775, true);
													    if(!file_exists($target_dir)){
													    	$errors[] = "Erro ao criar pasta. (Forbidden)";
													    	$upload = flase;
													    }else{
													    	//if it is all right, give green light to upload the file
															$upload = true;
													    }
													}else{
														$upload = true;
													}
												}
											}
										}else{
											$upload = false;
											$errors['upload'] = "Por favor, seleciona um ficheiro para carregar!";
										}
										if($upload){
											$userid = $_SESSION['userid'];
											if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
												$avatar = "UPDATE users SET avatar='$target_file' WHERE id='$userid'";
												$set_avatar = @mysqli_query($dbcon, $avatar);
												if($set_avatar){
													header("Location: ./settings.php");
												}else{
													unlink($target_file);
													$errors['upload'] = "Erro ao atualizar avatar. Tenta novamente mais tarde!";
												}
											}
										}
									}
								}
								if((isset($_POST['application'])) && ($_POST['application'] == "avatarchange") && (isset($errors))){
										foreach ($errors as $error) {
											echo '<h6 style="color:red;">' . $error . '</h6><br>';
										}
								}
								$userid = $_SESSION['userid'];
								$API_key = "1147a52f57ea1916696f59fa14d3df95315b6468";
								$url = "http://" . $_SERVER['SERVER_NAME'] . "/API/SC_UsersProfile/?key=" . $API_key . "&id=" . $userid . "";
								$json_object= file_get_contents($url);
								$json_decoded= json_decode($json_object);
								foreach ($json_decoded->user as $user) {
									$user_avatar = $user->avatar;
								}
								echo '
								<form action="./settings.php" method="POST" enctype="multipart/form-data">
									<input type="text" value="avatarchange" name="application" id="application" hidden>
									<div class="form-group">
										<img src="' . $user_avatar . '" width="128" height="128">
										<img src="' . $user_avatar . '" width="64" height="64" style="vertical-align: bottom;">
										<img src="' . $user_avatar . '" width="32" height="32" style="vertical-align: bottom;">
									</div>
									<div class="form-group">
										<label for="fileToUpload">Avatar:</label>
										<input type="file" name="fileToUpload" id="fileToUpload" class="form-control" style="cursor: pointer;">
									</div>
									<div class="form-group">
										<input type="submit" value="Atualizar avatar!" class="form-control" style="cursor: pointer;">
										<input type="submit" name="remove_avatar" value="Remover Avatar!" class="form-control" style="cursor: pointer;">
									</div>
								</form>
								';
								?>
							</div>
							<div class="col-md-1"></div>
						</div>
					</div>
				</div>
				<div class="col-md-2"><?php echo news(); ?></div>
			</div>
			<?php echo footer(); ?>
		</div>
	</body>
</html>
