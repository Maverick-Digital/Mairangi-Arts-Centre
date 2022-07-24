<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560, 2560);
$size =   array(900, 450);
$crop = false;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');

//echo "XCLASS: ".$xclass;

$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); 
$posttype = 'page';	
if(get_sub_field("case_studies")){
	$myarray = get_sub_field("case_studies");
	$args = array(
		'post_type' => array($posttype),
		'post__in' => $myarray,
		'orderby' => 'post__in',
	);
}else{
	$args = array(
		'post_type' => array($posttype),
		'post_parent' => 848
	);

}
$wp_query->query($args);
$random = rand(1000000, 10000000);
if($wp_query->have_posts()):

	?>
	<div class="layer casestudies <?php echo $xclass; ?>">
		<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>"></div> 
		<?php if (get_sub_field("content")) { ?>
	<div class="clearfix grid pad-bot-40">
		<div class="col inner inner-narrow ">
				<?php echo get_sub_field('content'); ?>
		
		</div>
	</div>
<?php 	} ?>
	<div class="inner casestudySlider_wrap">
	<ul id="section<?php echo $random; ?>"  class="casestudySlider">
		<?php 	
		 while ( $wp_query->have_posts()) :  $wp_query->the_post(); 
				$image = fly_get_attachment_image_src(get_post_thumbnail_id(), array(1920,1000), true);
				if(!$image) {
					$image = fly_get_attachment_image_src(686, array( 950, 720 ), true );
				}
			  ?>
			  
			  <li class="trans slide background-image" style="background-image:url(<?php echo $image['src']; ?>);">
				<a class="link-overlay "  href="<?php echo get_the_permalink(); ?>"  >
				</a>
				<div class=" anim grid">
				<div class="info col-align-middle">
					<div class="left">
						<?php  if(get_field('teaser')){ 
							echo get_field('teaser');  
						}else{ ?>
							<h2 class="title tohide"><?php echo get_the_title(); ?></h2>
						<?php } ?>
						<p><a href="<?php echo get_the_permalink(); ?>" class="button" >Learn More</a></p>
					</div>
				</div>
			</div>
			</li>
		<?php endwhile; ?>
		</ul>
		<svg class="cnr tl" viewBox="0 0 70.5 70.5" xmlns="http://www.w3.org/2000/svg"><path d="m0 67v-64.18a2.82 2.82 0 0 1 2.82-2.82h64.18a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1 -3.5 3.5h-60v60a3.5 3.5 0 0 1 -3.5 3.5 3.5 3.5 0 0 1 -3.5-3.5z" fill="#0eb1aa"/></svg>
		<svg class="cnr tr" viewBox="0 0 70.5 70.5" xmlns="http://www.w3.org/2000/svg"><path d="m3.5 0h64.18a2.82 2.82 0 0 1 2.82 2.82v64.18a3.5 3.5 0 0 1 -3.5 3.5 3.5 3.5 0 0 1 -3.5-3.5v-60h-60a3.5 3.5 0 0 1 -3.5-3.5 3.5 3.5 0 0 1 3.5-3.5z" fill="#0eb1aa"/></svg>
		<svg class="cnr bl" viewBox="0 0 70.5 70.5" xmlns="http://www.w3.org/2000/svg"><path d="m67 70.5h-64.18a2.82 2.82 0 0 1 -2.82-2.82v-64.18a3.5 3.5 0 0 1 3.5-3.5 3.5 3.5 0 0 1 3.5 3.5v60h60a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1 -3.5 3.5z" fill="#0eb1aa"/></svg>
		<svg class="cnr br" viewBox="0 0 70.5 70.5" xmlns="http://www.w3.org/2000/svg"><path d="m70.5 3.5v64.18a2.82 2.82 0 0 1 -2.82 2.82h-64.18a3.5 3.5 0 0 1 -3.5-3.5 3.5 3.5 0 0 1 3.5-3.5h60v-60a3.5 3.5 0 0 1 3.5-3.5 3.5 3.5 0 0 1 3.5 3.5z" fill="#0eb1aa"/></svg>
	</div>
</div>
<?php endif; 
wp_reset_postdata(); ?>
<?php 

	ob_start();
		if(get_sub_field('layout')=='carousel'){ ?>
			$("#section<?php echo $random; ?>").slick({ slidesToShow:1, dots:true, arrows:false });
	<?php }
	$myScripts .= ob_get_clean();
