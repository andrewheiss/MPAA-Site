<section id="comments">
	<header>
		<h3>Comments</h3>
	</header>
	<?php if ($node->comment_count < 1): ?>
		<div class="message">There aren't any comments yet. Start the conversation below!</div>
	<?php endif ?>
	<?php print $content; ?>
</section>