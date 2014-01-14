<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8">
	<title>Twittersch</title>

</head>
<body>

<?php require 'functions/login.php'; ?>

<form action="index.php" method="POST">
	<input type="text" name="user" placeholder="E-post"><br>
	<input type="password" name="password" placeholder="Lösenord"><br>
	<input type="submit" value="Logga in"><br><br>
</form>

<form action="index.php" method="POST">
	<input type="text" name="create-username" placeholder="Användarnamn"><br>
	<input type="email" name="create-email" placeholder="E-post"><br>
	<input type="password" name="create-password" placeholder="Lösenord"><br>
	<input type="submit" value="Registrera">
</form>

<div class="errors">

	<?php

	foreach ($errors as $error) {
		print $error . '<br>';
	}

	?>	

</div>

</body>
</html>	