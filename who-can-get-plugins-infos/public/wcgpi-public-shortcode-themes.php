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

// Shortcode
function wcgpi_theme_shortcodes($atts = [], $content = null, $tag = '') {
    $wcgpi_atts = shortcode_atts([
    	'type' => '',
		'theme_id' => '',
    ], $atts, $tag);
	$datas = 0;
	$cats = 0;
	$source = 0;
	$without_author_link = 0;
	$author = 0;
	$price = 0;
	$since = 0;
	$last_update = 0;
	$retro_compat = 0;
	$rating_decimal = 0;
	$downloaded = 0;
	$permalink = 0;
	$thumbnail = 0;
    if ($wcgpi_atts['type'] == 'envato') {
    	// Get envato datas
		$datas = wcgpi_get_envato_infos($wcgpi_atts['theme_id']);
		// Cats
		$cats = str_replace( 'wordpress/', '', $datas['item']['category'] );
		// Source
		$source = 'Envato';
		// Author
			/* Do not exists on Envato API */
		// Price
		$price = $datas['item']['cost'] . '&nbsp;$';
		// Since date
		$since = date_i18n( get_option( 'date_format' ), strtotime($datas['item']['uploaded_on']) );
		// Last update date
		$last_update = date_i18n( get_option( 'date_format' ), strtotime($datas['item']['last_update']) );
		// Retrocompat
		$retro_compat = 0;
		// Rating decimal
		$rating_decimal = round($datas['item']['rating_decimal'], 2) . '/5';
		// Download qty
		$downloaded = $datas['item']['sales'];
		// Permalink
		$permalink = $datas['item']['url'];
		// Icon
		$thumbnail = $datas['item']['thumbnail'];
		
    } elseif ($wcgpi_atts['type'] == 'wporg') {
    	// Get wporg datas
		$plugin_infos = wcgpi_get_wporg_theme_infos($wcgpi_atts['theme_id']);
		$datas = unserialize( $plugin_infos );
		// Cats
		$categories = $datas->tags;
		if ($categories) {
			$i = 1;
			foreach ($categories as $category) {
				if ($i == 1) {
					$cats = $category;
				} elseif ($i < 3) {
					$cats .= ', ' . $category;
				}
				$i++;
			}
		}
		// Source
		$source = 'WordPress.org';
		// Author
		$author = $datas->author;
		// Price
		$price = 0 . '&nbsp;$';
		// Last update date
		$last_update = date_i18n( get_option( 'date_format' ), strtotime($datas->last_updated));
		// Ratings
		if ($datas->rating) {
			$ratingValue = $datas->rating;
			$ratingCount = $datas->num_ratings;
			$rating_decimal = round(($ratingValue / 2) / $ratingCount, 2) . '/5';
		} else {
			$rating_decimal = 'not rated yet';
		}
		// Download qty
		$downloaded = $datas->downloaded;
		// Permalink
		$permalink = 'https://wordpress.org/themes/' . $wcgpi_atts['theme_id'];
		// Icon
		$get_version = $datas->version;
		$getScreenshot = 'https://themes.svn.wordpress.org/' . $wcgpi_atts['theme_id'] . '/' . $get_version . '/screenshot.png';
		if (@getimagesize($getScreenshot)) {
			$thumbnail = $getScreenshot;
		} else {
			$thumbnail = 0;
		}
    }
    // Display HTML
    $output = '';
    $output .= '<div 
    	id="wcgpi_container" 
    	data-wcgpi_type="' . $wcgpi_atts['type'] . '" 
    	data-wcgpi_id="' . $wcgpi_atts['theme_id'] . '">';
    $output .= '<ul>';
    if ($thumbnail) {
	    $output .= '<li><img src="' . $thumbnail . '" alt="" width="80" height="80" /></li>';
    }
    if ($permalink) {
	    $output .= '<li><a href="' . $permalink . '" target="_blank">' . __('Permalink', 'who-can-get-plugins-infos') . '</a></li>';
	}
    if ($source) {
	    $output .= '<li>' . __('Source:', 'who-can-get-plugins-infos') . ' ' . $source . '</li>';
    }
    if ($author) {
	    $output .= '<li>' . __('By', 'who-can-get-plugins-infos') . ' ' . $author . '</li>';
    }
	if ($cats) {
	    $output .= '<li>' . __('Category:', 'who-can-get-plugins-infos') . ' ' . $cats . '</li>';
    }
    if ($price) {
	    $output .= '<li>' . __('Price:', 'who-can-get-plugins-infos') . ' ' . $price . '</li>';
    }
    if ($last_update) {
	    $output .= '<li>' . __('Last update on ', 'who-can-get-plugins-infos') . ' ' . $last_update . '</li>';
    }
    if ($rating_decimal) {
	    $output .= '<li>' . __('Rate:', 'who-can-get-plugins-infos') . ' ' . $rating_decimal . '</li>';
    }
    if ($downloaded) {
	    $output .= '<li>' . $downloaded . ' ' . __('downloads', 'who-can-get-plugins-infos') . '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    if (!is_null($content)) {
        $output .= apply_filters('the_content', $content);
        $output .= do_shortcode($content);
    }
    return $output;
}
function wcgpi_theme_shortcodes_init() {
    add_shortcode('themeinfos', 'wcgpi_theme_shortcodes');
}
add_action('init', 'wcgpi_theme_shortcodes_init');

