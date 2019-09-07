<?php
session_start();
if(!isset($_SESSION['userid'])){
  header("Location: ../login.php");
  exit();
}
require('../mysqli_connect.php');
require('../news.php');
require('../footer.php');

$user_id = $_SESSION['userid'];
$get_API = "SELECT api_key FROM api_keys WHERE owner='$user_id'";
$keyResult = @mysqli_query($dbcon, $get_API);
if($keyResult){
  if(mysqli_num_rows($keyResult) != 0){
    while($key = mysqli_fetch_array($keyResult, MYSQLI_ASSOC)){
      $API_key = $key['api_key'];
    }
  }
}else{
  echo mysqli_error($dbcon);
}
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>Gerar API Key | SlideCorner</title>
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<link rel="shortcut icon" href="../favicon.png">
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
				<a class="navbar-brand" href="../">SlideCorner</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<?php include('../subjects.php'); ?>
					</ul>
					<ul class="navbar-nav ml-auto">
						<?php include('../user-status.php'); ?>
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
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Criar uma WebAPI do <?php echo $_SERVER['SERVER_NAME']; ?></h4>
										<p class="card-text">
                      <br>
                      <?php
                      if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($API_key)){
                          $message = "Possível tentativa de burla do sistema de WebAPI por parte do utilizador " . $user_id . "!";
                          $time = date("Y-m-d H:i:s");
                          $report = "INSERT INTO user_tracking (user, action, time) VALUES ('$user_id', '$message', '$time')";
                          $insert_report = @mysqli_query($dbcon, $report);
                          echo '<center><b>A minha WebAPI do SlideCorner: <code>' . $API_key . '</code></b></center><br><br>';
                        }else{
                          $scratch = $user_id . time() . "SC_API";
                          $finalKey = hash('sha1', $scratch);
                          $reg_key = "INSERT INTO api_keys (api_key, owner) VALUES ('$finalKey', '$user_id')";
                          $insert_key = @mysqli_query($dbcon, $reg_key);
                          if($insert_key){
                            header("Location: ./generate-api.php");
                          }else{
                            if(!is_null(mysqli_error($insert_key))){ echo mysqli_error($insert_key) . '<br>';}
                            if(!is_null(mysqli_error($dbcon))){ echo mysqli_error($dbcon);}
                          }
                        }
                      }else{
                        if(!isset($API_key)){
                          echo '
                          <form action="generate-api.php" method="POST">
                            <input type="checkbox" required> Aceito os termos de uso da API<br>
                            <input type="submit" value="Criar API Key!">
                          </form>';
                        }else{
                          echo '<center><b>A minha WebAPI do SlideCorner: <code>' . $API_key . '</code></b></center><br><br>';
                        }
                      }
                      ?>
											Com a WebAPI do SlideCorner, desenvolvedores podem obter informações sobre utilizadores registados no website e suas publicações.<br><br>

                      <h3>SC_UsersProfile</h3><br>
                      Uso: <code> http://<?php echo $_SERVER['SERVER_NAME'];?>/API/SC_UsersProfile/?key=XXXXXXXXXXXXXXXXXXXX&id=XXX </code><br><br>
                      <code>O parametro "key" deverá ser preenchido com a API Key.<br>
											O parametro "id" deverá ser preenchido com o id do utilizador.</code><br>

                      Com esta API, desenvolvedores irão ter acesso a:<br><br>
											<ul>
                        <ul>
                          <li>id</li>
                          <ul>
                            <li>O id do utilizador</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>username</li>
                          <ul>
                            <li>O nome do utilizador</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>avatar</li>
                          <ul>
                            <li>A url interna do avatar do utilizador</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>last_join</li>
                          <ul>
                            <li>A data e hora da última vez que o utilizador iniciou sessão</li>
                          </ul>
                        </ul>
                        <br>
												<ul>
                          <li>confirmated</li>
                          <ul>
                            <li>Ao estado da confirmação da conta do utilizador</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>status</li>
                          <ul>
                            <li>Estado da conta do utilizador</li>
                          </ul>
                        </ul>
											</ul>
											<br>

                      <h3>SC_UsersPosts</h3><br>
                      Uso: <code> http://<?php echo $_SERVER['SERVER_NAME'];?>/API/SC_UsersPosts/?key=XXXXXXXXXXXXXXXXXXXX&id=XXX </code><br><br>
                      <code>O parametro "key" deverá ser preenchido com a API Key.<br>
											O parametro "id" deverá ser preenchido com o id da publicação.</code><br>

                      Com esta API, desenvolvedores irão ter acesso a:<br><br>
											<ul>
                        <ul>
                          <li>id</li>
                          <ul>
                            <li>O id da publicação</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>title</li>
                          <ul>
                            <li>O título da publicação</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>description</li>
                          <ul>
                            <li>A descrição da publicação</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>cat</li>
                          <ul>
                            <li>A categoria da publicação</li>
                          </ul>
                        </ul>
                        <br>
												<ul>
                          <li>author</li>
                          <ul>
                            <li>O id do autor da publicação</li>
                          </ul>
                        </ul>
                        <br>
                        <ul>
                          <li>pub_time</li>
                          <ul>
                            <li>Data e hora da publicação</li>
                          </ul>
                        </ul>
											</ul>
											<br>
										</p>
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
	</body>
</html>
