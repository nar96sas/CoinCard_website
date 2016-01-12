<html>
<head>
	<title> Instrument </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-musicien.css"/>
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
		$query = "Select Code_Instrument, Nom_Instrument from Instrument order by Nom_Instrument";
	?>
	<div class="box-content">
		<div class="content-wrap">
			<div class="box-singer-full">
				<div class="title_box_key">
					<h3> <a title="Musicien" href="Instrument"> Instrument </a> </h3>
				</div>
				<ul class="list-singer-item">
					<?php
						foreach ($pdo->query($query) as $row) {
							echo "<li>";
							echo "<a title='". $row['Nom_Instrument'] . "' href=''>";
							echo "<img src='photo_instrument.php?code=" . $row['Code_Instrument'] . "' title='". $row['Nom_Instrument'] . "' onerror=\"this.src='image/pas_de_photo.jpg'\" />";
							echo "</a>";
							echo "<h3>";
							echo "<a title='". $row['Nom_Instrument'] . "' href=''>" . $row['Nom_Instrument'] . "</a>"; 
							echo "</h3>";
							echo "</li>";
						} 
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php
		$pdo=NULL;
	?>
</body>
</html>

