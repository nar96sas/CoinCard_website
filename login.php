<html>
<head>
	<title> Login </title>
	<meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-index.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/style-login.css"/>
	<link rel="stylesheet" media="screen" type="text/css" href="css/reset.css"/>
</head>
<body>
	<div id="header">
		<div class="logo">
			<a href="index.php" title="Coin Card - Get your classical music"> <img src="image/logo.png" alt="Coin Card"> </a>
		</div>
	</div>

	<div class="wpage_lightbox">
		<div class="title_lightbox">
			<label> Sign in </label>
		</div>
		<div class="content-lightbox">
			<div class="fun-login">
				<form method="post" action="validation.php">
					<div class="pdform">
						<?php echo "<input type='hidden' name='url' value='".$_GET['url']."'"; ?>
						<label class="lb"> Login : </label>
						<div class="row"> <input type="text" class="input" name="login"> </div>
						<label class="lb"> Password : </label>
						<div class="row"> <input type="password" class="input" name="password"> </div>
						<div class="box-more-option">
							<span>
								<input type="checkbox" class="rememberpass" name="remember">
								<label class="option"> Remember me </label>
								<button type="submit" class="btn"> Login </button> 
							</span>
						</div>
						<?php
							if ($_GET['hide'] == 0)
								echo "<div class='hide'>";
							else echo "<div>";
						 ?>
							<div class="error">
								<span class="icon"> </span>
								<div class="content-alert" id="loginError"> Wrong Login or Password </div>
							</div>
						</div>
						<div class="box-not-user">
							D'ont have account ? <a href="register.php?error=0&full=1" title="Sign up now"> Sign up now </a> ! 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>