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
	/**
	 * Setup class.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		
		add_action('flat_image_header', array($this, 'set_title_flat_image'));
		/**
		 * Verifico l'esistenza del plugin che ha le funzioni che mi interessano: extra_tax_fields_class
		 *
		 */
		
		if( class_exists( 'extra_tax_fields_class' ) ){
			
			$this->extrafields = new extra_tax_fields_class();
			
			add_filter( 'woocommerce_show_page_title',  array($this, 'notitle'));
			add_action( 'set_address_flat', array($this, 'set_address'), 11, 2);
			add_action( 'set_address_flat', array($this, 'set_room_numbers'), 12, 2);
		}	
	}

	/**
	 * Publica il numero di stanze in cui è composta il flat all'interno di un head grafico della pagina categoria di woocommerce
	 *
	 */
	
	public function set_room_numbers(){
		$extrafields = new extra_tax_fields_class();
		
		echo '<div class="rooms_details ">' . __('N° Rooms: ') . $extrafields->count_tax_children() . "</div>";
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
	/**
	 * rimuove il titolo nella pagina di categoria di woocommerce
	 *
	 */
	
	
	public function notitle(){
	 return false;
	}
	
	public function set_address (){
		/**
		 * richiamo un metodo non presente in questa classe
		 * ma presente in extra-tax-fields-class.php
		 */
		 
         $cat_obj = $this->extrafields->query_tax_obj();
		 
     
        if($cat_obj)    {
            
            $category_ID  = $cat_obj->term_id;
            $t_id = $category_ID;
            //then i get the data from the database
            $cat_data = get_option( "taxonomy_$t_id" );
            $string_address =  $cat_data['city']. " " . $cat_data['country']; 
            
            echo '<div class="address_details ">' . $string_address . "</div>";
               
            
        }
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
			
		}
		
		/*
		 * Funzione che ha lo scopo di restituire le stanze disponibili
		 *
		 * @return array
		 */
		public function get_available_rooms( $flatID ){
			
		}
		
		
		/*
		 * Funzione che ha lo scopo di restituire il numero delle stanze di un appartamento
		 *
		 * @return number
		 */
		public function get_rooms( $flatID ){
			
		}
		/*
		 * Funzione che ha lo scopo di restituire dati delle stanze di un appartamento
		 *
		 * @return array
		 */
		public function get_array_rooms( $flatID ){
			
		}
		
		/*
		 * Funzione che restituisce la prossima data disponibile per uno specifico appartamento o in generale
		 *
		 * @return roomId
		 */
		public function get_next_available_room( $flatID= null ){
			
		}
		
		/*
		 * funzione che restituisce un range di prezzo per l'appartamento specificato
		 *
		 * @return string
		 */
		public function get_flat_price_range( $flatID ){
			
		}
		
		/*
		 * funzione che restituisce 
		 *
		 * @return string
		 */
		public function get_flat_address( $flatID = null ){
			
		}

}

}

return new Booking_Plus_Flat();