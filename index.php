<?php
session_start();
require('mysqli_connect.php');
require('news.php');
require('truncate.php');
require('footer.php');
?>
<html lang="pt">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<title>SlideCorner</title>
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
								<nav class="navbar navbar-expand-sm">
									<form class="form-inline" action="./" method="GET">
										<input class="form-control" type="text" name="q" placeholder="Procurar" value="<?php if(isset($_GET['q'])){echo $_GET['q'];} ?>">
										<select class="form-control" name="subject">
											<option value="all">Todas</option>
											<?php
											$disciplinas = "SELECT * FROM subject_list ORDER BY name ASC";
											$get_disciplinas = @mysqli_query($dbcon, $disciplinas);
											if($get_disciplinas){
												while($subjects = mysqli_fetch_array($get_disciplinas, MYSQLI_ASSOC)){
													echo '<option value="' . $subjects['cat'] . '"';
													if((isset($_GET['subject'])) && ($_GET['subject'] == $subjects['cat'])){
														echo 'selected';
													}
													echo '>' . $subjects['name'] . '</option>';
												}
											}else{
												echo '<option>Error</option>';
											}
											?>
										</select>
										<button class="btn btn-success" type="submit">Search</button>
									</form>
								</nav>
								<!-- Start list code -->
									<?php
									if(isset($_GET['subject'])){
										if($_GET['subject'] != "all"){
											$subject = mysqli_real_escape_string($dbcon, $_GET['subject']);
										}
									}
									if(isset($_GET['q'])){
										if($_GET['q'] != ""){
											$q = mysqli_real_escape_string($dbcon, $_GET['q']);
										}
									}
									if((isset($subject)) && (isset($q))){
										$query = "SELECT * FROM posts WHERE cat='$subject' AND title LIKE '%$q%' OR description LIKE '%$q%' ORDER BY pub_time DESC";
									}elseif (isset($subject)) {
										$query = "SELECT * FROM posts WHERE cat='$subject' ORDER BY pub_time DESC";
									}elseif (isset($q)) {
										$query = "SELECT * FROM posts WHERE title LIKE '%$q%' OR description LIKE '%$q%' ORDER BY pub_time DESC";
									}else{
										$query = "SELECT * FROM posts ORDER BY pub_time DESC";
									}
									if(!isset($query)){
										echo '
										<div class="card">
											<div class="card-body">
												<h4 class="card-title">Internal Server Error</h4>
												<p class="card-text">The server couldn\'t fetch any posts due to a server error. Please try again later.</p>
												<p>Error id: query_not_set</p>
											</div>
										</div>';
									}else{
										$get_posts = @mysqli_query($dbcon, $query);
										if($get_posts){
											if(mysqli_num_rows($get_posts) != 0){
												while($post = mysqli_fetch_array($get_posts, MYSQLI_ASSOC)){
													if(!is_null($post['password'])){
														$lock = '<i class="fas fa-lock"></i>';
													}else{
														$lock = "";
													}
													echo '
													<div class="card">
														<a href="./showpost.php?p=' . $post['id'] . '" style="color:black; text-decoration: none;">
															<div class="card-body">
																<h4 class="card-title">' . $lock . '' . $post['title'] . '</h4>
																<p class="card-text">' . truncate($post['description'], 100) . '</p>
															</div>
														</a>
													</div>';
												}
											}else{
												echo '
												<div class="card">
													<div class="card-body">
														<h4 class="card-title">Não foi possível encontrar resultados para a tua pesquisa!</h4>
														<p class="card-text">
														Exprimenta procurar por palavras-chave.<br>
														Ex.: tsunami
														</p>
														<p><b>ou</b> <a href="./newpost.php"><button type="button" class="btn btn-success">Cria a tua propria publicação!</button></a></p>
													</div>
												</div>';
											}
										}else{
											echo '
											<div class="card">
												<div class="card-body">
													<h4 class="card-title">Internal Server Error</h4>
													<p class="card-text">The server couldn\'t fetch any posts due to a server error. Please try again later.</p>
													<p>Error id: couldnt_get_posts</p>
												</div>
											</div>';
										}
									}
									?>
								<!-- End list code -->
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
