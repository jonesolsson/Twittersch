<?php require 'functions/login.php';
	  require 'head.php';	
 ?>

<body>

	<div class="container index-wrap">	

		<div class="row-fluid login-wrap-row">
			
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



<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>	