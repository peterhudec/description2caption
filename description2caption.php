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

/**
 * Main plugin class
 * the long name is intentional to avoid collisions in global namespace
 */
class Description_2_Caption_Plugin {
	
    /**
     * Constructor
     */
	function __construct() {
	    // hooks
		register_activation_hook( __FILE__, array( $this, 'register' ) );
        
        // filters
        add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );
        
        // actions
        add_action( 'add_attachment', array( $this, 'add_attachment' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array( $this, 'init' ) );
	}
    
    /**
     * Default settings
     */
    public function register() {
        add_option( 'description_2_caption_move', 0 );
    }
    
    /**
     * Plugin action links
     */
    public function plugin_action_links( $links, $file ) {
        static $this_plugin;
        if ( ! $this_plugin ) {
            $this_plugin = plugin_basename( __FILE__ );
        }
        if ( $file == $this_plugin ) {
            $settings_link = '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=d2c-options">Settings</a>';
            array_unshift( $links, $settings_link );
        }
        return $links;
    }
    
    /**
     * Trigered after user uploads attachment and before the attachment form gets displayed
     */
    public function add_attachment( $post_ID )
    {
        $post = get_post( $post_ID );
        $post->post_excerpt = $post->post_content;
        if ( get_option( 'description_2_caption_move') ) {
        	$post->post_content = null;
		}
        wp_update_post( $post );
    }
    
    /**
     * Adds plugin entry in the admin menu
     */
    public function admin_menu() {
        add_plugins_page(
	        'Description 2 Caption',
	        'Description 2 Caption',
	        'administrator',
	        'd2c-options',
	        array( $this, 'options_cb' )
		);
    }
    
    /**
     * Called upon plugin initialization
     */
    public function init()
    {
        register_setting(
            'description_2_caption_move',
            'description_2_caption_move'
		);
        add_settings_section(
            'd2c_section',
            '',
            array( $this, 'section_cb' ),
            'd2c-options'
		);
        add_settings_field(
            'description_2_caption_move',
            'Copy or move caption to description?',
            array( $this, 'move_cb' ),
            'd2c-options',
            'd2c_section'
		);
    }
    
    /**
     * Empty section callback
     */
    public function section_cb() {}
    
	/**
	 * Options callback
	 */
    public function options_cb() { ?>
	<div class="wrap">
		<h2>Description 2 Caption options</h2>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php settings_fields( 'description_2_caption_move' ); ?>
			<?php do_settings_sections( 'd2c-options' ); ?>
			<?php submit_button(); ?>
		</form>
		<p>
			Created by <strong>Peter Hudec</strong>, <a href="http://peterhudec.com" target="_blank">peterhudec.com</a>.
		</p>
	</div>
	<?php }
	
	/**
	 * Move setting callback
	 */
	public function move_cb() { ?>
		<input type="radio" id="description_2_caption_copy" name="description_2_caption_move" value="0" <?php checked( 0, get_option( 'description_2_caption_move' ) ); ?> />
		<label for="d2c_copy">Copy</label>
		<br />
		<input type="radio" id="description_2_caption_move" name="description_2_caption_move" value="1" <?php checked( 1, get_option( 'description_2_caption_move' ) ); ?> />
		<label for="description_2_caption_move">Move</label>
	<?php }
}

// instantiate plugin with long name to avoid collisions with other plugins
$description_2_caption_plugin = new Description_2_Caption_Plugin();
?>