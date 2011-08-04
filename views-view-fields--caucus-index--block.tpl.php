<?php //dpm($fields); ?>

<article class="caucus-topic">
	<header>
		<h4><time timestamp="<?php print format_date($fields['created']->raw, 'custom', 'Y-m-d'); ?>"><?php print $fields['created']->content; ?></time></h4>
		<h3><?php print $fields['title']->content; ?></h3>
	</header>
	<?php print $fields['field_caucus_banner_small_fid']->content; ?>
	<?php print $fields['field_caucus_description_value']->content; ?>
	<?php if ($fields['nodereferrer_type']->content != ''): ?>
		<p class="message-box"><?php print $fields['nodereferrer_type_1']->content; ?> articles, including 
		<?php 
		if ($fields['nodereferrer_type_1']->content > 2) {
			print add_and($fields['nodereferrer_type']->content);
		} elseif($fields['nodereferrer_type_1']->content == 2) {
			print add_and_2($fields['nodereferrer_type']->content);
		} else {
			print $fields['nodereferrer_type']->content;
		}
		?></p>
	<?php else: ?>
		<p class="message-box orange">There are no articles for this topic yet.</p>
	<?php endif ?>
</article>