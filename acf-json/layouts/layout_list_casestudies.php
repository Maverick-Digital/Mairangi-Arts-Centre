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

if (get_field('memories_assigned_relationship')) :
	$ids = get_field('memories_assigned_relationship');
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
	<div class="inner col inner-<?php echo $inner.' '.$column_vertical_alignment; ?>  clearfix">
		<?php

		$currentPage = get_the_ID();
		$wp_query = null;
		$wp_query = new WP_Query();
		$args = array();

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

		if ($wp_query->have_posts()) :
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
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim"]); ?>
										</div>
										<div class="tags abs"><span class='tag'>Case Study</span></div>
									
									</div>
								
									<?php if (get_post_type() != 'tour_tiles'){ ?>
									<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
									<?php } ?>
									<div class="match">
										<h4 class="subpage color"><?php echo get_the_title(); ?></h4>
										<div class="teaser">
											<?php 
											$excerpt = strip_tags(get_field('teaser'));
											$excerpt = substr($excerpt, 0, 200);
											$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
											echo '<p>'.$excerpt.'&hellip;</p>';											
										
											?>
										</div>
									</div>
									<?php if (get_post_type() == 'tour_tiles'){ ?>
										<a class="button alt small center" href="/contact-us">Enquire Now</a>
										<?php } ?>
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
			endif;
		if (get_sub_field("show_content_after") && get_sub_field("content_after")) { ?>
			<div class="clearfix grid content_after">
				<div class="col inner inner-narrow ">
					<?php echo get_sub_field('content_after'); ?>

				</div>
			</div>
		<?php 	} ?>

	</div>
</section>

<?php 
endif;