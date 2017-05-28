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
       
       //add_action( 'woocommerce_after_main_content', array($this, 'ig_test2')); 
    }
    
    function ig_test2(){
$url = 'http://it.wikipedia.org/w/api.php?action=query&prop=extracts|info&exintro&titles=verona&format=json&explaintext&redirects&inprop=url&indexpageids';

    $json = file_get_contents($url);
    $data = json_decode($json);
    
    echo $data->query->pages->title . '<br />';
    
    echo $data->extract . '<br />';
   echo  '<pre>';
   var_dump($data);
   echo  '<pre>';
}
 
    }
}
return new Wikipedia_Functions();






