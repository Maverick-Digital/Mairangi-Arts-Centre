<?php 
$wp_query = new WP_Query(); 
$myarray = get_sub_field("popular_flights");
$posttype = 'page';
$args = array(
'post_type' => array($posttype),
'post__in' => $myarray,
'orderby' => 'menu_order',
    'order' => 'ASC',
);


$wp_query->query($args);
if($wp_query->have_posts()):

 ?>
<div class="layer  <?php echo get_sub_field("class"); ?>">
	<div class="inner center pad-bot-40">		
		<h3 class="section-heading case">Case Studies</h3>
	</div>
		<ul class="casestudies">
		<?php 	
		$c=5;
		 while ( $wp_query->have_posts()) : 
			$wp_query->the_post(); 
			$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), true );
			if(!is_array($image)){ $image['src'] = '';}
			$content      = get_the_content();
		//$content = strip_shortcodes( $content );
		$superCleaned = strip_tags($content); //No HTML Tags
		$sentence = preg_split( '/(\.|!|\?)\s/', $superCleaned, 2, PREG_SPLIT_DELIM_CAPTURE );
				$sentence = strip_shortcodes($sentence['0']);

			//$term_list = wp_get_post_terms(get_the_ID(), 'trip-type', array("fields" => "names"));
			  //
			  ?>
			  <li class="anim style-<?php echo get_the_id(); ?>  color-<?php echo get_field('color_scheme'); ?>" >
				<a href="<?php echo get_the_permalink(); ?>" style="display:block;">
									<img class="anim" src="<?php echo $image['src']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />

				<div class="card anim_slow">
				<div class="table">
				   <div class="table-cell">
						<div class="title anim_slow">
							<h3 class='subpage anim_slow'><?php the_title() ?></h3>
							<div class="meta anim_slow">	
								<p class="teaser smaller"><?php echo $sentence; ?></p>
								<div class="action"><object style="display:block;"><a href="<?php echo get_the_permalink(); ?>" class="button">View Project</a></object></div>
							</div>
						</div>				   
					</div>
				</div>
					
					
					
				</div>
				</a>
			</li>
			  <?php
			  
			  
			  /*
			  ?>
			  
			  
			   <li data-aos="flip-left" >
					<a href="<?php echo get_the_permalink(); ?>"><div class="card background-image" style="background-image:url(<?php echo $image['src']; ?>);" >
						<div class="title">
							<div class="category"><?php echo $term_list[0]; ?></div>
							<h2><?php the_title() ?></h2>
						</div>
						<div class="info clearfix">
							<?php if(get_field( 'flight_price')){ ?> <div class="price"><?php the_field( 'flight_price' ); ?><?php if(get_field( 'flight_price_suffix')){ ?><span>/<?php the_field( 'flight_price_suffix' ); ?></span><?php } ?></div><?php } ?>
							<div class="action"><a href="<?php echo get_the_permalink(); ?>" class="button small">More Info</a></div>
						</div>
					</a>
				</li><?php */ 
				$c++;
			endwhile; 
			if(is_front_page()){
			
				$image = fly_get_attachment_image_src(30, array( 650, 650 ), true );

			 ?>
			
			<li class="anim" >
				<a href="<?php echo get_the_permalink(231); ?>" style="display:block;">
									<img class="anim" src="<?php echo $image['src']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />

				<div class="card anim_slow">
				<div class="table">
				   <div class="table-cell">
						<div class="title anim_slow">
							<h2 class='anim_slow'>See more of our work</h2>
							<div class="meta anim_slow">	
								<?php /* <p>Tactical paid media to beat the OTA's</p> */ ?>
								<div class="action"><object style="display:block;"><a href="<?php echo get_the_permalink(231); ?>" class="button">View All Projects</a></object></div>
							</div>
						</div>				   
					</div>
				</div>
					
					
					
				</div>
				</a>
			</li>
			
			<?php }
			
			?>
		</ul>
</div>
<?php endif; 
wp_reset_postdata(); ?>
