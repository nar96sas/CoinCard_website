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
		$query_title = "select Nom_Musicien, Prénom_Musicien, Année_Naissance, Année_Mort, Nom_Pays from Musicien inner join Pays on Pays.Code_Pays = Musicien.Code_Pays where Code_Musicien = " . $_GET['code'];
		foreach ($pdo->query($query_title) as $row) {
			$title = $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ;
		}
		echo "<title>".  $title. "</title>";
	?>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-musicien-item.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-album.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-footer.css"/>	
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-page.css"/>	
</head>
<body>
	<?php
		if (!isset($_GET['page']))
			$_GET['page'] = 1;
		switch ($_GET['type']) {
			case "interpreter":
				$query_total_page = "select count (*) as total from Enregistrement inner join Interpréter on Enregistrement.Code_Morceau = Interpréter.Code_Morceau where Code_Musicien = " . $_GET['code'];		
				break;
			case "directeur":
				$query_total_page = "select count (*) as total from Enregistrement inner join Direction on Enregistrement.Code_Morceau = Direction.Code_Morceau where Code_Musicien = " . $_GET['code'];
				break;
			case "composer":
				$query_total_page = "select count (*) as total from Oeuvre inner join Composer on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre where Composer.Code_Musicien =". $_GET['code'];
				break;
		}
		
		foreach ($pdo->query($query_total_page) as $row) {
			$total_page = floor($row['total']/12) + 1; //floor : lấy phần nguyên vd: floor(1.2)
		}
		$start = ($_GET['page']-1) * 10;
		$end = $start + 10; 
		include('header.php');
	?>
	<div class="full-banner">
		<div class="container-2">
		<?php echo "<img src='image/" . $_GET['type'] . ".jpg'>"; ?>
			<div class="box-info-artist">
				<div class="info-artis fluid">
					<div class="inside">
						<?php echo "<img src='photo_musicien.php?code=" . $_GET['code']  . "' onerror=\"this.src='image/pas_de_photo.jpg'\" >"; ?>
						<div class="info-summary">
							<div class="info-summary-title">
								<?php 
									foreach ($pdo->query($query_title) as $row) {
										echo "<h1>" . $title . "</h1>";
										echo "<p> Birthday: " . $row[utf8_decode('Année_Naissance')] . "</p>";
										echo "<p> Died: " . $row[utf8_decode('Année_Mort')] . "</p>";
										echo "<p> Country: " . $row['Nom_Pays'] . "</p>";
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrap-body group page-artist-all page-artist container-2">
		<div class="wrap-2-col">
			<div class="wrap-content">
				<h2 class="title-section"> <a> Oeuvre </a> </h2>
				<div class="list-item full-width">
					<ul class="playlist">
						<?php
							switch ($_GET['type']) {
								case "composer" :
									$query_oeuvre = "select * from (
														select Titre_Oeuvre,Oeuvre.Code_Oeuvre,row_number() over (order by Titre_Oeuvre) as row from Oeuvre inner join Composer on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre where Code_Musicien =".$_GET['code']."
													) a where row > $start and row <= $end";
									foreach ($pdo->query($query_oeuvre) as $row) {
										echo "<li class='fn-playlist-item fn-song'>";
										echo "	<div class='item-song'>";
										echo "<h3> <a class='fn-name' href='composer_oeuvre.php?code_oeuvre=".$row['Code_Oeuvre']."'' title='". $row['Titre_Oeuvre'] . "'>" . $row['Titre_Oeuvre'] . " </a> </h3>";
										echo "	</div>";
										echo "</li>";
									}
									break;
								case "directeur" :
									$query_oeuvre = "select * from (
														select distinct Titre,Enregistrement.Code_Morceau,row_number() over (order by Titre) as row from Enregistrement inner join Direction on Enregistrement.Code_Morceau = Direction.Code_Morceau where Code_Musicien = " . $_GET['code'] . "
													) a where row > $start and row <= $end";
									foreach ($pdo->query($query_oeuvre) as $row) {
										echo "<li class='fn-playlist-item fn-song'>";
										echo "	<div class='item-sonqg'>";
										echo "<h3> <a class='fn-name' href='oeuvre-item.php?code_morceau=".$row['Code_Morceau']."'' title='". $row['Titre'] . "'>" . $row['Titre'] . " </a> </h3>";
										echo "	</div>";
										echo "</li>";
									}
									break;
								case "interpreter" :
									$query_oeuvre = "select * from (
														select distinct Titre,Enregistrement.Code_Morceau,row_number() over (order by Titre) as row from Enregistrement inner join Interpréter on Enregistrement.Code_Morceau = Interpréter.Code_Morceau where Code_Musicien = " . $_GET['code'] . "
													) a where row > $start and row <= $end";
									foreach ($pdo->query($query_oeuvre) as $row) {
										echo "<li class='fn-playlist-item fn-song'>";
										echo "	<div class='item-song'>";
										echo "<h3> <a class='fn-name' href='oeuvre-item.php?code_morceau=".$row['Code_Morceau']."'' title='". $row['Titre'] . "'>" . $row['Titre'] . " </a> </h3>";
										echo "	</div>";
										echo "</li>";
									}									
									break;
							}
						?>
					</ul>
				</div>
			</div>
			<div class="pagination">
				<ul>
					<?php
						for ($i=1;$i<=$total_page;$i++)
							echo "<li> <a class='active' href='musicien-item.php?code=".$_GET['code']."&type=".$_GET['type']."&page=$i'> $i </a></li>";
					?>
				</ul>
			</div>
			<div class="wrap-content">
				<h2 class="title-section"> <a> Album </a> </h2>
				<div class="list-item full-width">
						<?php
							switch ($_GET['type']) {
								case "composer" :
									$query_album = "select distinct Album.Code_Album, Titre_Album, Nom_Musicien, Année_Album from 
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
										where Composer.Code_Musicien = ". $_GET['code'];
									break;
								case "interpreter" : 
									$query_album = "select distinct Album.Code_Album, Titre_Album, Nom_Musicien, Année_Album from 
											Musicien inner join 
															(Interpréter inner join 
																(Enregistrement inner join 
																	(Composition_Disque inner join 
																		(Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
																	on Composition_Disque.Code_Disque = Disque.Code_Disque) 
																on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
															on Enregistrement.Code_Morceau = Interpréter.Code_Morceau)  
											on Musicien.Code_Musicien = Interpréter.Code_Musicien 
										where Interpréter.Code_Musicien = ". $_GET['code'];
									break;
								case "directeur" :
									$query_album = "select distinct Album.Code_Album, Titre_Album, Nom_Musicien, Année_Album from 
											Musicien inner join 
															(Direction inner join 
																(Enregistrement inner join 
																	(Composition_Disque inner join 
																		(Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
																	on Composition_Disque.Code_Disque = Disque.Code_Disque) 
																on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
															on Enregistrement.Code_Morceau = Direction.Code_Morceau)  
											on Musicien.Code_Musicien = Direction.Code_Musicien 
										where Direction.Code_Musicien = ". $_GET['code'];
									break;
							}
							foreach ($pdo->query($query_album) as $row) {
								echo "<div class='pone'>
									<div class='item'>
									<a title='". $row['Titre_Album'] . "' href='album_item.php?code_album=" . $row['Code_Album'] . "' class='thumb'>
										<img width='240' src='photo_album.php?code=" . $row['Code_Album'] . "' title='". $row['Titre_Album'] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />
									</a>
									<div class='description'>
										<h2 class='title-item ellipsis'>
											<a title='". $row['Titre_Album'] . "' href='album_item.php?code_album=". $row['Code_Album'] ."'>" . $row['Titre_Album'] . "</a>
										</h2>
										<div class='inblock ellipsis'>
											<h4 class='title-sd-item'> <a href=''>" . $row[utf8_decode('Année_Album')] . " </a> </h4>
										</div>
									</div> </div> </div>";
							}
						?>			
				</div>
			</div>
			<?php 
				switch ($_GET['type']) {
					case "directeur" :
						$query_do = "select distinct Nom_Orchestre from Direction inner join Orchestres on Direction.Code_Orchestre = Orchestres.Code_Orchestre where Code_Musicien =". $_GET['code'];
						echo "<div class='wrap-content'>
								<h2 class='title-section'> <a> Orchestre </a> </h2>
								<div class='list-item full-width'>
									<ul class='playlist'>";
										foreach ($pdo->query($query_do) as $row) {
											echo "<li class='fn-playlist-item fn-song'>
													<div class='item-song'>
														<h3>" . $row['Nom_Orchestre'] . "</h3>
													</div>
												</li>";
											}
						
								echo"</ul>
								</div> </div>";
						break;
					case "interpreter" :
						$query_ii = "select distinct Interpréter.Code_Instrument,Nom_Instrument from Instrument inner join Interpréter on Instrument.Code_Instrument = Interpréter.Code_Instrument where Code_Musicien=" . $_GET['code'];
						echo "<div class='wrap-content'>
								<h2 class='title-section'> <a> Instrument </a> </h2>
								<div class='list-item full-width'>
									<ul class='instrument'>";
										foreach ($pdo->query($query_ii) as $row) {
											echo "<li>
													<img src='photo_instrument.php?code=" . $row['Code_Instrument'] . "' title='". $row['Nom_Instrument'] . "' onerror=\"this.src='image/pas_de_photo.jpg'\" />
													<h3> ". $row['Nom_Instrument'] . "</h3>
											</li>";
										} 
								echo"</ul>
								</div> </div>";									
						break;			
					}	
			?>
		</div>
	</div>
	<?php
		include('footer.php');
		$pdo=NULL;
	?>
</body>
</html>

