<?php

/**
 * @link              https://jeanbaptisteaudras.com/portfolio/extension-wordpress-obtenir-stats-plugins-wp/
 * @since             1.0
 * @package           Who can get plugins and themes infos ?!
 *
 * @wordpress-plugin
 * Plugin Name:       Who can get plugins and themes infos ?!
 * Plugin URI:        https://jeanbaptisteaudras.com/portfolio/extension-wordpress-obtenir-stats-plugins-wp/
 * Description:       Get and display plugins and theme informations from official repo or Envato premium repo.
 * Version:           1.0
 * Author:            Jean-Baptiste Audras, project manager @ Whodunit
 * Author URI:        http://jeanbaptisteaudras.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       who-can-get-plugins-infos
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * i18n
 */
load_plugin_textdomain( 'who-can-get-plugins-infos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

/**
 * Admin
 */
if (is_admin()) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/wcgpi-admin.php';
}
/**
 * Public
 */
require_once plugin_dir_path( __FILE__ ) . 'public/wcgpi-public.php';
