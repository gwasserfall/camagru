<?= Component::load("GlobalHeader") ?>
<body>
<?= Component::load("PageHeader") ?>
<div class="container">
	<div class="row">
		<div class="col-12">
			main content here should be centered
		</div>
	</div>
</div>

<?php foreach($data["posts"] as $post): ?>

	<?= $post->delete() ?>
<?= Component::load("PageFooter") ?>
</body>
<?= Component::load("GlobalFooter") ?>