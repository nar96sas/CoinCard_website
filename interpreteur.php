<html>
<head>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-musicien.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-footer.css"/>
	<title> Interpréteur </title>
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
		if (!isset($_GET["init"]))
			$_GET["init"] = "A";
		$query = "Select distinct Interpréter.Code_Musicien,Nom_Musicien,Prénom_Musicien from Musicien inner join Interpréter on Musicien.Code_Musicien = Interpréter.Code_Musicien where (((Nom_Musicien)like '". $_GET["init"] ."%')) order by Nom_Musicien";
	?>
	<div class="box-content">
		<div class="content-wrap">
			<div class="box-singer-full">
				<div class="title_box_key">
					<h3> <a title="Intépreteur" href="interpreteur.php?init=A"> Interpréteur </a> </h3>
					<div class="sing-select-abc">
						<?php
							$nom = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
							for ($i=0; $i < count($nom); $i++)
							{
								if ($_GET['init'] == $nom[$i])
									echo "<a href='interpreteur.php?init=". $nom[$i] ."' title='". $nom[$i] ."' class='active'>". $nom[$i] . " </a>";
								else 
									echo "<a href='interpreteur.php?init=". $nom[$i] ."' title='". $nom[$i] ."'>". $nom[$i] . " </a>";
							}
						?>
					</div>
				</div>
				<ul class="list-singer-item">
					<?php
						foreach ($pdo->query($query) as $row) {
							echo "<li>";
							echo "<a title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . "' href='musicien-item.php?code=" . $row['Code_Musicien'] . "&type=interpreter'>";					
							echo "<img src='photo_musicien.php?code=" . $row['Code_Musicien'] . "' title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";
							echo "</a>";
							echo "<h3>";
							echo "<a title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . "' href='musicien-item.php?code=" . $row['Code_Musicien'] . "&type=interpreter'>" . $row['Nom_Musicien'] . ' ' . $row[utf8_decode('Prénom_Musicien')]  . "</a>"; 
							echo "</h3>";
							echo "</li>";
						} 
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

