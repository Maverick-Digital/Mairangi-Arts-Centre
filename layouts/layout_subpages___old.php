<?php
$wp_query = new WP_Query(); 
$parent = get_sub_field('parent_page');
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    =>  $parent,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
    );
$wp_query->query($args);
$currentPage = get_the_ID();
if(get_sub_field("id") == "work"){
	$width="wide";
}else{
	$width="medium";
}
$alternate = "right";
?>
<section class="layer">
	<div class="inner <?php echo $width; ?> ">
	<?php 
			if (get_sub_field('title')){ ?>
				<?php echo get_sub_field('title'); ?>
		<?php }   ?>       
<div id="portfolio" class="grid load-posts"> 
<?php 
if(get_sub_field("id") == "work"): 

	 while ( $wp_query->have_posts()) : 
		$wp_query->the_post(); 
		if(get_post_thumbnail_id()){
			//$bgImage =  wp_get_attachment_image_src(get_post_thumbnail_id(), "full", false ); 
			$bgImage =  fly_get_attachment_image_src(get_post_thumbnail_id(),array( 1920, 1100 ), true );
			$bg = 'style="background-image:url('.$bgImage["src"].')"';
		}
		$content      = get_the_content();
		//$content = strip_shortcodes( $content );
		$superCleaned = strip_tags($content); //No HTML Tags
		$sentence = preg_split( '/(\.|!|\?)\s/', $superCleaned, 2, PREG_SPLIT_DELIM_CAPTURE );
		$sentence = strip_shortcodes($sentence['0']);
		if($alternate == "right"){
			$alternate = "left";
		}else{
			$alternate = "right";
		}
		?>
		<div class="layer layout_2col_images clearfix  light style-<?php echo get_the_id(); ?> color-<?php echo get_field('color_scheme'); ?>"> 
			<div class="abs bg_color  " <?php echo $bg; ?>  data-aos="fade-in" data-aos-duration="700" data-aos-once="true"></div>
			<div class="inner <?php echo $alternate; ?> clearfix">
				<div class="grid column-2">
					<div class="col textwrap pad-top-140 pad-bot-140" >
						<div class="_inner">
						<h2 data-aos="fade-up" data-aos-anchor-placement="top-bottom"><?php the_title(); ?></h2>
						<p class="teaser" data-aos="fade-up" data-aos-anchor-placement="top-bottom"><?php echo $sentence; ?></p>
						<p data-aos="fade-up" data-aos-anchor-placement="top-bottom"><a href="<?php echo get_the_permalink(); ?>/" class="button">View Project</a></p>
						</div>
					</div>
					<div class="col imgwrap"></div>
				</div>
			</div>
		</div>
		<?php
	endwhile;
else: 
?>

<div class="layer  <?php echo get_sub_field("class"); ?>">
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
			  <li class="anim" >
				<?php /* <a href="<?php echo get_the_permalink(); ?>" style="display:block;"></a> */ ?>
				<img class="anim" src="<?php echo $image['src']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
				<div class="card anim_slow style-<?php echo get_the_id(); ?>">
				<div class="table">
				   <div class="table-cell">
						<div class="title anim_slow">
							<h3  class=' subpage anim_slow'><?php the_title() ?></h3>
							<div class="meta anim_slow">	
								<p class="teaser" data-aos="fade-up" data-aos-anchor-placement="top-bottom"><?php echo $sentence; ?></p>
								<div class="action">
									<object style="display:block;">
										<?php if(get_sub_field("id") == "ideas"){ 
											$text = "Read More";
										}else{
											$text = "View Project";
										}
										?>
										<a href="<?php echo get_the_permalink(); ?>" class="button"><?php echo $text; ?></a>
									</object>
								</div>
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
			endwhile; ?>
		</ul>
</div>
<?php
endif;

wp_reset_postdata();
?>
		</div>
	</div>
</section>
