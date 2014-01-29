<?php session_start(); if( ! empty($_SESSION['user'])) { 

require 'functions/functions.php';

?>
<!DOCTYPE html>
<html>
<head>

	<title>Twittersch</title>

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/ionicons.min.css" />

</head>
<body>	

	<div class="container">

		<?php require 'navigation.php'; ?>

		<div class="row-fluid tweet-form-wrap">
			
			<div class="span3"></div>

			<div class="span2">
				
				<h1>
				
				<?php

				foreach(getCurrentUserId($_SESSION['user_id']) as $user ) { 
					
					$username = $user['username'];	
					print "<a href='profile.php?user=$username'>" . $username . "</a>";

				}

				?>

				</h1>

			</div>

			<div class="span3">			

				<form action="content.php" method="POST" class="tweet-form">
					<textarea name="content"></textarea>

					<div class="errors">
						<?php
						foreach($errors as $error) {
							print $error;
						}
						?>
				</div>

			</div>

			<div class="span1 tweet-btn">
					<i class="ion-paper-airplane"></i>
					<input type="submit" value="">
				</form>
			</div>

			
			<div class="span3">
				


			</div>

		</div>

		<div class="row-fluid feed">
				
			<div class="span3"></div>
			
			<div class="span6 posts-wrap">

				<?php $posts = getPostsFromDB(($start -1) * $view); foreach ($posts as $post) : ?>
				<div class="post">
					
					<?php

						// print_r($post);

						$conversationId = $post['conversation_id'];
						$replyId  	   = $post['post_id']; 
						$username 	   = $post['username'];
						$answerToNames = $post['answer_to_name'];

						// print '<pre>';
						// print_r($post);


						print "<a href='profile.php?user=$username' class='sender'>" . $username . '</a>';
						if($answerToNames != '') {
							print "<p><a href='profile.php?user=$answerToNames'>" . '@' . $answerToNames . '</a> ' . linkToAnchor($post['content']) . '</p>';
							// print "<a href='#' class=''>" . 'Detaljer' . "</a>";

						} else {
							print '<p>' . linkToAnchor($post['content']) . '</p>';
							// print "<a href='#' class='show-conversation'>" . 'Visa Konversation' . "</a>";
						}

						?>

						<div class="post-menu">
							<ul>
								<li><a href="#" class="show-conversation">Visa Konversation</a></li>
								<li><a href="#" class="answer-to-post">Svara</a></li>
							</ul>								
						</div>
						

						
						<!-- IN MED BACKUP -->	
						<?php foreach(getReplayPostsFromDB($replyId) as $replyPost) : ?>	

						<div class="reply-post hide">

							<?php

								$replyToId 	  = $replyPost['post_id'];
								$conversId    = $replyPost['conversation_id'];
								$replyName 	  = $replyPost['username'];
								$answerToName = $replyPost['answer_to_name'];

								//print_r($replyPost);

								if($replyPost['answer_to_id'] != 0/* && $conversId != $replyToId*/) {	
									print  "<a href='profile.php?user=$replyName' class='sender'>" . $replyPost['username'] . '</a>';
									print  "<p><a href='profile.php?user=$answerToName'>" . '@' . $answerToName . '</a>: ' . linkToAnchor($replyPost['content']) . '</p>';
/*
									print '<pre>';
									print_r($replyPost); */
								}
							?>

						</div>

						<?php endforeach; ?>

					<form action="content.php" method="POST" class="reply-form hide">
						<!-- <input type="text" name="reply"> -->
						<textarea name="reply"></textarea>
						<input type="hidden" name="current_conversation_id" value="<?= $conversationId ?>">
						<input type="hidden" name="conversation_id" value="<?php if($conversationId == 0){ print $replyId; } else { print $conversationId; } ?>">
						<input type="hidden" name="answer_to_name" value="<?= $username ?>">
						<input type="hidden" name="reply_id" value="<?= $replyId ?>">
						
						<div class="test">
							<i class="ion-paper-airplane"></i>
							<input type="submit" value="">
						</div>
					</form>

				</div>			

					<?php endforeach; ?>

				<div class="pagecount">

					<?php

						printPageLinks($pages, $start, '');	
			    	
				    ?>

			    </div>

			</div>

			<div class="span3"></div>

		</div>

	</div>
	
<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>	

<?php

	} else {	
		header('Location: index.php');
	}
?>
