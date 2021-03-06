<?php
/**
 * @file
 * Theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It should be placed within the <body> tag. When selecting through CSS
 *   it's recommended that you use the body tag, e.g., "body.front". It can be
 *   manipulated through the variable $classes_array from preprocess functions.
 *   The default values can be one or more of the following:
 *   - front: Page is the home page.
 *   - not-front: Page is not the home page.
 *   - logged-in: The current viewer is logged in.
 *   - not-logged-in: The current viewer is not logged in.
 *   - node-type-[node type]: When viewing a single node, the type of that node.
 *     For example, if the node is a "Blog entry" it would result in "node-type-blog".
 *     Note that the machine name will often be in a short form of the human readable label.
 *   - page-views: Page content is generated from Views. Note: a Views block
 *     will not cause this class to appear.
 *   - page-panels: Page content is generated from Panels. Note: a Panels block
 *     will not cause this class to appear.
 *   The following only apply with the default 'sidebar_first' and 'sidebar_second' block regions:
 *     - two-sidebars: When both sidebars have content.
 *     - no-sidebars: When no sidebar content exists.
 *     - one-sidebar and sidebar-first or sidebar-second: A combination of the
 *       two classes when only one of the two sidebars have content.
 * - $node: Full node object. Contains data that may not be safe. This is only
 *   available if the current page is on the node's primary url.
 * - $menu_item: (array) A page's menu item. This is only available if the
 *   current page is in the menu.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $mission: The text of the site mission, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 * - $primary_links (array): An array containing the Primary menu links for the
 *   site, if they have been configured.
 * - $secondary_links (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title: The page title, for use in the actual HTML content.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the
 *   view and edit tabs when displaying a node).
 * - $help: Dynamic help text, mostly for admin pages.
 * - $content: The main content of the current page.
 * - $feed_icons: A string of all feed icons for the current page.
 *
 * Footer/closing data:
 * - $footer_message: The footer message as defined in the admin settings.
 * - $closure: Final closing markup from any modules that have altered the page.
 *   This variable should always be output last, after all other dynamic content.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * Regions:
 * - $content_top: Items to appear above the main content of the current page.
 * - $content_bottom: Items to appear below the main content of the current page.
 * - $navigation: Items for the navigation bar.
 * - $sidebar_first: Items for the first sidebar.
 * - $sidebar_second: Items for the second sidebar.
 * - $header: Items for the header region.
 * - $footer: Items for the footer region.
 * - $page_closure: Items to appear below the footer.
 *
 * The following variables are deprecated and will be removed in Drupal 7:
 * - $body_classes: This variable has been renamed $classes in Drupal 7.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess()
 * @see zen_process()
 */
?>
<!DOCTYPE html>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
	<title><?php print $head_title; ?></title>
	<?php print $head; ?>
	<?php print $styles; ?>
	<link rel="alternate" type="application/rss+xml" title="MPAA blog posts" href="<?php print $GLOBALS[base_url]; ?>/rss/blog" />
	<link rel="alternate" type="application/rss+xml" title="The Caucus" href="<?php print $GLOBALS[base_url]; ?>/rss/caucus" />
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body class="<?php print $classes; ?>">
	<!--[if lte IE 6]>
		<div class="message-box orange" style="text-align: center;"><p><b>NOTICE</b><br /> Because you are using a very old version of Internet Explorer, this site will not work perfectly. <br />Please consider upgrading to a newer version or using a different browser.</p></div>
	<![endif]-->
	<div id="wrapper">
		<section id="top" class="row">
			<header class="column grid_9">
				<h1>
					<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
					<span><?php print $site_name; ?></span>
				</h1>
			</header>
		</section>
		
		<section id="nav-wrapper" class="row">
			<nav id="primary" class="column grid_8">
				<?php print $navigation; ?>
			</nav>
			<div id="search-box" class="column grid_4">
				<form method="get" action="http://www.google.com/search"> 
					<input type="search" name="q" id="search-field" value="" placeholder="Search&hellip;" />
					<input type="hidden" name="sitesearch" value="mpaa.byu.edu" /> 
				</form>
				
				<ul class="social-icons">
					<li><a href="http://www.youtube.com/user/mpaabyu"><img src="<?php echo base_path() . path_to_theme(); ?>/images/social/16/youtube.png" alt="YouTube" /></a></li>
					<li><a href="https://www.facebook.com/byumpa"><img src="<?php echo base_path() . path_to_theme(); ?>/images/social/16/facebook.png" alt="Facebook" /></a></li>
					<li><a href="https://twitter.com/#!/BYUmpa"><img src="<?php echo base_path() . path_to_theme(); ?>/images/social/16/twitter.png" alt="Twitter" /></a></li>
				</ul>
			</div>
		</section>
		
		<?php 
		// Front page gets lots of blocks; no content
		if ($is_front) {
			print $highlight;
		?>
		
		<section id="content-wrapper" class="row">
			<div id="content">
				<?php print $messages; ?>
				<?php print $front_message; ?>
			</div>
		</section>
		
		<section class="region-sidebar front-rows row">
			<?php print $front_row; ?>
		</section>	
			
		<?php } else {
			// Every other page… 
			
			if ($show_sidebar) {
				$content_grid = 'grid_8';
			} else {
				$content_grid = 'grid_12';
			} ?>
		
		<section id="content-wrapper" class="row">
			<div id="content" class="column <?php print $content_grid; ?>">
				<?php print $breadcrumb; ?>
				
				<?php print $tabs; ?>
				
				<?php if ($show_title): ?>
				<h2><?php print $title; ?></h2>
				<?php endif ?>
				
				<?php print $messages; ?>
				
				<?php print $help; ?>
				
				<?php print $content; ?>
				
				<?php print $caucus_index; ?>
			</div>
			<?php if ($show_sidebar): ?>
			<?php print $sidebar; ?>
			<?php endif ?>
		</section>
		<?php } // End of front page/regular page check ?>
		
		<section id="bottom" class="row">
			<footer>
				<?php print $footer; ?>
				<p id="login-logout">
				<?php if ($show_login): ?>
				<a href="/user/login">Log in</a>
				<?php else: ?>
				<a href="/admin">Site administration</a> &bull; <a href="/logout">Log out</a>	
				<?php endif ?>
				</p>	
			</footer>
		</section>
	</div> <!-- End of #wrapper -->

	<?php if ($use_google_jquery): ?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<?php endif ?>
	
	<?php print $scripts; ?>
	
	<!--[if IE 6]>
		<script type="text/javascript" src="<?php print $GLOBALS['base_url'] ."/"; print $directory; ?>/js/suckerfish.js"></script>
	<![endif]-->
	
	<?php print $page_closure; ?>
	<?php print $closure; ?>
</body>
</html>