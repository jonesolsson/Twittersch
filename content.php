<?php session_start(); if( ! empty($_SESSION['user'])) { 

require 'functions/functions.php';

require 'head.php';


?>

<body id="home">

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
						Har gjort <span class="whisp-count"><?= countUsersPosts($username); ?></span> viskningar
					</p>

					<p>
						<?php 

						foreach (getLatestPostFromUser($username) as $latestPost) {
							print 'den senaste gjordes <span class="date">' . date('j/M-Y', strtotime($latestPost['posted'])) . '</span>';							
						}


						?>

					</p>
				</div>

			</div>

			<div class="span5">			

				<form action="content.php" method="POST" class="tweet-form">
					<textarea name="content" placeholder="Dela en viskning..."></textarea>

					<div class="error-wrap-feed">
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

						$sanUsername 	= sanitize($username);
						$sanAswerName	= sanitize($answerToNames);   						


						print "<a href='profile.php?user=$sanUsername' class='sender'>" . sanitize($username) . '</a>';
						if($answerToNames != '') {
							print "<p class='is-reply'><a href='profile.php?user=$sanAswerName'>" . '@' . $sanAswerName . '</a> ' . linkToAnchor($post['content']) . '</p>';
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
				    		<p class="closeBtn">x</p>
													
							<?php

							$modalPosts = getConversationToModal($conversationId);	

							foreach ($modalPosts as $modalpost) : ?> 
									
								<div class="modal-post">
								
								<?php

									$modalpostUsername = $modalpost['username'];
									$modalpostAnswerName = $modalpost['answer_to_name'];

									$sanModalpostUsername = sanitize($modalpostUsername);
									$sanModalpostAnswerName = sanitize($modalpostAnswerName);

									print "<a href='profile.php?user=$sanModalpostUsername' class='sender'>" . $sanModalpostUsername . '</a>';
									if($modalpostAnswerName != '') {
										print "<p class='is-reply'><a href='profile.php?user=$sanModalpostAnswerName'>" . '@' . sanitize($modalpostAnswerName) . '</a> ' . linkToAnchor($modalpost['content']) . '</p>';

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

								$sanAnswerToName = sanitize($answerToName);
								$sanReplyName = sanitize($replyName);

								if($replyPost['answer_to_id'] != 0/* && $conversId != $replyToId*/) {	
									print  "<a href='profile.php?user=$sanReplyName' class='sender'>" . sanitize($replyPost['username']) . '</a>';
									print  "<p><a href='profile.php?user=$sanAnswerToName'>" . '@' . sanitize($answerToName) . '</a>: ' . linkToAnchor($replyPost['content']) . '</p>';

								}
							?>

						</div>

						<?php endforeach; ?>

					<!-- DETALJINFORMATION -->
					<div class="detail-wrap hide">

						<div class="thumbnail-img">
							<img src="<?= sanitize($post['image_url']); ?>">
						</div>
					
						<p><?= $post['username'] . ' viskade detta den <span class="date">' . date('j/M-Y', strtotime($post['posted'])) . '</span>'; ?></p>

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
					
					<div class="page-num">
					<?php

						printPageLinks($pages, $start, '');	
			    		
				    ?>						
					</div>

					<div class="next-btn">	
					<?php	

						if( ! empty($_GET['page'])) {
							$pageNum = $_GET['page'] + 1;
							print "<a href='content.php?page=$pageNum' class='active'>" . 'Nästa' . '</a>';
						} else {
							if(countAllPosts() > 10) {
								print "<a href='content.php?page=2' class='active'>" . 'Nästa' . '</a>';
							}
						}

					?>
					</div>

			    </div>

			</div>

			<div class="span3"></div>

		</div>

		<!-- Modal overlay  -->
	    <div class="overlay"></div>

	</div>

	<?php require 'footer.php'; ?>
	
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
