<?php session_start(); if( ! empty($_SESSION['user'])) { 

require 'functions/functions.php';

require 'head.php';


?>

<body>

	<?php require 'navigation.php'; ?>

	<div class="container">		

		<div class="row-fluid tweet-form-wrap">
			
			<!-- <div class="span1"></div> -->

			<div class="span3 content-username">
				
				<h1>
				
				<?php

				foreach(getCurrentUserId($_SESSION['user_id']) as $user ) { 
					
					$username = $user['username'];	
					print "<a href='profile.php?user=$username'>" . $username . "</a>";

				}

				?>

				</h1>
				
				<div class="user-facts">						
					<p>
						Har gjort <?= countUsersPosts($username); ?> inlägg och
					</p>

					<p>
						<?php 

						foreach (getLatestPostFromUser($username) as $latestPost) {
							print 'det senaste gjordes ' . date('j/M-Y', strtotime($latestPost['posted']));							
						}


						?>

					</p>
				</div>

			</div>

			<div class="span5">			

				<form action="content.php" method="POST" class="tweet-form">
					<textarea name="content" placeholder="Skriv en viskning..."></textarea>

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

			
			<div class="span3"></div>

		</div>

		<div class="row-fluid feed">
				
			<div class="span3"></div>
			
			<div class="span6 posts-wrap">

				<?php $posts = getPostsFromDB(($start -1) * $view); foreach ($posts as $post) : ?>
				<div class="post">
					
					<?php

						$conversationId = $post['conversation_id'];
						$replyId  	   = $post['post_id']; 
						$username 	   = $post['username'];
						$answerToNames = $post['answer_to_name'];


						print "<a href='profile.php?user=$username' class='sender'>" . $username . '</a>';
						if($answerToNames != '') {
							print "<p class='is-reply'><a href='profile.php?user=$answerToNames'>" . '@' . $answerToNames . '</a> ' . linkToAnchor($post['content']) . '</p>';
							// print "<a href='#' class=''>" . 'Detaljer' . "</a>";

						} else {
							print '<p>' . linkToAnchor($post['content']) . '</p>';
							// print "<a href='#' class='show-conversation'>" . 'Visa Konversation' . "</a>";
						}

						?>

						<div class="post-menu">
							<ul>
								<li><a href=".modal<?= $replyId ?>" class="show-conversation">Visa Konversation</a></li>
								<li><a href="#" class="answer-to-post">Svara</a></li>
								<li><a href="#" class="details">Detaljer</a></li>
							</ul>								
						</div>
						

						<!-- Konversations modal -->	
						<!-- <div id="modal<?= $replyId ?>" class="modal"> -->
						<div class="conversation-modal modal modal<?= $replyId ?>">
				    		<p class="closeBtn">Close</p>
													
							<?php

							$modalPosts = getConversationToModal($conversationId);	

							foreach ($modalPosts as $modalpost) : ?> 
									
								<div class="modal-post">
								
								<?php

									$modalpostUsername = $modalpost['username'];
									$modalpostAnswerName = $modalpost['answer_to_name'];

									print "<a href='profile.php?user=$modalpostUsername' class='sender'>" . $username . '</a>';
									if($modalpostAnswerName != '') {
										print "<p class='is-reply'><a href='profile.php?user=sanitize($modalpostAnswerName)'>" . '@' . sanitize($modalpostAnswerName) . '</a> ' . linkToAnchor($modalpost['content']) . '</p>';

									} else {
										print '<p>' . linkToAnchor($modalpost['content']) . '</p>';

									}
																													

								?>								

								</div>

							<?php endforeach; ?>

								<form action="content.php" method="POST" class="modal-reply-form">
									<textarea name="reply"></textarea>
									<input type="hidden" name="current_conversation_id" value="<?= $conversationId ?>">
									<input type="hidden" name="conversation_id" value="<?php if($conversationId == 0){ print $replyId; } else { print $conversationId; } ?>">
									<input type="hidden" name="answer_to_name" value="<?= sanitize($username) ?>">
									<input type="hidden" name="reply_id" value="<?= $replyId ?>">
									
									<div class="test">
										<i class="ion-paper-airplane"></i>
										<input type="submit" value="">
									</div>
								</form>	

			   			</div>
						
	
						<?php foreach(getReplayPostsFromDB($replyId) as $replyPost) : ?>	

						<div class="reply-post hide">

							<?php

								$replyToId 	  = $replyPost['post_id'];
								$conversId    = $replyPost['conversation_id'];
								$replyName 	  = $replyPost['username'];
								$answerToName = $replyPost['answer_to_name'];

								if($replyPost['answer_to_id'] != 0/* && $conversId != $replyToId*/) {	
									print  "<a href='profile.php?user=sanitize($replyName)' class='sender'>" . sanitize($replyPost['username']) . '</a>';
									print  "<p><a href='profile.php?user=sanitize($answerToName)'>" . '@' . sanitize($answerToName) . '</a>: ' . linkToAnchor($replyPost['content']) . '</p>';

								}
							?>

						</div>

						<?php endforeach; ?>

					<!-- DETALJINFORMATION -->
					<div class="detail-wrap hide">

						<div class="thumbnail-img">
							<img src="<?= sanitize($post['image_url']); ?>">
						</div>
					
						<p><?= $post['username'] . ' viskade detta den ' . date('j/M-Y', strtotime($post['posted'])); ?></p>

						</div>
	
					<form action="content.php" method="POST" class="reply-form hide">
						<!-- <input type="text" name="reply"> -->
						<textarea name="reply"></textarea>
						<input type="hidden" name="current_conversation_id" value="<?= $conversationId ?>">
						<input type="hidden" name="conversation_id" value="<?php if($conversationId == 0){ print $replyId; } else { print $conversationId; } ?>">
						<input type="hidden" name="answer_to_name" value="<?= sanitize($username) ?>">
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

		<!-- Modal overlay  -->
	    <div class="overlay"></div>

	</div>
	
<!-- JavaScript -->
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/script.js"></script>
<script src="popeasy/jquery.modal.js"></script>
<script src="popeasy/site.js"></script>

</body>
</html>	

<?php

	} else {	
		header('Location: index.php');
	}
?>
