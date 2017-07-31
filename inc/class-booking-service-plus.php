<?php

//include_once WP_PLUGIN_DIR . '/woocommerce-bookings/includes/class-wc-booking.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/***********

Booking ID Numero di prenotazione
Flat ID numero di appartamento
Room ID numero di stanza




**************/

if ( ! class_exists( 'booking_sevice_plus' ) ) {

	class booking_sevice_plus  {
		
		public $bookingID;
		
		public $flatID;
		
		public $roomID;
		
		private $today_date;
			
		public $date_format = 'd-m-Y';
		
		public $time_format = 'H:i:s';
		
		public function __construct() {
			
			add_action('woocommerce_single_product_summary', array( $this, 'room_is_bookable'));
		
			add_action('woocommerce_single_product_summary', array( $this, 'get_next_book_date'));
		
			//add_action('woocommerce_single_product_summary', array( $this, 'room_is_bookable'));
			
			add_action('woocommerce_single_product_summary', array( $this, 'set_flat_description'));
			
			
		}
		
	
		
		
		public function set_flat_description(){
			
			$roomID = self::get_roomID();	
			
						
			$cats =  $this->get_the_category($roomID );
			
			
			 echo '<div class="flat-description"><p>' . $cats[0]->description . '</p><div>' ;

		}
		
		public function get_the_category( $id = false ) {
			$categories = get_the_terms( $id, 'product_cat' );
			if ( ! $categories || is_wp_error( $categories ) )
				$categories = array();

			return $categories;
		}
		
		/*
		 * Setter per la variabile format time
		 *
		 * @return boolean
		 */
		public function set_timeformat($timeformat) { 
			$this->timeformat = $timeformat; 
		}
		/*
		 * Getter per la variabile format time
		 *
		 * @return boolean
		 */
		public function get_timeformat() { 
			return $this->timeformat; 
		}
		
		
		public function get_today(){
			
			return date( $this->date_format , current_time( 'timestamp', 0 ) );
		}
		
		public function get_booking_end_date( $id ){
        
			if( class_exists('WC_Booking') ) {
				$wcBooking = new WC_Booking( $id );
				return $wcBooking->get_end_date( $this->date_format, $this->time_format );
			}
		 }

		public function get_booking_start_date( $id ){
			if( class_exists('WC_Booking') ) {
			$wcBooking = new WC_Booking( $id );
			return $wcBooking->get_start_date( $this->date_format, $this->time_format );
			}
		 }
    	
		
		public static function get_roomID(){
			if ( function_exists( 'is_product' ))
			if( is_product() ){
				global $product;
				$id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;
				return $id ;
				
			}else{
				return false;
			}
		}
   
		/*
		 *
		 *
		 * @return boolean
		 */
		public static function room_is_bookable( $roomID = '' ){
			
			if( empty ( $roomID )){
			$roomID = self::get_roomID();
			}else{
				$roomID = $roomID;
			}
			/*
			* get_order_by_roomID restituisce FALSE se non ci sono prenorazioni
			* altrimenti restituisce un array
			*
			*
			*/
			$room_booking = self::get_order_by_roomID($roomID);
			
			//wp_die(var_dump( $room_booking ) );
			
			if(  $room_booking === false ) {
				// non ci sono prenotazioni per questa stanza
				return false;
				
			}else{
				//  ci sono prenotazioni per questa stanza
				return true;
				
			}
		}
		
		
		public static function get_order_by_roomID($roomID = null) {
		
			if( empty ( $roomID ))
				$roomID = self::get_roomID();	

			global $wpdb;
			$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape('_booking_product_id')."' AND meta_value='".$wpdb->escape($roomID)."'");
			if (is_array($meta) && !empty($meta) && isset($meta[0])) {

				return $meta; 
			}
			else {
				return false;
			}
		}
		
		/*
		 *
		 *
		 * @return date or false
		 */
		public function get_next_book_date( $roomID = null ){
			

			$room_booking = $this->get_order_by_roomID( $roomID );
			
			
			
			if( $room_booking === false){
				
				echo "<div class='room_status bookable onsale'>";
				// non ci sono prenotazioni per questa stanza
				
				_e( 'This room is bookable.', 'booking-extension' );
				
			}else{
				

				if( class_exists('WC_Booking') ) {

				echo "<div class='room_status not_bookable onsale'>";

				// ottengo l'ultima prenotazione
				$last_booked_date = end( $room_booking );
				$book_end_date = $this->get_booking_end_date( $last_booked_date->post_id );
				//echo "Prossima prenotazione disponibile: $book_end_date </br>";
				
				printf(  __( 'Currently this room is not available. Next available date: %s', 'booking-extension' ), $book_end_date );
				
				} else {
					
					_e( 'Currently this room is not available.', 'booking-extension' );
				}
				
			}
			
			echo "</div><br/>";
		}
		
		
		
		
		
	}
}

return new booking_sevice_plus();