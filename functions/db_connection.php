<?php

//Connection till databasen
function connection() {

	$link = mysqli_connect('localhost',
						   'root',
						   'root',
						   'Twittersch'
			  			);

	if( ! $link) {			

		print 'Error #' . mysqli_connect_errno() . '<br>'; 
		print mysqli_connect_error() . '<br>'; 
		die;

	} else {

		return $link;

	}

}



?>