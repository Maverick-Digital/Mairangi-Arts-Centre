<?php
/*
 * Add a testimonial custom post type.
 */
 


add_action('init', 'create_ifeelfree_testimonial');

function create_ifeelfree_testimonial() 
{
  
  $labels = array(
    'name' => _x('Testimonials', 'testimonials'),
    'singular_name' => _x('Testimonial', 'testimonial'),
    'add_new' => _x('Add New', 'testimonial'),
    'add_new_item' => __('Add New Testimonial'),
    'edit_item' => __('Edit Testimonial'),
    'new_item' => __('New Testimonial'),
    'view_item' => __('View Testimonial'),
    'search_items' => __('Search Testimonials'),
    'not_found' =>  __('No Testimonials found'),
    'not_found_in_trash' => __('No Testimonials found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'rewrite' => array( 'slug' => 'testimonials' ),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 20,
    'supports' => array('title','editor','thumbnail', 'excerpt', 'custom-fields'),
    'menu_icon'   => 'dashicons-cart',
	'public' => false,
	'has_archive' => 'testimonials/archive' ,
	'taxonomies' => array('post_tag','testimonial-categories'),
	

  ); 
  register_post_type('testimonials',$args);
}

register_taxonomy( "testimonial-categories", 
	array( 	"testimonial" ), 
	array( 	"hierarchical" => true,
			"labels" => array('name'=>"Testimonial Category",'add_new_item'=>"Add New Category"), 
			"singular_label" => 'Testimonial Category', 
			'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true, 
			"rewrite" => array( 'slug' => 'testimonials/category', // This controls the base slug that will display before each term 
			                    'with_front' => true)
		 ) 
);




/*
register_taxonomy( "testimonial-budget", 
	array( 	"testimonial" ), 
	array( 	"hierarchical" => true,
			"labels" => array('name'=>"Testimonial Budget",'add_new_item'=>"Add New Testimonial Budget"), 
			"singular_label" => 'Testimonial Budget', 
			'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true, 
			"rewrite" => array( 'slug' => 'testimonial-budget', // This controls the base slug that will display before each term 
			                    'with_front' => false)
		 ) 
);

register_taxonomy( "testimonial-type", 
	array( 	"testimonial" ), 
	array( 	"hierarchical" => true,
			"labels" => array('name'=>"Testimonial Type",'add_new_item'=>"Add New Testimonial Type"), 
			"singular_label" => 'Testimonial Type',
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true, 
			"rewrite" => array( 'slug' => 'testimonials', // This controls the base slug that will display before each term 
			                    'with_front' => true,  'hierarchical' => true )
			                    

		 ) 
);
*/


if (function_exists('acf_add_options_page')) {

   /* // already added in theme...
    acf_add_options_page(array(
        'page_title' => 'Global Content',
        'menu_title' => 'Global Content',
        'menu_slug' => 'global-content',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
    
    
    */

  
    acf_add_options_sub_page(array(
        'page_title' => 'Testimonial Settings',
        'menu_title' => 'Testimonial Settings',
        'parent_slug' => 'global-content',
    ));
    /*
    acf_add_options_sub_page(array(
        'page_title' => 'People',
        'menu_title' => 'People',
        'parent_slug' => 'global-content',
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Design',
        'menu_title' => 'Design',
        'parent_slug' => 'global-content',
    ));
    */

}

add_shortcode('testimonials', 'hwd_testimonials');


function hwd_testimonials( $atts, $content = null ){	

	global $myScripts;
	extract( shortcode_atts( array(
		'number' => '4',
		'columns' => '4',
		'excerpt' => false,
		'filters' => false
	), $atts ) );	
		

	$args=array(
		'post_type' => 'testimonials',
		'post_status' => 'publish',
		'orderby'   => 'rand',
		'posts_per_page' => $number
	);

	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
		$output.= '';
		if(get_the_ID() == 7819){
			$output.= '<div class="testimonial_wrap">';
		}
		while ($my_query->have_posts()) : $my_query->the_post();
		
			$meta = get_post_meta( get_the_ID() );	
		
			$class = '';	
			$terms = wp_get_post_terms( get_the_ID(), 'types' );
			foreach ( $terms as $term ) {
				$class .= $term->slug.' ';
			}
			$output.= '<div class="testimonial">';		
            if (get_field('rating')) {
                $output.= do_shortcode('[stars rating=5]');
            }
			$output.= '<p class="lead"><strong>'.get_the_title().'</strong></p>';
			$output.= $excerpt ? get_the_excerpt() : wpautop(get_the_content()) ;
			$output.= '<p>';
				if(!empty($meta['author'][0]))
				$output.= '<strong>'.$meta['author'][0].'</strong>';
				if(!empty($meta['location'][0]))
				$output.= ' - '.$meta['location'][0];
			$output.= '</p></div>';
		endwhile;

	}	
	wp_reset_postdata();
	if(get_the_ID() == 7819){
		$output.= '</div>';
	}else{
        $output.= '<p><a style="text-align:left;" href="'.get_the_permalink(7819).'">See more reviews</a></p>';
    }
	
    if (get_the_ID() == 7819) {
		ob_start(); ?>
		var $container = $('.testimonial_wrap');
		$container.isotope({
			//layoutMode: 'fitRows',
			itemSelector: '.testimonial'
		});
		function onArrange() {
			setTimeout(function(){$container.isotope('layout');}, 300);
			jQuery(".match").matchHeight();
			AOS.refresh();
		}
		// bind event listener
		$container.on( 'arrangeComplete', onArrange );
		<?php
		$myScripts .= ob_get_clean();

    }
	
	return $output;



}

function output_testimonials_func() {
ob_start();
$currentPage = get_the_ID();
//$temp = $wp_query; $wp_query= null;
$feedback ='';
$wp_query = new WP_Query(); 
$args = array(
    'post_type'      => 'testimonials',
    'posts_per_page' => -1,
   /*	'post_parent' => $currentPage, */
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'posts_per_page' => -1
    
    );

	
$wp_query->query($args);
		
			
if ($wp_query->have_posts()) :
 ?>
<section class="layer blog article">
	<div class="inner medium edge">
		<?php if (get_sub_field('title',$currentPage)){ ?>
		<h1 class="center "><?php echo get_sub_field('title', $currentPage); ?></h1>	
		<?php }
		
		if($feedback != ''){
			echo "<p class='center'>$feedback</p>";
		}
		//echo str_replace(",",", ",$_POST['tour-length-names']);
		?>
		<section class="layer filterbar container">
	<div class="inner clearfix">	
			
			<div id="dd" class="wrapper-dropdown-4 drop"><p>Destinations</p>
				<ul class="dropdown" >
					<?php
					
					 $term="testimonial-type";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						
								echo '<li><label for="'.$termname.'"><span></span>'.$term->name.'</label><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'></li>';
						}
					}
				
					?>
				</ul>
			</div>
			<div id="dd2" class="wrapper-dropdown-4 drop"><p>Length</p>
				<ul class="dropdown" >
					<?php
					 $term="testimonial-budget";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						
								echo '<li><label for="'.$termname.'"><span></span>'.$term->name.'</label><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'></li>';
						}
					}
					?>
				</ul>
			</div>
			<div class="wrapper-dropdown-4 action">
			<a href="javascript:void(0)" class="et_pb_button find">Inspire Me</a>
			
			<a href="javascript:void(0)" class="reset">reset</a>
			</div>
	</div>
</section>
<?php
		
		
		$currentPage = get_the_ID();
	

?>          
<div class="port_wrap">
    <div id="portfolio" class="grid load-posts">
       <?php 
      
$count =2;
		// if ( $wp_query->have_posts()) :
		 while ( $wp_query->have_posts()) : 
		 $wp_query->the_post(); 

$flight_title = get_the_title();//get_field('flight_title');
$flight_price = get_field('flight_price');
$flight_price_suffix = get_field('flight_price_suffix');
$flight_length = get_field('flight_length');
// $flight_map = get_field('flight_map');
$flight_departure = get_field('flight_departure');
$key_points = get_field('key_points');
$content = get_field('content');



if(get_field('flight_title')):


 	
$terms = get_the_terms( get_the_id(), 'testimonial-categories' );
$term_links ="";

if ( $terms && ! is_wp_error( $terms ) ) : 
foreach ( $terms as $term ) {
	$links[] = $term->name;
	}
endif;
$terms = get_the_terms( get_the_id(), 'testimonial-budget' );
if ( $terms && ! is_wp_error( $terms ) ) : 
foreach ( $terms as $term ) {
	$links[] = $term->name;
	}
endif;
$tax_links = join( " ", str_replace(' ', '-', $links));
$tax = strtolower($tax_links); 

echo '<div class="all portfolio-item isotope-item portfolio-item--width1 '. $tax .'">';
$image= false;
if(has_post_thumbnail()){
$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
}
//$image = fly_get_attachment_image_src( 1130, array( 650, 650 ), false );
if(!$image) {
	$images = get_attached_media('image',  get_the_id());
	foreach($images as $image) { 
	$image = fly_get_attachment_image_src($image->ID, array( 650, 650 ), false );
	break;
		} 
	
}
?>
<span class="bg"></span>
<div class="col tile tour" >
<?php //if($image) { ?>
	<div class="card background-image" style="background-image:url(<?php echo $image['src']; ?>)">
		<a class="link-overlay" href="<?php echo get_the_permalink(); ?>">
		<span class="et_overlay"></span>
		<?php 
		if($flight_length){ ?>
		<div class="days-icon anim"><?php echo $flight_length; ?><span class="sub">days</span></div></a>			
		<?php } ?>		
	</div>
<?php // } ?>
	<div class="tile-copy clearfix">
		<h3><a href="<?php echo get_the_permalink(); ?>" ><?php if($flight_title){echo $flight_title; }else{ echo get_the_title();} ?></a></h3>
		<div class="dest"><?php echo $destinations; ?></div>
		<?php if($flight_price){ 
					$wp_session = WP_Session::get_instance();
					$currency = $wp_session['Currency'];
					$prefix = '$';
					$_suffix = '('.strtoupper($currency).')';
					if($currency == 'nzd' || $currency == 'usd' || $currency == 'aud'){
						$prefix = '$';
					}else if($currency == 'gbp'){
						$prefix = '&pound;';
					}else if($currency == 'eur'){
						$prefix = '&euro;';
					}
					$_suffix = ' '.strtoupper($currency).'';
					//echo $currency.$flight_price;
					//<span class="suffix">'.$flight_price_suffix.'</span> 
					// $myPrice = $prefix.do_shortcode('[convert number='.$flight_price.' from="nzd" to="'.$currency.'"]').'<span class="suffix">'.$flight_price_suffix.'</span><span class="_suffix">'.$_suffix.'</span>';			
					$myPrice = $prefix.do_shortcode('[convert number='.$flight_price.' from="nzd" to="'.$currency.'"]').' <span class="_suffix">'.$_suffix.'</span>';			
		
					//$myPrice = $prefix.do_shortcode('[convert number=49.99 from="nzd" to="'.$currency.'"]').'<span class="suffix">'.$flight_price_suffix.'</span> <span class="_suffix">'.$_suffix.'</span>';			
					?> <div class="price_indicator"><?php echo $myPrice; ?></div>
					<?php } ?>
				<?php /* <p><?php echo $tax; ?></p> */ ?>

<?php

						?>
						<p class="link_wrap"></p>
					
						</div><!-- .tile-copy -->
					</div>
					<?php
					// echo '</a>';
echo '</div>';

endif; // end check for title field 

endwhile;
?>
		</div>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();
endif;
return ob_get_clean();

 
 }
 
function testimonialSlides(){
if(!is_front_page()){
	//return;
}
ob_start();

 $wp_query = new WP_Query(); 

$args = array(
    'post_type'      => 'testimonials',
    'order'          => 'DESC',
    'meta_key'			=> 'start_date',
	'orderby'			=> 'meta_value',
    'posts_per_page' => 6,
  'orderby' => 'rand',
  //  'paged' => $paged,
  'tax_query' => array(
    array(
      'taxonomy' => 'testimonial-type',
      'field'    => 'slug',
      'terms'    => array('current','long-term'),
    ),
 )
    );
$posts = new WP_Query($args);
 ?>
<?php if ($posts->have_posts()) : 

 
						 $prev_month = '';
						 $firstTime = true;
						 $c= 0;
					while ($posts->have_posts()) : $posts->the_post();
					$c ++;
$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
			if(!is_array($image)){ $image['src'] = '';}
			$term_list = wp_get_post_terms(get_the_ID(), 'testimonial-type', array("fields" => "id=>slug"));
			//print_r($term_list);
			$term_list2 = wp_get_post_terms(get_the_ID(), 'testimonial-categories', array("fields" => "id=>slug"));
			
			$tax_links = join( " ", str_replace(' ', '-', $term_list)).' '.join( " ", str_replace(' ', '-', $term_list2));
			$tax_links = str_replace('+-', '', $tax_links);
			$tax = strtolower(remove_accents($tax_links));  
			if($c <7){
			$tax .= " featured";
			} 
			?>
			
<li class="background-image dark" style="background-image:url(<?php echo  $image['src']; ?>)">
					
				<div class="intro-copy">
					<div class="inner ">
						
										<h4>Testimonial/<em>whakaaturanga</em></h4>			

					<h1><?php the_title() ?></h1>
					<?php if(get_field('sub_title')){ ?><h2><?php the_field( 'sub_title' ); ?></h2><?php } ?>
					<?php
					if(is_front_page()){
					echo "<div class='lead'>";
					the_excerpt();
					echo "</div>";
					//echo "mike";
					//the_excerpt();
	//return;
}
/*		<a class="button ghost " href="<?php the_permalink(); ?>"><span class="secondline"><i class="fa fa-long-arrow-right"> </i> more information</span></a>
*/
?>
<br/>
							
							
				</div>
				</div>
			</li>
<?php endwhile;

 endif; 
 wp_reset_postdata();

 
 
 
 
return ob_get_clean();
}
 

add_shortcode('list_testimonials', 'testimoniallist');

 function testimoniallist(){

ob_start();
//echo "testimoniallist";
 $wp_query = new WP_Query(); 

$args = array(
    'post_type'      => 'testimonials',
    'order'          => 'DESC',
   // 'posts_per_page' => 7,
   // 'post__not_in'	=> array(get_the_ID()),
  //'orderby' => 'rand',
  //  'paged' => $paged,
  
 
    );
$posts = new WP_Query($args);
  if ($posts->have_posts()) : 
//echo "testimoniallist";

 ?>

<section class="stacked testimonial-listing ">
		<div id="__portfolio" class="aquisition_list load-posts clearfix ">
<?php
						 $prev_month = '';
						 $firstTime = true;
						 $x=0;
					while ($posts->have_posts()) : $posts->the_post();
					
$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
			if(!is_array($image)){ $image['src'] = '';}
			
			//for ($x = 0; $x <= 6; $x++) {
			
				if($x ==0){
					$width = 'full horizontal ';
				}else if (($x -1) % 3 == 0){ 
					$width = '2';
				}else{
					$width = '1';
				}

			?>
			<div class="all isotope-item portfolio-item portfolio-item--width<?php echo $width.' '; echo $tax; ?>">
				
				<div class="card"  >
					<div class="title  background-image" style="background-image:url(<?php echo $image['src']; ?>);">
					<a href="<?php echo get_the_permalink(); ?>">

						</a>
						
							<img src="<?php echo $image['src']; ?>" />
							<?php 
							if($x ==0){ ?>
							<div class="exhib-cat testimonial">
				Most recent Testimonial</div>
							<?php 
							}else{ ?>
							<div class="exhib-cat testimonial">
				Testimonial</div>
							<?php }
							?>
					</div>
				<div class="info cf">
				
					<h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title() ?></a></h2>
					<?php if(get_field('sub_title')){ ?><h4><?php the_field( 'sub_title' ); ?></h4><?php } ?>
					<p class="highlights">
						<?php 	the_excerpt(); ?>
						</p>	
						<footer class="posts__post-details">
								<div class="posts__post-teaser-overlay"></div>
								<div class="posts__post-primary-topic topic-code">
								<?php
	//$term_list = wp_get_post_terms(get_the_ID(), 'trip-type', array("fields" => "id=>name"));
	
$args = array( 'hide_empty=0' );
 
//$terms = get_terms( 'exhibition-type', $args );
$terms = wp_get_post_terms(get_the_ID(), 'testimonial-categories', array());
//echo '<div class="my_term-archive">';





if ( ! empty( $terms ) ) {
    $count = count( $terms );
    $i = 0;
    $term_list = '<div class="tag_p"><span class="cat_title">Category:</span>';
    foreach ( $terms as $term ) {
    
        $i++;
        $term_list .= ' <a class="icon-tag" href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) ) . '">' . $term->name . '</a>';
        if ( $count != $i ) {
            $term_list .= ' ';
        }
        else {
            $term_list .= '</div>';
        }
    }
    echo $term_list;
}
$tags = '';
$t = wp_get_post_tags(get_the_ID());
//print_r($t);
if($t){
 foreach ($t as $tag)
    {
    //	if($tags==""){$tags = "<i class='icon icon-tag' > </i> "; }
        $tags .= " <a   class=' icon-tag' href='".get_tag_link($tag->term_id)."'>".$tag->name."</a>";
    }
    echo '<div class="tag_p"><span class="cat_title">Tags:</span> '.$tags.'</div>';

    }
?>

									<a class="category" href="<?php the_permalink(); ?>"><i class="fa fa-arrow-right"> </i> more</a>
							
								</div>
							</footer>

				</div>
				</div>
			</div>
<?php 
$x++;
endwhile; ?>

	</div>
	<hr/>
<div class='text-center'><a href="<?php echo get_home_url(); ?>/testimonials/archive/" class="button small alt"><i class="icon icon-cinema"></i> all testimonials</a></div></section>
<?php 


 endif; 
 wp_reset_postdata(); 
return ob_get_clean();
}
 
 
 
//add_shortcode('recent_innovations', 'ifeel_free_news');
add_shortcode('acq_carousel', 'acq_carousel_func');

function acq_carousel_func($atts=null, $content=null){
ob_start();
 $wp_query = new WP_Query(); 
//\\echo get_the_ID();

$args = array(

    'post_type'      => 'testimonials',
    'order'          => 'DESC',
   // 'meta_key'			=> 'start_date',
	// 'orderby'			=> 'meta_value',
	'post__not_in'	=> array(get_the_ID()),
    'posts_per_page' => 14,
  	'orderby' => 'rand',
  //  'paged' => $paged,
  /* 'tax_query' => array(
    array(
      'taxonomy' => 'exhibition-type',
      'field'    => 'slug',
      'terms'    => array('current','long-term'),
    ),
 ) */
    );
$posts = new WP_Query($args);
 ?>
<?php if ($posts->have_posts()) : 
//echo "MIKE";
 ?>

<section class="layer exhibition-listing inner thin pad-bot-20">
<hr/>
		<div id="acq_carousel" class="clearfix  ">
<?php
						 $prev_month = '';
						 $firstTime = true;
						 $c=0;
					while ($posts->have_posts()) : $posts->the_post();
					$c++;
					
					

			$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
			if(!is_array($image)){ $image['src'] = '';}
			
			?>
		<div class="all isotope-item portfolio-item horizontal acq">
			<div class="card"  >
				<div class="title  background-image" style="background-image:url(<?php echo $image['src']; ?>);">
				<a href="<?php echo get_the_permalink(); ?>"></a>
				
						<img src="<?php echo $image['src']; ?>" />
				</div>
				<div class="info cf">
					<h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title() ?></a></h3>
					<?php if(get_field('sub_title')){ ?><h4><?php the_field( 'sub_title' ); ?></h4><?php } ?>
					
					<p class="highlights">
						<?php echo get_the_excerpt(); ?>
					</p>	
					<footer class="posts__post-details">
						<div class="posts__post-teaser-overlay"></div>
						<div class="posts__post-primary-topic topic-code">
						
						<a class="category" href="<?php the_permalink(); ?>"><i class="fa fa-arrow-right"> </i> more</a>
						</div>
					</footer>
				</div>
			</div>
		</div>
	<?php 
	
	endwhile; ?>
	</div>
<div class='text-center'><a href="<?php echo get_home_url(); ?>/testimonials/archive/" class="button small alt"><i class="icon icon-cinema"></i> all testimonials</a></div></section>

</section>
<?php 


endif; 
wp_reset_postdata(); 
return ob_get_clean();
}

 
 
 


function add_testimonial_filter_bar_func(){

ob_start();

if (wp_is_mobile()) {
	return ob_get_clean();
}

$currentPage = get_the_ID();
$paged = get_query_var('paged');

 ?>
 <div class=" filterbar clearfix">
		
			
			<div id="dd" class="wrapper-dropdown-4 drop"><p>Testimonial Type</p>
				<ul class="dropdown" >
					<?php
					
					 $term="testimonial-type";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'><label for="'.$termname.'"><span></span>'.$term->name.'</label></li>';
						}
					}
				
					?>
				</ul>
	
			</div>
			
			<div id="dd2" class="wrapper-dropdown-4 drop"><p>Testimonial Budget</p>
				<ul class="dropdown" >
					<?php
					 $term="testimonial-budget";

					$terms = get_terms($term,array( 'hide_empty' => false));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'><label for="'.$termname.'"><span></span>'.$term->name.'</label></li>';
						}
					}
					?>
				</ul>
				
			</div>
			<div class="wrapper-dropdown-4 action">
			<a href="javascript:void(0)" class="button alt find">Inspire Me</a>
			
			<a href="javascript:void(0)" class="reset">reset</a>
			</div>
</div>
<?php 


return ob_get_clean();
}


add_shortcode('add_testimonial_filter_bar', 'add_testimonial_filter_bar_func');




?>