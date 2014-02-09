<?php session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'login.php';

function sanitize($str) {
    return filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
}

function getCurrentUserName($username) {

	//$userId = $_SESSION['user_id'];

	$link = connection();

	$query = "SELECT * FROM users WHERE username='$username'";

	$result = mysqli_query($link, $query);

	$currentUser = [];

	while($row = mysqli_fetch_assoc($result)) {

		$currentUser[] = $row;

	}

	return $currentUser;

}

function getCurrentUserId($userId) {

	//$userId = $_SESSION['user_id'];

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
			  ORDER BY posted DESC LIMIT $start, 10";

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
			  WHERE users.username = '$user' ORDER BY posted DESC LIMIT $start, 10";

	$result = mysqli_query($link, $query);

	$posts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$posts[] = $row;

	}

	return $posts;

}

function getLatestPostFromUser($user) {

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users ON posts.user_id = users.id
			  WHERE users.username = '$user' ORDER BY posted DESC LIMIT 1";

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

	$query = "UPDATE posts SET posted=posted, conversation_id='$conversId'
			  WHERE id=$conversId";

	mysqli_query($link, $query);

}

function getConversationToModal($conversId) {

	$link = connection();

	$query = "SELECT *, posts.id AS post_id FROM posts INNER JOIN users ON posts.user_id = users.id
		     WHERE conversation_id='$conversId' ORDER BY posted ASC";

	$result = mysqli_query($link, $query);

	$posts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$posts[] = $row;

	}

	return $posts;

}

	
//Posta ett inlägg
if(isset($_POST['content'])) {

	$userId  = $_SESSION['user_id'];
	$content = $_POST['content'];

	$errors = contentError($content);

	if(count($errors) == 0) {

		writePostToDB($userId, sanitize($content)); 

	}		

}

//Formulärhantering för replay posts
if(isset($_POST['reply'])) {

	@$userId  	  = $_SESSION['user_id'];
	$content   	  = $_POST['reply'];
	$replyId 	  = $_POST['reply_id'];
	$answerToName = $_POST['answer_to_name'];
	$conversId    = $_POST['conversation_id'];
	$currentConversId = $_POST['current_conversation_id'];

	$errors = contentError($content);

	if(count($errors) == 0) {

		writeReplyPostToDB($userId, $content, $replyId, $answerToName, $conversId);

		if($currentConversId == 0) {
			updatePostToConversation($conversId);	
		}
	}

}

function updateUserProfile($username, $mail, $presentation, $id) {

	$link = connection();

	$query = "UPDATE users SET username='$username', mail='$mail', presentation='$presentation'
			  WHERE id='$id'";

	mysqli_query($link, $query);

}

function updadteUserPassword($password, $id) {

	$link = connection();

	$query = "UPDATE users SET password='$password' WHERE id=$id";

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

function validateUpdate($username, $mail) {

	$errors = [];

	if($username == '') {
		$errors[] = 'Användarnamn saknas';
	}

	if(filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
		$errors[] = 'Ogiltig E-post';
	} elseif($mail == '') {
		$errors[] =  'E-post saknas';
	}

	return $errors;
}

$pressErrors = '';
$pressSuccess = '';
//Uppdatera profildata
if (isset($_POST['update_username'])) {

	$id 				= $_POST['id'];

	$currentUsername	= $_POST['current_username'];
	$updateUsername 	= $_POST['update_username'];

	$currentMail		= $_POST['current_mail'];	
	$updateMail			= $_POST['update_mail'];

	$updatePresentation = $_POST['update_presentation'];

	$isUsernameTaken = isUsernameTakenUpdate($currentUsername, $updateUsername);
	$doesUserExist   = doesUserExistUpdate($currentMail, $updateMail);	

	if(count($doesUserExist) != 0) {
		$pressErrors = 'Den här e-posten har redan ett registrerat konto';
	} elseif(count($isUsernameTaken) != 0) {
		$pressErrors = 'Användarnamnet är redan taget';
 	} else {

 		$errors = validateUpdate($updateUsername, $updateMail);	

		if(count($errors) == 0) {

				updateUserProfile($updateUsername, $updateMail, $updatePresentation, $id);	

				$pressSuccess = 'Profilen är uppdaterad!';

		} 
	}
} 

$passErrors = '';
$passSuccess = '';
//Uppdatera lösenord
if(isset($_POST['update_password'])) {

	$id 				= $_POST['id'];

	$updatePassword 	= $_POST['update_password'];
	$updatePasswordConf = $_POST['update_confirm_password'];

	$hashedPass         = encrypt($updatePassword);
	$hashedPassConf		= encrypt($updatePasswordConf);	

	if($updatePassword != '' && $updatePasswordConf != '') {

		if($hashedPass == $hashedPassConf) {

			updadteUserPassword($hashedPass, $id);

			$passSuccess = 'Lösenordet uppdaterat!';

		} else {

			$passErrors = 'Lösenorden matchar inte';

		}

	} else {

		$passErrors = 'Båda fälten måste fyllas i';
	}

}

function UpdateImgUrlToDB($url, $userId) {

	$link = connection();

	$query = "UPDATE users SET image_url='$url' WHERE id='$userId'";

	$result = mysqli_query($link, $query);

}

 $imageError = [];	

 //Uppladdning av bilder
 if(isset($_FILES['upload'])) {

 	if($_FILES['upload']['error'] == 0) {

 		$tmp  = $_FILES['upload']['tmp_name'];
 		$name = $_FILES['upload']['name'];
 		$size = $_FILES['upload']['size'];

 		if($size < 1024 * 1024) {

 			if(@getimagesize($tmp) !== false) { 

 				if( ! is_dir("uploads/$currentUsername")) {

 					UpdateImgUrlToDB("uploads/$currentUsername/$name", $id);
 					mkdir("uploads/$currentUsername");
 					move_uploaded_file($tmp, "uploads/$currentUsername/$name");	

 				} else {

 					UpdateImgUrlToDB("uploads/$currentUsername/$name", $id);
 					move_uploaded_file($tmp, "uploads/$currentUsername/$name");

 				}  				

 			} else {

 				$imageError[] = 'Filen måste vara en bild!';

 			}

 		} else {

 			$imageError[] = 'Filen är för stor!';

 		} 			

 	} else {

 		$imageError[] = 'Uppladdningen misslyckades';

 	}

 }

//Leta efter länkar i inlägg
function linkToAnchor($text) {
    // The Regular Expression filter
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";   	 

    // Check if there is a url in the text
    if(preg_match_all($reg_exUrl, $text, $url)) {
        // make the urls hyper links
        $matches = array_unique($url[0]);
        foreach($matches as $match) {
            $replacement = "<a href=".$match.">{$match}</a>";
            $text = str_replace($match,$replacement,$text);
        }
         
        return nl2br($text);
       
     } else {

        // if no urls in the text just return the text
        return nl2br($text);

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
} else {
	$numRows = countAllPosts();
}

$view    = 10;
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
			print "<a href='profile.php?user=$username&page=$i' class='active'>$i</a>";
		} else {
			print "<a href='content.php?page=$i' class='active'>$i</a>";			
		}	
	}
}
	


?>