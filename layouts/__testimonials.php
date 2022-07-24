<?php
$showTest = get_field('show_testimonials');
if(is_singular('product')){
	$showTest = true;
}
if (!$showTest || is_singular('business-listing') || is_singular('case-studies')) :

else :
	global $post;
	$xclass =  '';
	$style = '';
	$class = '';
	$classes = '';
	$id = '';
	include('set_up_layout_styles.php');
	$class = '';
	//	echo 'testimonial_bg_image '.get_field('testimonial_bg_image').'  '.$class;
	if (get_field('testimonial_bg_image')) {
		$image_src =  fly_get_attachment_image_src(get_field('testimonial_bg_image'), array(1920, 1000), false);
		$style .= ' background-image:url(' . $image_src['src'] . ');';
	} else if (get_field('testimonial_bg_image', get_option('page_on_front'))) {
		$image_src =  fly_get_attachment_image_src(get_field('testimonial_bg_image', get_option('page_on_front')), array(1920, 1000), false);
		$style .= ' background-image:url(' . $image_src['src'] . ');';
	} else {
		$class .= ' no-bgimage';
	}
	/*if(get_field('testimonial_bg_texture')){ 
		$style .= ' bg_texture';
	}*/
	//echo get_field('testimonial_bg_focal_point');
	if (get_field('testimonial_bg_focal_point')) {
		$coords = explode(',', get_field('testimonial_bg_focal_point'));
		$style .=   "transform-origin:" . $coords[0] . " " . $coords[1] . ";  background-position:" . $coords[0] . " " . $coords[1] . "; ";
		//echo "FOCAL".get_sub_field('focal_point');
	}
	$args = array(
		'post_type'      => 'testimonials',
		'order'          => 'ASC',
		'orderby'        => 'random',
		'posts_per_page' => 6,
		'tax_query' => array()
	);
	//print_r(get_field('testimonial_category'));
	//echo sizeof(get_field('testimonial_category'));

	if (is_array(get_field('testimonial_category')) && sizeof(get_field('testimonial_category')) > 0) {
		//echo "ADD";
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial-categories',
				'terms' => get_field('testimonial_category')
			)
		);
	}

	//print_r($args);
	$wp_loop = new WP_Query();
	$wp_loop->query($args);
	$post_count = $wp_loop->post_count;

	if ($wp_loop->have_posts()) :


?>
		<div id="<?php echo $id; ?>" class="layer  testimonial_layout text-center clearfix pad-top-200 pad-bot-140  noprint">
			<?php /* <span class="image_overlay"></span> */ ?>
			<div class="inner">
				<h3 class="pad-bot-80">What our customers say</h3>
				<div id="testimonials_slider">
				<?php
				$count = 0;
				echo do_shortcode('[wprevpro_usetemplate tid="1" pageid="" langcode="" tag=""]');
				?>

				</div>
			</div>
		</div>

		<?php ob_start(); ?>
		$(".wprevprodiv").slick({ 
			slidesToShow:4, 
			dots:false, 
			arrows:false,
			infinite: true,
			responsive: [{
				breakpoint: 1480,
				settings: {
					slidesToShow: 3,
				}
			}, {
				breakpoint: 900,
				settings: {
				
					slidesToShow: 2,
				
				}
			}, {
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					dots: false,
					centerMode: true
					
				}
				// settings: "unslick" // destroys slick
			}]
 });
<?php
		$myScripts .= ob_get_clean();

	endif;
	wp_reset_query();
endif;
