<?php
	session_start();
	$_SESSION['nb-item']--;
	if ($_SESSION['nb-item'] == 0) unset($_SESSION['cart']);
	unset($_SESSION['cart'][$_GET['stt']]);
	header("Location:" . $_GET['url']);
?>