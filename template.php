<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to mpaa_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: mpaa_breadcrumb()
 *
 *   where mpaa is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */

function add_colon($date) {
	$timezone_minutes = substr($date, -2);
	$output = rtrim($date, $timezone_minutes) . ":" . $timezone_minutes;
	return $output;
}

function fix_spaces($path) {
	return str_replace(' ', '%20', $path);
}

function add_and($string) {
	$last = substr(strrchr($string, ","), 2);
	$output = rtrim($string, $last) . ' and ' . $last;	
	return $output;;
}

function add_and_2($string) {
	return str_replace(',', ' and', $string);
}

/**
 * Implementation of HOOK_theme().
 */
function mpaa_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!

  $hooks['comment_form'] = array ('arguments' => array('form' => NULL));

  // $hooks['user_login'] = array ('template' => 'user-login', 'arguments' => array('form' => NULL));
  // $hooks['user_register'] = array ('template' => 'user-register', 'arguments' => array('form' => NULL));
	
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */

function mpaa_preprocess(&$vars, $hook) {
	// echo "<pre>";
	// print_r($vars);
	// echo "</pre>";
}
// */

function forum_thread_icon_path() {
  return base_path() . path_to_theme() ."/images";
}


/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function mpaa_preprocess_page(&$vars, $hook) {
	// Disable Drupal's jQuery since Google's CDN version is hardcoded in the template, but not on admin, edit, or add pages
	$curr_uri = request_uri();
	if (!strpos($curr_uri,'admin') > 0 && !strpos($curr_uri,'edit') > 0 && !strpos($curr_uri,'add') > 0 && !strpos($curr_uri,'batch') > 0) {
		$scripts = drupal_add_js();
		unset($scripts['core']['misc/jquery.js']);
		$vars['scripts'] = drupal_get_js('header', $scripts);
		$vars['use_google_jquery'] = TRUE;
	} else {
		$vars['use_google_jquery'] = FALSE;
	}
	
	// Strip duplicate head charset metatag
	$matches = array();
	  preg_match_all('/(<meta http-equiv=\"Content-Type\"[^>]*>)/', $vars['head'], $matches);
	  if( count($matches) >= 2){
	    $vars['head'] = preg_replace('/<meta http-equiv=\"Content-Type\"[^>]*>/', '', $vars['head'], 1); // strip 1 only
	    $vars['head'] = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', '', $vars['head']);
	  }
	
	// Determine if page is a forum
	$node = $vars['node'];
	$template = $vars['template_files'][0];
	
	if ($template == 'page-forum' || $node->type == 'forum') {
		$is_forum = TRUE;
	}
	
	if (in_array('page-user', $vars['template_files'])) {
		$is_user = TRUE;
	}
	
	if (in_array('page-user-login', $vars['template_files'])) {
		$vars['title'] = drupal_set_title(t('Log in'));
	}
	
	if (in_array('page-user-register', $vars['template_files'])) {
		$vars['title'] = drupal_set_title(t('Create new account'));
	}
	
	// Hide the page title on nodes, since their titles are included in the node template
	$vars['show_title'] = TRUE;	
	if ($template == 'page-node') {
		$vars['show_title'] = FALSE;
	} 
	
	// Show or hide the sidebar
	$vars['show_sidebar'] = TRUE;
	if ($is_forum || $is_user) {
		$vars['show_sidebar'] = FALSE;
	}
	
	// Determine if user is logged in or not
	global $user;
	$vars['show_login'] = FALSE;
	if ($user->uid == 0) {
		$vars['show_login'] = TRUE;
	}

	// $menu = menu_navigation_links("primary-links");
	// $vars['footer_menu_primary'] = theme('links', $menu);

}


/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function mpaa_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
  
   // Optionally, run node-type-specific preprocess functions, like
   // mpaa_preprocess_node_page() or mpaa_preprocess_node_story().
   $function = __FUNCTION__ . '_' . $vars['node']->type;
   if (function_exists($function)) {
     $function($vars, $hook);
   }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function mpaa_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */

function mpaa_preprocess_block(&$vars, $hook) {
	// Determine if the block is merely a container for a node
	$node_in_block = strpos($vars['block']->content, 'node-type-page');
	if ($node_in_block) {
		$vars['node_in_block'] = TRUE;
	}	
}
// */

/**    Returns the offset from the origin timezone to the remote timezone, in seconds.
*    @param $remote_tz;
*    @param $origin_tz; If null the servers current timezone is used as the origin.
*    @return int;
*/

function mpaa_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    $lastitem = sizeof($breadcrumb);
    $crumbs = '<nav class="breadcrumbs">';
    $a=1;
    foreach($breadcrumb as $value) {
        if ($a!=$lastitem){
         $crumbs .= $value . ' &rsaquo; ';
         $a++;
        }
        else {
            $crumbs .= '<span class="breadcrumbcurrent">'.$value.'</span>';
        }
    }
    $crumbs .= '</nav>';
  }
  return $crumbs;
}

function mpaa_comment_form($form) {
	// Rename some of the form element labels.
	$form['name']['#title'] = t('Name');
	$form['homepage']['#title'] = t('Website');
	$form['comment_filter']['comment']['#title']  = t('Your comment');	
	$form['mail']['#description'] = t('(Will not be shared or displayed)');
	$form['submit']['#value'] = t('Post comment');
	
	// Output comment form
	$output = '';
	if ($form['comment_preview']) {
		$form['comment_preview']['#prefix'] = '<div id="comment-preview">';
		$output .= drupal_render($form['comment_preview']);
	}
	
	if ($form['_author']) {
		$class = 'author';
	} else {
		$class = 'normal';
	}
	$output .= "<div id=\"comment-form-wrapper\" class=\"$class\">";
	
	$output .= '<div class="information">';
	if ($form['_author']) {
		$output .= drupal_render($form['_author']);
	}
	$output .= drupal_render($form['name']);
	$output .= drupal_render($form['mail']);
	$output .= drupal_render($form['homepage']);
	$output .= '</div>';
	$output .= '<div class="comment-field">';
	$output .= drupal_render($form['comment_filter']['comment']);
	$output .= '</div>';
	$output .= '<div class="misc">';
	$output .= drupal_render($form);
	$output .= '</div>';
	$output .= '</div>';
	
	// echo "<pre>";
	// print_r($form);
	// echo "</pre>";
	
	return $output;
}

function mpaa_preprocess_user_login(&$vars) {
	drupal_add_js('misc/collapse.js');
	$vars['rendered'] = drupal_render($vars['form']);
}

function mpaa_preprocess_user_register(&$vars) {
	drupal_add_js('misc/collapse.js');
	$vars['form']['submit']['#value'] = t('Create account');
	$vars['rendered'] = drupal_render($vars['form']);
}