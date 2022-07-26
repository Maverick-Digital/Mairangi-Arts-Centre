<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560, 2560);
$size =   array(1400, 900);
$crop = true;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');

//print_r($fields);
//$fields = get_fields();



$imageL = wp_get_attachment_image_src(get_sub_field('main_image'), $sizeL, false);
$image = wp_get_attachment_image_src(get_sub_field('main_image'), $size, $crop);
?>
<section id="<?php echo $id; ?>" class="<?php echo $id; ?> layer   ">
	<div id="start_location" class="map_layout layer layout_2col_imagesinner-<?php echo $inner;
																				echo $column_vertical_alignment; ?>  clearfix">
		<div class="inner  inner-<?php echo $inner;
										echo $column_vertical_alignment; ?> <?php echo $xclass; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		<?php




		//echo "myScripts ".$myScripts;
		$location = get_sub_field('google_map');
		if (!empty($location)) :
		?>
			<div class="bg-image">
				<div id="map" class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
						<?php echo get_sub_field('info_window'); ?>
					</div>
				</div>
			</div>
			<?php
			ob_start(); ?>
			function new_map( $el ) {
			var $markers = $el.find('.marker');
			var args = {
			zoom : 8,
			center : new google.maps.LatLng(0, 0),
			mapTypeId : google.maps.MapTypeId.ROAD,
			};
			var styles = [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#bdbdbd"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dadada"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#c9c9c9"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  }
];*/

			var styledMap = new google.maps.StyledMapType(styles, { name: "Styled Map" });
			var map = new google.maps.Map($el[0], args);
			map.mapTypes.set("map_style", styledMap);
			map.setMapTypeId("map_style");
			map.markers = [];
			$markers.each(function () {
			add_marker($(this), map);
			});
			center_map(map);
			return map;
			}
			function add_marker($marker, map) {
			// var
			var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
			var host = window.location.host
			console.log(window.location.host);

			var imagePath = "<?php echo get_stylesheet_directory_uri(); ?>/library/images/icons/map-marker.svg";
			console.log(imagePath);
			var image = {
			url: imagePath
			}
			var markerIcon = {
			url: '<?php echo get_stylesheet_directory_uri(); ?>/library/images/icons/map-marker.svg',
			scaledSize: new google.maps.Size(70, 70),
			};
			// create marker
			var marker = new google.maps.Marker({
			position: latlng,
			icon: markerIcon,
			animation: google.maps.Animation.DROP,
			map: map
			});
			// add to array
			map.markers.push(marker);
			// if marker contains HTML, add it to an infoWindow
			if ($marker.html()) {
			// create info window
			var infowindow = new google.maps.InfoWindow({
			content: $marker.html()
			});
			// show info window when marker is clicked
			google.maps.event.addListener(marker, 'click', function () {
			infowindow.open(map, marker);
			});
			}
			}

			function center_map(map) {
			// vars
			console.log('centermap');
			var bounds = new google.maps.LatLngBounds();
			// loop through all markers and create bounds
			$.each(map.markers, function (i, marker) {
			var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
			bounds.extend(latlng);

			});
			// only 1 marker?
			if (map.markers.length == 1) {
			// set center of map
			map.setCenter(bounds.getCenter());
			map.setZoom(<?php echo $location['zoom']; ?>);
			} else {
			// fit to bounds
			map.fitBounds(bounds);
			}
			}
			var map = null;
			$(document).ready(function () {
			$('.acf-map').each(function () {
			map = new_map($(this));
			});
			});



		<?php
			$myScripts .= ob_get_clean();
		endif;



		?>

		
			<div class="grid">
				<?php
				$classesLeft = 'col textwrap ' . $content_vertical_align;
				$classesRight = 'col imgwrap ' . $content_vertical_align;
				?>
				
				<div class="<?php echo $classesLeft; ?> ">
					<div class="_inner">
						<?php
						if (get_sub_field('content')) {
							echo preg_replace(
								"#/<p>(\s|&nbsp;|</?\s?br\s?/?>)</?p>#",
								"",
								get_sub_field('content')
							);
						}

						?>
					</div>
				</div>



			</div>
			<div style="pointer-events:none;" class="<?php echo $classesRight; ?> "></div>		
		</div>
	</div>
</section>
<?php
