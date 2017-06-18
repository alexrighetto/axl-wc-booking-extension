<?php

/**
 * Gmaps Functions Class
 *
 * @author   WooThemes
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gmaps_Functions' ) ) {

class Gmaps_Functions {
	/**
	 * Setup class.
	 *
	 * @since 1.0
	 */
    
    
    
	public function __construct() {
        add_action('wp_enqueue_scripts',array( $this, 'foundationpress_scripts'));
        add_action( 'woocommerce_after_shop_loop', array( $this,'add_map'), 100, 2);
        
    }
    
    public function add_map (){
		echo '<h1>' . __('The neighborhood', 'woocommerce') . '</h1>'; 
        echo'<div id="map-canvas" style="height:400px"></div>';
    }
    
    
		
		function foundationpress_scripts() {
		
		$address = Booking_Plus_Flat::return_address();	
	
		$handle 			=	'map-scripts';
		$src				=	plugins_url(  "../js/scripts.js" , __FILE__ );
		$dep				=	array('google-maps');
		$ver 				=	'1';
		$translation_array 	=	array(
									'address'	=> $address,
									'zoom' 		=> 13,
									'map_tag'	=> 'map-canvas'
								);
		
		
		wp_register_script( $handle	, $src, $dep, $ver, true );
		wp_localize_script( $handle , 'script_data', $translation_array );
		//Load custom JS script    
    	wp_enqueue_script( $handle); 
		


    // Load Google Maps API. Make sure to add the callback and add custom-scripts dependency
    wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCSdGzaaomcoSbkBqU8YLIRHGqGDeyIYnk',  array(  ) ); 
        //wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?key=AIzaSyCSdGzaaomcoSbkBqU8YLIRHGqGDeyIYnk&callback=initMap',  array( 'custom-scripts' ) ); 

		}

    
}
    
    

 
    
}
return new Gmaps_Functions();
