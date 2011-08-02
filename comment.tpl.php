<article class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ' '. $status; print ' '. $zebra; ?>">  
    <header>
		<?php if ($comment->new): ?>
		<span class="new"><?php print drupal_ucfirst($new) ?></span>
		<br />
		<?php endif ?>
        <span class="comment-author"><?php echo $author; ?></span><br />
		<time datetime="<?php print add_colon(format_date($comment->timestamp, 'custom', 'Y-m-d\TH:i:sO')); ?>" pubdate><?php print format_date($comment->timestamp, 'large'); ?></time>

		<?php if ($links): ?>
			<div class="links"><?php print $links ?></div>
		<?php endif ?>
    </header>
	<div class="comment-content">
		<?php print $content ?>
	</div>
</article>