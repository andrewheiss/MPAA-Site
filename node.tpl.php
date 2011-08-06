<?php
// Set up node template variables
$print_title_link = true;
$heading_tag = 'h2';
$show_links = true;
$pubdate = '';

if ($node->view) {
	$heading_tag = 'h3';
	$show_links = false;
} elseif ($is_front) {
	$show_links = false;
	$print_title_link = false;
} else {
	$pubdate = ' pubdate';
	$path = isset($_GET['q']) ? $_GET['q'] : '<front>';
	$link = url($path, array('absolute' => TRUE));
}

if ($node->type == 'blog' || $node->type == 'news') {
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
<section class="post clear-block <?php print $classes; ?>">
	<?php if ($is_caucus): ?>
		<div class="small-banner"><?php print $banner; ?></div>
	<?php endif ?>
	<article>
		<header>
			<<?php print $heading_tag; ?> class="title">
			<?php if ($print_title_link): ?>
				<a href="<?php print $node_url; ?>"><?php print $title; ?></a>
			<?php else: ?>
				<?php print $title; ?>
			<?php endif ?>
			</<?php print $heading_tag; ?>>
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
		
		<footer>
			<?php if ($show_links): ?>
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style " style="padding-bottom: .5em;" addthis:url="<?php print $link; ?>" addthis:title="<?php print $title; ?>">
				<a class="addthis_button_google_plusone" g:plusone:size="small" g:plusone:count="false" style="margin-top: -3px;"></a>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_linkedin"></a>
				<a class="addthis_button_googlereader"></a>
				<a class="addthis_button_compact"></a>
				<a class="addthis_counter addthis_bubble_style"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e3a153960d60c98"></script>
			<!-- AddThis Button END -->
			<?php endif ?>
			<?php if ($taxonomy) { ?>
		      <div id="tags"><?php echo $terms ?></div>
		    <?php } ?>
		</footer>
	</article>
</section>

<?php 
if ($show_links) {
	print $links; 
}
?>
