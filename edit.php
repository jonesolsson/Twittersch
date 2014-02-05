<?php session_start(); if( ! empty($_SESSION['user'])) { 

	  require 'functions/functions.php'; 

	  require 'head.php';	
?>

<body>

<?php require 'navigation.php'; ?>

<div class="container">

	<div class="row-fluid edit">	

		<div class="span3"></div>

		<div class="span6 edit-form-wrap">


			<?php foreach (getCurrentUserId($_SESSION['user_id']) as $user) : 

				if($user['image_url'] == '') {
					$path = 'images/def.jpg';
				} else {
					$path = $user['image_url'];	
				}
				

			?>						

			<form enctype="multipart/form-data" action="edit.php" method="POST">

				<div class="change-pic">	

					<div class="profile-pic">
					
						<img src="<?= sanitize($path) ?>" alt="profile-picture">	

					</div>

					<input type="file" name="upload">					

				</div>	
				
				<input type="hidden" name="id" value="<?= $user['id'] ?>">
				<input type="hidden" name="current_mail" value="<?= sanitize($user['mail']) ?>">
				<input type="hidden" name="current_username" value="<?= sanitize($user['username']) ?>">	
				
				<div class="input-wrap">
					<label for="username">användarnamn</label>
					<input type="text" name="update_username" value="<?= sanitize($user['username']); ?>">
				</div>
				
				<div class="input-wrap">
					<label for="mail">e-post</label>
					<input type="mail" name="update_mail" value="<?= sanitize($user['mail']); ?>">
				</div>

<!-- 				<div class="input-wrap">
					<label for="password">lösenord</label>
					<input type="password" name="update_password">
				</div>	
				<div class="input-wrap">	
					<label for="confirm_password">bekräfta lösenord</label>
					<input type="password" name="update_confirm_password"><br>
				</div> -->
				
				<div class="presentation">
					<label for="presentation">presentation</label>
					<textarea name="update_presentation" cols="30" rows="10"><?= sanitize($user['presentation']); ?></textarea>
					<input type="submit" value="uppdatera">
				</div>
				
			</form>

			<div class="error-wrap">
				
				<?php

				foreach($errors as $error) {
					print '<p>' . $error . '</p>';
				} 

				print $pressErrors;
				print $pressSuccess;

				?>

			</div>	



			<form action="edit.php" method="POST" class="password-form">

				<input type="hidden" name="id" value="<?= $user['id'] ?>">
				
				<div class="input-wrap">
					<label for="password">lösenord</label>
					<input type="password" name="update_password">
				</div>	
				<div class="input-wrap">	
					<label for="confirm_password">bekräfta lösenord</label>
					<input type="password" name="update_confirm_password"><br>
				</div>

				<input type="submit" value="Uppdatera lösenord">				

			</form>

			<?php endforeach; ?>

			<div class="error-wrap">
				
			<?php

				print $passErrors;
				print $passSuccess;

			?>

			</div>	
		
		</div>

		<div class="span3"></div>

	</div>

</div>	

<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>


</body>
</html>

<?php

	} else {	
		header('Location: index.php');
	}
?>