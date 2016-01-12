<html>
<head>
	<title> Register </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-signup-succes.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
</head>
<body>
	<?php
	$driver = 'sqlsrv';
	$host = 'INFO-SIMPLET';
	$nomDb = 'Classique_Web';
	$user = 'ETD'; $password = 'ETD';
	// Chaine de connexion
	$pdodsn = "$driver:Server=$host; Database=$nomDb";
	// Connexion PDO
	$pdo = new PDO($pdodsn, $user, $password);
	?>

	<div class="header">
		<div class="logo">
			<a href="index.php" title="Coin Card - Get your classical music"> <img src="image/logo.png" alt="Coin Card"> </a>
		</div>
	</div>
	<?php
		if ($_POST['nom'] == "" || $_POST['prenom'] == "" || $_POST['password'] == "" || $_POST['login'] == "")
			header("Location: register.php?error=0&full=0");
		else
		{
			$query_check = "select Login from Abonné where Login='" . $_POST['login'] . "'";
			if ($pdo->query($query_check)->fetchColumn() != "") 
			{
				header("Location: register.php?error=1&full=1");
			}
			$query_check_2 = "select Nom_Abonné from Abonné where Nom_Abonné='" . $_POST['nom'] . "'";
			if ($pdo->query($query_check_2)->fetchColumn() != "") 
			{
				header("Location: register.php?error=2&full=1");
			}
			else
			{
				$query_pays = "Select Code_Pays,Nom_Pays from Pays order by Nom_Pays";
				foreach ($pdo->query($query_pays) as $row) {
					if ($_POST['pays'] == $row['Nom_Pays'])
						$code_pays = $row['Code_Pays'];
				} 

				$query = "insert into Abonné (Nom_Abonné, Prénom_Abonné, Login, Password, Adresse, Ville, Code_Pays, Email,Credit) values ('". $_POST['nom'] ."','". $_POST['prenom'] ."','" . $_POST['login'] ."','" . $_POST['password'] ."','" . $_POST['address'] ."','" . $_POST['city'] ."','". $code_pays . "','" . $_POST['email'] ."',100)";
				$pdo->query($query); 	

				/*$query2 = "select Login from Abonné";
				foreach ($pdo->query($query2) as $row) {
					echo $row['Login']. "<br/>";
				}*/
			}
		}
	?>
	<div>
		<div class="wpage bgh">
			<div class="report-complete">
				<p class="title"> Congratulations on a successful registration !</p>
				<p> </p>
				<?php 
					echo "<p> Name : " . $_POST['nom'] . "</p>";
					echo "<p> First Name : " . $_POST['prenom'] . "</p>";
					echo "<p> Login : " . $_POST['login'] . "</p>";	
					echo "<p> Country : " . $_POST['pays'] . "</p>";
					echo "<p> City : " . $_POST['city'] . "</p>";
					echo "<p> Address : " . $_POST['address'] . "</p>";
					echo "<p> Email : " . $_POST['email'] . "</p>";
				?>
				<p class="pdbtn" align="center">
					<a href="login.php?hide=0" class="btn"> Login </a>
				</p>
			</div>
		</div>
	</div>
	<?php $pdo=NULL ?>
</body>
</html>