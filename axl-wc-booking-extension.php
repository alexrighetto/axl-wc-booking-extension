<?php
/*
Plugin Name: WC Booking Extension
Plugin URI: 
Description: 
Author: Alex
Version: 1.0
Author URI: 
*/
define('PLUGINPATH', plugin_dir_path( __FILE__ )) ;
    
require_once PLUGINPATH.'inc/multi-purpose-class.php';
require_once PLUGINPATH.'inc/extra-tax-fields-class.php';

require_once PLUGINPATH.'inc/class-booking-plus-flat.php';
require_once PLUGINPATH.'inc/class-booking-service-plus.php';




require_once PLUGINPATH.'inc/gmaps-functions-class.php';

require_once PLUGINPATH.'inc/FoursquareApi.php';
require_once PLUGINPATH.'inc/wikipedia-class.php';
require_once PLUGINPATH.'inc/foursquare-class.php';




// remove default sorting dropdown in StoreFront Theme
 
add_action('init','delay_remove');
 
function delay_remove() {
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );


}


 
/**
* Loads a translation file if the paged being viewed isn't in the admin.
*
* @since 0.1
*/
/**
	 * Localisation
	 */

add_action( 'init', 'axl_load_plugin_textdomain' );

	 function axl_load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'axl-wc-booking-extension' );
		$dir    = trailingslashit( WP_LANG_DIR );

		load_textdomain( 'wc-booking-extension', $dir . 'axl-wc-booking-extension/wc-booking-extension-' . $locale . '.mo' );
		load_plugin_textdomain( 'wc-booking-extension', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
