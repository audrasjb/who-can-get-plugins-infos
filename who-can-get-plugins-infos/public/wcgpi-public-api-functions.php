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

// API - Envato
function wcgpi_get_envato_infos( $item_id ) {
	// Prepare cache parameters
	$CACHE_EXPIRATION = 3600;
	$transient_id = 'wcgpi_item_' . $item_id . '_data';
	$cached_item = get_transient( $transient_id );
	if ( !$cached_item || ( $cached_item->item_id != $item_id ) ) {
		$api_url = "http://marketplace.envato.com/api/edge/item:%s.json";
		$response = wp_remote_get( sprintf( $api_url, $item_id ) );
		if ( is_wp_error( $response ) or ( wp_remote_retrieve_response_code( $response ) != 200 ) ) {
			return false;
		}
		$item_data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( !is_array( $item_data ) ) {
			return false;
		}
		// Prepare data for caching
        $data_to_cache = new stdClass();
        $data_to_cache->item_id = $item_id;
        $data_to_cache->item_info = $item_data;
		// Set transient caching
		set_transient( $transient_id, $data_to_cache, $CACHE_EXPIRATION );
		// Return Envato datas
		return $item_data;
	}
	// We do have cache datas
	return $cached_item->item_info;
}

// API - WPorg - plugins
function wcgpi_get_wporg_plugin_infos( $item_id ) {
	// Prepare cache parameters
	$CACHE_EXPIRATION = 3600;
	$transient_id = 'wcgpi_item_' . $item_id . '_data';
	$cached_item = get_transient( $transient_id );
	if ( !$cached_item || ( $cached_item->item_id != $item_id ) ) {
		$args = (object) array( 'slug' => $item_id );
		$request = array( 'action' => 'plugin_information', 'timeout' => 15, 'request' => serialize( $args) );
		$url = 'http://api.wordpress.org/plugins/info/1.0/';
		$response = wp_remote_post( $url, array( 'body' => $request ) );
		$item_data = $response['body'];
		// Prepare data for caching
        $data_to_cache = new stdClass();
        $data_to_cache->item_id = $item_id;
        $data_to_cache->item_info = $item_data;
		// Set transient caching
		set_transient( $transient_id, $data_to_cache, $CACHE_EXPIRATION );
		// Return WPorg datas
		return $data_to_cache->item_info;
	}
	// We do have cache datas
	return $cached_item->item_info;
}

// API - WPorg - themes
function wcgpi_get_wporg_theme_infos( $item_id ) {
	// Prepare cache parameters
	$CACHE_EXPIRATION = 3600;
	$transient_id = 'wcgpi_item_' . $item_id . '_data';
	$cached_item = get_transient( $transient_id );
	if ( !$cached_item || ( $cached_item->item_id != $item_id ) ) {
		$args = (object) array( 'slug' => $item_id );
		$request = array( 'action' => 'theme_information', 'timeout' => 15, 'request' => serialize( $args) );
		$url = 'http://api.wordpress.org/themes/info/1.0/';
		$response = wp_remote_post( $url, array( 'body' => $request ) );
		$item_data = $response['body'];
		// Prepare data for caching
        $data_to_cache = new stdClass();
        $data_to_cache->item_id = $item_id;
        $data_to_cache->item_info = $item_data;
		// Set transient caching
		set_transient( $transient_id, $data_to_cache, $CACHE_EXPIRATION );
		// Return WPorg datas
		return $data_to_cache->item_info;
	}
	// We do have cache datas
	return $cached_item->item_info;
}