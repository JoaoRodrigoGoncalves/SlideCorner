<?php
session_start();//access the current session.
// if no session variable exists then redirect the user
if (!isset($_SESSION['userid'])) {
header("location: ./");
exit();
//cancel the session and redirect the user:
}else{ //cancel the session
$_SESSION = array(); // Destroy the variables.
session_destroy(); // Destroy the session
header("location: ./");
exit();
}
?>