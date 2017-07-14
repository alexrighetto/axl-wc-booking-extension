<?php
/*
Plugin Name: Booking Extension
Plugin URI: 
Description: 
Author: Alex
Version: 1.0
Text Domain: booking-extension
Domain Path: /languages
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


define('PLUGINPATH', plugin_dir_path( __FILE__ )) ;
    
//require_once PLUGINPATH.'inc/multi-purpose-class.php';
require_once PLUGINPATH.'inc/extra-tax-fields-class.php';

require_once PLUGINPATH.'inc/class-booking-plus-flat.php';
require_once PLUGINPATH.'inc/class-booking-service-plus.php';




require_once PLUGINPATH.'inc/gmaps-functions-class.php';

require_once PLUGINPATH.'inc/FoursquareApi.php';
//require_once PLUGINPATH.'inc/wikipedia-class.php';
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

function my_plugin_load_plugin_textdomain() {
    load_plugin_textdomain( 'booking-extension', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'my_plugin_load_plugin_textdomain' );
