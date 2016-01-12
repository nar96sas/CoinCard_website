<html>
<head>
	<?php
		$driver = 'sqlsrv';
		$host = 'INFO-SIMPLET';
		$nomDb = 'Classique_Web';
		$user = 'ETD'; $password = 'ETD';
		// Chaine de connexion
		$pdodsn = "$driver:Server=$host; Database=$nomDb";
		// Connexion PDO
		$pdo = new PDO($pdodsn, $user, $password);
		echo "<title> Search : ".$_POST['input']."</title>";
	?>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-oeuvre.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
</head>
<body>
	<?php
		include('header.php');
			switch ($_POST['dbo']) {
				case "Oeuvre" :
					$query_search = "select Oeuvre.Code_Oeuvre, Titre_Oeuvre, Année, Libellé_Type, Nom_Musicien from Type_Morceaux inner join (Musicien inner join (Oeuvre inner join Composer on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre) on Musicien.Code_Musicien = Composer.Code_Musicien) on Type_Morceaux.Code_Type = Oeuvre.Code_Type where (((Titre_Oeuvre)like '". $_POST['input'] ."%'))";
					foreach ($pdo->query($query_search) as $row) {								
						echo "<p>" . $row['Titre_Oeuvre'] . " " . $row['Nom_Musicien'] ." </p>";
						echo "<p> Genre : " . $row[utf8_decode('Libellé_Type')] ."</p><br/>"; 
					}
					break;
				case "Musicien" :
					$query_search = "select Nom_Musicien, Prénom_Musicien, Musicien.Code_Musicien, Nom_Pays from Pays inner join Musicien on Pays.Code_Pays = Musicien.Code_Pays where (((Nom_Musicien)like '". $_POST['input'] ."%')) OR (((Prénom_Musicien)like '". $_POST['input'] ."%'))";
					foreach ($pdo->query($query_search) as $row) {
						echo "<img src='photo_musicien.php?code=" . $row['Code_Musicien'] . "' title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";	
						echo "<p>" . $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ." </p>";
						echo "<p> Country : " . $row['Nom_Pays'] ."</p><br/>"; 
					}
					break;
				case "Album" :
					$query_search = "select * from Album inner join Genre on Album.Code_Genre = Genre.Code_Genre where (((Titre_Album)like '". $_POST['input'] ."%'))";
					foreach ($pdo->query($query_search) as $row) {
						echo "<img src='photo_album.php?code=" . $row['Code_Album'] . "' title='". $row['Titre_Album'] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";	
						echo "<p>" . $row['Titre_Album'] ." </p>";
						echo "<p> Genre : " . $row[utf8_decode('Libellé_Abrégé')] ."</p>"; 
						echo "<p> Release : " . $row[utf8_decode('Année_Album')] ."</p><br/>"; 
					}
					break;
				case "Enregistrement" :
					$query_search = "select distinct Titre_Album, Album.Code_Album,Titre from Enregistrement inner join (Composition_Disque inner join (Album inner join Disque on Album.Code_Album = Disque.Code_Album) on Composition_Disque.Code_Disque = Disque.Code_Disque) on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau where (((Titre)like '". $_POST['input'] ."%'))";
						foreach ($pdo->query($query_search) as $row) {
							echo "<p>" . $row['Titre'] ." </p>";
							echo "<p> In Album : " . $row['Titre_Album'] ." </p><br/>";
						}
					break;	
			}
	?>
</body>
</html>