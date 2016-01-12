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
		if (!isset($_GET['error'])) $_GET['error'] = 0; 
	?>
	<title> My Cart </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-cart.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
</head>
<body>
	<?php include('header.php'); ?>
		<div class="contents">
		<?php
			$url = $_SERVER['REQUEST_URI'];
			echo "<form method='post' action='buy_succes.php?id=".$_SESSION["CODE_USER"] ."&url=$url'>";  
			$prix_total = 0;
			?>
			<div class='cmn-h1-basic01'>
				<div class='col01'> <h1> Shopping Cart </h1> </div>
				<div class='col02'>
					<div class="txt01"> Your Credit : 
					<?php
						$query_credit = "select Credit from Abonné where Code_Abonné = ".$_SESSION["CODE_USER"];
						foreach ($pdo->query($query_credit) as $row) {
							echo $row['Credit'];
						}
					?>
					</div>
				</div>
			</div>
			<?php if (empty($_SESSION['cart'])) { ?>
			<div class='box-cart01 cart-empty'>
				<p class='txt01'> You have no items in your shopping cart. </p>
			</div>
			<?php }
			else {
				if ($_GET['error'] == 1) {
						echo "<div class='box-cart01 cart-empty'>";
						echo "	<p class='txt01'> Not enough money to buy this/these items </p>";
						echo "</div>";
					} ?>
				<div class='sec-confirm01'>
					<p class='txt-subtotal01'> Prix </p>
					<div class='sec-confirm01In'>
				<?php
					$stt_item = 0; 
					foreach ($_SESSION['cart'] as $item)  {
					$query_item = "select Code_Morceau, Titre, Prix from Enregistrement where Code_Morceau =". $item;
					foreach ($pdo->query($query_item) as $row) { ?>
								<div class='box-cart02'>
									<div class='col01'>
										<div class='clear-fix'>
						<?php echo "		<p class='title01'> <a href=''>". $row['Titre']." </a> </p>"; 
							  echo "		<input type='hidden' name='code-morceau-".$stt_item."' value='" .$row['Code_Morceau']. "'>"; 
							  echo "		<input type='hidden' name='prix-morceau-".$stt_item."' value='" .$row['Prix']. "'>"; ?>
										</div>
									</div>
									<div class='col02'>
						<?php 	echo "	<p class='txt-price01'>".$row['Prix']." $ </p>"; 
								$prix_total = $prix_total + $row['Prix']; ?>
									</div>
									<div class='col03'>
										<ul class='list-cart01'>
											<?php echo "<li class='list01'> <a href='remove-item.php?url=$url&stt=$stt_item' name='remove' value='$stt_item'> Remove </a></li>";
												echo "<li class='list02'> <button name='stt' type='submit' value='$stt_item'> Buy </button> </li>"; ?>
										</ul>
									</div>
								</div>
						<?php $stt_item++;
					}
				} ?>
					</div>
				</div>
				<?php echo "<input type='hidden' name='nb_items' value='$stt_item'>"; ?>
				<div class="clear-fix mb35">
					<div class="box-payment02">
						<p class="title01"> BUY ALL </p>
						<div class="inner">
							<div class="boxWrap01">
								<div class="box02">
									<?php echo "<button class='btn-buy-all' type='submit' name='buy-all' value='Buy All'>".$prix_total ." $</button>"; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php } ?>
		</div>
	<?php $pdo=NULL ?>
</body>
</html>