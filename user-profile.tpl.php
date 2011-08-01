<?php
	$user_left = module_invoke('views' ,'block', 'view', 'recent_comments_by_user-block_1');
	$user_right = module_invoke('views' ,'block', 'view', 'recent_posts_by_user-block_1');
?>
<div class="profile">
	<?php print $user_profile; ?>
	<div class="row">
		<div class="column grid_6">
			<h3>Recent comments</h3>
			<?php print $user_left['content']; ?>
		</div>
		<div class="column grid_6">
			<h3>Recent content</h3>
			<?php print $user_right['content']; ?>
		</div>
	</div>
</div>