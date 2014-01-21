<?php session_start();

require 'db_connection.php';

function getPostsToProfile() {

	$user = $_GET['user'];

	$link = connection();

	$query = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.id
			  WHERE users.username = '$user'";

	$result = mysqli_query($link, $query);

	$posts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$posts[] = $row;

	}

	return $posts;

}

function writeReplyPostToDB($userId, $content, $aswerToId) {

	$link = connection();

	$query = "INSERT INTO posts (user_id, content, answer_to_id)
			  VALUES ('$userId', '$content', '$aswerToId')";

	mysqli_query($link, $query);

}






?>