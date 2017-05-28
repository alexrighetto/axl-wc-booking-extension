
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
    
    //https://tommcfarlin.com/refactoring-our-code-for-google-maps-in-wordpress
	
    if ( null === document.getElementById( 'map-canvas' ) ) {
		return;
	}

	var map, marker;

	map = new google.maps.Map( document.getElementById( 'map-canvas' ), {

		zoom:           13,
		center:          new google.maps.LatLng( 45.438384, 10.991622 ),

	});

	// Place a marker in Atlanta
	marker = new google.maps.Marker({

		position:  new google.maps.LatLng( 45.438384, 10.991622 ),
		map:      map

	});
    
    // Add an InfoWindow for Atlanta
	infowindow = new google.maps.InfoWindow();
	google.maps.event.addListener( marker, 'click', ( function( marker ) {

		return function() {
			infowindow.open( map, marker );
		}

	})( marker ));
        

}