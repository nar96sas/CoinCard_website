<?php
					echo "<div class='info-top-play group'>
						<div class='info-content'>";
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
									where (((Titre)like '". $_POST['input'] ."%'))";
						$query_interpreter = "select distinct Interpréter.Code_Musicien, Nom_Musicien,Prénom_Musicien from Musicien inner join (Interpréter inner join Enregistrement on Interpréter.Code_Morceau = Enregistrement.Code_Morceau) on Musicien.Code_Musicien = Interpréter.Code_Musicien where (((Titre)like '". $_POST['input'] ."%'))";
						$query_directeur = "select distinct Direction.Code_Musicien, Nom_Musicien, Prénom_Musicien from Musicien inner join (Direction inner join Enregistrement on Direction.Code_Morceau = Enregistrement.Code_Morceau) on Musicien.Code_Musicien = Direction.Code_Musicien where (((Titre)like '". $_POST['input'] ."%'))";
						$query_album = "select distinct Titre_Album, Album.Code_Album from Enregistrement inner join (Composition_Disque inner join (Album inner join Disque on Album.Code_Album = Disque.Code_Album) on Composition_Disque.Code_Disque = Disque.Code_Disque) on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau where (((Titre)like '". $_POST['input'] ."%'))";
						$query_item = "select distinct Titre_Oeuvre,Titre,Prix,Durée from
													Composer inner join
														(Oeuvre inner join 
															(Composition_Oeuvre inner join 
																(Enregistrement inner join Composition on Enregistrement.Code_Composition = Composition.Code_Composition) 
															on Composition_Oeuvre.Code_Composition = Composition.Code_Composition)
														on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
													on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
									where (((Titre)like '". $_POST['input'] ."%'))";
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
						echo " </p> </div> </div> </div> ";
			?>