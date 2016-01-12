<html>
<head>
	<title> Musicien </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-musicien.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-page.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-footer.css"/>
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
		if (!isset($_GET['page']))
			$_GET['page'] = 1;
		$query_total_page = "select count (*) as total from Musicien where (((Nom_Musicien)like '". $_GET["init"] ."%'))";
		foreach ($pdo->query($query_total_page) as $row) {
			$total_page = floor($row['total']/12) + 1; //floor : lấy phần nguyên vd: floor(1.2)
		}
		$start = ($_GET['page']-1) * 10;
		$end = $start + 10;
		$query = "select * from (
					select Nom_Musicien,Prénom_Musicien,Code_Musicien, row_number() over (order by Nom_Musicien) as row from Musicien where (((Nom_Musicien)like '". $_GET["init"] ."%')) 
				) a where row > $start and row <= $end";
	?>
	<div class="box-content">
		<div class="content-wrap">
			<div class="box-singer-full">
				<div class="title_box_key">
					<h3> <a title="Musicien" href="musicien.php?init=A"> Musicien </a> </h3>
					<div class="sing-select-abc">
						<?php
							$nom = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
							for ($i=0; $i < count($nom); $i++)
							{
								if ($_GET['init'] == $nom[$i])
									echo "<a href='musicien.php?init=". $nom[$i] ."' title='". $nom[$i] ."' class='active'>". $nom[$i] . " </a>";
								else 
									echo "<a href='musicien.php?init=". $nom[$i] ."' title='". $nom[$i] ."'>". $nom[$i] . " </a>";
							}
						?>
					</div>
				</div>
				<ul class="list-singer-item">
					<?php
						foreach ($pdo->query($query) as $row) {
							$query_c = "select Musicien.Code_Musicien from Musicien inner join Composer on Musicien.Code_Musicien = Composer.Code_Musicien where Composer.Code_Musicien =" . $row['Code_Musicien'];
							$query_d = "select Musicien.Code_Musicien from Musicien inner join Direction on Musicien.Code_Musicien = Direction.Code_Musicien where Direction.Code_Musicien =" . $row['Code_Musicien'];
							$query_i = "select Musicien.Code_Musicien from Musicien inner join Interpréter on Musicien.Code_Musicien = Interpréter.Code_Musicien where Musicien.Code_Musicien =" . $row['Code_Musicien'];
							if ($pdo->query($query_c)->fetchColumn() != "") $type = "composer";
							if ($pdo->query($query_d)->fetchColumn() != "") $type = "directeur";
							if ($pdo->query($query_i)->fetchColumn() != "") $type = "interpreter";
							else $type = "composer";
							echo "<li>";
							echo "<a title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . "' href='musicien-item.php?code=". $row['Code_Musicien'] ."&type=". $type ."'>";
							echo "<img src='photo_musicien.php?code=" . $row['Code_Musicien'] . "' title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";
							echo "</a>";
							echo "<h3>";
							echo "<a title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . "' href='musicien-item.php?code=". $row['Code_Musicien'] ."&type=". $type ."'>" . $row['Nom_Musicien'] . ' ' . $row[utf8_decode('Prénom_Musicien')]  . "</a>"; 
							echo "</h3>";
							echo "</li>";
						} 
					?>
				</ul>
			</div>
			<div class="pagination">
				<ul>
					<?php
						for ($i=1;$i<=$total_page;$i++)
							echo "<li> <a class='active' href='musicien.php?init=".$_GET['init']."&page=$i'> $i </a></li>";
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php 
		include('footer.php');
		$pdo=NULL;
	?>
</body>
</html>

