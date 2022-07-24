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
?>

<section class="layer services-grid grid single_column <?php echo $xclass; ?>">
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">

	<?php if (get_sub_field("content")) { ?>
		<div class="clearfix grid pad-bot-40">
			<div class="col inner inner-narrow ">
				<?php echo get_sub_field('content'); ?>

			</div>
		</div>
	<?php 	}
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
	
	$currentPage = get_the_ID();
	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	$wp_query->query($args);

	if($wp_query->have_posts()):

	if (get_sub_field('services_layout') == 'panels') :
	?>
		<div class="inner pad-bot-default">
			<div class="flex-container">
				<?php
				$count = 2;
				// if ( $wp_query->have_posts()) :
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
					$imageID = 686;
					if (get_the_ID() != $currentPage) {
						if(get_field("tile_image")){ 
							$imageID = get_field("tile_image"); 
						}else if(get_post_thumbnail_id()){
							$imageID = get_post_thumbnail_id();
						}
						$image = fly_get_attachment_image_src($imageID, array(950, 720), true);
						

						
						
						if (get_field('tile_image_focal_point')) {
							$coords = explode(',', get_field('tile_image_focal_point'));
							$bgpos =  " background-position:" . $coords[0] . " " . $coords[1] . "; ";
						} else {
							$bgpos = " background-position:center center; ";
						}


				?>
						<div class="flex-slide background-image anim" style="background-image:url(<?php echo $image['src']; ?>); <?php echo $bgpos; ?>">
							<a href="<?php echo get_the_permalink(); ?>" class="link-overlay"> </a>
							<div class="border_wrap anim"><?php echo $badge; ?>
								<div class="flex-about">
									<h3 class="title tohide"><?php echo get_the_title(); ?></h3>
									<div class="content hide">
										<h3 class="title"><?php echo get_the_title(); ?></h3>
										<?php echo get_field('teaser'); ?>
										<p><a href="<?php echo get_the_permalink(); ?>" class="button">Learn More</a></p>
									</div>
								</div>
							</div>
						</div>
				<?php
					}
				endwhile;
				// Restore original post data.
				wp_reset_query();
				?>
			</div>
		</div>
		<?php ob_start(); ?>
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

	elseif (get_sub_field('services_layout') == 'carousel') :
			?>
		<?php if (get_sub_field("content")) { ?>
			<div class="clearfix grid">
				<div class="col inner inner-narrow pad-bot-40 ">
					<?php echo get_sub_field('content'); ?>

				</div>
			</div>
			<?php 	}
	

				?>

					<ul class="carousel clearfix">
						<?php
						$count = 0;
						// if ( $wp_query->have_posts()) :
						while ($wp_query->have_posts()) :
							$wp_query->the_post();

							if (get_the_ID() != $currentPage) {
								$count++;

						?>
								<li class="item anim">
									<article class="product item_inner">
										<div class="bg-image anim abs">
												<?php
												
												echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
										</div>
										<div class="title grid anim abs">
											<div class="col col-align-bottom anim">
												<h3 class="subpage"><?php the_title() ?></h3>
												<div class="teaser anim">
												<h5>4 RIDE COMBO – $149.00</h5>
												<p>This flexi pass allows the participant to select FOUR activities from Swoop, Freefall Xtreme, V-Force, Shweeb & Agrojet. However they can double-up on their favourite if they wish, in favour of their least favourite.</p>
												<p><a class="button alt" href="<?php echo get_the_permalink(); ?>">Find out more</a>
												<?php echo get_field("short_description"); ?></div>
												<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;">xxx<span class=" sr-only"><?php echo get_the_title(); ?></span></a>

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

					<?php ob_start(); ?>
					console.log("fire featured products");
					var n = $("#section-<?php echo $id; ?> .carousel .item").length;
					var myCenter = false;
					if(n>2){
						myCenter = true;
					}
					
					$("#section-<?php echo $id; ?> .carousel").slick({
						
						
						variableWidth: false,
						arrows: false,
						speed: 300,
						slidesToShow: 3,
						slidesToScroll: 1,
						dots: false,
						centerMode: myCenter,
						responsive: [{
							breakpoint: 1480,
							settings: {
								slidesToShow: 2,
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
								slidesToShow: 1,
								dots: false,
								centerMode: true
							}
							// settings: "unslick" // destroys slick
						}]

					});
					console.log("fire featured products");
					console.log("hover");
				$("#section-<?php echo $id; ?> li").hover(
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

		<?php	$_myScripts ='';
					$myScripts .= ob_get_clean();

		
		elseif (get_sub_field('services_layout') == 'grid') :
			?>
			
			<div class="services services-grid grid grid-no-gutter">
				<?php
				$count = 0;
				// if ( $wp_query->have_posts()) :
				while ($wp_query->have_posts()) :
					$wp_query->the_post();

					if (get_the_ID() != $currentPage) {
						$count ++;

				?>	
					
			<article id="<?php echo $post->post_name; ?>" class="col">
			<div class="bg-image background-image" >
			<?php
			echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["alt"=> get_the_title(), "class" => "cover", 'sizes' => '(min-width: 600px) 50vw,
			100vw' ]);
			?>
			</div>
			<div class="col tile-copy grid abs anim">
				<div class=" pad-top-30 pad-bot-30 inner col col-align-middle center">
					<?php 
					if(get_field('teaser')){
 						echo get_field('teaser');
						}else{ ?>
						<h2><?php echo get_the_title(); ?></h2>
						<?php	
					} ?>
				</div>
			</div>
		
			<?php /*
			<div class="tile-copy col col-midde">
				<h3><?php echo get_the_title(); ?></h3>
				<?php if(get_field('teaser')){ ?>
					<div class="info-deal anim ani2">
						<?php echo get_field('teaser'); ?>
					</div>
				<?php } ?>
				<div class="info-action pad-top-20 anim ani3">	
					<a href="<?php echo get_the_permalink(); ?>" class="button alt ">Read More</a> <?php echo do_shortcode('[add_booking_but]'); ?>
				</div>
			</div>
			*/ ?>
			<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
		</article>
				
				<?php
					}
				endwhile;
				// Restore original post data.
				wp_reset_query();
				?>
			
		</div>
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
						$count ++;
						$image = fly_get_attachment_image_src(get_post_thumbnail_id(), array(950, 950), array( 'center', 'center' ));
						if (!$image) {
							$image = fly_get_attachment_image_src(686, array(950, 950), true);
						}

					
				?>
							<div class="altern grid <?php if($count % 2 == 0){ echo 'grid-reverse'; } ?>">
								<div class="col col-align-top pad-top-30 pad-bot-30  image background-image" style="background-image:url(<?php echo $image['src']; ?>);">
									
								</div>
								<div class="col text grid">
									<div class=" pad-top-30 pad-bot-30 inner col col-align-middle">
							
										<?php 
											if(get_field('teaser')){
												echo get_field('teaser');
												}else{ ?>
												<h2><?php echo get_the_title(); ?></h2>
												<p><a href="<?php echo get_the_permalink(); ?>" class="button">Learn More</a></p>
												<?php	
											} ?>
									</div>
								</div>
							</div>
				<?php
					}
				endwhile;
				// Restore original post data.
				wp_reset_query();
				?>
			</div>
		</div>
		<?php ob_start(); ?>
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


	endif;
endif;	
endif;
?> </div>
</section>
