<?php
/*
Plugin Name: Description 2 Caption
Description: This plugin copies the value of description to caption in the media editor, after the media attachment has been uploaded. I created this plugin to fix the annoying feature of Wordpress, when by uploading images it copies the IPTC caption to description and leaves the caption field empty.
Version: 1.0
Author: Peter Hudec
Author URI: http://peterhudec.com
Plugin URI: http://peterhudec.com/programming/description2caption
License: GPL2
*/

// hooks
register_activation_hook( __FILE__, 'd2c_defaults' );
add_filter('plugin_action_links', 'd2c_action_links', 10, 2);
add_action('add_attachment', 'd2c');
add_action('admin_menu', 'd2c_options');
add_action('admin_init', 'd2c_init');


//add setting link to plugins list
function d2c_action_links($links, $file) {
    static $this_plugin;
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
    if ($file == $this_plugin) {
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=d2c-options">Settings</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}

function d2c_defaults(){
	add_option('d2c_move', 0);
}

/**
 * The "Caption" input field in the media item form is filled with
 * post excerpt in the get_attachment_fields_to_edit() function
 * 
 * This action copies the attachment's post_content to its post_excerpt
 * after the attachment post is inserted to the DB after file upload
 */
function d2c($post_ID){
	$post = get_post($post_ID);
	$post->post_excerpt = $post->post_content;
	if(get_option('d2c_move')) $post->post_content = null;
	wp_update_post( $post );
}

/**
 * Options
 */

// add plugin settings page
function d2c_options(){
	add_plugins_page(
		'Description 2 Caption',
		'Description 2 Caption',
		'administrator',
		'd2c-options',
		'd2c_options_cb');
}

// add settings
function d2c_init(){
	register_setting(
		'd2c_move',
		'd2c_move' );
	add_settings_section(
		'd2c_section',
		'',
		'd2c_section_cb',
		'd2c-options');
	add_settings_field(
		'd2c_move',
		'Copy or move caption to description?',
		'd2c_move_cb',
		'd2c-options',
		'd2c_section');
}
function d2c_section_cb(){}

// options page form
function d2c_options_cb(){
	?>
	<div class="wrap">
		<h2>Description 2 Caption options</h2>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php settings_fields('d2c_move'); ?>
			<?php do_settings_sections('d2c-options'); ?>
			<?php submit_button(); ?>
		</form>
		<p>Created by <strong>Peter Hudec</strong>, <a href="http://peterhudec.com" target="_blank">peterhudec.com</a>.</p>
	</div>
	<?php
}

// copy or move setting content
function d2c_move_cb(){
	?>
	<input type="radio" id="d2c_copy" name="d2c_move" value="0" <?php checked(0, get_option('d2c_move')); ?> />
	<label for="d2c_copy">Copy</label><br />
	<input type="radio" id="d2c_move" name="d2c_move" value="1" <?php checked(1, get_option('d2c_move')); ?> />
	<label for="d2c_move">Move</label>
	<?php
}
?>