<?php

/**
 * Foursquare Functions Class
 *
 * @author   WooThemes
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Foursquare_Functions' ) ) {

class Foursquare_Functions {
	

    
	public function __construct() {
       
		
        add_action( 'init', array( $this, 'fq_loader') );
		
        
    }
    
	function fq_loader(){
    	if ( is_product_category() ){
    		add_action( 'woocommerce_after_main_content', array( $this, 'ig_test') );
		}
	}
	
	
    function ig_test($location = "Verona"){


// Set your client key and secret
	$client_key = "HTMVVYXFBTZUEED10NI0O2MMIICQHTJIKVSOTE4JJBQVXF5Z";
	$client_secret = "RSZSRSBUY3NJEL53M55NPSNHGC2VHI0BCKERYNSWK0PXL4ND";
	// Load the Foursquare API library

	if($client_key=="" or $client_secret=="")
	{
        echo 'Load client key and client secret from <a href="https://developer.foursquare.com/">foursquare</a>';
        exit;
	}
		$address = Booking_Plus_Flat::return_address();	
	$foursquare = new FoursquareApi($client_key,$client_secret);
	$location = array_key_exists("location",$_GET) ? $_GET['location'] : $address;
    
    	
	// Generate a latitude/longitude pair using Google Maps API
	list($lat,$lng) = $foursquare->GeoLocate($location);
	
	
	// Prepare parameters
	$params = array("ll"=>"$lat,$lng");
	
	// Perform a request to a public resource
	$response = $foursquare->GetPublic("venues/search",$params);
	$venues = json_decode($response);

		
	 echo '<h3>' . __('Things to see around', 'booking-extension') . '</h3>'; 
	 foreach($venues->response->venues as $venue): 
		
		if( $venue->stats->checkinsCount > 10){
                    echo '<div class="items_around">';
					if(isset($venue->categories['0']))
					{
						echo '<image class="icon" src="'.$venue->categories['0']->icon->prefix.'88.png"/>';
					}
					else
						echo '<image class="icon" src="https://foursquare.com/img/categories/building/default_88.png"/>';
					echo '<a href="https://it.foursquare.com/v/'.$venue->id.'" target="_blank"/><b>';
					echo $venue->name;
					echo "</b></a><br/>";
					
					
						
                    if(isset($venue->categories['0']))
                    {
						if(property_exists($venue->categories['0'],"name"))
						{
							echo ' <i> '.$venue->categories['0']->name.'</i><br/>';
						}
					}
					
					/*if(property_exists($venue->hereNow,"count"))
					{
							echo ''.$venue->hereNow->count ." people currently here <br/> ";
					}*/

                    echo '<b><i>History</i></b> :'.$venue->stats->usersCount." visitors , ".$venue->stats->checkinsCount." visits ";
					 echo '</div>';
		}
		
		endforeach; 
}
 
    }
}
return new Foursquare_Functions();
