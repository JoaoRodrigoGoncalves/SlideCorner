<?php
$disciplinas = "SELECT * FROM subject_list ORDER BY name ASC";
$get_disciplinas = @mysqli_query($dbcon, $disciplinas);
if($get_disciplinas){
	$total = '
	<li class="nav-item dropdown">
      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-book"></i> Disciplinas</a>
      		<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
	while($subjects = mysqli_fetch_array($get_disciplinas, MYSQLI_ASSOC)){
    	$total = $total . '<a class="dropdown-item" href="./?subject=' . $subjects['cat'] . '">' . $subjects['name'] . '</a>';
	}
	$total = $total . '</div></li></ul><ul class="navbar-nav"><a href="./newpost.php" class="nav-link"><i class="fas fa-plus"></i> Nova Publicação</a>';
	echo $total;
}else{
	echo '<a class="nav-link" href="#">Erro: ' . mysqli_error($dbcon) . '|' . mysqli_error($get_disciplinas) . '</a>';
}
?>