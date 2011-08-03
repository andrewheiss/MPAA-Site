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

if ($node->type == 'blog') {
	$show_meta = TRUE;
} elseif ($node->type == 'caucus_post') {
	$show_meta = TRUE;
	$is_caucus = TRUE;
	$caucus_class = ' class="caucus-author"';
	
	$author_img = '<img src="/' . fix_spaces($node->field_caucus_author_picture[0]['filepath']) . '" alt="' . $node->field_caucus_author[0]['value'] . '" />';
	$author_name = $node->field_caucus_author[0]['value'];
	
	// If there's a URL for the author, build a link. Otherwise just output the author's name
	if ($node->field_caucus_author_url[0]['url']) {
		$author_link = '<a href="' . $node->field_caucus_author_url[0]['url'] . '" title="' . $node->field_caucus_author_url[0]['title'] . '">';
		
		$author_img = $author_link . $author_img . '</a>';
		$author_name = $author_link . $author_name . '</a>';
	}
	 
	$name =  $author_name . ' &bull; ' . $node->field_caucus_author_bio[0]['value'] . '</p><p>';
	
	// Get information from parent node
	$parent_id = $node->field_caucus_topic[0]['nid'];
	$parent = node_load($parent_id);
	$banner = '<a href="' . url($parent->path) . '"><img src="/' . fix_spaces($parent->field_caucus_banner_small[0]['filepath']) . '" alt="" /></a>';
}

?>
<section class="post <?php print $classes; ?>">
	<?php if ($is_caucus): ?>
		<div class="small-banner"><?php print $banner; ?></div>
	<?php endif ?>
	<article>
		<header>
			<<?php print $heading_tag; ?> class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></<?php print $heading_tag; ?>>
			<?php if ($show_meta): ?>
			<?php if ($is_caucus) {
				print $author_img;
			} ?>
			<div class="post-meta">
				<p<?php print $caucus_class; ?>><em>by</em> <?php print $name; ?> <em>on</em> <time datetime="<?php print add_colon(format_date($created, 'custom', 'Y-m-d\TH:i:sO')); ?>"<?php print $pubdate; ?>><?php print format_date($created, 'large'); ?></time> <a href="<?php print $node_url; ?>#comments" class="comment_count"><?php print $comment_count; ?> comment(s)</a></p>
			</div>
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