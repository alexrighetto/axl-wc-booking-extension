<?php

/**
 * Wikipedia Functions Class
 *
 * @author   WooThemes
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wikipedia_Functions' ) ) {

class Wikipedia_Functions {
	
    
    
	public function __construct() {
<<<<<<< HEAD
      
=======
       //if ( is_tax())
>>>>>>> origin/master
       add_action( 'woocommerce_after_main_content', array($this, 'ig_test2')); 
    }
    
    function ig_test2(){
$url = 'http://it.wikipedia.org/w/api.php?action=query&prop=extracts|info&exintro&titles=verona&format=json&explaintext&redirects&inprop=url&indexpageids';

    $json = file_get_contents($url);
    $data = json_decode($json);
    
    $pageid = $data->query->pageids[0];
		echo "<h4>" . $data->query->pages->$pageid->title . "</h4>";
		
		echo "<p>" . $data->query->pages->$pageid->extract  . "</p>";
		
		echo "<a href=" . $data->query->pages->$pageid->fullurl . " target='_blank'>maggiori info</a>";
		
		//var_dump( $data);
}
 
    }
}
return new Wikipedia_Functions();






