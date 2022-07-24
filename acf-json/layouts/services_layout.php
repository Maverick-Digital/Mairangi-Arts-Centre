<?php
global $post;
global $myScripts;
// only need these if performing outside of admin environment
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

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

?>
<section id="<?php echo $id; ?>" class="<?php echo $id; ?> layer  <?php echo $xclass; ?> ">
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>"></div>
	<?php if (get_sub_field("content")) { ?>
		<div class="clearfix inner  ">
			<div class="grid pad-bot-40">
				<div class="<?php if(get_sub_field('content_sidebar')){ echo 'col-7'; } ?> col">
					<?php echo get_sub_field('content'); ?>
				</div>
				<?php if(get_sub_field('sidebar')): ?>
					<div class="col col-5 col-align-bottom content_sidebar">
						<div class="grid grid-nogutter">
							<div class="col col-grow-1">
								<?php echo get_sub_field('content_sidebar'); ?>
							</div>
							<?php if (get_sub_field('services_layout') == 'carousel') { ?>
								<div class="col col-grow-1">
									<div class="slick_controls">
										<button class="slick_prev"></button> <button class="slick_next"></button>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php 	} ?>
	<div class="inner col inner-<?php echo $inner.'  '.$column_vertical_alignment; ?>  clearfix">
		<?php

		/*
	if( get_sub_field('services')):
		$ids = get_sub_field('services');
		$args = array(
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'post__in'			=> $ids,
			'post_status'		=> 'publish',
			'orderby'        	=> 'post__in',
			//'order'          => 'ASC',
			//'orderby'        => 'menu_order'
		);
	*/
		$currentPage = get_the_ID();
		$wp_query = null;
		$wp_query = new WP_Query();
		$args = array();


		//echo get_sub_field('data_source');
		//echo get_sub_field('services_layout');
		if (get_sub_field('data_source') == 'custom') {

			if (get_sub_field('services')) :
				$ids = get_sub_field('services');
				$args = array(
					'post_type'      => 'any',
					'posts_per_page' => -1,
					'post__in'			=> $ids,
					'post_status'		=> 'publish',
					'orderby'        	=> 'post__in',
					//'order'          => 'ASC',
					//'orderby'        => 'menu_order'
				);

				$wp_query->query($args);
			endif;
		} else if (get_sub_field('data_source') == 'parent_page') {
			//echo get_sub_field('parent_page');
			if (get_sub_field('parent_page')) :
				$post_parent = get_sub_field('parent_page', false, false);

				$args = array(
					'post_type'      => 'any',
					'posts_per_page' => -1,
					'post_parent'			=> $post_parent,
					'post_status'		=> 'publish',
					//'orderby'        	=> 'post__in',
					'order'          => 'ASC',
					'orderby'        => 'menu_order',
					'post__not_in' => array(get_the_ID())
				);
				//print_r($args);
				$wp_query->query($args);
			endif;
		}
		// print_r($args);

		if ($wp_query->have_posts()) :
			if (get_sub_field('services_layout') == 'buttons') :
				?>
						<ul class="services buttons clearfix">
							<?php
							$count = 0;
							// if ( $wp_query->have_posts()) :
							while ($wp_query->have_posts()) :
								$wp_query->the_post();
								if (get_the_ID() != $currentPage) {
									$count++;	?>
									<li>
											<a class="button ghost" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
									</li>
							<?php
								}
		
							endwhile;
							// Restore original post data.
							wp_reset_query();
							?>
						</ul>
						<?php ob_start(); 
						$myScripts .= ob_get_clean();
		
					elseif (get_sub_field('services_layout') == 'panels') :
		?>
				<ul class="services panels clearfix">
					<?php
					$count = 0;

					// if ( $wp_query->have_posts()) :
					while ($wp_query->have_posts()) :
						$wp_query->the_post();

						if (get_the_ID() != $currentPage) {
							$count++;

					?>
							<li class="item anim">
								<article class="product item_inner 	<?php echo "page-id-" . get_the_ID(); ?> ">
									<div class="card">
										<div class="bg-image anim abs">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", '_sizes' => '100vw']); ?>
										</div>
										<div class="title grid grid-nogutter anim abs">
											<div class="heading col col-align-bottom anim col-6">
												<?php //echo getProductType($post); 
												?>
												<h3 class="subpage"><?php the_title() ?></h3>
											</div>
											<div class="teaser col col-align-middle anim col-6">
												<h3 class="subpage"><?php the_title() ?></h3>
												<?php if (get_field('teaser')) {
													echo  get_field('teaser');
												}
												?>
											</div>
										</div>
									</div>
									<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
								</article>
							</li>

					<?php
						}

					endwhile;
					// Restore original post data.
					wp_reset_query();
					?>
				</ul>
				<?php ob_start(); ?>
			
			<?php
				$myScripts .= ob_get_clean();

			elseif (get_sub_field('services_layout') == 'carousel') :

			?>

				<ul class="services carousel clearfix rows-<?php echo get_sub_field('carousel_options'); ?>">
					<?php
					$count = 0;

					// if ( $wp_query->have_posts()) :
					while ($wp_query->have_posts()) :
						$wp_query->the_post();

						if (get_the_ID() != $currentPage) {
							$count++;

					?>
							<li class="item anim">
								<article class="product item_inner 	<?php echo "page-id-" . get_the_ID(); ?> ">
									<div class="card">
										<div class="bg-image anim abs">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", '_sizes' => '100vw']); ?>
										</div>
										<div class="title grid grid-nogutter anim abs">
											<div class="heading col col-align-bottom anim">
												<?php //echo getProductType($post); 
												?>
												<h3 class="subpage"><?php the_title() ?></h3>
											</div>

											<div class="teaser col col-align-bottom anim">
											 <h3 class="subpage"><?php the_title() ?></h3> 
												<?php if (get_field('teaser')) {
													echo  get_field('teaser');
												}
												?>
											</div>
										</div>
									</div>
									<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
								</article>
							</li>

					<?php
						}

					endwhile;
					// Restore original post data.
					wp_reset_query();
					?>
				</ul>

				<?php ob_start(); ?>
				console.log("fire carousel <?php echo $id; ?>");
				var n = $("#<?php echo $id; ?> .carousel .item").length;
				var myCenter = true;
				if(n>2){
				myCenter = true;
				}
				<?php
				if(get_sub_field('carousel_options') == 'custom' && get_sub_field('carousel_json_settings')){
				?>
				$("#<?php echo $id; ?> .carousel").slick(<?php echo get_sub_field('carousel_json_settings'); ?>);
				<?php
				}else{
				?>
				$("#<?php echo $id; ?> .carousel").slick( {
				rows: 1,
				variableWidth: false,
				arrows: true,
				speed: 300,
				slidesToShow: 3,
				slidesToScroll: 1,
				dots: false,
				centerMode: myCenter,
				responsive: [{
				breakpoint: 1480,
				settings: {
				slidesToShow: 4,
				}
				}, {
				breakpoint: 900,
				settings: {
				infinite: true,
				slidesToShow: 2,
				centerMode: myCenter
				}
				}, {
				breakpoint: 600,
				settings: {
				slidesToShow: 2,
				//dots: true,
				centerMode: true
				}
				// settings: "unslick" // destroys slick
				}]

		});
		<?php
			}
				?>

				$("#<?php echo $id; ?> .slick_prev").click(function(e) {
				$("#<?php echo $id; ?> .carousel").slick('slickPrev');
				});

				$("#<?php echo $id; ?> .slick_next").click(function(e) {
				$("#<?php echo $id; ?> .carousel").slick('slickNext');
				});

				/*

				$("#<?php echo $id; ?> li").hover(
				function() {
				console.log("hover" + $(this).find('.teaser'));

				$(this).find('.teaser').fadeIn('fast');
				$(this).find('.col').removeClass('col-align-bottom')
				.addClass('col-align-middle');

				}, function() {
				$( this ).find('.teaser').hide();
				$(this).find('.col').removeClass('col-align-middle')
				.addClass('col-align-bottom');
				}
				);

				*/

			<?php
				$myScripts .= ob_get_clean();
			elseif (get_sub_field('services_layout') == 'slider') :
			?>
				<ul class="services slider  side-by-side clearfix">
					<?php
					$count = 0;
				
					while ($wp_query->have_posts()) :
						$wp_query->the_post();


						if (get_the_ID() != $currentPage) {
					?>
							<li class="item anim ">
								<article id="<?php echo $post->post_name; ?>" class="product  item_inner page-<?php echo get_the_ID() . ' ' . get_field('page_class'); ?>">
									<div class="bg-image anim abs">
										<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim"]); ?>
									</div>
									<div class="title grid anim _abs ">
										<div class="col col-align-middle anim">
											
											<h3 class="subpage"><?php the_title() ?></h3>
											<div class="teaser anim">
												<?php if (get_field('teaser')) {
													echo get_field('teaser');
												}
												?>
											</div>
											<?php
											if (get_post_type() != 'page_touchpoints') { ?>
												<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
											<?php } ?>
										</div>
									</div>

								</article>
							</li>

					<?php
							$count++;
						}

					endwhile;
					// Restore original post data.
					wp_reset_query();
					?>
				</ul>
				<?php ob_start(); ?>
				console.log("fire slider: <?php echo $id; ?>");

				/*
				$("#<?php echo $id; ?> .slider").slick({
				variableWidth: false,
				arrows: true,
				speed: 300,
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: false,
				infinite: true
				});
				console.log("fire featured products");
				console.log("hover");

				$("#<?php echo $id; ?> li").hover(
				function() {
				console.log("hover" + $(this).find('.teaser'));

				$(this).find('.teaser').fadeIn('fast');
				$(this).find('.col').removeClass('col-align-bottom')
				.addClass('col-align-middle');

				}, function() {
				$( this ).find('.teaser').hide();
				$(this).find('.col').removeClass('col-align-middle')
				.addClass('col-align-bottom');
				}
				);
				*/

			<?php
				$myScripts .= ob_get_clean();


			elseif (get_sub_field('services_layout') == 'grid') :
			?>
				<ul class="services services-grid grid grid-no-gutter column-4 <?php echo $xclass; ?>">
					<?php
					$count = 0;
					// if ( $wp_query->have_posts()) :
					while ($wp_query->have_posts()) :
						$wp_query->the_post();
						if (get_the_ID() != $currentPage) {
							$count++;
					?>
						<li class="item anim">
								<article class="product item_inner 	<?php echo "page-id-" . get_the_ID(); ?> ">
									<div class="card">
										<div class="bg-image anim abs">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", '_sizes' => '100vw']); ?>
										</div>
										<div class="title grid grid-nogutter anim abs">
										</div>
									</div>
								
									<?php if (get_post_type() != 'tour_tiles'){ ?>
									<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
									<?php } ?>
									<div class="match teaser">
										<h4 class="subpage color"><?php echo get_the_title(); ?></h4>
										<div class="teaser">
											<?php 
											/*
											$excerpt = strip_tags(get_field('teaser'));
											$excerpt = substr($excerpt, 0, 200);
											$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
											echo '<p>'.$excerpt.'&hellip;</p>';	
											*/
												echo get_field('teaser');									
										
											?>
										</div>
									</div>
								</article>
							</li>
					<?php
						}
					endwhile;
					// Restore original post data.
					wp_reset_query();
					?>
				</ul>
			<?php
			/*  ob_start(); ?>
		$(".flex-slide").each(function(){
		$(this).hover(function(){
		$(this).find('.tohide').stop().hide();
		$(this).find('.content').stop().delay(350).fadeIn();
		}, function(){
		$(this).find('.tohide').stop().delay(350).fadeIn();
		$(this).find('.content').stop().hide();
		})
		});
	<?php
		$myScripts .= ob_get_clean();

*/

			else :
			?>
				<div class="inner inner-1170 pad-bot-default">
					<div class="services alternating">
						<?php
						$count = 0;
						// if ( $wp_query->have_posts()) :
						while ($wp_query->have_posts()) :
							$wp_query->the_post();

							if (get_the_ID() != $currentPage) {
								$count++;

						?>
								<article id="<?php echo $post->post_name; ?>">
									<div class="altern grid <?php if ($count % 2 == 0) { echo 'grid-reverse'; } ?> page-<?php echo get_the_ID() . '  ' . get_field('page_class'); ?>">
										<div class="col col-align-top  image background-image" <?php /* style="background-image:url(<?php echo $image['src']; ?>);" */ ?>>
											<?php
												echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim"]);
											?>
										</div>
										<div class="col text grid">
											<div class=" pad-top-60 pad-bot-60 inner col col-align-middle">
												<h3 class="subpage"><?php echo get_the_title(); ?></h3>
												<?php
												//echo do_shortcode('[product_price]');
												if (get_field('teaser')) {
													echo get_field('teaser'); ?>
												<?php
												} else { ?>
													<?php if (get_post_type() == 'page_touchpoint') {
													} else { ?>
														<p><a href="<?php echo get_the_permalink(); ?>" class="button">Learn More</a></p>
												<?php }
												} ?>
											</div>
										</div>
									</div>
								</article>
						<?php
							}
						endwhile;
						// Restore original post data.
						wp_reset_query();
						?>
					</div>
				</div>
				<?php

				if ($fields['class'] == 'slideshow') {
					ob_start(); ?>
					console.log("fire slider: <?php echo $id; ?>");

					$("#<?php echo $id; ?> .alternating").slick({
					variableWidth: false,
					arrows: true,
					speed: 300,
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false,
					infinite: false
					});


		<?php
					$myScripts .= ob_get_clean();
				}


			endif;

		endif;
		?>
		<?php if (get_sub_field("show_content_after") && get_sub_field("content_after")) { ?>
			<div class="clearfix grid content_after">
				<div class="col inner inner-narrow ">
					<?php echo get_sub_field('content_after'); ?>

				</div>
			</div>
		<?php 	} ?>

	</div>
</section>