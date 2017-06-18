<?php
/**
 * Booking Plus Class
 *
 * @author   WooThemes
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Booking_Plus_Flat' ) ) {

class Booking_Plus_Flat {
	
	public function __construct() {
		add_filter( 'woocommerce_show_page_title',  array($this, 'notitle'));
		add_action('flat_image_header', array($this, 'set_title_flat_image'));
		add_action( 'set_address_flat', array($this, 'get_array_rooms'), 11, 2);
		
		add_action( 'set_address_flat', array($this, 'get_address'), 11, 2);
		add_action( 'set_address_flat', array($this, 'flat_is_bookable'), 11, 2);
		add_action( 'woocommerce_before_shop_loop', array($this, 'rooms_title'), 11, 2);
	
		add_action( 'set_address_flat', array($this, 'set_total_number_rooms'), 11, 2);
		
		add_action( 'set_address_flat', array($this, 'set_total_number_rooms_bookable'), 11, 2);
		add_action( 'woocommerce_archive_description', array($this, 'set_cat_title'), 9, 2);
		
		add_action( 'woocommerce_after_main_content', array($this, 'set_instagram')); 
		
	}
	
	public function set_instagram(){
		echo '<div id="instafeed"></div>';
	}
	
	
	public function set_cat_title(){
		if( is_tax() )
		echo '<h3 class="main_flat_desc">' . __('Flat description', 'booking-extension') . '</h3>';
	}
	
	
	public function set_total_number_rooms(){
	
		$total_rooms = $this->get_rooms();
		
		echo "<div class='listing_main_number'>";
		_e('Total number of rooms:', 'booking-extension') . $total_rooms ;
		echo "</div>";
	}
	
	
	
	
	
	
	
	public function set_total_number_rooms_bookable(){
	
		$total_rooms_bookable = count($this->get_available_rooms());
		
		//var_dump( $total_rooms_bookable );
		
		$total_rooms_num =$this->get_rooms();
		
		if( $total_rooms_bookable  ){
			
			echo "<div class='listing_main_bookable'>";
			
			if( $total_rooms_bookable <= 1 ){
				
				_e( 'There is only an available room.', 'booking-extension' );

				
			}else{
				/* translators: %s: Numbrer of rooms available */
				printf(  __( 'There are %s available rooms', 'booking-extension' ), $total_rooms_bookable );
				
			} 
				
			echo"</div>";
			
			
		}
		
		
	}
	
	
	
	
	/**
	 * rimuove il titolo nella pagina di categoria di woocommerce
	 *
	 */
	
	public function rooms_title(){
	 echo '<h2>' . __('Rooms', 'booking-extension') . '</h2>';
	}

	
	public function notitle(){
	 return false;
	}
	
	
	
	/**
	 * Publica il titolo della categoria  di un head grafico della pagina categoria di woocommerce
	 *
	 */
	
	
	public function set_title_flat_image(){
		?>
	
		<h1 class="entry-title entry-prop"><?php woocommerce_page_title(); ?></h1>
		
        <span class="property_ratings listing_slider">
                     
        </span> 
    	</h1>
    	<div class="listing_main_image_location">
			<?php do_action ('set_address_flat'); ?>
		</div>
		<?php
	}
	public static function get_flatID(){
			if ( function_exists( 'is_product_category' )){
				if( is_product_category() ){

					return get_queried_object()->term_id;

				}else{
					return false;
				}
			}else{
			return false;
	}}
	
	
	/*
		 * Funzione che ha lo scopo di restituire dati delle stanze di un appartamento
		 *
		 * @return array
		 */
		public function get_array_rooms( $flatID = null ){
			if( empty ( $flatID ))
			$flatID = $this->get_flatID();
			
			 $args = array(
				'post_type'             => 'product',
				'post_status'           => 'publish',
				'ignore_sticky_posts'   => 1,
				'posts_per_page'        => '-1',
				
				'tax_query'             => array(
					
					array(
						'taxonomy'         => 'product_cat',
				 		'field' => 'term_id',
				 		'terms' => array( $flatID )
					),
				)
			);
			$products = new WP_Query($args);
			
			
			// Il secondo Loop
			while( $products->have_posts() ):
				$products->next_post();
				$array_rooms[] = $products->post->ID ;
			endwhile;
			
			return $array_rooms;
		}
	
	
		public function get_rooms( $flatID = null ){
        
		   if( empty ( $flatID ))
				$flatID = $this->get_flatID();


			


				$term = get_term( $flatID, 'product_cat' ); 
				return $term->count ;

			   
        
    	}
	
	/*
		 * funzione che stabilisce se nell'appartamento ci sono stanze prenotabili
		 * 
		 * Restituisce false, se nell'appartamento nno ci sono stanze libere, o non ci sono stanze impostate
		 * restituisce true se cce ne sono
		 *
		 * @return boolean
		 */
		public function flat_is_bookable( $flatID ){
			
			// se non esiste l'id lo ottengo;
			
			if( empty ( $flatID )){
			$flatID = $this->get_flatID();
			}
			
			$rooms_available = $this->get_available_rooms( $flatID );
			
			if( ! $rooms_available ) {
				  //array contains only empty values
				//echo "niente prenotabile";
				return false;
			}else{
				//echo " prenotabile";
				return true;
			}
			
			
		}
	
	/*
		 * Funzione che ha lo scopo di restituire le stanze disponibili
		 *
		 * @return array
		 */
		public function get_available_rooms( $flatID = NULL ){
			
			if( empty ( $flatID )){
			$flatID = $this->get_flatID();
			}
			
		
			
			// OTTENGO UN ARRAY CON TUTTI GLI ID delle stanze
			// basato sulla categoria attuale
			
			$array_rooms = $this->get_array_rooms($flatID);
			
			
			
			
			foreach ($array_rooms as $array_room) {
				
				//richiamo una funzione statica da booking_service_plus_class
				
				if( booking_sevice_plus::room_is_bookable($array_room) ){
					$rooms_avaiable[] = $array_room;
					
				}
				
			
			}
			
			
			
			if(!array_filter($rooms_avaiable,'trim')) {
				  //array contains only empty values
				return false;
			}else{
				
				return $rooms_avaiable;
			}
		
		}
	
		public function get_address($echo = 1, $no_number = false){
		
			
			if( empty ( $flatID )){
			$flatID = $this->get_flatID();
			}

			
				$t_id = $flatID;
				//then i get the data from the database
				$cat_data = get_option( "taxonomy_$t_id" );
				$string_address = $cat_data['address_1'] . " " . $cat_data['postcode'] . " " . $cat_data['city']. " " . $cat_data['country']; 

				//var_dump( $echo );
				
				echo "<div class='listing_main_location'> $string_address </div>";
				

			
		}
	
	public static function return_address(){
		
			
			if( empty ( $flatID )){
			$flatID = self::get_flatID();
			}

			
				$t_id = $flatID;
				//then i get the data from the database
				$cat_data = get_option( "taxonomy_$t_id" );
				$string_address = $cat_data['address_1'] . " " . $cat_data['postcode'] . " " . $cat_data['city']. " " . $cat_data['country']; 

				//var_dump( $echo );
				
				return $string_address ;
				

			
		}
	

}

}

return new Booking_Plus_Flat();