<?php require 'functions/login.php'; ?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8">
	<title>Twittersch</title>

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/ionicons.min.css" />

</head>
<body>

<div class="container index-wrap">	

	<div class="row-fluid">
		
		<div class="span4"></div>

		<div class="span4 login-wrap">
			<form action="index.php" method="POST">
				<label for="user"></label>
				<input type="text" name="user" placeholder="E-post"><br>

				<label for="password"></label>
				<input type="password" name="password" placeholder="Lösenord"><br>
				
				<input type="submit" value="Logga in"><br><br>
			</form>
		</div>	

		<div class="span4 error-wrap">
			
			<?= $error ?>

		</div>

	</div>

	<div class="row-fluid">

		<div class="span4"></div>
		
		<div class="span4 form-divide">
			<p>Inte medlem?</p>
		    <p class="pinkish">Registrera!</p>
			<i class="ion-arrow-down-c"></i>
		</div>

		<div class="span4"></div>

	</div>

	<div class="row-fluid">

		<div class="span4"></div>
		
		<div class="span4 register-wrap">
			<form action="index.php" method="POST">
				<input type="text" name="create-username" placeholder="Användarnamn"><br>
				<input type="email" name="create-email" placeholder="E-post"><br>
				<input type="password" name="create-password" placeholder="Lösenord"><br>
				<input type="submit" value="Registrera">
			</form>

			<?= $succes; ?>

		</div>

		<div class="span4 error-wrap">
		
			<?php

				foreach ($errors as $error) {
					print $error . '<br>';
				}

			?>	
		
		</div>	


	</div>

</div>

<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>	