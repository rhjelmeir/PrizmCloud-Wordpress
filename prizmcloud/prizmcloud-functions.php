<?php

if (!defined('PRIZMCLOUD_WP_PLUGIN_URL'))
{
	define('PRIZMCLOUD_WP_PLUGIN_URL', WP_PLUGIN_URL . '/prizmcloud');
}

/*function grpdocs_getGuid($link = "http://apps.groupdocs.com/document-viewer/17b5b1da8d3227b12a28e1780e2beab76e760ecc5f9f5e6fc8594edc189eb786/1")
{
    preg_match('/([0-9a-f]){64}/', $link, $matches);
    return isset($matches[0]) ? $matches[0] : '';
}*/

function prizmcloud_mce_addbuttons()
{
	// Permissions Check
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	// Add button to TinyMCE Editor
	if ( get_user_option('rich_editing') == 'true')
	{
		add_filter("mce_external_plugins", "prizmcloud_add_tinymce_plugin");
		add_filter('mce_buttons', 'prizmcloud_register_mce_button');
	}
}

function prizmcloud_register_mce_button($buttons)
{
	array_push($buttons, "separator", "prizmcloud");
	return $buttons;
}

function prizmcloud_add_tinymce_plugin($plugin_array)
{
	$plugin_array['prizmcloud'] = PRIZMCLOUD_WP_PLUGIN_URL.'/js/prizmcloud_plugin.js';
	return $plugin_array;
}

function prizmcloud_admin_print_scripts($arg)
{
	global $pagenow;
	if (is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php'))
	{
		$js = PRIZMCLOUD_WP_PLUGIN_URL.'/js/prizmcloud-quicktags.js';
		wp_enqueue_script("prizmcloud_qts", $js, array('quicktags') );
	}
}
