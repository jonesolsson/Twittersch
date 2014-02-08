<?php $username = $_SESSION['username']; ?>
<div class="row-fluid nav">
		
	<div class="span2"></div>	

	<div class="span9 nav-wrap">
		
		<ul class="profile-nav">
			<li><a href="profile.php?user=<?= $username ?>" id="profileLink"><i class="ion-person"></i>Profil</a></li>
		</ul>

		<ul class="main-nav">			
			<li><a href="content.php" id="homeLink"><i class="ion-home"></i>Feed</a></li>
			<li><a href="edit.php" id="editLink"><i class="ion-edit"></i>Redigera</a></li>
			<li><a href="logout.php"><i class="ion-log-out"></i>Logge Ut</a></li>
		</ul>

	</div>

	<div class="span1"></div>

</div>

<!-- Nav for smaller screens -->
<div class="row-fluid mobile-nav">
	<div class="row-fluid nav-btn-wrap">
		<p class="logo">Twittershh...</p>
		<i class="ion-navicon mobile-nav-btn"></i>
	</div>

	<div class="span12 mobile-nav-wrap hide">
		<ul>
			<li><a href="profile.php?user=<?= $username ?>"><i class="ion-person"></i>Profil</a></li>
			<li><a href="content.php"><i class="ion-home"></i>Feed</a></li>
			<li><a href="edit.php"><i class="ion-edit"></i>Redigera</a></li>
			<li><a href="logout.php"><i class="ion-log-out"></i>Logge Ut</a></li>
		</ul>
	</div>
</div>
