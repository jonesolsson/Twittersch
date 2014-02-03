<?php

require 'db_connection.php';


function getConversationToModal($conversId) {

	$link = connection();

	$query = "SELECT * FROM posts WHERE conversation_id='$conversId'";

	$result = mysqli_query($link, $query);

	$posts = [];

	while($row = mysqli_fetch_assoc($result)) {

		$posts[] = $row;

	}

	return $posts;

}


?>