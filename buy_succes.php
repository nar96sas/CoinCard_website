<?php
	session_start();
	$driver = 'sqlsrv';
	$host = 'INFO-SIMPLET';
	$nomDb = 'Classique_Web';
	$user = 'ETD'; $password = 'ETD';
	// Chaine de connexion
	$pdodsn = "$driver:Server=$host; Database=$nomDb";
	// Connexion PDO
	$pdo = new PDO($pdodsn, $user, $password);
	if (!isset($_POST['buy-all'])) {
		$code_morceau = "code-morceau-" . $_POST['stt'];
		$prix_morceau = "prix-morceau-" . $_POST['stt'];
		$query_buy = "insert into Achat (Code_Enregistrement,Code_Abonné) values ('". $_POST[$code_morceau] ."','". $_GET['id']. "')";
		$pdo->query($query_buy);
		$query_credit = "select Credit from Abonné where Code_Abonné=". $_GET['id'];
		foreach ($pdo->query($query_credit) as $row) {
			$credit = $row['Credit'] - $_POST[$prix_morceau];
			if ($credit < 0) {
				$delete = 0;
				header("Location:" . $_GET['url'] . "?error=1");
			}
			else {
				$query_update = "update Abonné set Credit='$credit' where Code_Abonné = " .$_GET['id'];
				$pdo->query($query_update);
				$delete = 1;
			}
		}
		if ($delete != 0) {
			$_SESSION['nb-item']--;
			if ($_SESSION['nb-item'] == 0) unset($_SESSION['cart']);
			unset($_SESSION['cart'][$_POST['stt']]);
		}
	}
	else
	{
		$query_credit = "select Credit from Abonné where Code_Abonné=". $_GET['id'];
		for($stt_item=0; $stt_item < $_POST['nb_items']; $stt_item++) {
			$code_morceau = "code-morceau-" . $stt_item;
			$prix_morceau = "prix-morceau-" . $stt_item;
			$query_buy = "insert into Achat (Code_Enregistrement,Code_Abonné) values ('". $_POST[$code_morceau] ."','". $_GET['id']. "')";
			$pdo->query($query_buy);
			
			foreach ($pdo->query($query_credit) as $row) {
				if ($credit < 0) {
					$delete = 0;
					header("Location:" . $_GET['url'] . "?error=1");
				}
				else {
					$credit = $row['Credit'] - $_POST[$prix_morceau];
					$query_update = "update Abonné set Credit='$credit' where Code_Abonné = " .$_GET['id'];
					$pdo->query($query_update);
					$delete = 1;
				}
			}
		}
		if ($delete != 0) {
			unset($_SESSION['nb-item']);
			unset($_SESSION['cart']);
		}
	}
	$pdo = NULL;
	if ($delete == 1)
		header("Location:" . $_GET['url']);
?>