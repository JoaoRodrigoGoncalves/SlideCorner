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
						<?php include('user-status.php'); ?>
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
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							if(!empty($_POST['email'])){
								$email = mysqli_real_escape_string($dbcon, $_POST['email']);
							}else{
								$email = false;
								$errors['email'] = "Por favor, escreve o teu endereço de email!";
							}
							if(!empty($_POST['pwd'])){
								$password = mysqli_real_escape_string($dbcon, $_POST['pwd']);
							}else{
								$password = false;
								$errors['password'] = "Por favor, escreve a tua palavra-passe!";
							}
							if($email && $password){ //verifica se não são false (portanto, se não tem erros)
								$password_d = $password;
								$password = hasher($password);
								$userinfo = "SELECT * FROM users WHERE email='$email' AND password='$password'";
								$get_info = @mysqli_query($dbcon, $userinfo);
								if($get_info){
									if(mysqli_num_rows($get_info) == 1){
										while ($info = mysqli_fetch_array($get_info, MYSQLI_ASSOC)){
											$user_id = $info['id'];
											$user_ip = $_SERVER['REMOTE_ADDR'];
											$time = date('Y-m-d H:i:s');
											$update = "UPDATE users SET last_ip='$user_ip', last_join='$time' WHERE id='$user_id'";
											$run_update = @mysqli_query($dbcon, $update);
											if($run_update){
												session_start();
												$_SESSION['userid'] = $info['id'];
												$_SESSION['username'] = $info['username'];
												header("Location: ./");
												exit();
											}else{
												$errors[] = "Erro ao atualizar utilizador!";
											}
										}
									}else{
										$errors[] = "Endereço de email ou palavra-passe estão incorretos!";
									}
								}else{
									$errors[] = "Erro ao verificar credenciais." . mysqli_error($dbcon);
								}
							}
							if ((empty($errors['email'])) || (empty($errors['password']))){
								foreach ($errors as $error) {
									echo '<h6 style="color:red;">' . $error . '</h6><br>';
								}
							}
						}
						echo '<br>
						<form action="./login.php" method="POST">
							<div class="form-group">
								<label for="email">Email: <a href="#" data-toggle="tooltip" title="Deves introduzir o email com que te registaste no SlideCorner!">[?]</a></label>';
								if(!empty($errors['email'])){echo '<h6 style="color:red;">'. $errors['email'] . '</h6>';}
						echo'	<input type="text" class="form-control" id="email" name="email" value="';
								if(isset($_POST['email'])){
									echo $_POST['email'];
								}
						echo '">
							</div>
							<div class="form-group">
								<label for="pwd">Palavra-passe: <a href="#" data-toggle="tooltip" title="Deves introduzir a palavra-passe com que te resgistaste no SlideCorner!">[?]</a></label>';
								if(!empty($errors['password'])){echo '<h6 style="color:red;">'. $errors['password'] . '</h6>';}
						echo 	'<input type="password" class="form-control" name="pwd" id="pwd">
							</div>
							<div class="form-group">
								<input type="submit" class="form-control" value="Iniciar Sessão!">
							</div>
						</form>';
						?>
						<h5>Não tens uma conta? <a href="./register.php">Regista-te!</a></h5>
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
	</body>
</html>
