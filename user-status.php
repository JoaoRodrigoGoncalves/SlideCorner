<?php
if(isset($_SESSION['userid'])){
	echo '<li class="nav-item"><a href="http://' . $_SERVER['SERVER_NAME'] . '/settings.php" class="nav-link"><i class="fas fa-sliders-h"></i> Gestão da conta</a></li>';
	echo '<li class="nav-item"><a href="http://' . $_SERVER['SERVER_NAME'] . '/logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Terminar Sessão</a></li>';
}else{
	echo '<li class="nav-item"><a href="http://' . $_SERVER['SERVER_NAME'] . '/login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
	echo '<li class="nav-item"><a href="http://' . $_SERVER['SERVER_NAME'] . '/register.php" class="nav-link"><i class="fas fa-user-plus"></i> Registar</a></li>';
}
?>
