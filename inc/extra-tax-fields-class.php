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

if ( ! class_exists( 'extra_tax_fields_class' ) ) {

class extra_tax_fields_class {
	/**
	 * Setup class.
	 *
	 * @since 1.0
	 */
	public function __construct() {
        
        
        add_action( 'product_cat_add_form_fields', array( $this, 'product_cat_add_new_meta_field'));
        add_action( 'product_cat_edit_form_fields', array( $this,'woocommerce_taxonomy_edit_meta_field') );
        add_action( 'create_product_cat', array( $this,'save_taxonomy_custom_meta' ));
        add_action( 'edited_product_cat', array( $this,'save_taxonomy_custom_meta'));
       // add_action( 'woocommerce_archive_description', array( $this,'get_address'), 7, 2);
        add_action( 'woocommerce_archive_description', array( $this,'get_venue_img'), 9, 2);
        add_action( 'woocommerce_archive_description', array( $this,'count_tax_children'), 8, 2);


    }
   
	/**
	* da id ottengo se l'appartamento è libero
	*
	* @since 1.0
	*/
	
   
       
    
    
    

     
    public function query_tax_obj(){
        global $wp_query;
        return $wp_query->get_queried_object();
    }
    
    
     public function get_venue_img(){
        
       if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
			echo "<div class='flat_listing_main_image' style=' background-image: url(" . $image . ")' >";
			/*
			 * richiamo azioni importanti
			 * @hooked set_title_flat_image 10 , 2
			 */
			
			do_action ( 'flat_image_header' );
		    
			echo"</div>";
		}
	}
         
     }
    
    
    public function count_tax_children(){
        
       
        // get the query object
        $cat_obj = $this->query_tax_obj();


        if($cat_obj)    {
           /* $category_name = $cat_obj->name;
            $category_desc = $cat_obj->description;*/
            $category_ID  = $cat_obj->term_id;
            
            $term = get_term( $category_ID, 'product_cat' ); 
            return $term->count ;
            
        }    
        
    }
    
    
    
    // Add term page
    public function product_cat_add_new_meta_field() {
        // this will add the custom meta field to the add new term page
        ?>
        <div class="form-field">
            <label for="term_meta[address_1]"><?php _e( 'Address', 'woocommerce' ); ?></label>
            <input type="text" name="term_meta[address_1]" id="term_meta[address_1]" value="">
            <p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
        </div>
        <div class="form-field">
            <label for="term_meta[city]"><?php _e( 'City', 'woocommerce' ); ?></label>
            <input type="text" name="term_meta[city]" id="term_meta[city]" value="">
            <p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
        </div>
        <div class="form-field">
            <label for="term_meta[postcode]"><?php _e( 'Postcode', 'woocommerce' ); ?></label>
            <input type="text" name="term_meta[postcode]" id="term_meta[postcode]" value="">
            <p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
        </div>

        <div class="form-field">
            <label for="term_meta[country]"><?php _e( 'Country', 'woocommerce' ); ?></label>
            <input type="text" name="term_meta[country]" id="term_meta[country]" value="">
            <p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
        </div>
    <?php
    }
    
     public  function woocommerce_taxonomy_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_$t_id" ); ?>

	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[address_1]"><?php _e( 'Address', 'woocommerce' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[address_1]" id="term_meta[address_1]" value="<?php echo esc_attr( $term_meta['address_1'] ) ? esc_attr( $term_meta['address_1'] ) : ''; ?>">
			<p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
		</td>
	</tr>
    <tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[city]"><?php _e( 'City', 'woocommerce' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[city]" id="term_meta[city]" value="<?php echo esc_attr( $term_meta['city'] ) ? esc_attr( $term_meta['city'] ) : ''; ?>">
			<p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
		</td>
	</tr>
 <tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[postcode]"><?php _e( 'Postcode', 'woocommerce' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[postcode]" id="term_meta[postcode]" value="<?php echo esc_attr( $term_meta['postcode'] ) ? esc_attr( $term_meta['postcode'] ) : ''; ?>">
			<p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
		</td>
	</tr>
<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[country]"><?php _e( 'Country', 'woocommerce' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[country]" id="term_meta[country]" value="<?php echo esc_attr( $term_meta['country'] ) ? esc_attr( $term_meta['country'] ) : ''; ?>">
			<p class="description"><?php _e( 'Enter a value for this field','woocommerce' ); ?></p>
		</td>
	</tr>
<?php
}
    public function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  


}
 
    }

return new extra_tax_fields_class();






