<?php
if ($node->view) {
	$heading_tag = 'h3';
	$pubdate = '';
	$show_links = false;
} else {
	$heading_tag = 'h2';
	$pubdate = ' pubdate';
	$show_links = true;
}

?>
<section class="post <?php print $classes; ?>">
	<article>
		<header>
			<<?php print $heading_tag; ?> class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></<?php print $heading_tag; ?>>
			<?php if ($node->type == 'blog'): ?>
			<p><em>by</em> <a href="#"><?php print $name; ?></a> <em>on</em> <time datetime="<?php print format_date($created, 'custom', 'Y-m-d\TH:i:sO'); ?>"<?php print $pubdate; ?>><?php print format_date($created, 'large'); ?></time> <a href="#comments" class="comment_count"><?php print $comment_count; ?> comment(s)</a></p>
			<?php endif; ?>
		</header>
		<?php print $content; ?>
	</article>
</section>

<?php 
if ($show_links) {
	print $links; 
}
?>