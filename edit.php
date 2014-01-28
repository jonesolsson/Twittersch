<?php require 'functions/functions.php'; ?>
<!DOCTYPE html>
<html>
<head>

	<title>Twittersch</title>

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/ionicons.min.css" />

</head>
<body>

<div class="container">

	<?php require 'navigation.php'; ?>

	<div class="row-fluid">	

		<div class="span4"></div>

			<div class="span4 edit-form-wrap">	

			<?php foreach (getCurrentUser() as $user) : ?>

			<form enctype="multipart/form-data" action="edit.php" method="POST">

				<input type="file" name="upload"><br>
				
				<input type="hidden" name="id" value="<?= $user['id'] ?>">
				<input type="hidden" name="current_mail" value="<?= sanitize($user['mail']) ?>">
				<input type="hidden" name="current_username" value="<?= sanitize($user['username']) ?>">	

				<label for="username">användarnamn</label>
				<input type="text" name="update_username" value="<?= sanitize($user['username']); ?>"><br>

				<label for="mail">e-post</label>
				<input type="mail" name="update_mail" value="<?= sanitize($user['mail']); ?>"><br>

				<label for="password">lösenord</label>
				<input type="password" name="update_password" value="<?= sanitize($user['password']); ?>"><br>
				<label for="confirm_password">bekräfta lösenord</label>
				<input type="password" name="update_confirm_password" value="<?= sanitize($user['password']); ?>"><br><br>

				<label for="presentation">presentation</label><br>
				<textarea name="update_presentation" cols="30" rows="10" value="<?= sanitize($user['presentation']); ?>"></textarea><br>
				
				<input type="submit" value="uppdatera"><br>

			</form>

			<?php endforeach; ?>

			</div>

		<div class="span4"></div>

	</div>

</div>	

</body>
</html>