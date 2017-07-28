var script_data;
var flat_lat 	= jQuery('.lat').val();
var flat_long 	= jQuery('.long').val();
if (!flat_lat) { flat_lat = 45.438384;}
if (!flat_long) { flat_long = 10.991622;}
'use strict';
 jQuery(document).ready(function(){
		
		
		
	var map = new GMaps({
    	el: '#' + script_data.map_tag,
		lat: flat_lat,
  		lng: flat_long
      });
	
	map.addMarker({
	  lat: flat_lat,
	  lng: flat_long,
	  /*title: 'Lima',
	  click: function(e) {
		alert('You clicked in this marker');
	  }*/
	});
		
	jQuery('#geocode').on( "click", function(e) {
		
		var address_1 	= jQuery('.address_1').val();
		var city 		= jQuery('.city').val();
		var postcode 	= jQuery('.postcode').val();
		var country 	= jQuery('.country').val();
		var full_address = address_1 + ' ' + city + ' ' + postcode + ' ' + country
        e.preventDefault();
		
		//window.alert(full_address);
		
		
		
        GMaps.geocode({
			
          address: full_address,
          callback: function(results, status){
            if(status==='OK'){
              var latlng = results[0].geometry.location;
              map.setCenter(latlng.lat(), latlng.lng());
              map.addMarker({
                lat: latlng.lat(),
                lng: latlng.lng()
              });
				jQuery('.lat').val(latlng.lat());
				jQuery('.long').val(latlng.lng());
            }
          }
        });
      });
		
	});
