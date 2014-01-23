<?php 
	 require 'functions/functions.php';
 ?>
<!DOCTYPE html>
<html>
<head>

	<title>Twittersch</title>
	<style>.reply_post{margin-left: 30px;}</style>

</head>
<body>
	
 	<?php
	 	if( ! empty($_SESSION['user'])) {
 			require 'navigation.php';				
 		}  
 	?>	

	<h1><?= $_GET['user']; ?></h1>

	<div class="posts">
		<?php $posts = getPostsToProfile(($start -1) * $view); foreach ($posts as $post) : ?>
		<div class="post">
			
			<?php

				$conversationId = $post['conversation_id'];
				$replyId 	    = $post['post_id']; 
				$username 		= $post['username'];
				$answerToNames  = $post['answer_to_name'];

				print "<a href='profile.php?user=$username'>" . $username . '</a><br>';
				if($answerToNames != '') {
					print "<a href='profile.php?user=$answerToNames'>" . '@' . $answerToNames . '</a> ' . $post['content'] . '<br><br>';
				} else {
					print $post['content'] . '<br><br>';
				}
	
				foreach(getReplayPostsFromDB($post['post_id']) as $replyPost) : ?>
				<div class="reply_post">
					
					<?php

						$replyToId 	  = $replyPost['post_id'];
						$conversId    = $replyPost['conversation_id'];
						$replyName 	  = $replyPost['username'];
						$answerToName = $replyPost['answer_to_name'];


						if($replyPost['answer_to_id'] != 0) {
							print  $replyPost['username'] . '<br>';
							print  "<a href='profile.php?user=$answerToName'>" . '@' . $answerToName . '</a>: ' . $replyPost['content'];

					?>
					
					<form action="content.php" method="POST">
						<input type="text" name="reply">
						<input type="hidden" name="conversation_id" value="<?= $replyId ?>">
					 	<input type="hidden" name="answer_to_name" value="<?= $replyName ?>">
						<input type="hidden" name="reply_id" value="<?= $replyToId ?>">
						<input type="submit" value="reply">
					</form><br>	
				</div>

				<?php } endforeach; ?>
				
			<form action="profile.php?user=<?= $username ?>" method="POST">
				<input type="text" name="reply">
				<input type="hidden" name="conversation_id" value="<?php if($conversationId == 0){ print $replyId; } else { print $conversationId; } ?>">
				<input type="hidden" name="answer_to_name" value="<?= $username ?>">
				<input type="hidden" name="reply_id" value="<?= $replyId ?>">
				<input type="submit" value="reply">
			</form><br>

		</div>
		<?php endforeach;

			printPageLinks($pages, $start, $_GET['user']);

	    ?>
	</div>

</body>
</html>	

