<section class="caucus-topic <?php print $classes; ?>">
	<header>
		<h4><time datetime="<?php print format_date($created, 'custom', 'Y-m-d'); ?>" pubdate><?php print format_date($created, 'custom', 'F Y'); ?></time></h4>
		<h2><?php print $node->title; ?></h2>
	</header>
	<img src="/<?php print fix_spaces($node->field_caucus_banner_large[0]['filepath']); ?>" alt="<?php print $node->title; ?>" />
	<article id="caucus-description">
		<?php print $node->field_caucus_description[0]['view']; ?>
	</article>
</section>

<section class="post node-type-caucus-post">
<?php 
if ($node->field_caucus_posts[0]['items']) {
	foreach ($node->field_caucus_posts[0]['items'] as $post) {
		$child = node_load($post['nid']);
	
		$author_img = '<img src="/' . fix_spaces($child->field_caucus_author_picture[0]['filepath']) . '" alt="' . $child->field_caucus_author[0]['value'] . '" />';
		$author_name = $child->field_caucus_author[0]['value'];
	
		// If there's a URL for the author, build a link. Otherwise just output the author's name
		if ($child->field_caucus_author_url[0]['url']) {
			$author_link = '<a href="' . $child->field_caucus_author_url[0]['url'] . '" title="' . $child->field_caucus_author_url[0]['title'] . '">';
		
			$author_img = $author_link . $author_img . '</a>';
			$author_name = $author_link . $author_name . '</a>';
		}
	 
		$name =  $author_name . ' &bull; ' . $child->field_caucus_author_bio[0]['value'] . '</p><p>';
?>
	<article>
		<header>
			<h3><a href="<?php print url($child->path); ?>"><?php print $child->title; ?></a></h3>
			<?php print $author_img; ?>
			<div class="post-meta">
				<p class="caucus-author"><em>by</em> <?php print $name; ?> <em>on</em> <time datetime="<?php print add_colon(format_date($child->created, 'custom', 'Y-m-d\TH:i:sO')); ?>"><?php print format_date($child->created, 'large'); ?></time> <a href="<?php print url($child->path); ?>#comments" class="comment_count"><?php print $child->comment_count; ?> comment(s)</a></p>
			</div>
		</header>
		<?php //print $child->teaser; ?>
	</article>
<?php } 
	} else { ?>
	<div class="message">There are no articles for this topic yet.</div>
<?php } ?>
</section>
