var google, script_data;

google.maps.event.addDomListener( window, 'load', gmaps_results_initialize );
/**
 * Renders a Google Maps centered on Atlanta, Georgia. This is done by using
 * the Latitude and Longitude for the city.
 *
 * Getting the coordinates of a city can easily be done using the tool availabled
 * at: http://www.latlong.net
 *
 * @since    1.0.0
 */
function gmaps_results_initialize() {
    
    'use strict';
	//https://tommcfarlin.com/refactoring-our-code-for-google-maps-in-wordpress
	
    if ( null === document.getElementById( script_data.map_tag ) ) {
		return;
	}

	var geocoder, map, marker,  latitude, longitude;
	
	
	
	
	geocoder = new google.maps.Geocoder();
	
	geocoder.geocode( { 'address': script_data.address}, function(results, status) {

	  if (status === google.maps.GeocoderStatus.OK) {
	
		  //return results;
		  
		latitude = results[0].geometry.location.lat();
		longitude = results[0].geometry.location.lng();
		
		map = new google.maps.Map( document.getElementById( script_data.map_tag ), {

			zoom:           Number( script_data.zoom ),
			center:         new google.maps.LatLng( latitude, longitude )

		}); 
		  
		
		 // Place a marker in Atlanta
		marker = new google.maps.Marker({

			position:  new google.maps.LatLng( latitude,longitude ),
			map:      map

		}); 
		  
	  } 
	}); 
	
	
	
	
    
    /*// Add an InfoWindow for Atlanta
	infowindow = new google.maps.InfoWindow();
	google.maps.event.addListener( marker, 'click', ( function( marker ) {

		return function() {
			infowindow.open( map, marker );
		}

	})( marker ));
      */  

}