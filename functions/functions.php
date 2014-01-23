<?php session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'login.php';

function sanitize($str) {
    return filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
}

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

function getPostsFromDB($start) {

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users ON posts.user_id = users.id 
			  ORDER BY posted DESC LIMIT $start, 3";

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

function getPostsToProfile($start) {

	$user = $_GET['user'];

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users ON posts.user_id = users.id
			  WHERE users.username = '$user' ORDER BY posted DESC LIMIT $start,3";

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
			  ORDER BY posted ASC";@@

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

	
//Posta ett inlägg
if(isset($_POST['content'])) {

	$userId  = $_SESSION['user_id'];
	$content = $_POST['content'];

	$errors = contentError($content);

	if(count($errors) == 0) {

		writePostToDB($userId, $content); 

	}		

}

//Formulärhantering för replay posts
if(isset($_POST['reply'])) {

	$userId  	  = $_SESSION['user_id'];
	$content   	  = $_POST['reply'];
	$replyId 	  = $_POST['reply_id'];
	$answerToName = $_POST['answer_to_name'];
	$conversId    = $_POST['conversation_id'];

	$errors = contentError($content);

	if(count($errors) == 0) {

		writeReplyPostToDB($userId, $content, $replyId, $answerToName, $conversId);

		if($conversId == 0) {
			updatePostToConversation($conversId);	
		}
	}

}

function updateUserProfile($username, $mail, $password, $presentation, $id) {

	$link = connection();

	$query = "UPDATE users SET username='$username', mail='$mail', password='$password', presentation='$presentation'
			  WHERE id='$id'";

	mysqli_query($link, $query);

}

function doesUserExistUpdate($currentMail, $newMail) {

	$link = connection();

	$query = "SELECT * FROM users WHERE mail='$newMail'";

	$result = mysqli_query($link, $query);

	$numRows = mysqli_num_rows($result);

	$currentUser = [];

	if($numRows != 0) {

		if($newMail != $currentMail) {

			while($row = mysqli_fetch_assoc($result)) {

				$currentUser[] = $row;

			}	

		}

	}

	return $currentUser;	

}

function isUsernameTakenUpdate($currentUsername, $newUsername) {

	$link = connection();

	$query = "SELECT * FROM users WHERE username='$newUsername'";

	$result = mysqli_query($link, $query);

	$numRows = mysqli_num_rows($result);

	$existingUser = [];

	if($numRows != 0) {

		if($newUsername != $currentUsername) {

			while($row = mysqli_fetch_assoc($result)) {
				$existingUser[] = $row;
			}
		}	
	}

	return $existingUser;

}

//Uppdatera profildata
if (isset($_POST['update_username'])) {

	$id 				= $_POST['id'];

	$currentUsername	= $_POST['current_username'];
	$updateUsername 	= $_POST['update_username'];

	$currentMail		= $_POST['current_mail'];	
	$updateMail			= $_POST['update_mail'];

	$updatePassword 	= $_POST['update_password'];
	$updatePasswordConf = $_POST['update_confirm_password'];

	$updatePresentation = $_POST['update_presentation'];

	$isUsernameTaken = isUsernameTakenUpdate($currentUsername, $updateUsername);
	$doesUserExist   = doesUserExistUpdate($currentMail, $updateMail);	

	if(count($doesUserExist) != 0) {
		print 'Den här e-posten har redan ett registrerat konto';
	} elseif(count($isUsernameTaken) != 0) {
		print 'Användarnamnet är redan taget';
 	} else {

 		$errors = validateRegister($updateUsername, $updateMail, $updatePassword);	

		if(count($errors) == 0) {

			if($updatePassword == $updatePasswordConf) {

				updateUserProfile($updateUsername, $updateMail, $updatePassword, $updatePresentation, $id);	

			}

			else {
				print 'lösenorden matchar';
			}

		} 
	}


}

//Paging
function countAllPosts() {

	$link = connection();

	$query = "SELECT * FROM posts";

	$result = mysqli_query($link, $query);

	$rows = mysqli_num_rows($result);

	return $rows;

}

function countUsersPosts($user) {

	$link = connection();

	$query = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.id
			  WHERE users.username = '$user'";

	$result = mysqli_query($link, $query);

	$rows = mysqli_num_rows($result);

	return $rows;

}

//Kolla om man bifinner sig på "content" eller "profile"
if( ! empty($_GET['user'])) {
	$numRows = countUsersPosts($_GET['user']);
	print $_GET['user'];  
} else {
	$numRows = countAllPosts();
}

print $numRows;
$view    = 3;
$pages	 = ceil($numRows / $view);
$start	 = 1;

if(isset($_GET['page'])) {

	$start = (int)$_GET['page'];

	if($start < 1) {
		$start = 1;
	} elseif($start > $pages) {
		$start = $pages;
	}
}

//Skriver ut rätt antal länkar
function printPageLinks($pages, $start, $username) {

	for($i = 1; $i <= $pages; $i++) {

		if($i == $start) {
			print "<b>$i</b>";
		} elseif( ! empty($_GET['user'])) {
			print "<a href='profile.php?user=$username&page=$i'>$i</a>";
		} else {
			print "<a href='content.php?page=$i'>$i</a>";			
		}	
	}
}
	


?>