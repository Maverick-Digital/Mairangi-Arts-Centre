<?php
// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );
require_once( 'library/navwalker.php' );
require_once( 'library/testimonials.php' );
//require_once( 'library/post-type-work.php' );
// inherited theme and content..
require_once( 'library/shortcodes-inherited.php');
require_once( 'library/product-helpers.php' );


// require_once( 'library/woo.php' );
require_once( 'library/svg.php' );
require_once( 'library/rankmath.php' );
require_once( 'library/tinyMCE.php' );
require_once( 'library/galleries.php' );
require_once( 'library/shortcodes.php' );
require_once( 'library/ACF_Layout.php' );
// disbale some layouts rather than delete
require_once( 'library/ACF_Layouts-remove.php' );

// require_once( 'library/acf-header-slides.php' );
//require_once( 'library/trips.php' );
//require_once( 'library/acf.php' );

/*
// include your composer dependencies
require_once (__DIR__ . '/library/vendor/autoload.php');
define('APPLICATION_NAME', 'SouthernLake');
define('CREDENTIALS_PATH', __DIR__ .'/.credentials/client_secret_475895365588-621ji9kug53u8ven1agv6696bgfm8dsb.apps.googleusercontent.com (2).json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR)
));
*/



// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
 require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {
  add_filter( 'wp_queue_default_connection', function() {
    return 'sync';
  } );
  // add_image_size( 'giant-size-hard-crop', 2000, 1500, true );

  //add_theme_support( 'post-thumbnails' );
  //add_image_size( 'image-gallery', 1920, 1000, true );
  //Allow editor style.
 //  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  //  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 8,1 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // remove caption width
  add_filter( 'img_caption_shortcode_width', '__return_false' );
  // cleaning up excerpt
  //add_filter( 'excerpt_more', 'bones_excerpt_more' );


} /* end bones ahoy */
add_post_type_support( 'page', 'excerpt' );

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );



/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}


/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

   $wp_customize->remove_section('title_tagline');
   $wp_customize->remove_section('colors');
  $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
   $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'News Sidebar', 'bonestheme' ),
		'description' => __( 'In the news sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Articles Sidebar', 'bonestheme' ),
		'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer1',
		'name' => __( 'Footer 1', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer2',
		'name' => __( 'Footer 2', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer3',
		'name' => __( 'Footer 3', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer4',
		'name' => __( 'Footer 4', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer5',
		'name' => __( 'Footer 5', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer6',
		'name' => __( 'Footer 6', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer7',
		'name' => __( 'Footer 7', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer8',
		'name' => __( 'Footer 8', 'bonestheme' ),
		//'description' => __( 'Educational Articles sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

} // don't remove this bracket!



/* disable_wp_emojicons */

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
add_filter( 'emoji_svg_url', '__return_false' );

function custom_jpg_compression($args) {
    return 90;
}
add_filter('jpeg_quality', 'custom_jpg_compression');


/**
 * Add automatic image sizes
 */
//if ( function_exists( 'add_image_size' ) ) { 
	
//}
function my_acf_init() {

	acf_update_setting('google_api_key', 'AIzaSyC3YbJgivzC8TuUJslnE7RZFsBqzmQaDf0');
}

add_action('acf/init', 'my_acf_init');



  add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
  function spinner_url( $image_src, $form ) {
      return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to you theme images folder
  
  }

add_filter( 'gform_next_button', 'input_to_button', 10, 2 );
add_filter( 'gform_previous_button', 'input_to_button', 10, 2 );
add_filter( 'gform_submit_button', 'input_to_button', 10, 2 );
function input_to_button( $button, $form ) {
    $dom = new DOMDocument();
    $dom->loadHTML( $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);
    $new_button = $dom->createElement( 'button' );
    
    $button_span = $dom->createElement( 'span', $input->getAttribute( 'value' ) );
    $new_button->appendChild( $button_span );
    $input->removeAttribute( 'value' );
    foreach( $input->attributes as $attribute ) {
    	if($attribute->name =='class'){
    		$attribute->value.= ' button gform_button';

    	}
        $new_button->setAttribute( $attribute->name, $attribute->value );
    }
    $input->parentNode->replaceChild( $new_button, $input );
    return $dom->saveHtml( $new_button );
}
/**
 * Filters the next, previous and submit buttons.
 * Replaces the forms <input> buttons with <button> while maintaining attributes from original <input>.
 *
 * @param string $button Contains the <input> tag to be filtered.
 * @param object $form Contains all the properties of the current form.
 *
 * @return string The filtered button.
 */


/*  Thumbnail upscale
/* ------------------------------------ */ 
function alx_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){
  if ( !$crop ) return null; // let the wordpress default function handle this

  $aspect_ratio = $orig_w / $orig_h;
  $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

  $crop_w = round($new_w / $size_ratio);
  $crop_h = round($new_h / $size_ratio);

  $s_x = floor( ($orig_w - $crop_w) / 2 );
  $s_y = floor( ($orig_h - $crop_h) / 2 );

  return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'alx_thumbnail_upscale', 10, 6 );


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/  


function footer_script(){ 
  global $myScripts;
  ?>
<script>
  
jQuery(document).ready(function($){
  console.log("footer scripts init");
  <?php  echo $myScripts;  ?>
})
</script>
<?php }

add_action('wp_footer', 'footer_script',30); 


add_shortcode('add_booking_but', 'output_booking_button');
add_shortcode('us_btn', 'output_booking_button');


function vc_build_link( $value ) {
	return vc_parse_multi_attribute( $value, array(
		'url' => '',
		'title' => '',
		'target' => '',
		'rel' => '',
	) );
}
function vc_parse_multi_attribute( $value, $default = array() ) {
	$result = $default;
	$params_pairs = explode( '|', $value );
	if ( ! empty( $params_pairs ) ) {
		foreach ( $params_pairs as $pair ) {
			$param = preg_split( '/\:/', $pair );
			if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
				$result[ $param[0] ] = trim( rawurldecode( $param[1] ) );
			}
		}
	}

	return $result;
}



function output_booking_button($atts, $size = null){
	
  $a = shortcode_atts( array(
	'text' => __( 'Book Now', 'us' ),
	'link' => '',
	'color' => 'primary',
	'bg_color' => '',
	'text_color' => '',
	'style' => 'solid',
	'icon' => '',
	'iconpos' => 'left',
	'size' => '15px',
	'align' => 'left',
	'el_class' => '',
	'button_block' => false,
    'style' => '',
	), $atts );
  ob_start();

    if (isset($a['link']) && $a['link'] != '' ) {

		if (strpos($a['link'], 'url:') === 0) {
			$link = vc_parse_multi_attribute($a['link']);
			//print_r($link);
			$a['link'] = $link['url'];

		 }

		$b_link = $a['link'];
		



    }else if(get_field('booking_now_link')){
      $b_link = get_field('booking_now_link') .'?iframe=1';
    }else{
		$b_link = get_field('default_booking_link', 'option');
		}
	if (strpos($b_link, 'rezdy') !== false) {
		$b_xtras = '  class="button rezdy rezdy-modal '.$a['style'].'" ';
	}else{
		$b_xtras = ' class="button '.$a['style'].'" ';
	}
	if($a['button_block'] == true){ echo "<div class='button_block'>";}
	echo "<a href='$b_link' $b_xtras >".$a['text']."</a>";
	if($a['button_block'] == true){ echo "</div>";}
	//echo "<a href='".get_the_permalink(29)."' class='button' >".$a['text']."</a>";
	return ob_get_clean();
}
add_shortcode('add_voucher_but', 'output_voucher_button');

function output_voucher_button($atts, $size = null){
  $a = shortcode_atts( array(
		'text' => 'Vouchers',
	), $atts );
  ob_start();
	 echo "<a href='".get_the_permalink(923)."' class='button alt' >".$a['text']."</a>";
	return ob_get_clean();
}
add_shortcode('add_logo', 'output_add_logo');

function output_add_logo($atts, $size = null){
  if(!get_field('logo', get_the_ID())){
    
    return '';
    }
  $a = shortcode_atts( array(
	
	), $atts );
  ob_start();
  $img = fly_get_attachment_image_src(get_field('logo', get_the_ID()),array(700 ,700), false );
  ?>
  <img class="img-responsive page-icon" src="<?php echo $img['src']; ?>" width="<?php echo $img['width']; ?>" height="<?php echo $img['height']; ?>" alt="<?php echo get_the_title(); ?>" />
<?php
	return ob_get_clean();
}

// Add a filter for the post thumbnail ID since it doesn't exist in WP core
add_filter( 'get_post_metadata', function ( $value, $post_id, $meta_key, $single ) {
	
	// We want to pass the actual _thumbnail_id into the filter, so requires recursion
	static $is_recursing = false;
	
	// Only filter if we're not recursing and if it is a post thumbnail ID
	if ( ! $is_recursing && $meta_key === '_thumbnail_id' ) {
		$is_recursing = true; // prevent this conditional when get_post_thumbnail_id() is called
		$value = get_post_thumbnail_id( $post_id );
		$is_recursing = false;
		$value = apply_filters( 'post_thumbnail_id', $value, $post_id ); // yay!
		if ( ! $single ) {
			$value = array( $value );
		}
	}
	
	return $value;

}, 10, 4);

// Add fallback for post thumbnail
// So whenever a featured image is called if there isn't one for the current post it will return
// your fallback attachment

add_filter( 'post_thumbnail_id', function( $id ) {
  if(get_post_type($id) == "staff"){
    return $id ? $id : 2675; // Set fallback to attachment with ID of 5
  }else  if(get_post_type($id) == "map_layer"){
    return $id ? $id : false;
  }else{
      return $id ? $id : get_field('default_image', 'options'); // Set fallback to attachment with ID of 5
  }
} );



function next_page_not_post($anchor='',$loop=NULL, $getPagesQuery='sort_column=menu_order&sort_order=asc') {
	global $post;

	$getPages = '';
	
	// cousins will have a similar grandparent
	// find the grandparent
	// query the children of common grandparent
	// combine to get all cousins
	if ($loop == 'cousins' || $loop == 'cousinsloop') {
		$getPages = array();
		$ancestors = get_post_ancestors($post->ID);
		
		if (count($ancestors) > 1) {
			// grandparent is $ancestors[1]
			$pageUncle = get_pages('child_of='. $ancestors[1] . '&parent='.$ancestors[1] . '&' . $getPagesQuery);
		
			foreach ($pageUncle as $uncle) {
				$cousins = get_pages('child_of='. $uncle->ID . '&parent='.$uncle->ID . '&' . $getPagesQuery);
				$getPages = array_merge($getPages, $cousins);
				unset($cousins);
			}
		}
	} elseif ($loop != 'expand') $getPagesQuery .= '&parent='.$post->post_parent;
	
	// only query if we don't have results from cousins
	if (!is_array($getPages)) $getPages = get_pages('child_of='.$post->post_parent.'&'.$getPagesQuery);
	
	$pageCount = count($getPages);
	
	for($p=0; $p < $pageCount; $p++) {
	  	// get the array key for our entry
		if ($post->ID == $getPages[$p]->ID) break;
	}
	
	// assign our next key
	$nextKey = $p+1;
	
	// if there isn't a value assigned for the previous key, go all the way to the end
	if (isset($getPages[$nextKey])) {
		$anchorName = $getPages[$nextKey]->post_title;
		$output = '<a href="'.get_permalink($getPages[$nextKey]->ID).'" title="'.$anchorName.'">';
	}
	elseif ($loop == 'expand') {
		// fixed by banesto
		// http://wordpress.org/support/topic/plugin-next-page-not-next-post-link-from-child-to-grand-parent-does-not-work
		// query parent page level, and then loop to find next entry, eke!
		// get grandparent id
		$parentInfo = get_page($post->post_parent);
	
		// query the level above's pages
		// $getParentPages = get_pages('child_of='.$parentInfo->post_parent.'&parent='.$parentInfo->post_parent.'&'.$getPagesQuery);
		$getParentPages = get_pages($getPagesQuery);

		$parentPageCount = count($getParentPages);
	
		for($pp=0; $pp < $parentPageCount; $pp++) {
	  		// get the array key for our entry
			// if ($post->post_parent == $getParentPages[$pp]->ID) break;
			if ($post->ID == $getParentPages[$pp]->ID) break;
		}
	
		// assign our next key
		$parentNextKey = $pp+1;
		
		if (isset($getParentPages[$parentNextKey])) {
			$anchorName = $getParentPages[$parentNextKey]->post_title;
			$output = '<a href="'.get_permalink($getParentPages[$parentNextKey]->ID).'" title="'.esc_attr( $anchorName ) .'">';
		}
	}	
	elseif (isset($loop) && ($loop != 'cousins')) {
		$anchorName = $getPages[0]->post_title;		
		$output = '<a href="'.get_permalink($getPages[0]->ID).'" title="'.esc_attr( $anchorName ).'">';
	}
	
	// determine if we have a link and assign some anchor text
	if (!empty($output)) {
		if ($anchor == '') {
			$output .= $anchorName;
		} else {
			$output .= str_replace('%title', $anchorName, $anchor);
		}	
		$output .= '</a>';

		return $output;

	}
}

function previous_page_not_post($anchor='',$loop=NULL, $getPagesQuery='sort_column=menu_order&sort_order=asc') {
	global $post;
	
	$getPages = '';	

	// cousins will have a similar grandparent
	// find the grandparent
	// query the children of common grandparent
	// combine to get all cousins
	if ($loop == 'cousins' || $loop == 'cousinsloop') {
		$getPages = array();
		$ancestors = get_post_ancestors($post->ID);
		
		if (count($ancestors) > 1) {
			// grandparent is $ancestors[1]
			$pageUncle = get_pages('child_of='. $ancestors[1] . '&parent='.$ancestors[1] . '&' . $getPagesQuery);
		
			foreach ($pageUncle as $uncle) {
				$cousins = get_pages('child_of='. $uncle->ID . '&parent='.$uncle->ID . '&' . $getPagesQuery);
				$getPages = array_merge($getPages, $cousins);
				unset($cousins);
			}
		}
	} elseif ($loop != 'expand') $getPagesQuery .= '&parent='.$post->post_parent;
	
	// only query if we don't have results from cousins
	if (!is_array($getPages)) $getPages = get_pages('child_of='.$post->post_parent.'&'.$getPagesQuery);
	
	$pageCount = count($getPages);
	
	for($p=0; $p < $pageCount; $p++) {
	  // get the array key for our entry
		if ($post->ID == $getPages[$p]->ID) break;
	}
	
	// assign our next & previous keys
	$prevKey = $p-1;
	$lastKey = $pageCount-1;
	
	// if there isn't a value assigned for the previous key, go all the way to the end
	if (isset($getPages[$prevKey])) {
		$anchorName = $getPages[$prevKey]->post_title;
		$output = '<a href="'.get_permalink($getPages[$prevKey]->ID).'" title="'.esc_attr( $anchorName ).'">';
	}
	elseif ($loop == 'expand') {
		if ($post->post_parent != 0) {
			$anchorName = get_the_title($post->post_parent);		
			$output = '<a href="'.get_permalink($post->post_parent).'" title="'.esc_attr( $anchorName ).'">';
		}
	}
	elseif (isset($loop) && ($loop != 'cousins')) {
		$anchorName = $getPages[$lastKey]->post_title;		
		$output = '<a href="'.get_permalink($getPages[$lastKey]->ID).'" title="'.esc_attr( $anchorName ).'">';
	} 

	
	// determine if we have a link and assign some anchor text
	if (!empty($output)) {
		if ($anchor == '') {
			$output .= $anchorName;
		} else {
			$output .= str_replace('%title', $anchorName, $anchor);			
		}	
		
		$output .= '</a>';

	  	return $output;

	}
}
/* DON'T DELETE THIS CLOSING TAG */ ?>