<?php
	$pdo = new PDO("sqlsrv:Server=INFO-SIMPLET;Database=Classique_Web", "ETD", "ETD");
	$query = "select Pochette FROM Album WHERE Code_Album=". $_GET['code'];
	$stmt = $pdo->query($query);
    $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
    $stmt->fetch(PDO::FETCH_BOUND);
    $image = pack("H*", $lob);

	//Changer le type de contenu de la page dans l'entête HTTP
	header("Content-Type: image/jpeg");
	//Ecrire ensuite ce flux dans le flux de réponse :
	echo $image; 
	$pdo = null;
?>