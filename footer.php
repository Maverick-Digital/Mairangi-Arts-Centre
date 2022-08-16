<script>
  // Initialize and add the map
function initMap() {
  // The location of Uluru
  const uluru = { lat: -36.739380, lng: 174.750580 };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16,
    center: uluru,
  disableDefaultUI: true,
  styles:[
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
]
  });
  // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: uluru,
    map: map,
  });
}
window.initMap = initMap;
</script>

<?php if (get_field("show_instagram")  && !is_plugin_active('sb-instagram-feed') || is_single()) { ?>
  <div class='instagram layer noprint'>
    <span class="follow-us"><a target="_blank" href="https://www.instagram.com/mairangiarts/"><i class="fa-brands fa-square-instagram"></i> Follow us</a></span>
    <?php
    echo do_shortcode('[instagram-feed feed=1]');
    ?>
  </div>
<?php } ?>



<?php if (is_front_page()) { ?>
    <div class="cutom-google-map" id="map"></div>
<?php } else { ?>
    
<?php } ?>


<div class="inner-narrow mx-auto pad-bot-60 pad-top-60">
  <?php echo do_shortcode('[affiliates]') ?>
</div>
<?php
$globalContentID = 2260;
if (have_rows('page_layout', $globalContentID)) : ?>
  <?php
  while (have_rows('page_layout', $globalContentID)) : the_row();
    $c++;
    $fields = get_sub_field('settings');
    if (isset($fields[0])) {
      $fields = $fields[0];
    } else {
      //$fields = $fields['row-0'];
    }
  ?>
    <div class="page_layout global-loop-<?php echo $c; ?>">
      <?php if (isset($fields['vertical_title']) && $fields['vertical_title'] != '') : ?>
        <div class="grid grid-nogutter">
          <div class="col col-fixed" style='width:6em;'>
            <div class="verttext">
              <h2><strong><?php echo $fields['vertical_title']; ?></strong></h2>
            </div>
          </div>
          <div class="col ">
          <?php endif;
        ACF_Layout::render(get_row_layout());
          ?>
          <?php if (isset($fields['vertical_title']) && $fields['vertical_title'] != '') : ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php
  endwhile; ?>
<?php
endif; ?>
<!-- Footer -->
<footer class="pad-top-40 pad-bot-40">
  <div class="inner">
    <div class="clearfix footer-widget-wrap">
      <div class="center footer-widget">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer1')) : ?>
        <?php endif; ?>
      </div>
      <div class="center footer-widget">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer2')) : ?>
        <?php endif; ?>
      </div>
      <div class="center footer-widget">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer3')) : ?>
        <?php endif; ?>
      </div>
      <div class="center footer-widget">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer4')) : ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="subfooter">
      <div class="footer-meta clearfix center">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer6')) : ?>
        <?php endif; ?>
        <p style="font-size:10px;">&copy; <?php echo get_bloginfo('name');  ?>. Website by <a id="maverick-logo" href="http://maverickdigital.nz/" target="_blank"></a></p>

      </div>
    </div>

  </div>

</footer>

</div><!-- end div.wrap -->
</div><!-- end div.moved -->

<div id="NavDrawer" class="drawer drawer--right">
  <div class="draw_bg">
    <div class="drawer__inner">
      <div class="logo_footer">
        <a class="desktop" href="<?php echo get_home_url(); ?>">
          <?php
          echo wp_get_attachment_image(get_field('logo_ghost', 'options'), 'large');
          ?> </a>
      </div>
      <!-- Menu -->
      <nav id="ml-menu" class="menu">
        <!-- Close button for mobile version -->
        <button class="action action--close js-drawer-close" aria-label="Close Menu"><span class="icon icon--cross"></span></button>
        <div class="menu__wrap">
          <?php custom_menu_output('sub-nav');  ?>
        </div>
      </nav>
    </div>
  </div>
</div>

<div class="back-to-top-wrap"><a class="back-to-top" href="#"><img src="<?php echo get_template_directory_uri(); ?>/library/images/icons/arrow-up-plain.svg" alt="top" /></a></div>
<?php wp_footer(); ?>
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3YbJgivzC8TuUJslnE7RZFsBqzmQaDf0&callback=initMap&center=47.65,-122.35&zoom=12&format=png&maptype=roadmap&style=element:geometry%7Ccolor:0xf5f5f5&style=element:labels.icon%7Cvisibility:off&style=element:labels.text.fill%7Ccolor:0x616161&style=element:labels.text.stroke%7Ccolor:0xf5f5f5&style=feature:administrative.land_parcel%7Celement:labels.text.fill%7Ccolor:0xbdbdbd&style=feature:poi%7Celement:geometry%7Ccolor:0xeeeeee&style=feature:poi%7Celement:labels.text.fill%7Ccolor:0x757575&style=feature:poi.park%7Celement:geometry%7Ccolor:0xe5e5e5&style=feature:poi.park%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&style=feature:road%7Celement:geometry%7Ccolor:0xffffff&style=feature:road.arterial%7Celement:labels.text.fill%7Ccolor:0x757575&style=feature:road.highway%7Celement:geometry%7Ccolor:0xdadada&style=feature:road.highway%7Celement:labels.text.fill%7Ccolor:0x616161&style=feature:road.local%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&style=feature:transit.line%7Celement:geometry%7Ccolor:0xe5e5e5&style=feature:transit.station%7Celement:geometry%7Ccolor:0xeeeeee&style=feature:water%7Celement:geometry%7Ccolor:0xc9c9c9&style=feature:water%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&size=480x360">
</script>
</body>

</html> <!-- end of site. what a ride! -->
