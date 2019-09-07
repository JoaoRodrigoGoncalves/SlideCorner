<?php
session_start();
require('mysqli_connect.php');
require('news.php');
require('hasher.php');
require('footer.php');
?>
<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>Nova Publicação</title>
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
				<div class="col-md-10">
					<?php
					if(!isset($_SESSION['userid'])){
						echo '
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								<div style="margin-top: 25%; margin-left: 30%;">
									<h4>Por favor, <a href="./login.php">Inicia Sessão</a> para continuar!</h4>
								</div>
							</div>
							<div class="col-md-2"></div>
						</div>';
					}else{
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							if(!empty($_POST['title'])){
								$title = htmlspecialchars($_POST['title']);
								$title = nl2br($title);
							}else{
								$title = false;
								$errors['title'] = "Por favor, escreve o título da tua publicação!";
							}
							if(!empty($_POST['description'])){
								$description = htmlspecialchars($_POST['description']);
								$description = nl2br($description);
							}else{
								$description = false;
								$errors['description'] = "Por favor, escreve uma descrição para a tua publicação!";
							}
							if(($_POST['cat'] != "") || (!empty($_POST['cat'])) || (isset($_POST['cat']))){
								$cat = mysqli_real_escape_string($dbcon, $_POST['cat']);
							}else{
								$cat = false;
								$errors['cat'] = "Por favor, seleciona a disciplina/categoria da tua publicação!";
							}
							if(!empty($_FILES['fileToUpload']['name'])){
								if ($_FILES["fileToUpload"]["size"] > 104857600) {
								    $errors['upload'] = "O ficheiro é muito pesado! (MAX 100MB)!";
								    $upload = false;
								}else{
									$filename = mysqli_real_escape_string($dbcon, $_FILES["fileToUpload"]["name"]);
									$target_dir = "files/posts/user" . $_SESSION['userid'] . "/";
									$target_file = $target_dir . basename($filename);
									//remove "dangerous" simbols
									$target_file = str_replace("ç","c", $target_file);
									$target_file = str_replace("ã","a", $target_file);
									$target_file = str_replace("õ","o", $target_file);
									$target_file = str_replace("á","a", $target_file);
									$target_file = str_replace("à","a", $target_file);
									$target_file = str_replace("ó","o", $target_file);
									$target_file = str_replace("ò","o", $target_file);
									$target_file = str_replace("Ó","O", $target_file);
									$target_file = str_replace("Ò","O", $target_file);
									$target_file = str_replace("Á","A", $target_file);
									$target_file = str_replace("À","A", $target_file);
									$target_file = str_replace("Í","I", $target_file);
									$target_file = str_replace("í","i", $target_file);
									$target_file = str_replace("ì","i", $target_file);
									$target_file = str_replace("Ì","I", $target_file);
									$target_file = str_replace(" ","_", $target_file);
									//put the file extension in lowercase
									$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
									//check if file already exists
									if (file_exists($target_file)) {
										$errors['upload'] = "Já carregas-te um ficheiro com esse nome! Por favor, altera o nome do ficheiro antes que o tentares carregar novamente!";
										$upload = false;
									}else{
										//check if the file extension is allowed
										if($fileType != "html" && $fileType != "php" && $fileType != "htm" && $fileType != "asp" && $fileType != "xml" && $fileType != "sql" && $fileType != "bat") {
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
										}else{
											$errors['upload'] = "Por favor, carrega um tipo de ficheiro diferente!";
											$upload = false;
										}
									}
								}
							}else{
								$upload = false;
								$errors['upload'] = "Por favor, seleciona um ficheiro para carregar!";
							}
							if($title && $description && $cat && $upload){
								$author_id = $_SESSION['userid'];
								if(!empty($_POST['password'])){
									$password = mysqli_real_escape_string($dbcon, $_POST['password']);
									$password = hasher($password);
									$post = "INSERT INTO posts (title, description, cat, author, path, password) VALUES ('$title', '$description', '$cat', '$author_id', '$target_file', '$password')";
								}else{
									$post = "INSERT INTO posts (title, description, cat, author, path) VALUES ('$title', '$description', '$cat', '$author_id', '$target_file')";
								}
								if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
									$set_post = @mysqli_query($dbcon, $post);
									if($set_post){
										$this_post = "SELECT id FROM posts WHERE author='$author_id' ORDER BY pub_time DESC LIMIT 1";
										$get_this_post = @mysqli_query($dbcon, $this_post);
										if($get_this_post){
											while ($this_post_info = mysqli_fetch_array($get_this_post, MYSQLI_ASSOC)){
												//track
												$track = "O Utilizador criou uma publicação (id " . $this_post_info["id"] . ")";
												$time = date("Y-m-d H:i:s");
												$this_post_id = $this_post_info['id'];
												$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$author_id', '$this_post_id', '$track', '$time')";
												$run_track = @mysqli_query($dbcon, $set_track);
												//end track
												header("Location: ./showpost.php?p=" . $this_post_info['id']);
												exit();
											}
										}else{
											$errors[] = "Ocurreu um erro ao tentar te rencaminhar para o teu post!. Pedimos desculpa!";
										}
									}else{
										$errors[] = "Ocurreu um erro ao realizar a publicação! Por favor, tenta mais tarde!";
										unlink($target_file);
									}
								} else {
									$errors[] = "Ocurreu um erro ao carregar o teu ficheiro! Por favor, tenta mais tarde!";
								}
							}
							if ((empty($errors['title'])) || (empty($errors['description'])) || (empty($errors['cat'])) || (empty($errors['upload']))){
								foreach ($errors as $error) {
									echo '<h6 style="color:red;">' . $error . '</h6><br>';
								}
							}
						}
						//post form
						echo'
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								<form method="POST" action="./newpost.php" enctype="multipart/form-data">
									<label for="title">Título: <a href="#" data-toggle="tooltip" title="Este será o nome da publicação! (Obrigatório!)">[?]</a></label>';
						if(!empty($errors['title'])){echo '<h6 style="color:red;">'. $errors['title'] . '</h6>';}
						echo'<input type="text" name="title" maxlenght="65" class="form-control" placeholder="Título" value="';
						if(isset($_POST['title'])){echo $_POST['title'];}
						echo '">
									<label for="description">Descrição: <a href="#" data-toggle="tooltip" title="Esta será a descrição da publicação! (Obrigatório!)">[?]</a></label>';
						if(!empty($errors['description'])){echo '<h6 style="color:red;">'. $errors['description'] . '</h6>';}
						echo '<textarea name="description" rows="10" class="form-control" placeholder="Descrição" value="';
						if(isset($_POST['description'])){echo $_POST['description'];}
						echo '"></textarea>
									<label for="cat">Disciplina/Categoria: <a href="#" data-toggle="tooltip" title="Esta é a disciplina/categoria da publicação! (Obrigatório!)">[?]</a></label>';
						if(!empty($errors['cat'])){echo '<h6 style="color:red;">'. $errors['cat'] . '</h6>';}
						echo '<select name="cat" class="form-control">';
						$subjects = "SELECT * FROM subject_list";
						$get_subjects = @mysqli_query($dbcon, $subjects);
						if($get_subjects){
							echo '<option>-Disciplina-</option>';
							while($subject = mysqli_fetch_array($get_subjects, MYSQLI_ASSOC)){
								if((isset($_POST['cat'])) && ($subject['cat'] == $_POST['cat'])){
									echo '<option value="' . $subject['cat'] . '" selected>' . $subject['name'] . '</option>';
								}else{
									echo '<option value="' . $subject['cat'] . '">' . $subject['name'] . '</option>';
								}
							}
						}else{
							echo '<option>Error</option>';
						}
						echo'</select>
									<label for="fileToUpload">Ficheiro: <a href="#" data-toggle="tooltip" title="Este é o ficheiro que queres partilhar com a tua publicação! (Obrigatório, max. 100MB)">[?]</a></label>';
						if(!empty($errors['upload'])){echo '<h6 style="color:red;">'. $errors['upload'] . '</h6>';}
						echo '<input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
									<label for="password">Palavra-passe: <a href="#" data-toggle="tooltip" title="Este site foi criado com o intuito de partilhar ficheiros e trabalhos entre utilizadores, mas também respeitamos a privacidade e damos a opção ao autor de protejer a sua publicação com uma palavra-passe! (Opcional)">[?]</a></label>
									<input type="password" class="form-control" name="password" placeholder="Palavra-passe (Opcional)">
									<br>
									<input type="submit" class="form-control" value="Publicar!">
								</form>
								<br><br>
							</div>
							<div class="col-md-2"></div>
						</div>
						';
						//end post form
					}
					?>
				</div>
				<div class="col-md-2"><?php echo news();?></div>
			</div>
			<?php echo footer(); ?>
		</div>
	</body>
	<script>
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</html>
