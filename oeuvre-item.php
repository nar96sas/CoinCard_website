<html>
<head>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-album-item.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-oeuvre.css"/>
	<?php
		$driver = 'sqlsrv';
		$host = 'INFO-SIMPLET';
		$nomDb = 'Classique_Web';
		$user = 'ETD'; $password = 'ETD';
		// Chaine de connexion
		$pdodsn = "$driver:Server=$host; Database=$nomDb";
		// Connexion PDO
		$pdo = new PDO($pdodsn, $user, $password);
		$query_title = "select Titre from Enregistrement where Code_Morceau = " . $_GET['code_morceau'];
		foreach ($pdo->query($query_title) as $row) {
			$title = $row['Titre'];
		}
		echo "<title>".  $title. "</title>";
	?>
</head>
<body>
	<?php include('header.php'); ?>
	<div class="wrap-body group page-play-song container-2">
		<div class="wrap-content-2">
			<div class="player">
			<div class="cover">
				<div class="mask"> </div>
				<?php 
					echo "<audio src='extrait.php?code=". $_GET['code_morceau'] . "' controls> </audio>" 
				?>
				</div>
			</div>
			<?php
				$url = $_SERVER['REQUEST_URI'];
				echo "<a href='addCart.php?code-track=".$_GET['code_morceau']."&url=$url' class='button-style-1'>"; 
			?>
				<i class="zicon icon-add"></i>
				<span> Add to card </span>
			</a>
			<div class="info-top-play group">
				<div class="info-content">
					<?php
						$query_composer = "select distinct Titre_Oeuvre, Nom_Musicien,Prénom_Musicien,Titre,Prix,Musicien.Code_Musicien,Durée from
												Musicien inner join 
													(Composer inner join
														(Oeuvre inner join 
															(Composition_Oeuvre inner join 
																(Enregistrement inner join Composition on Enregistrement.Code_Composition = Composition.Code_Composition) 
															on Composition_Oeuvre.Code_Composition = Composition.Code_Composition)
														on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
													on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre) 
												on Musicien.Code_Musicien = Composer.Code_Musicien	
									where Enregistrement.Code_Morceau =" . $_GET['code_morceau'];
						$query_interpreter = "select distinct Interpréter.Code_Musicien, Nom_Musicien,Prénom_Musicien from Musicien inner join (Interpréter inner join Enregistrement on Interpréter.Code_Morceau = Enregistrement.Code_Morceau) on Musicien.Code_Musicien = Interpréter.Code_Musicien where Enregistrement.Code_Morceau =" . $_GET['code_morceau'];
						$query_directeur = "select distinct Direction.Code_Musicien, Nom_Musicien, Prénom_Musicien from Musicien inner join (Direction inner join Enregistrement on Direction.Code_Morceau = Enregistrement.Code_Morceau) on Musicien.Code_Musicien = Direction.Code_Musicien where Enregistrement.Code_Morceau =" . $_GET['code_morceau'];
						$query_album = "select distinct Titre_Album, Album.Code_Album from Enregistrement inner join (Composition_Disque inner join (Album inner join Disque on Album.Code_Album = Disque.Code_Album) on Composition_Disque.Code_Disque = Disque.Code_Disque) on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau where Enregistrement.Code_Morceau = ". $_GET['code_morceau'];
						$query_item = "select distinct Titre_Oeuvre,Titre,Prix,Durée from
													Composer inner join
														(Oeuvre inner join 
															(Composition_Oeuvre inner join 
																(Enregistrement inner join Composition on Enregistrement.Code_Composition = Composition.Code_Composition) 
															on Composition_Oeuvre.Code_Composition = Composition.Code_Composition)
														on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
													on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
									where Enregistrement.Code_Morceau =". $_GET['code_morceau'];
						foreach ($pdo->query($query_album) as $row) { 
							$tmp = "<span> and Album : </span> <a title=\"".$row['Titre_Album']."\" href='album_item.php?code_album=".$row['Code_Album']."'>".$row['Titre_Album']."</a> </p>";
						}
						foreach ($pdo->query($query_item) as $row) {
							echo "<h1 class='txt-primary'>" . $row['Titre'] . "</h1>";
							echo "<div class='info-song-top'>";
							echo "	<p> <span> In Oeuvre : </span> <a title=\"". $row['Titre_Oeuvre']."\" href=''>" . $row['Titre_Oeuvre'] . "</a>";
							echo $tmp;
							echo "	<p> <span> Prix : </span>" . $row['Prix'] . "  $ </p>";
							echo "	<p> <span> Durée : </span>" . $row[utf8_decode('Durée')] . " </p>"; 
						}
						echo "	<p> <span> Composer: </span>";
						foreach ($pdo->query($query_composer) as $row) {
							echo "<a title='".$row['Nom_Musicien']." ". $row[utf8_decode('Prénom_Musicien')] ."' href='musicien-item.php?code=".$row['Code_Musicien']."&type=composer'>" . $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . " </a> ,";
						}
						echo "	<p> <span> Interpreter: </span>";
						foreach ($pdo->query($query_interpreter) as $row) {
							echo "<a title='".$row['Nom_Musicien']." ". $row[utf8_decode('Prénom_Musicien')]."' href='musicien-item.php?code=".$row['Code_Musicien']."&type=interpreter'>" . $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . " </a> ,";
						}
						echo " </p>";
						echo "	<p> <span> Director: </span>";
						foreach ($pdo->query($query_directeur) as $row) {
							echo "<a title='".$row['Nom_Musicien']." ". $row[utf8_decode('Prénom_Musicien')]."' href='musicien-item.php?code=".$row['Code_Musicien']."&type=directeur'>" . $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . " </a> ,";
						}
						echo " </p>";
							echo "</div>";  
						?>
				</div>	
			</div>
		</div>
	</div>
</body>
</html>