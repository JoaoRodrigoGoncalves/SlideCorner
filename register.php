<?php
session_start();
if(isset($_SESSION['userid'])){
	header("Location: ./");
	exit();
}
require('mysqli_connect.php');
require('hasher.php');
require('news.php');
require('footer.php');
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>SlideCorner Login</title>
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
						<li class="nav-item">
							<?php include('user-status.php'); ?>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<br><br><br>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="container">
						<?php
						$errors[] = "";
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							if(!empty($_POST['username'])){
								$username = mysqli_real_escape_string($dbcon, $_POST['username']);
							}else{
								$username = false;
								$errors['username'] = "Por favor, escreve um Nome de Utilizador";
							}
							if(!empty($_POST['email'])){
								$email = mysqli_real_escape_string($dbcon, $_POST['email']);
							}else{
								$email = false;
								$errors['email'] = "Por favor, escreve o teu email!";
							}
							if(!empty($_POST['password'])){
								$password = mysqli_real_escape_string($dbcon, $_POST['password']);
							}else{
								$password = false;
								$errors['password'] = "Por favor, escreve uma palavra-passe!";
							}
							if(!empty($_POST['confirm'])){
								$confirm = mysqli_real_escape_string($dbcon, $_POST['confirm']);
							}else{
								$confirm = false;
								$errors['confirm'] = "Por favor, confirma a tua palavra-passe!";
							}
							if($username && $email && $password && $confirm){
								$used_user = "SELECT * FROM users WHERE username='$username'";
								$get_useduser = @mysqli_query($dbcon, $used_user);
								if($get_useduser){
									if(mysqli_num_rows($get_useduser) != 0){
										$errors[] = "Esse Nome de Utilizador já está em uso!";
									}else{
										$used_email = "SELECT * FROM users WHERE email='$email'";
										$get_usedemail = @mysqli_query($dbcon, $used_email);
										if($get_usedemail){
											if(mysqli_num_rows($get_usedemail) != 0){
												$errors[] = "Esse endereço de email já está em uso!";
											}else{
												if($confirm != $password){
													$errors[] = "As palavras-passe não são iguais! Rescreve-as e tenta novamente";
												}else{
													$password = hasher($password);
													$user_ip = $_SERVER['REMOTE_ADDR'];
													$reg = "INSERT INTO users (username, password, email, last_ip) VALUES ('$username', '$password', '$email', '$user_ip')";
													$start_reg = @mysqli_query($dbcon, $reg);
													if($start_reg){
														header("Location: ./login.php");
														exit();
													}else{
														$errors[] = "Erro ao registar utilizador";
													}
												}
											}
										}else{
											$errors[] = "Erro ao verificar utilização do endereço de email";
										}
									}
								}else{
									$errors[] = "Erro ao verificar utilização do Nome de Utilizador." . mysqli_error($dbcon);
								}
							}
						}
						if((!empty($_POST['username'])) || (!empty($_POST['email'])) || (!empty($_POST['password'])) || (!empty($_POST['confirm']))){
							foreach ($errors as $error) {
								echo '<h6 style="color:red;">' . $error . '</h6>';
							}
						}
						echo '
						<form action="./register.php" method="POST">
							<div class="form-group">
								<label for="username">Nome de Utilizador: <a href="#" data-toggle="tooltip" title="Este será o nome pelo qual serás conhecido no SlideCorner!">[?]</a></label>';
								if(!empty($errors['username'])){echo '<h6 style="color:red;">'. $errors['username'] . '</h6>';}
						echo'	<input type="text" class="form-control" id="username" name="username" value="';
								if(isset($_POST['username'])){
									echo $_POST['username'];
								}
						echo '">
							</div>
							<div class="form-group">
								<label for="email">Endereço de email: <a href="#" data-toggle="tooltip" title="Irás necessitar deste email para iniciar sessão e para confirmar a tua conta!">[?]</a></label>';
								if(!empty($errors['email'])){echo '<h6 style="color:red;">'. $errors['email'] . '</h6>';}
						echo'	<input type="text" class="form-control" id="email" name="email" value="';
								if(isset($_POST['email'])){
									echo $_POST['email'];
								}
						echo '">
							<div class="form-group">
								<label for="password">Palavra-passe: <a href="#" data-toggle="tooltip" title="Esta será a tua palavra-passe para iniciar sessão no SlideCorner!">[?]</a></label>';
								if(!empty($errors['password'])){echo '<h6 style="color:red;">'. $errors['password'] . '</h6>';}
						echo 	'<input type="password" class="form-control" name="password" id="password">
							</div>
							<div class="form-group">
								<label for="confirm">Confirmar palavra-passe: <a href="#" data-toggle="tooltip" title="Deves reintroduzir a tua palavra-passe para teres a certeza que não te enagaste!">[?]</a></label>';
								if(!empty($errors['confirm'])){echo '<h6 style="color:red;">'. $errors['confirm'] . '</h6>';}
						echo 	'<input type="password" class="form-control" name="confirm" id="confirm">
							</div>
							<div class="form-group">
								<input type="submit" class="form-control" value="Resgistar!">
							</div>
						</form>
						<h6>Ao clicar no botão "Registar!", aceitas os nossos <a href="./support/termos-de-uso.php">Termos de Uso</a> e com a nossa <a href="./support/dados-recolhidos.php">Recolha de Dados</a></h6>';
						?>
					</div>
				</div>
			</div>
			<?php echo footer(); ?>
		</div>
		<script>
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();   
		});
		</script>
	</body>
</html>
