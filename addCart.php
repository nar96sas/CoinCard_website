<?php
	session_start();
	if (!isset($_SESSION['NOM_USER']))
		header("Location:login.php?hide=0&url=".$_GET['url']);
	else {
		if (isset($_SESSION['cart'])) {
			array_push($_SESSION['cart'],$_GET['code-track']);
			$_SESSION['nb-item']++;
		}
		else {
			$_SESSION['cart'] = array($_GET['code-track']);
			$_SESSION['nb-item']++;
		}
		header("Location:" . $_GET['url']);
	}
?>