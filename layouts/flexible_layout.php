<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(1200,1200);
$size =   array(900,450);
$crop = false;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include( 'set_up_layout_styles.php' );

$imageL = wp_get_attachment_image_src( get_sub_field('main_image'), $sizeL, false );
$image = wp_get_attachment_image_src( get_sub_field('main_image'), $size, $crop );



?>

<div id="<?php echo $id; ?>" class="layer flexible_layout clearfix <?php echo $xclass; ?> "> 

	<?php 
	

		if(strpos($xclass, 'map') !== false){ 
			
			$myScripts = "
			
			";
			//wp_enqueue_script( 'map-js', get_stylesheet_directory_uri() . '/library/js/map.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'googlemap-js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU8cwJjkAqtH1erNQWAUKX0uhASsYrak&sensor=false', array( 'jquery' ), '', true );
			//echo "myScripts ".$myScripts;
			
			$location = get_field('gmap_location','options');

			
			if( !empty($location) ):
			?>
			<div id="map" class="acf-map">
				<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
				<strong>Tourism Talent</strong><br/>
				High Street,<br/>
				Auckland CBD,<br/>
				New Zealand<br/>
				<a href="https://maps.google.com/maps?ll=-36.848185,174.76331&z=17&t=m&hl=en&gl=NZ&mapclient=embed&daddr=Tourism%20Talent%20Auckland%20CBD%20Auckland%201010@-36.8484597,174.7633315">Get Directions</a>
				</div>
			</div>
			<?php endif; ?>
<script type="text/javascript">
(function($) {

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP,
		styles : [
					{
						"featureType": "administrative",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#444444"
							}
						]
					},
					{
						"featureType": "landscape",
						"elementType": "all",
						"stylers": [
							{
								"color": "#f2f2f2"
							}
						]
					},
					{
						"featureType": "landscape.man_made",
						"elementType": "geometry.stroke",
						"stylers": [
							{
								"visibility": "simplified"
							},
							{
								"color": "#f70000"
							}
						]
					},
					{
						"featureType": "landscape.natural.landcover",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "landscape.natural.terrain",
						"elementType": "geometry",
						"stylers": [
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "landscape.natural.terrain",
						"elementType": "labels.text",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "landscape.natural.terrain",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "poi.attraction",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#a9f07e"
							}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "poi.park",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"hue": "#2dff00"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "all",
						"stylers": [
							{
								"saturation": -100
							},
							{
								"lightness": 45
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "geometry",
						"stylers": [
							{
								"visibility": "simplified"
							},
							{
								"color": "#ffffff"
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "labels",
						"stylers": [
							{
								"visibility": "simplified"
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#666464"
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "road.arterial",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "#4d4d4d"
							}
						]
					},
					{
						"featureType": "road.arterial",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#acacac"
							}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#393939"
							}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "labels.text.stroke",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "geometry",
						"stylers": [
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "labels.text",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit.line",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "on"
							}
						]
					},
					{
						"featureType": "water",
						"elementType": "all",
						"stylers": [
							{
								"color": "#aad2e3"
							},
							{
								"visibility": "on"
							}
						]
					}
				]
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
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

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
	
	var host = window.location.host
	console.log(window.location.host );
	if(host == "localhost:8888"){
		host = "localhost:8888/tourism_talent";
	}
	var imagePath = window.location.protocol + "//" + host + "/wp-content/themes/tourism_talent/library/images/map_marker.svg";
	console.log(imagePath);
	var image = {
		url: imagePath 
	}
	
	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		icon: image,
		//animation: google.maps.Animation.DROP,
		map			: map
	});
	
	
	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			 content: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

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

}

var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});

});

})(jQuery);
</script>
	<?php 
	} else {

	//	print_r($fields);
		 ?>
		<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
		
		<div class="inner inner-<?php echo $inner; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
			<div class="content_wrap">
				<?php
				 $classesLeft = 'col textwrap';
				$classesRight = 'col imgwrap';
		   
       		 ?>
			 <?php /* <div class="<?php echo $classesLeft; ?> " data-aos="<?php echo $fade; ?>"   data-aos-anchor-placement="top-center"> */ ?>
				 <div class="<?php echo $classesLeft; ?> "  >
					<div class="_inner">
					<?php 
						if (get_sub_field('content')) {
						echo get_sub_field('content');
					} ?>
					</div>
			 	</div>
			<?php if(strpos($xclass, 'map') !== false){ ?> 
			
			<?php }else{
				
				$images = $fields['row_images'];
				//echo "MIKE";
				//echo get_field('row_images');
				//print_r($images);
				
			if(is_array($images)){
				//echo "is here";
				
			 ?>
			
			<div class="col imgwrap">
			
		
			<?php 
			
				if(get_sub_field("image_layout") == "gallery"){	
				

				
					$sizeS =   array(550,550);
					$sizeL =   array(1600,1600);
					
					
					
					$id= "section-".rand(1000000, 10000000);
					 ?>
					<div>
						<ul id="<?php echo $id; ?>" class="gallery_images cS-hidden">
							<?php foreach( $images as $image ):
							//	$imageID = $image['ID'];
								
								$imgL = fly_get_attachment_image_src($image, $sizeL, false ); 

							 ?>
							<li>
							<a class='venobox ' data-gall='toam' href='<?php echo $imgL['src']; ?>'>
								<span class="image_holder anim">
									<?php
									/*
									<?php $img = fly_get_attachment_image_src($imageID, $sizeS, true );  ?>
									<img class="img-responsive" src="<?php echo $img['src']; ?>" width="<?php echo $img['width']; ?>" height="<?php echo $img['height']; ?>" alt="<?php echo get_the_title(); ?>" />
									*/
						// echo get_sub_field('image_style');
						if(get_sub_field('image_style') == "image-round"){
					
							echo ipq_get_theme_image( $image, array(
								array( 600, 600, true ),
								array( 450, 450, true )
								)
							);
					
						}else{
						//print_r($image);
						//echo  $image;
							echo ipq_get_theme_image( $image, array(
								array( 900, 600, false ),
								array( 450, 300, false )
					
								)
							);
						}
						?>
								</span>
							</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<script>
						jQuery(function($) {
							// gallery
							var $gallery = $('#<?php echo $id; ?>');
							 //if($gallery.find('li').length ==  1){
	 							//$('#<?php echo $id; ?>').removeClass('cS-hidden');

							 //}else{
							 var gallery_images = $gallery.lightSlider({
									item:1,
									loop:true,
									slideMove:1,
									mode:'fade',
									controls:false,
									keyPress:true,
									easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
									speed:1000,
									pause:7000,
									pauseOnHover:true,
									slideMargin: 0,
									pager:true,
									autoWidth:false,
									adaptiveHeight:true,
									auto:false,
									onSliderLoad: function() {
										$('#<?php echo $id; ?>').removeClass('cS-hidden');
									} 
	
								});
							// }
						});
					</script>
				</div>
				<?php 
				
				
				
				
				}else{		
					foreach( $images as $image ){
						//print_r($image);
						$attachment_ID =    $image['ID'];
							
						if($image['mime_type'] == 'image/svg+xml'){
							$img = wp_get_attachment_image($attachment_ID);
							$imgL = wp_get_attachment_image_src($attachment_ID);
							//echo $img;
						}else{

							if ($attachment_ID) {
								$classes = "";//"pad-top-20 pad-bot-20";
								$img = fly_get_attachment_image_src($attachment_ID, $size, $crop ); 
							}
						
							if($xclass == 'map'){
				
								$img = fly_get_attachment_image_src($attachment_ID, $size, false ); 
							}
					  		$imgL = fly_get_attachment_image_src($attachment_ID, $sizeL, false ); 
						}


						if ($img) {
							$thumb_img = get_post($attachment_ID); // Get post by ID
							$caption = false;
							$caption = $thumb_img->post_excerpt; // Display Caption
							if (!$caption) {
								$caption = "";//CAPTION: We are the business behind the businesses that power your local economy";
							}else{
								//  $classes ="";
							} 
				  
				

				

					 ?>
					<div class="<?php echo $classes; ?> pad-bot-20"  >
						<?php
						if (strpos($xclass, 'video') !== false) {
							// echo 'true'.$xclass;
							$start = strpos($xclass, 'video-') + 6;
							$videoUrl = substr($xclass,$start);	
							//echo $videoUrl; ?>
							<a class="venobox" data-autoplay="true" data-vbtype="video" href="https://youtu.be/<?php echo $videoUrl; ?>?rel=0&amp;autoplay=1">
						<?php
							}else{
								//print_r($imgL)
						
							if (strpos($class, 'no-link') !== false) { ?>
								<a class='venobox ' data-gall='toam' href='<?php echo $imgL['src']; ?>'>
							<?php } 
						} ?>
						<div class="image_holder anim">
						
						<?php
						 if(get_sub_field('image_style') == "image-round"){
							echo ipq_get_theme_image( $image['ID'], array(
								array( 600, 600, true ),
								array( 450, 450, true )
					
								)
							);
					
						}else{
							echo ipq_get_theme_image( $image['ID'], array(
								array( 900, 600, true ),
								array( 450, 300, true )
					
								)
							);
						}
						?>
						</div>
			
			   
						<?php if ($caption) {

							echo '<p class="wp-caption-text">' . $caption . '</p>';
						}else{
							 // echo '<p class="caption">&nbsp;</p>';
						}
						if (strpos($class, 'no-link') !== false) { ?>
						 </a>
						<?php } ?>
					</div>
					<?php 
				
					} 
					?>
					</div>
				<?php
				}
			}
        
        }  ?>
         
        <?php
        
			}
			 ?>
			
		</div>
	</div>
	<?php  } ?>
</div>
