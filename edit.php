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

		<div class="span3"></div>

		<div class="span6 edit-form-wrap">

			<?php foreach (getCurrentUser() as $user) : 


			foreach(getProfileImg($user['username']) as $user) {

			 	$path = $user['url'];

			}

			?>
						

			<form enctype="multipart/form-data" action="edit.php" method="POST">

				<div class="change-pic">	

					<div class="profile-pic">
					
						<img src="<?= $path ?>" alt="profile-picture">	

					</div>

					<input type="file" name="upload"><br>					

				</div>	
				
				<input type="hidden" name="id" value="<?= $user['id'] ?>">
				<input type="hidden" name="current_mail" value="<?= sanitize($user['mail']) ?>">
				<input type="hidden" name="current_username" value="<?= sanitize($user['username']) ?>">	
				
				<div class="input-wrap">
					<label for="username">användarnamn</label>
					<input type="text" name="update_username" value="<?= sanitize($user['username']); ?>"><br>
				</div>
				
				<div class="input-wrap">
					<label for="mail">e-post</label>
					<input type="mail" name="update_mail" value="<?= sanitize($user['mail']); ?>"><br>
				</div>

				<div class="input-wrap">
					<label for="password">lösenord</label>
					<input type="password" name="update_password" value="<?= sanitize($user['password']); ?>"><br>
				</div>	
				<div class="input-wrap">	
					<label for="confirm_password">bekräfta lösenord</label>
					<input type="password" name="update_confirm_password" value="<?= sanitize($user['password']); ?>"><br><br>
				</div>
				
				<div class="presentation">
					<label for="presentation">presentation</label>
					<textarea name="update_presentation" cols="30" rows="10" value="<?= sanitize($user['presentation']); ?>"></textarea><br>
					<input type="submit" value="uppdatera">
				</div>
				
			</form>

			<?php endforeach; ?>
		
		</div>

		<div class="span3"></div>

	</div>


</div>	

</body>
</html>