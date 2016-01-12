<html>
<head>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-musicien-item.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-album-item.css"/>
	<?php
		$driver = 'sqlsrv';
		$host = 'INFO-SIMPLET';
		$nomDb = 'Classique_Web';
		$user = 'ETD'; $password = 'ETD';
		// Chaine de connexion
		$pdodsn = "$driver:Server=$host; Database=$nomDb";
		// Connexion PDO
		$pdo = new PDO($pdodsn, $user, $password);
		$query_title = "select Titre_Oeuvre from Oeuvre where Code_Oeuvre = " . $_GET['code_oeuvre'];
		foreach ($pdo->query($query_title) as $row) {
			$title = $row['Titre_Oeuvre'];
		}
		echo "<title>".  $title. "</title>";
	?>
</head>
<body>
	<?php 
		include('header.php'); 
		$query_info = "Select Nom_Musicien, Titre_Oeuvre, Libellé_Type, Opus from ".
					  		"Musicien inner join (Composer inner join ".  
								"(Oeuvre inner join Type_Morceaux on Oeuvre.Code_Type = Type_Morceaux.Code_Type) ".
							"on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre) on Musicien.Code_Musicien = Composer.Code_Musicien ".
					  "where Oeuvre.Code_Oeuvre = ".$_GET['code_oeuvre'];
		$query_track = "Select Titre, Enregistrement.Code_Morceau from 
							(Oeuvre inner join 
								(Composition_Oeuvre inner join  
									(Enregistrement inner join Composition on Enregistrement.Code_Composition = Composition.Code_Composition) 
								on Composition.Code_Composition = Composition_Oeuvre.Code_Composition) 
							on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
						where Oeuvre.Code_Oeuvre=".$_GET['code_oeuvre']; ?>
		<div class="info-top-play group">
				<div class="info-content">
		<?php	foreach ($pdo->query($query_info) as $row) {
				echo "<h1 class='txt-primary'>" . $row['Titre_Oeuvre'] . "</h1>";
				echo "<div class='info-song-top'>";
				echo "<p> <span> Composer : </span> ". $row['Nom_Musicien'] ."</p>";
				echo "<p> <span> Libellé_Type : </span>". $row[utf8_decode('Libellé_Type')] . "</p>";
				echo "<p> <span> Opus : </span> " . $row['Opus'] . "</p>";
				echo "<p> <span> Structure : </span> </p>";
				echo "</div>";
			}

			foreach ($pdo->query($query_track) as $row) {
				echo "<h3> <a class='fn-name' href='oeuvre-item.php?code_morceau=".$row['Code_Morceau']."'' title='". $row['Titre'] . "'>" ."+ ". $row['Titre'] . " </a> </h3>";
				}
		?>
			</div>
		</div>
	<?php $pdo =null; ?>
</body>
</html>