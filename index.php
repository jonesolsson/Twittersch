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

		<div class="login-wrap">
			<form action="index.php" method="POST">
				<label for="user"><i class="ion-ios7-email-outline"></i></label>
				<!-- <i class="ion-ios7-email-outline"></i> -->
				<input type="text" name="user" placeholder="E-post"><br>

				<label for="password"><i class="ion-ios7-locked-outline"></i></label>
				<input type="password" name="password" placeholder="Lösenord"><br>
				
				<input type="submit" value="Logga in"><br><br>
			</form>
		</div>	

	</div>

	<div class="row-fluid">
		
		<div class="form-divide">
			<p>Inte medlem?</p>
		    <p class="pinkish">Registrera!</p>
			<i class="ion-arrow-down-c"></i>
		</div>

	</div>

	<div class="row-fluid">
		
		<div class="register-wrap">
			<form action="index.php" method="POST">
				<input type="text" name="create-username" placeholder="Användarnamn"><br>
				<input type="email" name="create-email" placeholder="E-post"><br>
				<input type="password" name="create-password" placeholder="Lösenord"><br>
				<input type="submit" value="Registrera">
			</form>
		</div>

	</div>




	<div class="errors">

		<?php

		foreach ($errors as $error) {
			print $error . '<br>';
		}

		?>	

	</div>

</div>

<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>	