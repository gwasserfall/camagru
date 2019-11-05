<?= Component::load("GlobalHeader", ["title" => "My Posts"]) ?>
<body>
<?php Component::load("Desktop/SignedInHeader-desktop") ?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div id="posts-container" class="posts">

			<?php
			
				// <div class="post-container">
				// <div class="post">
				// 	<div class="stats">
				// 		<div class="likes single">
				// 			<img class="icon" src="/img/heart.svg" alt="">
				// 			<div class="counter">10.5K</div>
				// 		</div>
				// 		<div class="stats-spacer"></div>
				// 		<div class="comments single">
				// 			<!-- <div class="icon"></div> -->
				// 			<img class="icon" src="/img/comment.svg" alt="">
				// 			<div class="counter">10.9K</div>
				// 		</div>
				// 	</div>
				// 	<div class="image">
				// 		<img src="https://via.placeholder.com/300">
				// 	</div>

				// </div>
				// <div class="attribution">
				// 		<a href="#" class="user">@gwasserf</a>
				// 		<div class="date">July 07 2019</div>
				// </div>
				// </div>

			?>

			<div class="modal is-active">
				<div class="modal-background"></div>
				<div class="modal-content">
					<!-- Any other Bulma elements you want -->
					
					<header class="modal-card-head">
						<p class="modal-card-title">Make a new layer</p>
					</header>
					<section class="modal-card-body">
					<!-- Content ... -->
					<form action="/posts/add" method="POST" id="add-post">
						<textarea class="textarea"  name="comment" placeholder="Comment"></textarea>
						<button class="button" type="submit">Add</button>
					</form>
					</section>

				</div>
				<button class="modal-close is-large" aria-label="close"></button>
			</div>

			</div>
		</div>
	</div>
</div>


<script src="/js/api.js"></script>
<script src="/js/posts.js"></script>
<?php Component::load("Desktop/SignedInFooter-desktop") ?>
</body>
<?php Component::load("GlobalFooter") ?>