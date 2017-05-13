<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @link       http://jeanbaptisteaudras.com
 * @since      1.0.0
 *
 * @package    wcgpi
 * @subpackage wcgpi/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 * @package    wcgpi
 * @subpackage wcgpi/public
 * @author     audrasjb <audrasjb@gmail.com>
 */

require_once plugin_dir_path( __FILE__ ) . 'wcgpi-public-api-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'wcgpi-public-shortcode-plugins.php';
require_once plugin_dir_path( __FILE__ ) . 'wcgpi-public-shortcode-themes.php';

// Add script
function wcgpi_shortcode_scripts() {
	global $post;
	if( has_shortcode( $post->post_content, 'plugininfos') ) {
		?>
		<script>
		</script>
		<?php
	}
}
//add_action( 'wp_footer', 'wcgpi_shortcode_scripts', 100);
