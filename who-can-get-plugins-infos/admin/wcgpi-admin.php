<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://jeanbaptisteaudras.com
 * @author     audrasjb <audrasjb@gmail.com>
 * @since      1.0
 *
 * @package    wcgpi
 * @subpackage wcgpi/admin
 */

// Enqueue styles
add_action( 'admin_enqueue_scripts', 'enqueue_styles_wcgpi_admin' );
function enqueue_styles_wcgpi_admin() {
	wp_enqueue_style( 'wcgpi-admin-styles', plugin_dir_url( __FILE__ ) . 'css/wcgpi-admin.css', array(), '', 'all' );
}

// Enqueue scripts
add_action( 'admin_enqueue_scripts', 'enqueue_scripts_wcgpi_admin' );
function enqueue_scripts_wcgpi_admin() {
//	wp_enqueue_script( 'wcgpi-admin-scripts', plugin_dir_url( __FILE__ ) . 'js/wcgpi-admin.js', array( 'jquery' ), '', false );
}	

/**
 *
 * Plugin button in WordPress visual editor
 *
 */

class TinyMCE_wcgpi {
	/**
	* Plugin constructor.
	*/
	function __construct() {
		if ( is_admin() ) {
			add_action( 'init', array(  $this, 'setup_tinymce_wcgpi' ) );
		}
	}
	/**
	* Check if the current user can edit Posts or Pages, and is using the Visual Editor
	* If so, add some filters
	*/
	function setup_tinymce_wcgpi() {
		// Check if the logged in WordPress User can edit Posts or Pages
		// If not, don't register
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
        	return;
		}

		// Check if the logged in WordPress User has the Visual Editor enabled
		// If not, don't register
		if ( get_user_option( 'rich_editing' ) !== 'true' ) {
			return;
		}
		// Setup filters
		add_action( 'plugins_loaded', 'load_languages_tinymce_wcgpi' );
		add_action( 'before_wp_tiny_mce', array( &$this, 'translate_tinymce_wcgpi' ) );
		// Plugins
		add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin_wcgpi' ) );
		add_filter( 'mce_buttons_2', array( &$this, 'add_tinymce_wcgpi_toolbar_plugin_button' ) );		
		// Themes
		add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_theme_wcgpi' ) );
		add_filter( 'mce_buttons_2', array( &$this, 'add_tinymce_wcgpi_toolbar_theme_button' ) );		
	}	

	/**
	* Adds the plugin to the TinyMCE / Visual Editor instance
	*	
	* @param array $plugin_array Array of registered TinyMCE Plugins
	* @return array Modified array of registered TinyMCE Plugins
	*/
	function add_tinymce_plugin_wcgpi( $plugin_array ) {
		$plugin_array['tinymce_wcgpi_plugin_class'] = plugin_dir_url( __FILE__ ) . 'js/tinymce-wcgpi-plugin-class.js';
		return $plugin_array;
	}
	function add_tinymce_theme_wcgpi( $plugin_array ) {
		$plugin_array['tinymce_wcgpi_theme_class'] = plugin_dir_url( __FILE__ ) . 'js/tinymce-wcgpi-theme-class.js';
		return $plugin_array;
	}

	/**
	* Plugin's internationalization 
	*	
	* First load translation files
	* Then add translation strings to a javascript variable
	*/
	function load_languages_tinymce_wcgpi() {
	    load_plugin_textdomain( 'who-can-get-plugins-infos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
	// Adding i18n tinymce strings
	function translate_tinymce_wcgpi() {
		$translations = json_encode(
			array( 
				'wcgpi_modal_title_plugin' 		=> __('Plugin infos', 'who-can-get-plugins-infos'),
				'wcgpi_add_button_plugin' 		=> __('Add plugin infos', 'who-can-get-plugins-infos'),
				'wcgpi_type_label_plugin' 		=> __('Plugin source', 'who-can-get-plugins-infos'),
				'wcgpi_type_help_plugin' 		=> __('From where this plugin come from?', 'who-can-get-plugins-infos'),
				'wcgpi_type_wporg_plugin' 		=> __('WordPress.org official repository', 'who-can-get-plugins-infos'),
				'wcgpi_type_envato_plugin' 		=> __('Envato premium plugins repository', 'who-can-get-plugins-infos'),
				'wcgpi_plugin_id_plugin' 		=> __('Plugin ID', 'who-can-get-plugins-infos'),
				'wcgpi_plugin_id_help_plugin' 	=> __('Please add official WordPress.org plugin slug or Envato ID', 'who-can-get-plugins-infos'),

				'wcgpi_modal_title_theme' 		=> __('Theme infos', 'who-can-get-plugins-infos'),
				'wcgpi_add_button_theme' 		=> __('Add theme infos', 'who-can-get-plugins-infos'),
				'wcgpi_type_label_theme' 		=> __('Theme source', 'who-can-get-plugins-infos'),
				'wcgpi_type_help_theme' 		=> __('From where this theme come from?', 'who-can-get-plugins-infos'),
				'wcgpi_type_wporg_theme' 		=> __('WordPress.org official repository', 'who-can-get-plugins-infos'),
				'wcgpi_type_envato_theme' 		=> __('Envato premium themes repository', 'who-can-get-plugins-infos'),
				'wcgpi_plugin_id_theme' 		=> __('Theme ID', 'who-can-get-plugins-infos'),
				'wcgpi_plugin_id_help_theme' 	=> __('Please add official WordPress.org theme slug or Envato ID', 'who-can-get-plugins-infos'),
			)
		);
		echo '<script>var wcgpiTranslations = ' . $translations . ';</script>';
	}

	/**
	* Adds a button to the TinyMCE / Visual Editor which the user can click
	* to insert the wcgpi node tag.
	*
	* @param array $buttons Array of registered TinyMCE Buttons
	* @return array Modified array of registered TinyMCE Buttons
	*/
	// Plugin
	function add_tinymce_wcgpi_toolbar_plugin_button( $buttons ) {
		array_push( $buttons, 'tinymce_wcgpi_plugin_class' );
		return $buttons;
	}
	// Theme
	function add_tinymce_wcgpi_toolbar_theme_button( $buttons ) {
		array_push( $buttons, 'tinymce_wcgpi_theme_class' );
		return $buttons;
	}
}
$TinyMCE_wcgpi = new TinyMCE_wcgpi;