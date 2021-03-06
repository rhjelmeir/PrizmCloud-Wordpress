<?php

/*
Plugin Name: Prizm Cloud Embedded Document Viewer
Plugin URI: http://prizmcloud.accusoft.com/
Description: Prizm Cloud enables you to offer high-speed document viewing without worrying about additional hardware or installing software.  The documents stay on your servers, so you can delete, update, edit and change them anytime. We don't keep copies of your documents, so they are always secure!
Author: Accusoft <prizmcloud@accusoft.com>
Author URI: http://www.accusoft.com/
Version: 1.0.0
License: GPL2
*/

include_once('prizmcloud-functions.php');

function prizmcloud_getdocument($atts)
{
	extract(shortcode_atts(array(
		'key' => '',
		'document' => '',
		'type' => '',
		'width' => '',
		'height' => '',
		'height' => '',
		'print' => '',
		'color' => ''
	), $atts));

	$iframeWidth = $width + 20;
	$iframeHeight = $height + 20;
	$code = "<iframe src=\"http://connect.ajaxdocumentviewer.com/?key=".$key."&viewertype=".$type."&document=".$document."&viewerheight=".$height."&viewerwidth=".$width."&printButton=".$print."&toolbarColor=".$color."\" width=\"".$iframeWidth."\" height=\"".$iframeHeight."\"></iframe>";

	return $code;
}

// Activate Shortcode to Retrive Document with Prizm Cloud
add_shortcode('prizmcloud', 'prizmcloud_getdocument');

// Add Quicktag for Prizm Cloud Admin
add_action('admin_print_scripts','prizmcloud_admin_print_scripts');

// Add Prizm Cloud Dialog button to Tiny MCEEditor
add_action('admin_init','prizmcloud_mce_addbuttons');

// Add an Option to Settings Menu for Prizm Cloud
add_action('admin_menu', 'prizmcloud_settings_page');
function prizmcloud_settings_page()
{
	global $prizmcloud_settings_page;

	$prizmcloud_settings_page = add_options_page('Prizm Cloud', 'Prizm Cloud', 'manage_options', basename(__FILE__), 'prizmcloud_settings');

}
function prizmcloud_settings()
{
	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) die(t('An error occurred.'));
	if (! user_can_access_admin_page()) wp_die('You do not have sufficient permissions to access this page');

	require(ABSPATH. 'wp-content/plugins/prizmcloud/prizmcloud-settings.php');
}
