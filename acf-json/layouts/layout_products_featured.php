<?php
global $post;
global $myScripts;
 // require_once( 'filterbar.php' );

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


if(is_front_page()){
	$_class= "colored-tiles";
}else{
	$_class="featured-products";

}
?>

<section id="section-<?php echo $id; ?>" class="layer  grid  <?php echo $xclass.' '.$_class; ?>">
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>"></div>
	<div class="inner inner-<?php echo $inner;
							echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		<?php if (get_sub_field("content")) { ?>
			<div class="clearfix grid">
				<div class="col inner pad-bot-40 ">
					<?php echo get_sub_field('content'); ?>

				</div>
			</div>
			<?php 	}
		
		if (get_sub_field('selected_products')) :
			$ids = get_sub_field('selected_products');
			$args = array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'post__in'			=> $ids,
				'post_status'		=> 'publish',
				'orderby'        	=> 'post__in',
				//'order'          => 'ASC',
				//'orderby'        => 'menu_order'
			);
			if (is_admin()) {
				$args['posts_per_page'] = 2;
			}
			
			$currentPage = get_the_ID();
			$wp_query = null;
			$wp_query = new WP_Query();
			$wp_query->query($args);
			//echo $wp_query->post_count; 
			if ($wp_query->have_posts()) :



				?>
				<div class="col">
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
										<div class="bg-image anim card">
												<?php
												
												echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
										</div>
										<div class="grid">
											<div class="title col">
												<div class="match">
													<h4 class="subpage"><?php the_title() ?></h4>
													<?php echo get_field('teaser'); ?>
												</div>
											</div>
										</div>
										<div class="grid grid-nogutter actionwrap">
											<div class="col col-align-middle">
												<?php echo do_shortcode('[add_booking_but style="green"]');?>
											</div>
											<div class="col col-align-middle price text-right">
												<?php echo get_field("price");?>
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
				</div>
					<?php ob_start(); ?>
					console.log("fire featured products");
					var n = $("#section-<?php echo $id; ?> .carousel .item").length;
					var myCenter = false;
					if(n>2){
						myCenter = true;
					}
					
					$("#section-<?php echo $id; ?> .carousel").slick({
						
						
						variableWidth: true,
						arrows: false,
						speed: 300,
						infinite:false,
						loop:false,
						dots: false
					
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

				endif;
			
		endif;
		?>
	</div>
</section>