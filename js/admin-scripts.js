//window.alert('loaded');	
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
		draggable: true,
         dragend: function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
			 
			
			
			var geocoder = new google.maps.Geocoder;

			 var latlng = {lat: lat, lng: lng};
			 
			 geocoder.geocode({'location': latlng}, function(results, status) {
				 if (status === 'OK') {
            		if (results[1]) {
				
				//console.log( JSON.stringify(results) )
				
				/*numero*/console.log(results[0]['address_components'][1]['long_name'])
				/*indirizzo*/console.log(results[0]['address_components'][0]['long_name'])
				/*città*/console.log(results[0]['address_components'][2]['long_name'])
				
				/*Provincia*/console.log(results[0]['address_components'][4]['short_name'])
				/*Regione*/console.log(results[0]['address_components'][5]['short_name'])
				/*Stato*/console.log(results[0]['address_components'][6]['short_name'])
				/*cap*/console.log(results[0]['address_components'][7]['short_name'])
				
				jQuery('.lat').val(lat);
				jQuery('.long').val(lng);
				jQuery('.address_1').val(results[0]['address_components'][1]['long_name'] + ' ' + results[0]['address_components'][0]['long_name']);
				jQuery('.city').val(results[0]['address_components'][2]['long_name']);
				jQuery('.postcode').val(results[0]['address_components'][7]['short_name']);
				jQuery('.country').val(results[0]['address_components'][4]['short_name']);		
				//window.alert(results[1].formatted_address);
				}}
			 });


                //alert('draggable '+lat+" - "+ lng);
			 
			 
			 
			 
		 }
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
