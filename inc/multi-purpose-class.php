<?php

/**
 * Silvercare Class
 *
 * @author   WooThemes
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'booking_functions' ) ) {

class booking_functions {
	/**
	 * Setup class.
	 *
	 * @since 1.0
	 */
	public function __construct() {
        
       // add_action('woocommerce_single_product_summary', array( $this, 'add_text'));
       // add_action('storefront_single_post', array( $this, 'add_text'));
       // add_action('storefront_loop_post', array( $this, 'add_text'));
       // add_action('woocommerce_before_single_variation', array( $this, 'add_text'));
        
       
       }
    
    
                   
     public function get_booking_end_date( $id ){
        
        $wcBooking = new WC_Booking( $id );
        return $wcBooking->get_end_date( 'Y-m-d', 'H:i:s' );
    
     }
    
    public function get_booking_start_date( $id ){
        
        $wcBooking = new WC_Booking( $id );
        return $wcBooking->get_start_date( 'Y-m-d', 'H:i:s' );
    
     }
    
   public function get_post_id_by_meta_key_and_value($key, $value) {
		global $wpdb;
		$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($key)."' AND meta_value='".$wpdb->escape($value)."'");
		if (is_array($meta) && !empty($meta) && isset($meta[0])) {
			$meta = $meta[0];
		}		
		if (is_object($meta)) {
			return $meta->post_id;
		}
		else {
			return false;
		}
	}
    
          
    public function get_last_order( ){
        global $wpdb;
        $produto_id = get_the_ID(); // Product ID
        $consulta = "SELECT order_id " .
            "FROM {$wpdb->prefix}woocommerce_order_itemmeta woim " .
            "LEFT JOIN {$wpdb->prefix}woocommerce_order_items oi " .
            "ON woim.order_item_id = oi.order_item_id " .
            "WHERE meta_key = '_product_id' AND meta_value = %d " .
            "GROUP BY order_id;";   
        $order_ids = $wpdb->get_col( $wpdb->prepare( $consulta, $produto_id ) );
        $last_order = end( $order_ids );
        return $last_order;
    }
    
    
    public function add_text(){
        
        echo "current_time = " . date( 'Y-m-d', current_time( 'timestamp', 0 ) ) . '<br/>';  
        $today_dt =  date( 'Y-m-d', current_time( 'timestamp', 0  ) );
        $expire_dt = $this->get_booking_end_date( $this->get_post_id_by_meta_key_and_value('_booking_product_id', get_the_ID()) );
        
        if($today_dt < $expire_dt) { 
         echo 'oggi libero' . '<br/>';   
        }
        
        echo 'magia = ' . $this->get_post_id_by_meta_key_and_value('_booking_product_id', get_the_ID()). '<br/>';  
        echo 'id stanza = ' . get_the_ID() . '<br/>';    
            
        echo 'ordine id prenotazione = ' . $this->get_last_order() . '<br/>';      
        echo 'prossima prenotazione inizierà = ' . $this->get_booking_start_date( $this->get_post_id_by_meta_key_and_value('_booking_product_id', get_the_ID())) . '<br/>';
        echo 'e sarà prenotata fino a = ' . $this->get_booking_end_date( $this->get_post_id_by_meta_key_and_value('_booking_product_id', get_the_ID()) );
      
    } }
}

return new booking_functions();