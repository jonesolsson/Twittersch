<?php session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'login.php';

function writePostToDB($userId, $content) {	
	
	$link = connection();

	$query = "INSERT INTO posts (user_id, content) VALUES ('$userId', '$content')";

	mysqli_query($link, $query);

}

function getPostsFromDB() {

	$link = connection();

	$query = "SELECT * FROM posts ORDER BY posted DESC";

	$result = mysqli_query($link, $query);

	$posts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$posts[] = $row;

	}	

	return $posts;

}

function contentError($content) {

	$errors = [];

	if($content != '') {

		if(strlen($content > 140)) {

			$errors[] = 'Max 140 tecken...';

		}

	} else {

		$errors[] = 'Det vore trevligt om du skrev någonting';

	}

	return $errors;

}

//Är man inloggad eller ej
if($_SESSION['login']) {
	print "<a href='logout.php'>" . 'Logge ut' . "</a><br><br>";

	if(isset($_POST['content'])) {

		$userId  = $_SESSION['user_id'];
		$content = $_POST['content'];

		$errors = contentError($content);

		if(count($errors) == 0) {

			writePostToDB($userId, $content); 

		}		

	}

} else {

	print 'no access...';

}



?>