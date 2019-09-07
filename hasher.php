<?php
function hasher($string){
	if ((is_null($string)) || (!isset($string))){
		return false;
	}else{
		return hash('sha256', $string);
	}
}
?>