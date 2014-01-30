<?php 
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

		<?php

	 	if( ! empty($_SESSION['user'])) {
 			require 'navigation.php';

 		}  

 		$currentUser = getCurrentUserName($_GET['user']);

 			foreach ($currentUser as $user) {
 				
 			$userPresentation = $user['presentation'];


 			if($user['image_url'] == '') {
 				$path = 'images/def.jpg';
 			} else {
 				$path = $user['image_url'];   
 			}

 		}

 		?>		

		<div class="row-fluid profile-press">

			<div class="span3"></div>		

			<div class="span3 user-press">
				<h1><?= $_GET['user']; ?></h1>
				<p>
					<?= $userPresentation ?>
				</p>
			</div>					

			<div class="span3">

				<div class="profile-pic">					

					<img src="<?= $path ?>" alt="profile-picture">

				</div>

			</div>
		
			<div class="span3"></div>	

		</div>

		<div class="row-fluid feed">

			<div class="span3"></div>

			<div class="span6 posts-wrap">

				<?php $posts = getPostsToProfile(($start -1) * $view); foreach ($posts as $post) : ?>
				<div class="post">
					
					<?php

						$conversationId = $post['conversation_id'];
						$replyId 	    = $post['post_id']; 
						$username 		= $post['username'];
						$answerToNames  = $post['answer_to_name'];

						print "<a href='profile.php?user=$username'>" . $username . '</a><br>';
						if($answerToNames != '') {
							print "<p><a href='profile.php?user=$answerToNames'>" . '@' . $answerToNames . '</a> ' . linkToAnchor($post['content']) . '</p>';
							// print "<a href='#' class=''>" . 'Detaljer' . "</a>";
						} else {
							// print linkToAnchor($post['content']) . '<br><br>';
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

						<?php foreach(getReplayPostsFromDB($post['post_id']) as $replyPost) : ?>
						<div class="reply-post hide">
							
							<?php

								$replyToId 	  = $replyPost['post_id'];
								$conversId    = $replyPost['conversation_id'];
								$replyName 	  = $replyPost['username'];
								$answerToName = $replyPost['answer_to_name'];


								if($replyPost['answer_to_id'] != 0) {
								
									print  $replyPost['username'] . '<br>';
									print  "<a href='profile.php?user=$answerToName'>" . '@' . $answerToName . '</a>: ' . linkToAnchor($replyPost['content']);

								}
							?>							

						</div>

						<?php endforeach; ?>
						
					<form action="profile.php?user=<?= $username ?>" method="POST" class="reply-form hide">
						<!-- <input type="text" name="reply"> -->
						<textarea name="reply"></textarea>
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
						printPageLinks($pages, $start, $_GET['user']);

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

