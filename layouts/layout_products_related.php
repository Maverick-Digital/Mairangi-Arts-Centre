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
if(is_singular("product")){
	$xclass.= ' ';
}
?>

<section id="<?php echo $id; ?>" class="layer related-products grid single_column <?php echo $xclass; ?>">
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner inner-wider <?php  echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
	<?php if (get_sub_field("content") || is_singular("product")) { ?>
		<div class="clearfix grid">
			<div class="col inner ">
				<?php
				if(is_singular("product")){ ?>
					<h2 class="pad-bot-40 center">Other trips you may like</h2> 
					<?php
				}else{ 
					echo get_sub_field('content'); 
				} ?>
			</div>
		</div>
	<?php 	}
	$ids = array();

	if(is_singular('product')){
	
		$ids = get_field('selected_products');
		
	}else{
		$ids = get_sub_field('selected_products');
	}
	print_r($ids);

	

	if(!empty($ids)):
		
		$args = array(
			//'post_type'      => 'page',
			'posts_per_page' => -1,
			'post__in'			=> $ids,
			'post_status'		=> 'publish',
			//'orderby'        	=> 'post__in',
			//'order'          => 'ASC',
			//'orderby'        => 'menu_order'
		);
		if(is_admin()){
			$args['posts_per_page'] =3;
		}

	$currentPage = get_the_ID();
	$wp_query = new WP_Query();
	$wp_query->query($args);
	if($wp_query->have_posts()):
			?>
	
	<ul class="services carousel clearfix">
						<?php
						$count = 0;
						// if ( $wp_query->have_posts()) :
						while ($wp_query->have_posts()) :
							$wp_query->the_post();
							
							if (get_the_ID() != $currentPage) {
								$count++;
								
						?>
								<li class="item anim">
									<article class="product item_inner 	<?php echo getProductType($post); ?>">
										<div class="bg-image anim abs">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
										</div>
										<div class="title grid anim abs">
											<div class="col col-align-bottom anim">
											<?php //echo getProductType($post); ?>
												<div class="teaser anim">
												<?php if(get_field('teaser')){ ?>
													<h3 class="subpage"><?php the_title() ?></h3>
													<?php
													echo get_field('teaser');
													}else{ ?>
												<h3 class="subpage"><?php the_title() ?></h3>
												<p><a class="button alt" href="<?php echo get_the_permalink(); ?>">Find out more</a>
											<?php } ?>
											<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>

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
					console.log("fire featured products <?php echo $id; ?>");
					var n = $("#<?php echo $id; ?> .carousel .item").length;
					var myCenter = false;
					if(n>2){
						myCenter = true;
					}
					
					$("#<?php echo $id; ?> .carousel").slick({
						
						
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
								slidesToShow: 3,
							}
						}, {
							breakpoint: 900,
							settings: {
								infinite: true,
								slidesToShow: 3,
								centerMode: myCenter
							}
						}, {
							breakpoint: 600,
							settings: {
								slidesToShow: 2,
								dots: true,
								centerMode: true
							}
							// settings: "unslick" // destroys slick
						}]

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

		<?php	
				$myScripts .= ob_get_clean();
			endif;
		endif;
		wp_reset_query();

?> </div>
</section>
