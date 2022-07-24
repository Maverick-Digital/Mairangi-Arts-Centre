<?php
global $post;
global $myScripts;
//wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&libraries=places&callback=initMap', array( 'jquery' ), '', true );
//wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&libraries=places', array( 'jquery' ), '', true );

 ?>    
  <section id="map_container" class="map map_container layer clearfix light" >
		<div id="map_full" class="clearfix" style="width:100%; max-width:970; max-height:500px; padding-bottom:50%; margin:0 auto;">
		</div>
</section> 
<?php

//wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&callback=initMap', array( 'jquery' ), '', true );
?>
<script>
// itinerary day map [individual_marker]
function initMap( $el ) {
	  var $markers = jQuery('body').find('.acf-map-marker');
	  

      var mapArgs = {
          zoom        : 7,
          mapTypeId   : google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: true,
          scrollwheel: false,
      
      };
    var styles=[
{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":0}]},
{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"off"},{"color":"#ffffff"},{"lightness":16}]},
{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},
{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},
{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":20},{"color":"#ececec"}]},
{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"off"},{"color":"#f0f0ef"}]},
{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"visibility":"off"},{"color":"#f0f0ef"}]},
{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"visibility":"off"},{"color":"#ff0000"}]},
{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"on"},{"color":"#8e9bb0"}]},
{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi","elementType":"geometry","stylers":[{"lightness":0},{"visibility":"off"},]},
{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"off"},{"color":"#d4d4d4"}]},
{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#303030"}]},
{"featureType":"poi","elementType":"labels.icon","stylers":[{"saturation":"100"}]},
{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},
{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#667794"}]},
{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"poi.school","elementType":"geometry.stroke","stylers":[{"lightness":"-61"},{"gamma":"0.00"},{"visibility":"off"}]},
{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"off"}]},
{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"on"}]},

{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":-17}]},
{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"},{"color":"#ffffff"},{"lightness":-19}]},
{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":-18}]},
{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":-16}]},
{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":-19}]},
{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c3cad5"},{"lightness":0}]},];

      var styledMap = new google.maps.StyledMapType(styles, {
        name: "Styled Map"
      });
      $element = jQuery("#map_full");
      var map = new google.maps.Map( $element[0] , mapArgs );
      map.mapTypes.set("map_style", styledMap);
      map.setMapTypeId("map_style");
      //console.log($el[0]);
	  map.markers = [];
	  var count=0;

      $markers.each(function(){
		count++;
	
          initMarker( jQuery(this), map, count );

      });
       centerMap( map );
      return map;
    }
  function initMarker( $marker, map, count) {
      // Get position from marker.
      var lat = $marker.data('lat');
	  var lng = $marker.data('lng');
	  var title = $marker.data('title');
	  var content = $marker.html();
      var latLng = {
          lat: parseFloat( lat ),
          lng: parseFloat( lng )
	  };
	    console.log('map marker' + latLng); 
      var producttype = $marker.data('producttype'); 
      var  icons_circle = {}
      if(producttype != undefined){
        icons_circle = {
          path: google.maps.SymbolPath.CIRCLE,
          fillColor: '#f1592a',
          fillOpacity: 1,
          strokeColor: '#f1592a',
          strokeOpacity: .3,
          strokeWeight: 20,
          scale: 3
        };
  
        // Create marker instance.
        var marker = new google.maps.Marker({
            position : latLng,
            map: map,
            icon: icons_circle,
        });
      }else{
      //console.log(producttype);
      // create icon
       var icons_standard = new google.maps.MarkerImage("<?php echo get_stylesheet_directory_uri(); ?>/library/images/icons/map_marker.svg", null, null, null, new google.maps.Size(30, 45));
	  
	   var markerIcon = {
  url: '<?php echo get_stylesheet_directory_uri(); ?>/library/images/icons/map_marker.svg',
  scaledSize: new google.maps.Size(25, 35),

  labelOrigin: new google.maps.Point(12,40),
};

var  icons_circle = {
        path: google.maps.SymbolPath.CIRCLE,
        fillColor: '#f1592a',
        fillOpacity: 1,
        strokeColor: '#f1592a',
        strokeOpacity: 1,
        strokeWeight: 1,
        scale: 5
      };

      // Create marker instance.
      var marker = new google.maps.Marker({
          position : latLng,
          map: map,
          icon: markerIcon,

          label: {
            text: title,
            color: '#FFF',
            fontSize: '16px',
		      	fontWeight: '800'
          }
      });
    }
  
      // Append to reference for later use.
      map.markers.push( marker );
  
      // If marker contains HTML, add it to an infoWindow.
      if( $marker.html() ){
  
          // Create info window.
          var infowindow = new google.maps.InfoWindow({
              content: $marker.html()
          });
  
          // Show info window when marker is clicked.
          google.maps.event.addListener(marker, 'click', function() {
              infowindow.open( map, marker );
          });
      }
  }
  function centerMap( map ) {
      // Create map boundaries from all map markers.
      var bounds = new google.maps.LatLngBounds();
      map.markers.forEach(function( marker ){
          bounds.extend({
              lat: marker.position.lat(),
              lng: marker.position.lng()
          });
      });
      // Case: Single marker.
      if( map.markers.length == 1 ){
          map.setCenter( bounds.getCenter() );
  
      // Case: Multiple markers.
      } else{
          map.fitBounds( bounds );
      }
  }
  
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&callback=initMap"></script>
