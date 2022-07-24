<?php
//wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&libraries=places&callback=initMap', array( 'jquery' ), '', true );
//wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&libraries=places', array( 'jquery' ), '', true );

 ?>    
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&libraries=places&callback=initMap"></script>
      
<script>

function initMap() {
    var mapOptions = {
    
    restriction: {
    latLngBounds: {north: 85, south: -85, west: -180, east: 180},
    strictBounds: true
  },
        center: new google.maps.LatLng(39.799697, 176.249687),
                 // center: {lat:-38.136891, lng: 176.249687}, 

        zoom: 1,
        minZoom: 1,
         disableDefaultUI: true,
         //center: locationNewZealand,
          gestureHandling: 'none',
          zoomControl: false,
          styles: [
           { featureType: "administrative.country", elementType: "labels", stylers: [ { visibility: "off" } ] },{
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [{"color": "#444444"}]},{"featureType": "landscape",
        "elementType": "all",
        "stylers": [{"color": "#727272"}]},{"featureType": "poi",
        "elementType": "all",
        "stylers": [{"visibility": "off"}]},{"featureType": "poi",
        "elementType": "labels",
        "stylers": [{"saturation": "-100"
            },{"lightness": "43"}]},{"featureType": "poi.attraction",
        "elementType": "all",
        "stylers": [{"visibility": "on"}]},{"featureType": "poi.business",
        "elementType": "all",
        "stylers": [{"visibility": "on"}]},{"featureType": "poi.school",
        "elementType": "all",
        "stylers": [{"visibility": "on"}]},{"featureType": "road",
        "elementType": "all",
        "stylers": [{"saturation": -100
            },{"lightness": 45}]},{"featureType": "road.highway",
        "elementType": "all",
        "stylers": [{"visibility": "simplified"}]},{"featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]},{"featureType": "transit",
        "elementType": "all",
        "stylers": [{"visibility": "off"}]},
        {"featureType": "water",
        "elementType": "all",
        "stylers": [{"color": "#212121"
            },{"visibility": "on"}]
    }]
    };
    map = new google.maps.Map(document.getElementById('map_full'), mapOptions);
    google.maps.event.addListenerOnce(map, 'idle', function() {
        //Map is ready
        console.log("idle");
        //worldViewFit(map);
    });
   
      
    google.maps.event.addDomListener(window, "resize", function() {
    	console.log("resize");
	   worldViewFit(map);

	});
}
function worldViewFit(mapObj) {
    var worldBounds = new google.maps.LatLngBounds(
    //    latLngBounds: {north: 85, south: -85, west: -180, east: 180},

        new google.maps.LatLng(85,-180),  //Top-left
        new google.maps.LatLng(-65, 180) //-46.11251, 163.4288)  //Bottom-right
    );
    
    mapObj.fitBounds(worldBounds, 0);
   /*
    var actualBounds = mapObj.getBounds();
    if(actualBounds.getSouthWest().lng() == -180 && actualBounds.getNorthEast().lng() == 180) {
        mapObj.setZoom(mapObj.getZoom()+1);
    }
    */
}
// google.maps.event.addDomListener(window, 'load', initialize);

(function($) {
 
/*
*  render_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/
 
function render_map( $el ) {
 
	// var
	var $markers = $el.find('.marker');
 
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};
 
	// create map	        	
	// var map = new google.maps.Map( $el[0], args);
 console.log("map: " + map);
	// add a markers reference
	map.markers = [];
 
	// add markers
	$markers.each(function(){
    	add_marker( $(this), map );
 
	});
 
	// center map
	center_map( map );
 
}
 
/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/
 var infoWindows=[];
function add_marker( $marker, map ) {
 
	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
 
 	console.log("add_marker" + map);
 var imagePath =  "<?php echo get_template_directory_uri(); ?>/library/images/map_marker_small.svg";
var image = {
        url: imagePath ,
        labelOrigin: new google.maps.Point(20,70),
        scaledSize: new google.maps.Size(20, 20), // scaled size
    };
    
	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		 map: map,
        icon: image,
         animation: google.maps.Animation.DROP,
	});
 
	// add to array
	map.markers.push( marker );
 	
	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html(),
			maxWidth: 300,
			maxHeight:200
		});
 infoWindows.push(infowindow);
		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {
		 	 for (i = 0; i < infoWindows.length; i++) {
                        infoWindows[i].close();
                    }
			infowindow.open( map, marker );
		});
		
		
		
		
	}
 
}
 
/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/
 
function center_map( map ) {
 
	// vars
	var bounds = new google.maps.LatLngBounds();
 
	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){
 
		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
 
		bounds.extend( latlng );
 
	});
 /*
	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}
*/
}
 
/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
 
$(document).ready(function(){
	
	
	var ControllerMap = new ScrollMagic.Controller();

	var slideScene = new ScrollMagic.Scene({
		triggerElement: "#map_full", // trigger CSS animation when header is in the middle of the viewport
		triggerHook: 0.5,
		duration: "90%",
		reverse:false
		// offset: jQuery(window).height(), //"200"
	})
	.on("enter", function (event) {
	
		$('.acf-map').each(function(){
			render_map( $(this) );
		});

		
	})
	//.addIndicators()
	.addTo(ControllerMap);


	  	

	
	
});
 
 
})(jQuery);

</script>
<?php 
		$wp_query = new WP_Query(); 		
	$args = array(
		'post_type'      => 'testimonials',
		'order'          => 'ASC',
		'orderby'        => 'random',
		'posts_per_page' => -1,
		'meta_query'	=> array(
		'relation'		=> 'AND',
		array(
			'key'		=> 'location',
			'value'		=> '',
			'compare'	=> '!='
		),
		));	 
	$wp_query->query($args);
	$post_count = $wp_query->post_count;

	if($wp_query->have_posts()) : 
 ?>
  <div class="acf-map" style="display:none;">
  <?php
  		while ($wp_query->have_posts()) : 
				$wp_query->the_post();
				$testimonial = get_the_content();
				$name = get_the_title();
				$logo = wp_get_attachment_image(get_field('logo'), 'thumbnail' ); 
				$date = get_field("date");
  
   // while ( have_rows('locations') ) : the_row(); 
  $location = get_field('location');
  //print_r($location);
  ?>
  <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
          <p style="margin:0 0 5px 0;text-transform:uppercase; font-size:10px;" class="center"><?php echo $name; ?></p>
		 <p class="center"><b><?php echo $testimonial; ?></b></p>
  </div>
  <?php endwhile; ?>
  </div>
  <section id="map_container" class="map map_container layer clearfix light" >
  		<div class="inner inner-1170 pad-top-80 pad-bot-40">
			<div>
				<h3 class="title element-masked-y subhead" style="text-align: center;" data-aos="text-intro" data-aos-anchor-placement='center-bottom' ><strong>Kia Kotahi Tātou</strong> | We are one</h3>
			</div>
		</div>
		<div id="map_full" class="clearfix" style="width:100%; max-width:970; max-height:500px; padding-bottom:50%; margin:0 auto;">
		</div>
		<div class="icon-wrap pad-bot-60 pad-bot-40 center">
				<div class="icon-drag"></div>
				<p>click to view reviews</p>
		</div>
</section> 
  <?php endif;
  	wp_reset_query();
   ?>
  
