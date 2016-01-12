<html>
<head>
	<title> Register </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-register.css"/>
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

	<div id="header">
		<div class="logo">
			<a href="index.php" title="Coin Card - Get your classical music"> <img src="image/logo.png" alt="Coin Card"> </a>
		</div>
	</div>
	<div class="bgpage">
		<div class="wpage"> 
			<div class="topbanner">
				<div class="pd-regis">
					<a class="btn-login" href="login.php?hide=0" title="Login to CoinCard ID"> Login </a>
					<span> Have an CoinCard ID ?</span>
				</div>
			</div>

			<div class="bregis">
				<div class="left-regis">
					<div class="img-map">
						<img src="image/map.png" width="557" height="530">
					</div>
				</div>

				<form method="post" action="signup-succes.php">
				<div class="right-regis">
					<p class="title-login"> SIGN UP </p>
					<p class="note"> ( <span class="red"> * </span> ) is obligate </p>
					<?php
						if ($_GET['full'] == 0)
							echo "<p class='err lb'> Please enter all information have (*) !</p>";
					?>
					<div class="pdform">
						<label class="lb"> Name : <span class="red"> * </span> </label>
						<div class="row"> 
							<?php
								if ($_GET['error'] == 0 || $_GET['error'] == 1) 
									echo "<input type='text' class='input' name='nom'>"; 
								if ($_GET['error'] == 2)
								{
									echo "<input type='text' class='input2' name='nom'>";
									echo "<p class='err lb'> Name is already used ! </p>";
								}
							?>
						</div>
						<label class="lb"> First Name : <span class="red"> * </span> </label>
						<div class="row"> <input type="text" class="input" name="prenom"> </div>
						<label class="lb"> Login : <span class="red"> * </span> </label> 
						<div class="row">
							<?php
								if ($_GET['error'] == 0 || $_GET['error'] == 2) 
									echo "<input type='text' class='input' name='login'>"; 
								if ($_GET['error'] == 1)
								{
									echo "<input type='text' class='input2' name='login'>";
									echo "<p class='err lb'> ID is already used ! </p>";
								}
							?>
						</div>
						<label class="lb"> Password : <span class="red"> * </span> </label>
						<div class="row"> <input type="password" class="input" name="password"> </div>
						<label class="lb"> Country : <label class="city"> City : </label> </label> 	
						<div class="row">
							<select name="pays" class="input country">
								<?php
									$query = "Select Code_Pays,Nom_Pays from Pays order by Nom_Pays";
									foreach ($pdo->query($query) as $row) { 
										echo "<option value='" . $row['Nom_Pays'] . "'>" . $row['Nom_Pays'] . "</option>";
									}	
								?>
							</select>
							<input type="text" class="input country ip-city" name="city">
						</div>
						<label class="lb"> Address : </label>
						<div class="row"> <input type="text" class="input" name="address"> </div>
						<label class="lb"> Email : </label>
						<div class="row"> <input type="email" class="input" name="email"> </div>
						<div class="row-btn">
							<input type="submit" value="Sign Up" class="btn">
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php $pdo=NULL ?>
</body>
</html>