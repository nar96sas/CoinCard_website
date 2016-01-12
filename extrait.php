<?php
	$driver = 'sqlsrv';
	$host = 'INFO-SIMPLET';
	$nomDb = 'Classique_Web';
	$user = 'ETD'; $password = 'ETD';
	// Chaine de connexion
	$pdodsn = "$driver:Server=$host; Database=$nomDb";
	// Connexion PDO
	$pdo = new PDO($pdodsn, $user, $password);
	$query = "select Extrait from Enregistrement where Code_Morceau=" . $_GET['code'];
	//foreach ($pdo->query($query) as $row) {
	//	echo $row['Extrait'];
	//}
	$stmt = $pdo->query($query);
    $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
    $stmt->fetch(PDO::FETCH_BOUND);
    $video = pack("H*", $lob);

	//Changer le type de contenu de la page dans l'entête HTTP
	header("Content-Type: audio/mpeg");
	//Ecrire ensuite ce flux dans le flux de réponse :
	echo $video; 
	$pdo = null;
?>