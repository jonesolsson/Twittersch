<?php ob_start();	

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

//Här börjar inloggningsdelen 
function doesUserExist($user) {

	$link = connection();

	$query = "SELECT * FROM users WHERE mail='$user'";

	$result = mysqli_query($link, $query);

	$numRows = mysqli_num_rows($result);

	$currentUser = [];

	if($numRows != 0) {

		while($row = mysqli_fetch_assoc($result)) {

			$currentUser[] = $row;

		}

	}

	return $currentUser;

}

//Formulärhantering för att logga in
if(isset($_POST['user']) && isset($_POST['password'])) {

	$user     = $_POST['user'];
	$password = $_POST['password'];

	$currentUser = doesUserExist($user);

	if(count($currentUser) == 0) {

		print 'fel kombination av e-post/lösenord';

	} else {
		
		foreach ($currentUser as $key) {
				$currentUser = $key;
			}	

		if($currentUser['mail'] == $user && $currentUser['password'] == $password) {

			session_start();

			$_SESSION['user'] = $user;
			$_SESSION['id']   = $currentUser['id'];

			header('Location: content.php');
			
		} else {

			print 'fel kombination av e-post/lösenord';

		}

	}

} 

//Registrera ny användare-delen börjar här
function validateRegister($username, $mail, $password) {

	$errors = [];

	if($username == '') {
		$errors[] = 'Användarnamn saknas';
	}

	if(filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
		$errors[] = 'Ogiltig E-post';
	} elseif($mail == '') {
		$errors[] =  'E-post saknas';
	}

	if($password == '') {
		$errors[] = 'Lösenord saknas'; 
	}

	return $errors;

}

function isUsernameTaken($username) {

	$link = connection();

	$query = "SELECT * FROM users WHERE username='$username'";

	$result = mysqli_query($link, $query);

	$numRows = mysqli_num_rows($result);

	$existingUser = [];

	if($numRows != 0) {

		while($row = mysqli_fetch_assoc($result)) {
			$existingUser[] = $row;
		}

	}

	return $existingUser;

}


function createUser($username, $mail, $password) {

	$link = connection();

	$query = "INSERT INTO users (username, mail, password) 
		      VALUES ('$username', '$mail', '$password')";

	$result = mysqli_query($link, $query);

}


if(isset($_POST['create-username']) && isset($_POST['create-email']) && isset($_POST['create-password'])) {

	$createUsername = $_POST['create-username'];
	$createEmail 	= $_POST['create-email'];
	$createPassword = $_POST['create-password'];

	$doesUserExist   = doesUserExist($createEmail);
	$isUsernameTaken = isUsernameTaken($createUsername);

	if(count($doesUserExist) != 0) {
		print 'Den här e-posten har redan ett registrerat konto';
	} elseif(count($isUsernameTaken) != 0) {
		print 'Användarnamnet är redan taget';
 	} else {

		$errors = validateRegister($createUsername, $createEmail, $createPassword);

		if(count($errors) == 0) {

			createUser($createUsername, $createEmail, $createPassword);

		}
	}

} else {
	$errors = [];
}



?>