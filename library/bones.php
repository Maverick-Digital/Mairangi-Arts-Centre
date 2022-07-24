<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/

  - head cleanup (remove rsd, uri links, junk css, ect)
  - enqueueing scripts & styles
  - theme support functions
  - custom menu output & fallbacks
  - related post function
  - page-navi function
  - removing <p> from around images
  - customizing the post excerpt

*//**
 * Rewrite the permalink for post types using the Custom Link option
 *
 * @param string $url  The original permalink.
 * @param object $post The post object.
 *
 * @since 1.0.0
 */
//this is gold
add_filter( 'wp_calculate_image_srcset', 'codextent_ssl_srcset' );

/* 
function shutdown_callback($buffer) {      
    //$buffer = str_replace('replacing','width',$buffer);
	$buffer = apply_filters('final_output_replacements', $buffer);
    return $buffer; 
}x

function buffer_start() { ob_start("shutdown_callback"); } 
function buffer_end() { ob_end_flush(); }

add_action('after_setup_theme', 'buffer_start');
add_action('shutdown', 'buffer_end');
*/




function codextent_ssl_srcset( $sources ) {
    foreach ( $sources as &$source ) {
        $source['url'] = set_url_scheme( $source['url'], 'https' );
    }
    return $sources;
}


/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

} /* end bones head cleanup */

/* post view counter */

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function wpdocs_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );
/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
    add_editor_style( get_template_directory_uri() . '/library/css/editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

// loading modernizr and jquery, and reply script
function bones_scripts_and_styles() {

  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {
		// Deregister the jquery version bundled with WordPress.
		//wp_deregister_script( 'jquery' );
		// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
		//wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', array(), '2.1.0', false );

		// enqueue styles and scripts
		// FONTS
		wp_enqueue_style('googleFonts', 'https://fonts.googleapis.com/css2?family=Exo:wght@300;400;500;700;800&display=swap');
		//wp_enqueue_style( 'fonts', get_template_directory_uri() . '/library/fonts/fonts.css', array(), '', 'all' );
		//wp_enqueue_style( 'cloudFonts', 'https://use.typekit.net/zfw6zrd.css', array(), '', 'all' );

		wp_enqueue_style( 'drawers', get_template_directory_uri() . '/library/css/drawers.css'); 
		wp_enqueue_script( 'drawers-js', get_template_directory_uri() . '/library/js/drawers.js', array( 'jquery' ), '', true );
	
		wp_enqueue_script( 'lightslider',get_template_directory_uri() . '/library/js/lightslider.min.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'lightslider', get_template_directory_uri() . '/library/css/lightslider.css');

		if (!is_front_page()) {}

		wp_enqueue_script( 'lightgallery-js', get_template_directory_uri() . '/library/js/lightgallery-all.min.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'lightgallery-css', get_template_directory_uri() . '/library/css/lightgallery.css');


		wp_enqueue_script( 'blog-js', get_template_directory_uri() . '/library/js/blog.js', array( 'jquery' ), '', true );
		// wp_enqueue_style('print', get_template_directory_uri() . '/library/css/print.css' ,array(),'' , 'print' );

		wp_enqueue_script( 'TweenMax-js', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js', array( 'jquery' ), 'false', true );
		wp_enqueue_script( 'ScrollMagic-js', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.6/ScrollMagic.min.js', array( 'jquery' ), 'false', true );
		//wp_enqueue_script( 'addIndicators-js', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.6/plugins/debug.addIndicators.min.js', array( 'jquery' ), 'false', true );
		wp_enqueue_script( 'gsap-js', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.6/plugins/animation.gsap.min.js', array( 'jquery' ), 'false', true );

		wp_enqueue_script( 'isotope-js', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array( 'jquery' ), 'false', true );
		wp_enqueue_script( 'imagesloaded-js', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js', array( 'jquery' ), 'false', true );


		//wp_enqueue_style('venobox', get_template_directory_uri() . '/library/js/venobox/venobox.css', array(), '', 'all' );
		//wp_register_script( 'venobox-js', get_template_directory_uri() . '/library/js/venobox/venobox.js', array( 'jquery' ), '', true );
		//wp_enqueue_script( 'venobox-js' );

		wp_enqueue_script( 'slick-js','//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js', array( 'jquery' ), '', true );
		//wp_enqueue_style( 'slick', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css');
		wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/library/css/slick.css');


		wp_enqueue_script( 'match-js',get_stylesheet_directory_uri() . '/library/js/jquery.matchHeight-min.js', array( 'jquery' ), '', true );

		
		wp_enqueue_script( 'aos-js', 'https://unpkg.com/aos@next/dist/aos.js', array('jquery'), false, true );
		 wp_enqueue_style('aos', get_template_directory_uri() . '/library/css/aos.css', array(), '', 'all' );
		
		wp_enqueue_script( 'objectFitPolyfill', get_template_directory_uri() . '/library/js/objectFitPolyfill.min.js', array('jquery'), false, true );

		wp_enqueue_style( 'hamburger', get_template_directory_uri() . '/library/css/hamburgers.css', array(), '', 'all' );
//		wp_enqueue_style('aspect-ratios', get_template_directory_uri() . '/library/css/aspect-ratios.css', array(), '', 'all' );

		wp_enqueue_script( 'classie', get_template_directory_uri() . '/library/js/classie.js', array('jquery'), false, true );
		wp_enqueue_script( 'modernizr-js', get_template_directory_uri().'/library/js/modernizr-custom.js', array( 'jquery' ), 'false', true );
		wp_enqueue_script( 'ml-menu-js', get_template_directory_uri() . '/library/js/ML-main.js', array('jquery'), false, true );
		wp_enqueue_style('ml-menu', get_template_directory_uri() . '/library/css/component.css');
		wp_enqueue_script( 'bones-js', get_template_directory_uri() . '/library/js/ready.min.js', array( 'jquery' ), 'false', true );
		wp_enqueue_style( 'grid', get_template_directory_uri() . '/library/css/grid.css', array(), '', 'all' );
		wp_enqueue_style( 'app', get_template_directory_uri() . '/library/css/app.css', array(), '', 'all' );
		wp_enqueue_style( 'type', get_template_directory_uri() . '/library/css/typography.css', array(), '', 'all' );
	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );
	// Declare WooCommerce support 
	add_theme_support( 'woocommerce' );
	// default thumb size
	set_post_thumbnail_size(400, 300, true);
	// rss thingy
	add_theme_support('automatic-feed-links');
	// wp menus
	add_theme_support( 'menus' );
	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'bonestheme' ),   // main nav in header
			'sub-nav' => __( 'Off-canvas Menu', 'bonestheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'bonestheme' ), // secondary nav in footer
			'social-links' => __( 'Social Links', 'bonestheme' ) // secondary nav in footer
		)
	);
	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form'
	) );

} /* end bones theme support */


// responsive oembed 
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="videoWrapper">' . $html . '</div>';
}


function themeslug_remove_hentry( $classes ) {
    if ( is_page() ) {
        $classes = array_diff( $classes, array( 'hentry' ) );
    }
    return $classes;
}
add_filter( 'post_class','themeslug_remove_hentry' );

// Apply filter
add_filter('body_class', 'mobile_body_classes');

function mobile_body_classes($classes) {
        if(!wp_is_mobile()){
        	 $classes[] = 'notouch';
        }
		return array_merge( $classes, array( get_field("header_type"),get_field("color_scheme") ) );
}

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'bonestheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
} /* end bones related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<hr/> <nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
function get_excerpt( $count ) {
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	if(get_field('teaser',$post->ID)){ 
		$excerpt = get_field('teaser',$post->ID);
	}
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = '<p>'.$excerpt.'&hellip;</p>';
	return $excerpt;
	}
// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ', 'bonestheme' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;', 'bonestheme' ) .'</a>';
}


 function content($limit, $content) {
      $content = explode(' ', $content, $limit);
      if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
      } else {
        $content = implode(" ",$content);
      } 
      $content = preg_replace('/\[.+\]/','', $content);
      $content = apply_filters('the_content', $content); 
      $content = str_replace(']]>', ']]&gt;', $content);
      return $content;
    }


?>
