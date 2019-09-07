<?php
session_start();
require('../mysqli_connect.php');
require('../news.php');
require('../footer.php');
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>SlideCorner</title>
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
										<h4 class="card-title">Dados Recolhidos Pelo Website (<?php echo $_SERVER['SERVER_NAME']; ?>)</h4>
										<p class="card-text">
											O endereço IP (Internet Protocol) de todos os utilizadores é registado nas nossas bases de dados por motivos de segurança (IP não disponível na <a href="./web-dev.php">API de Desenvolvedor</a>). Como por exemplo, usamos o IP para banir utilizadores e as suas possíveis contas secundárias do nosso website. Alguns casos que levam a um banimento por IP são:
											<ul>
												<li>Desrespeito dos <a href="./termos-de-uso.php">Termos de Serviço</a>;</li>
												<li>Tentativas de burla do website;</li>
												<li>etc.</li>
											</ul>
											Registamos a data e hora em que os utilizadores iniciam sessão para uso:
											<ul>
												<li>No estado online/offline dos utilizadores (Brevemente);</li>
												<li>Na <a href="./web-dev.php">API de Desenvolvedor</a>;</li>
												<li>Analizes de tempo offline dos utilizadores a escala global.</li>
											</ul>
											Registamos ainda os contúdos pelos quais os utilizadores navegam e/ou transferem de forma a calcular as publicações mais visitadas.
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