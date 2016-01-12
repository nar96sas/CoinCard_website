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
		$query_title = "select Titre_Album from Album where Code_Album = " . $_GET['code_album'];
		foreach ($pdo->query($query_title) as $row) {
			$title = $row['Titre_Album'];
		}
		echo "<title>".  $title. "</title>";
	?>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-album-item.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
</head>
<body>
	<?php 
		include('header.php');
		if (!isset($_GET['st']))
			$_GET['st'] = 0;

	?>
	<div class="wrap-content">
		<div class="info-top-play group">
			<?php echo "<img src='photo_album.php?code=" . $_GET['code_album'] . "' onerror=\"this.src='image/pas_de_photo.jpg'\" />"; ?>
			<div class="info-content">
				<?php
					$query = "select Code_Album,Titre_Album, Nom_Editeur, Libellé_Abrégé, Année_Album FROM Genre inner join (Album inner join Editeur on Album.Code_Editeur = Editeur.Code_Editeur) on Genre.Code_Genre = Album.Code_Genre where Code_Album=". $_GET['code_album'];
					$query_tracks = "select distinct Titre,Enregistrement.Code_Morceau,Prix from 
											Musicien inner join 
												(Composer inner join
													(Oeuvre inner join 
														(Composition_Oeuvre inner join 
															(Composition inner join 
																(Enregistrement inner join 
																	(Composition_Disque inner join 
																		(Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
																	on Composition_Disque.Code_Disque = Disque.Code_Disque) 
																on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
															on Enregistrement.Code_Composition = Composition.Code_Composition) 
														on Composition.Code_Composition = Composition_Oeuvre.Code_Composition) 
													on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
												on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre) 
											on Musicien.Code_Musicien = Composer.Code_Musicien 
										where Album.Code_Album =" . $_GET['code_album'];	
					$query_nom_musicien = "select distinct Nom_Musicien,Prénom_Musicien,Musicien.Code_Musicien from 
										Musicien inner join 
											(Composer inner join
													(Oeuvre inner join 
														(Composition_Oeuvre inner join 
															(Composition inner join 
																(Enregistrement inner join 
																	(Composition_Disque inner join 
																		(Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
																	on Composition_Disque.Code_Disque = Disque.Code_Disque) 
																on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
															on Enregistrement.Code_Composition = Composition.Code_Composition) 
														on Composition.Code_Composition = Composition_Oeuvre.Code_Composition) 
													on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
												on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre) 
											on Musicien.Code_Musicien = Composer.Code_Musicien 
										where Album.Code_Album =" . $_GET['code_album'];				
					foreach ($pdo->query($query) as $row)
						echo "<h1 class='txt-primary'>" . $row['Titre_Album'] . "</h1>";
						echo "<div class='info-song-top'>";
						echo "	<p> <span> Editor : </span>" . $row['Nom_Editeur'] . "</p>";
						echo "	<p> <span> Genre : </span>" . $row[utf8_decode('Libellé_Abrégé')] . "</p>"; 
						echo "	<p>  <span> Release : </span>" . $row[utf8_decode('Année_Album')] . "</p>";
						echo "	<p>  <span> Composer: </span>";
						foreach ($pdo->query($query_nom_musicien) as $row2) {
							echo "<a title='".$row2['Nom_Musicien']. " ".$row2[utf8_decode('Prénom_Musicien')]."' href='musicien-item.php?code=".$row2['Code_Musicien']."&type=composer'>" . $row2['Nom_Musicien'] . " ".$row2[utf8_decode('Prénom_Musicien')]. " </a> ,";
						} 
						echo " </p>";
						echo "</div>";  
					?>
			</div>	
		</div>
		<div class="player">
			<div class="cover">
				<div class="mask"> </div>
				<?php 
					foreach ($pdo->query($query_tracks) as $row) {
						if (!isset($_GET['code_morceau']))
							$_GET['code_morceau'] = $row['Code_Morceau'];
						else break;
					}
					echo "<audio src='extrait.php?code=". $_GET['code_morceau'] . "' controls> </audio>" 
				?>
			</div>
			<div class="box-scroll">
				<ul class="playlist">
					<?php
						$stt = 0;
						foreach ($pdo->query($query_tracks) as $row) {
							if ($stt == $_GET['st']) echo "<li class='fn-playlist-item fn-song fn-current'>";
							else echo "<li class='fn-playlist-item fn-song'>";
							echo "	<div class='item-song'>";
							if ($stt == $_GET['st'])
								echo "<span> </span>";
							else
								echo "		<span> $stt </span>";
							echo "		<h3> <a class='fn-name' href='album_item.php?code_album=". $_GET['code_album'] ."&st=$stt&code_morceau=" . $row['Code_Morceau'] . "' title=\"". $row['Titre'] . "\">" . $row['Titre'] . " </a> </h3>";
							echo "		<div class='inline ellipsis'>";
							echo "			<h4>";
							$query_musicien_tracks = "select distinct Nom_Musicien,Prénom_Musicien,Musicien.Code_Musicien from 
										Musicien inner join 
											(Composer inner join
													(Oeuvre inner join 
														(Composition_Oeuvre inner join 
															(Composition inner join Enregistrement 
															on Enregistrement.Code_Composition = Composition.Code_Composition) 
														on Composition.Code_Composition = Composition_Oeuvre.Code_Composition) 
													on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
												on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre) 
											on Musicien.Code_Musicien = Composer.Code_Musicien 
										where Enregistrement.Code_Morceau =" . $row['Code_Morceau'];
							foreach ($pdo->query($query_musicien_tracks) as $row2) {	
								echo "				<a href='musicien-item.php?code=".$row2['Code_Musicien']."&type=composer' title='Composer " . $row2['Nom_Musicien'] . " " . $row2[utf8_decode('Prénom_Musicien')]. "'>" . $row2['Nom_Musicien'] . " " . $row2[utf8_decode('Prénom_Musicien')] . "</a>,";
							}
							echo "			</h4>";
							echo "		</div>";
							echo "		<div class='prix'>";
							echo "			<h4>" . $row['Prix'] . " $ </h4>";
							echo "		</div>";
							echo " 	</div>";
							echo "	<div class='tool-song'>";
							echo "		<div class='i25 i-small addCart'>";
							$url = $_SERVER['REQUEST_URI'];
							echo "			<a href='addCart.php?code-track=".$row['Code_Morceau']."&url=$url' title='Add to Cart'></a>";
							echo "		</div>";
							echo "		<div class='i25 i-small direct'>";
							echo "			<a  title='". $row['Titre'] . "' href='oeuvre-item.php?code_morceau=" . $row['Code_Morceau']."'></a>";
							echo "		</div>";	
							echo "	</div>";
							echo "</li>";
							$stt++;
						}
					?>
				</ul>
			</div>	
		</div>
	</div>
</body>
</html>

