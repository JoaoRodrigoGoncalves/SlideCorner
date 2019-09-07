<?php
function footer(){
	$code = '<hr>
	<div class="d-flex justify-content-center ">
		<div class="p-2"><a href="http://' . $_SERVER['SERVER_NAME'] . '/support/dados-recolhidos.php" style="text-decoration: none;">Dados Recolhidos</a></div>
		<div class="p-2">&copy; ' . date('Y') . ' SlideCorner</div>
		<div class="p-2"><a href="http://' . $_SERVER['SERVER_NAME'] . '/support/web-dev.php" style="text-decoration: none;">Desenvolvedores</a></div>
	</div>';
	return $code;
}
?>