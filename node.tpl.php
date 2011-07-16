<section id="post" class="<?php print $classes; ?>">
	<article>
		<header>
			<?php //if (!$page && $title): ?>
			    <h2 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
			  <?php //endif; ?>
			<p><em>by</em> <a href="#"><?php print $name; ?></a> <em>on</em> <time datetime="<?php print format_date($created, 'custom', 'Y-m-d\TH:i:sO'); ?>" pubdate><?php print format_date($created, 'large'); ?></time> <a href="#comments" class="comment_count"></a></p>
		</header>
		<?php print $content; ?>
	</article>
</section>

<section id="comments">  

</section>