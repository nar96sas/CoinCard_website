<?php
	session_start();
	if(!isset($_COOKIE["NOM_USER"]))
	{
		if(isset($_SESSION["NOM_USER"])) {
			$nom = $_SESSION["NOM_USER"];
		}
	}
	else $nom = $_COOKIE["NOM_USER"];
?>
	<div id="header">
		<div class="logo">
			<a href="index.php" title="Coin Card - Get your classical music"> <img src="image/logo.png" alt="Coin Card"> </a>
		</div>
		<div class="section-search">
			<form method="POST" action="search.php" class="search">
				<div class="clearfix">
					<input class="input-txt" type="text" name="input" placeholder="Search from"/>
					<select name="dbo" class="input-select">
						<option value="Oeuvre"> Oeuvre </option>
						<option value="Album"> Album </option>
						<option value="Musicien"> Musicien </option>
						<option value="Enregistrement"> Tracks </option>
					</select>
					<span class="input-btn"> <button type="submit" class="btn-search" title="Search"> </button> </span>
				</div> 
			</form>
		</div>
		<?php if(isset($_SESSION["NOM_USER"]) || isset($_COOKIE["NOM_USER"])) {?>
		<div class="myCarton">
			<a href="cart.php">
				<p class="numberMyCart">
					<?php 
						if (empty($_SESSION['nb-item'])) $_SESSION['nb-item'] = 0;
						echo "<span class='loaded'>".$_SESSION['nb-item']." </span>" ?>
				</p>
				<span class="icon"> </span>
				<span class="txt"> MY CART </span>
			</a>
		</div>
		<?php } ?>
		<div class="account">
			<?php
				if(empty($_SESSION["NOM_USER"]) && empty($_COOKIE["NOM_USER"]))
				{
					$url = $_SERVER['REQUEST_URI'];
					echo "<a class='login' href='login.php?hide=0&url=$url' title='Login'> Login </a>";
					echo "<span> / </span>";
					echo "<a class='sign-up' href='register.php?error=0&full=1' title='Sign up'> Sign up </a>";
				}
				else
				{
					//My Cart

					//Account
					echo "<div class='user'>
							<a class='login' href='account.php' title='Account'>" . $nom . "<i class='icon-s-arrow'></i> </a>
							<div class='tip-dropdown'>
								<span class='arr-top'> </span>
								<ul>
									<li> 
										<a class='fn-profile' href='account.php' title='Account'> 
										<i class='zicon icon-account'> </i>
											Account
										</a> 
									</li>
									<li> 
										<a class='fn-edit' href='' title='Edit'> 
										<i class='zicon icon-update'> </i>
											Edit
										</a> 
									</li>
									<li> 
										<a class='fn-logout' href='logout.php' title='Sign out'> 
										<i class='zicon icon-out'> </i>
											Logout
										</a> 
									</li>
								</ul>	
							</div>
						</div>";
				}
			?>
		</div>
	</div>
	<div class="container">
		<ul>
			<li class="home"> <a title="Coin Card" href="index.php"> Home </a> </li>
			<li> <a title="Album" href="album.php"> Album </a> </li>
			<li> 
				<a title="Musicien" href="musicien.php?init=A"> Musicien </a> 
				<ul class="submenu">
					<li> <a href="compositeur.php" title="Compositeur" > Compositeur </a> </li>
					<li> <a href="interpreteur.php" title="Interpréteur"> Interpréteur </a></li>
					<li> <a href="directeur.php" title="Directeur"> Direteur </a> </li>
				</ul>
			</li>
		</ul>
	</div>
