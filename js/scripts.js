
 jQuery(document).ready(function(){
	
	var map = new GMaps({
	  div: '#' + script_data.map_tag,
	  lat: script_data.lat,
	  lng: script_data.lng
	});
	 
	 map.addMarker({
	  lat: script_data.lat,
	  lng: script_data.lng,
	  /*title: 'Lima',
	  click: function(e) {
		alert('You clicked in this marker');
	  }*/
	});
});