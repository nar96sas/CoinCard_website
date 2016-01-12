<?php
	if ($_POST['login'] == "" || $_POST['password'] = "")
		header("Location: login.php?hide=1");
	else
	{
		$Password = $_REQUEST["password"];
		$Login = $_REQUEST["login"];
		//$url = $_REQUEST["url"];
		$driver = 'sqlsrv'; $host = 'INFO-SIMPLET';
		$nomDb = 'Classique_Web';
		$user = 'ETD'; $passwordBD = 'ETD';
		$req_txt = "select Login, Password, Nom_Abonné ,Code_Abonné from Abonné where Login='$Login' and Password='$Password'";
		$strConnection = "$driver:Server=$host;Database=$nomDb";

		try {
			$arrExtraParam = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
			$pdo = new PDO($strConnection, $user, $passwordBD,$arrExtraParam);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
			$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
			die($msg);
		}

		$req = $pdo->query($req_txt);
		$CONNECTE = false;
		while ($row = $req->fetch()) {
			$CONNECTE=true;
			$Nom_User=$row[utf8_decode('Nom_Abonné')];
			$Code_User=$row[utf8_decode('Code_Abonné')];
		}
		$req->closeCursor();
		$pdo=NULL;
		if($CONNECTE == true) {
			session_start();
			if($_POST['remember'] == "on")
			{
				setcookie("NOM_USER",$Nom_User,time() + 3600*24*7);
				$_SESSION["NOM_USER"] = $Nom_User;
			}
			else $_SESSION["NOM_USER"] = $Nom_User;
			$_SESSION["CODE_USER"] = $Code_User;
			header("Location: ".$_POST['url']);
		} else { //Mot de passe (et/ou login) incorrect : rejet de l'utilisateur
			header("Location: login.php?hide=1");
		}
	} 
?>
</html>