<?php session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'login.php';

function getCurrentUser() {

	$userId = $_SESSION['user_id'];

	$link = connection();

	$query = "SELECT * FROM users WHERE id='$userId'";

	$result = mysqli_query($link, $query);

	$currentUser = [];

	while($row = mysqli_fetch_assoc($result)) {

		$currentUser[] = $row;

	}

	return $currentUser;

}

function writePostToDB($userId, $content) {	
	
	$link = connection();

	$query = "INSERT INTO posts (user_id, content) VALUES ('$userId', '$content')";

	mysqli_query($link, $query);

}

function getPostsFromDB() {

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users ON posts.user_id = users.id 
			  ORDER BY posted DESC";

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

		if(strlen($content) > 140) {

			$errors[] = 'Max 140 tecken...';

		}

	} else {

		$errors[] = 'Det vore trevligt om du skrev någonting';

	}

	return $errors;

}

function getPostsToProfile() {

	$user = $_GET['user'];

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users ON posts.user_id = users.id
			  WHERE users.username = '$user' ORDER BY posted DESC";

	$result = mysqli_query($link, $query);

	$posts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$posts[] = $row;

	}

	return $posts;

}

//Skriva ett svar till en post
function writeReplyPostToDB($userId, $content, $aswerToId, $answerToName, $conversId) {

	$link = connection();

	$query = "INSERT INTO posts (user_id, content, answer_to_id, answer_to_name, conversation_id)
			  VALUES ('$userId', '$content', '$aswerToId', '$answerToName', '$conversId')";

	mysqli_query($link, $query);

}

//Hämta alla svar till en post
function getReplayPostsFromDB($postid) {

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users
			  ON posts.user_id = users.id WHERE conversation_id='$postid' 
			  ORDER BY posted ASC";

	$result = mysqli_query($link, $query);

	$replyPosts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$replyPosts[] = $row;

	}

	return $replyPosts;

}

function updatePostToConversation($conversId) {

	$link = connection();

	$query = "UPDATE posts SET conversation_id='$conversId'
			  WHERE id=$conversId";

	mysqli_query($link, $query);

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

//Formulärhantering för replay
if(isset($_POST['reply'])) {

	$userId  	  = $_SESSION['user_id'];
	$content   	  = $_POST['reply'];
	$replyId 	  = $_POST['reply_id'];
	$answerToName = $_POST['answer_to_name'];
	$conversId    = $_POST['conversation_id'];

	$errors = contentError($content);

	if(count($errors) == 0) {

		writeReplyPostToDB($userId, $content, $replyId, $answerToName, $conversId);

		updatePostToConversation($conversId);	

	}

}





















?>