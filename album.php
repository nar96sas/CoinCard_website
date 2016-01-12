<html>
<head>
	<title> Album </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-album.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-footer.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-page.css"/>
</head>
<body>
	<?php
		include('header.php');
		$driver = 'sqlsrv';
		$host = 'INFO-SIMPLET';
		$nomDb = 'Classique_Web';
		$user = 'ETD'; $password = 'ETD';
		// Chaine de connexion
		$pdodsn = "$driver:Server=$host; Database=$nomDb";
		// Connexion PDO
		$pdo = new PDO($pdodsn, $user, $password);
		if (!isset($_GET['code']))
			$_GET['code'] = 1;
		if (!isset($_GET['page']))
			$_GET['page'] = 1;
	?>
	<div class="wrap-2-col">
		<div class="sidebar">
			<div class="mCustomScrollBar">
				<div class="mCustomScrollBox">
					<div class="mContainer">
						<ul class="data-list">
							<li class> Genre </li>
							<ul>
								<?php
									$query_genre = "select Code_Genre, Libellé_Abrégé from Genre";
									foreach ($pdo->query($query_genre) as $row) {
										if ($_GET['code'] == $row['Code_Genre'])
											echo "<li class='active'>";
										else 
											echo "<li class>"; 
										echo "<a href='album.php?code=" . $row['Code_Genre'] . "' title='" . $row[utf8_decode('Libellé_Abrégé')] . "'>" . $row[utf8_decode('Libellé_Abrégé')] . "</a>";
										echo "</li>";
									}
								?>
							</ul>
						</ul>
					</div>
				</div>	
			</div>
		</div>
		<div class="zcontent">
			<?php 
				$query_title = "select Code_Genre, Libellé_Abrégé from Genre where Code_Genre=" . $_GET['code'];
				foreach ($pdo->query($query_title) as $row)
					$title = $row[utf8_decode('Libellé_Abrégé')];
				echo "<h1 class='title-section'> $title </h1>";
			?>
			<div class="tab-pane">
				<?php
					$query_total_page = "select count (*) as total from Album inner join Editeur on Album.Code_Editeur = Editeur.Code_Editeur where Code_Genre = " . $_GET['code'];
					foreach ($pdo->query($query_total_page) as $row) {
						$total_page = floor($row['total']/12) + 1; //floor : lấy phần nguyên vd: floor(1.2)
					}
					$start = ($_GET['page']-1) * 12;
					$end = $start + 12;
					$query = "select * from (
								select Code_Album,Titre_Album, Nom_Editeur, Code_Genre, row_number() over (order by Année_Album) as row FROM 
								Album inner join Editeur on Album.Code_Editeur = Editeur.Code_Editeur where Code_Genre = " . $_GET['code'] . ") a where row > $start and row <= $end";
					foreach($pdo->query($query) as $row) {
						echo "<div class='pone-of-four'>";
						echo "	<div class='item'>";
						echo "		<a title='". $row['Titre_Album'] . "' href='album_item.php?code_album=" . $row['Code_Album'] . "' class='thumb'>";
						echo "			<img width='240' src='photo_album.php?code=" . $row['Code_Album'] . "' title='". $row['Titre_Album'] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";
						echo "		</a>";
						echo "		<div class='description'>";
						echo "			<h2 class='title-item ellipsis'>";
						echo "				<a title='". $row['Titre_Album'] . "' href='album_item.php?code_album=". $row['Code_Album'] ."'>" . $row['Titre_Album'] . "</a>";
						echo "			</h2>";
						echo "			<div class='inblock ellipsis'>";
						echo "				<h4 class='title-sd-item'>";
						echo "					<a href=''>" . $row['Nom_Editeur'] . " </a>";
						echo "				</h4>";
						echo "			</div>";
						echo "		</div>";
						echo "	</div>";
						echo "</div>";
					}
				?>
			</div>
			<div class="pagination">
				<ul>
					<?php
						for ($i=1;$i<=$total_page;$i++)
							echo "<li> <a class='active' href='album.php?code=".$_GET['code']."&page=$i'> $i </a></li>";
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php
		include('footer.php');
		$pdo = null;
	?>
</body>
</html>