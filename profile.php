<?php 
	 require 'functions/functions.php';

	 require 'head.php';

 ?>

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
								<li><a href=".modal<?= $replyId ?>" class="show-conversation">Visa Konversation</a></li>
								<li><a href="#" class="answer-to-post">Svara</a></li>
								<li><a href="#" class="details">Detaljer</a></li>
							</ul>								
						</div>

						<!-- Konversations modal -->	
<!-- 						<div id="modal<?= $replyId ?>" class="modal"> -->
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
										print "<p class='is-reply'><a href='profile.php?user=$modalpostAnswerName'>" . '@' . $modalpostAnswerName . '</a> ' . linkToAnchor($modalpost['content']) . '</p>';

									} else {
										print '<p>' . linkToAnchor($modalpost['content']) . '</p>';

									}
																													

								?>								

								</div>	

							<?php endforeach; ?>

								<form action="profile.php?user=<?= $username ?>" method="POST" class="modal-reply-form">
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

						<div class="detail-wrap hide"><?php print($post['posted']); ?></div>
						
					<form action="profile.php?user=<?= $username ?>" method="POST" class="reply-form hide">
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
						printPageLinks($pages, $start, $_GET['user']);

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

