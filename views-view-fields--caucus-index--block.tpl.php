<?php //dpm($fields); ?>

<article class="caucus-topic">
	<header>
		<h4><time timestamp="<?php print format_date($fields['created']->raw, 'custom', 'Y-m-d'); ?>"><?php print $fields['created']->content; ?></time></h4>
		<h3><?php print $fields['title']->content; ?></h3>
	</header>
	
	<?php print $fields['field_caucus_banner_small_fid']->content; ?>
	<?php print $fields['field_caucus_description_value']->content; ?>
</article>