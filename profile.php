<?php 
//require 'functions/profile_functions.php'; 
 require 'functions/functions.php';
 ?>
<!DOCTYPE html>
<html>
<head>

	<title>Twittersch</title>
	<style>.reply_post{color: red;}</style>

</head>
<body>
	
 	<a href="content.php">content</a>
	<h1><?= $_GET['user']; ?></h1>
	
	<div class="posts">
		<?php $posts = getPostsToProfile(); foreach ($posts as $post) : ?>
		<div class="post">
			
			<?php

				$replyId  = $post['post_id']; 
				$username = $post['username'];

				if($post['answer_to_name'] != '') 
					$answerToNames =  '@' . $post['answer_to_name'];	
				else
					$answerToNames = '';	

				print "<a href='profile.php?user=$username'>" . $username . '</a><br>';
				print $answerToNames . ' ' . $post['content'] . '<br><br>';

/*				print '<pre>';
				print_r($post);*/
				
				foreach(getReplayPostsFromDB($post['post_id']) as $replyPost) : ?>
				<div class="reply_post">
					
					<?php

						$replyToId 	  = $replyPost['post_id'];
						$conversId    = $replyPost['conversation_id'];
						$replyName 	  = $replyPost['username'];
						$answerToName = $replyPost['answer_to_name'];

						print  $replyPost['username'] . '<br>';
						print  '@' . $answerToName . ': ' . $replyPost['content'];

						/*print '<pre>';
						print_r($replyPost); */								

					?>
					
					<form action="content.php" method="POST">
						<input type="text" name="reply">
						<input type="hidden" name="conversation_id" value="<?= $replyId ?>">
					 	<input type="hidden" name="answer_to_name" value="<?= $replyName ?>">
						<input type="hidden" name="reply_id" value="<?= $replyToId ?>">
						<input type="submit" value="reply">
					</form><br>	
				</div>

				<?php endforeach; ?>
				
			<form action="profile.php?user=<?= $username ?>" method="POST">
				<input type="text" name="reply">
				<input type="hidden" name="answer_to_name" value="<?= $username ?>">
				<input type="hidden" name="reply_id" value="<?= $replyId ?>">
				<input type="submit" value="reply">
			</form><br>

		</div>
		<?php endforeach; ?>
	</div>

</body>
</html>	

