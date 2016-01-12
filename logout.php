<?php
	session_start();

	setcookie("NOM_USER","",time() - 3600*24*7);
	session_destroy();
	session_unset();
	header("Location: index.php");
?>