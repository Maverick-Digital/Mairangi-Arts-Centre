<?php
if (!get_field('show_testimonials')) :
else :
	global $post;
	$xclass =  '';
	$style = '';
	$class = '';
	$classes = '';
	$id = '';
	include('set_up_layout_styles.php');
	$class = '';
	$bgID = '';
	// background image 
	if (get_field('testimonial_bg_image')) {
		$bgID = get_field('testimonial_bg_image');
	} else if (get_field('testimonial_bg_image', get_option('page_on_front'))) {
		$bgID = get_field('testimonial_bg_image', get_option('page_on_front'));
	} else {
		$class .= ' no-bgimage';
		$bgID = false;
	}

	if (isset($fields['testimonial_bg_focal_point'])) {
		$coords = explode(',', $fields['testimonial_bg_focal_point']);
		$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
	}else if (get_field('testimonial_bg_focal_point', get_option('page_on_front'))) {
		$coords = explode(',', $fields['testimonial_bg_focal_point']);
		$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
	} else {
		$imgpos =  " object-position: 50% 50%;  ";
	}
	$args = array(
		'post_type'      => 'testimonials',
		'order'          => 'ASC',
		'orderby'        => 'random',
		'posts_per_page' => 6,
		'tax_query' => array()
	);
	if (is_array(get_field('testimonial_category')) && sizeof(get_field('testimonial_category')) > 0) {
		//echo "ADD";
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial-categories',
				'terms' => get_field('testimonial_category')
			)
		);
	}
	$wp_loop = new WP_Query();
	$wp_loop->query($args);
	$post_count = $wp_loop->post_count;
	if ($wp_loop->have_posts()) :
		global $loopCount;
		$loopCount = 1;
?>
		<div id="<?php echo $id; ?>" class="layer page_layout testimonials single_column  content_vertical_align-middle column_vertical_alignment-middle  clearfix pad-top-140 pad-bot-100 ">
			<div class="bg-image background-image ">
				<?php  /// default - check sizes
				echo wp_get_attachment_image($bgID, '2048x2048', "", ["class" => "cover", 'style' => $imgpos]);
				?>
			</div>
			<div class="bg-color abs"></div>
			<div class="inner inner-1170 grid">
				<div class="col">
					<ul id="testimonials_slider">
						<?php
						$count = 0;
						while ($wp_loop->have_posts()) :
							$count++;
							$wp_loop->the_post();
							$testimonial = get_the_content();
							$name = get_the_title();
							$byline = '';
							if (get_field("byline")) {
								$byline = " " . get_field("byline");
							}
							$author_name = get_field("author_name");
							$title = get_field("title");
							$location = get_field("location");
						?>
							<li class="item">
								<div class="testimonial_content">
									<blockquote>
										&ldquo;<?php echo $testimonial; ?>&rdquo;
									</blockquote>
									<div class="details">
										<p><strong><?php the_title(); ?></strong><br />
										<?php echo $byline; ?></p>
									</div>
								</div>
							</li>
						<?php
						endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php ob_start(); ?>
		$("#testimonials_slider").slick({
		//infinite:false,
		slidesToShow:1,
		dots:false,
		arrows:false,
		adaptiveHeight:true,
		});
<?php
		$myScripts .= ob_get_clean();
	endif;
	wp_reset_query();
endif;
