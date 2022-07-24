<?php
	wp_enqueue_script( 'map-js', get_stylesheet_directory_uri() . '/library/js/map.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false&libraries=places&callback=initMap', array( 'jquery' ), '', true );
 ?>          
<section id="map_container" class=" map_container layer clearfix pad-bot-160" >
		<div id="map" class=" map clearfix">
		</div>
</section>
