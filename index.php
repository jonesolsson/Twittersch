<?php require 'functions/login.php';
	  require 'head.php';	
 ?>

<body>

	<div class="container index-wrap">	

		<div class="row-fluid logo-wrap">
		
			<div class="span4"></div>

			<div class="span4">
				<h1>Twittershh...</h1>
				<p>share your whispers</p>
			</div>

			<div class="span4"></div>

		</div>

		<div class="row-fluid login-wrap-row">
			
			<div class="span4"></div>

			<div class="span4 login-wrap">
				<form action="index.php" method="POST">
					<label for="user"></label>
					<input type="email" name="user" placeholder="E-post">

					<label for="password"></label>
					<input type="password" name="password" placeholder="Lösenord">
					
					<input type="submit" value="Logga in">
				</form>
			</div>	

			<div class="span4 error-wrap">
				
				<?= $error ?>

			</div>

		</div>

		<div class="row-fluid login-middle-section">

			<div class="span4"></div>
			
			<div class="span4 form-divide">
				<p>Inte medlem?</p>	
				 <!-- <a href="#" class="pinkish">Registrera!</a> -->
				 <p>Registrera!</p>
				<p><i class="ion-arrow-down-c"></i></p>		    
			</div>

			<div class="span4"></div>

		</div>

	</div>

		<div class="row-fluid register-wrap-row">

			<div class="span4"></div>
			
			<div class="span4 register-wrap">
				<form action="index.php" method="POST">
					<input type="text" name="create-username" placeholder="Användarnamn">
					<input type="email" name="create-email" placeholder="E-post">
					<input type="password" name="create-password" placeholder="Lösenord">
					<input type="submit" value="Registrera">
				</form>

				<?= $succes; ?>

			</div>

			<div class="span4 error-wrap">
			
				<?php

					foreach ($errors as $error) {
						print '<p class="error">' . $error . '</p>';
					}

				?>	
			
			</div>	


		</div>



<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>	