<?php
session_start();
require('mysqli_connect.php');
require('news.php');
require('hasher.php');
require('footer.php');
if(!isset($_GET['p'])){
	header("Location: ./");
	exit();
}else{
	$p = mysqli_real_escape_string($dbcon, $_GET['p']);
	$post = "SELECT * FROM posts WHERE id='$p'";
	$get_post = @mysqli_query($dbcon, $post);
	if($get_post){
		if(mysqli_num_rows($get_post) != 1){
			header("Location: ./");
			exit();
		}else{
			while($post = mysqli_fetch_array($get_post, MYSQLI_ASSOC)){
				$title = $post['title'];
				$description = $post['description'];
				$author = $post['author'];
				$path = $post['path'];
				$password = $post['password'];
			}
			mysqli_free_result($get_post);
			$reactions = "SELECT * FROM user_reactions WHERE post_id='$p' AND type='post'";
			$get_reactions = @mysqli_query($dbcon, $reactions);
			if($get_reactions){
				if(mysqli_num_rows($get_reactions) != 0){
					$postLikes = 0;
					$postUnlikes = 0;
					while($reacType = mysqli_fetch_array($get_reactions, MYSQLI_ASSOC)){
						$react = $reacType['reaction'];
						if($react != 0){
							$postLikes = $postLikes + 1;
						}else{
							$postUnlikes = $postUnlikes + 1;
						}

					}
				}else{
					$postLikes = 0;
					$postUnlikes = 0;
				}
			}
		}
	}else{
		echo 'Internal Server Error.<br>
		There was an error while trying to get post information.<br>
		Please try again later.';
		exit();
	}
}
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title><?php echo $title; ?> | SlideCorner</title>
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
					<div class="container">
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div class="container">
									<div class="row justify-content-md-center">
										<?php
										if(isset($_SESSION['userid'])){
											$user_id = $_SESSION['userid'];
										}else{
											$user_id = 0;
										}
										function showForm($title, $p){
											return '
												<div class="card">
													<div class="card-body">
														<h4 class="card-title">' . $title . '</h4>
														<p class="card-text">Esta publicação foi protegida por palavra-passe.</p>
														<p>Por favor, escreve a palavra-passe no campo abaixo e clica em continuar!</p>
														<form action="./showpost.php?p=' . $p . '" method="POST">
															<div class="form-group">
																<label for="password">Palavra-passe: <a href="#" data-toggle="tooltip" title="Deves introduzir a palavra-passe que o autor desta publicação te forneceu!">[?]</a></label>
																<input type="password" name="password" class="form-control">
															</div>
															<div class="form-group">
																<input type="submit" value="Continuar" class="form-control">
															</div>
														</form>
													</div>
												</div>';
										}
										function showContent($p, $title, $description, $author, $path, $userid, $postLikes, $postUnlikes){
											$API_key = "1147a52f57ea1916696f59fa14d3df95315b6468";
											$url = "http://" . $_SERVER['SERVER_NAME'] . "/API/SC_UsersProfile/?key=" . $API_key . "&id=" . $author . "";
											$json_object= file_get_contents($url);
											$json_decoded= json_decode($json_object);
											foreach ($json_decoded->user as $user) {
												$author_decoded = $user->username;
												$author_avatar = $user->avatar;
											}
											list($ff, $pf, $uf, $filename) = explode("/", $path);
											if($userid != $author){
												$del = "";
											}else{
												$del = '<a href="#" style="color:black;" onClick="deletePost(\'' . $p . '\',\'' . $author .'\')" data-toggle="tooltip" title="Apagar publicação!"><i class="fas fa-trash-alt"></i></a>';
											}
											$return = '
												<div class="card">
													<div class="card-body">
														<h4 class="card-title">' . $title . ' ' . $del . '</h4>
														<p class="card-text">Publicado por: <img src="' . $author_avatar . '" width="32" height="32" style="border-radius: 50px;"> ' . $author_decoded . '.</p>
														<hr>
														<p>' . $description . '</p>
														<hr>';
														if($userid != 0){
															$return = $return . '<a href="' . $path . '" download><button type="button" class="btn btn-success" onmousedown="download(\'' . $p .'\',\'' . $title . '\',\'' . $filename . '\')">Transferir ' . $filename . '!</button></a>';
														}else{
															$return = $return . '<a href="./login.php" sytle="text-decoration: underline; color: blue;">Inicia Sessão</a> para obter acesso aos ficheiros disponíveis para transferência!';
														}
													$return = $return . '
														<hr>
														<i class="far fa-thumbs-up"></i> ' . $postLikes . ' <i class="fas fa-thumbs-down"></i> ' . $postUnlikes . '
													</div>
												</div>
											';
											return $return;
										}
										if($password != null){
											if($_SERVER['REQUEST_METHOD'] == 'POST'){
												if(!empty($_POST['password'])){
													$given_password = hasher($_POST['password']);
													if($given_password != $password){
														if(isset($_SESSION['userid'])){
															$user_id = $_SESSION['userid'];
															$track = "O utilizador errou a palavra-passe de " . $title . "(id " . $p . ")!";
															$time = date("Y-m-d H:i:s");
															$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
															$run_track = @mysqli_query($dbcon, $set_track);
														}
														$errors['password'] = "A palavra-passe que escreves-te está incorreta. Por favor tenta novamente!";
														echo showForm($title, $p);
													}else{
														if(isset($_SESSION['userid'])){
															$user_id = $_SESSION['userid'];
															$track = "O utilizador acertou a palavra-passe de " . $title . "(id " . $p . ")!";
															$time = date("Y-m-d H:i:s");
															$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
															$run_track = @mysqli_query($dbcon, $set_track);
														}
														echo showContent($p, $title, $description, $author, $path, $user_id, $postLikes, $postUnlikes);
													}
												}else{
													$errors['password'] = "Por favor, escreve a palavra-passe que te foi fornecida pelo autor desta publicação!";
													if(isset($_SESSION['userid'])){
														$user_id = $_SESSION['userid'];
														$track = "O utilizador não escreveu nada no campo da palavra-passe de " . $title . "(id " . $p . ")!";
														$time = date("Y-m-d H:i:s");
														$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
														$run_track = @mysqli_query($dbcon, $set_track);
													}
													echo showForm($title, $p);
												}
											}else{
												if(!isset($_SESSION['userid'])){
													if(isset($_SESSION['userid'])){
															$user_id = $_SESSION['userid'];
															$track = "O utilizador acedeu a " . $title . "(id " . $p . ")!";
															$time = date("Y-m-d H:i:s");
															$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
															$run_track = @mysqli_query($dbcon, $set_track);
														}
													echo showForm($title, $p);
												}else{
													if($_SESSION['userid'] != $author){
														if(isset($_SESSION['userid'])){
															$user_id = $_SESSION['userid'];
															$track = "O utilizador acedeu a " . $title . "(id " . $p . ")!";
															$time = date("Y-m-d H:i:s");
															$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
															$run_track = @mysqli_query($dbcon, $set_track);
														}
														echo showForm($title, $p);
													}else{
														if(isset($_SESSION['userid'])){
															$user_id = $_SESSION['userid'];
															$track = "O utilizador acedeu a " . $title . "(id " . $p . ")!";
															$time = date("Y-m-d H:i:s");
															$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
															$run_track = @mysqli_query($dbcon, $set_track);
														}
														echo showContent($p, $title, $description, $author, $path, $user_id, $postLikes, $postUnlikes);
													}
												}
											}
										}else{
											if(isset($_SESSION['userid'])){
												$user_id = $_SESSION['userid'];
												$track = "O utilizador acedeu a " . $title . "(id " . $p . ")!";
												$time = date("Y-m-d H:i:s");
												$set_track = "INSERT INTO user_tracking (user, post_id, action, time) VALUES ('$user_id', '$p', '$track', '$time')";
												$run_track = @mysqli_query($dbcon, $set_track);
											}
											echo showContent($p, $title, $description, $author, $path, $user_id, $postLikes, $postUnlikes);
										}
										?>
									</div>
								</div>
							</div>
							<div class="col-md-1"></div>
						</div>
					</div>
				</div>
				<div class="col-md-2"><?php echo news(); ?></div>
			</div>
			<?php echo footer(); ?>
		</div>
		<script>
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
		</script>
		<script type="text/javascript">
		function download(id, title, filename) {

			$.ajax({
				type: "POST",
				url: './add_download.php?id=' + id + '&title=' + title + '&filename=' + filename,
				data:{action:'clear'},
				success:function(html) {
					//alert(html);
				}
			});
		}

		function deletePost(id) {
			$.ajax({
				type: "POST",
				url: './del-post.php?id=' + id,
				data:{action:'clear'},
				success:function(html){
					alert(html);
					window.location.replace("./");
				},
				error:function(html){
					alert("Erro ao remover publicação!");
				}
			});
		}
		</script>
	</body>
</html>
