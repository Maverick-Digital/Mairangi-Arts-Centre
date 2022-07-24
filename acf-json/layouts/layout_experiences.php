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
	$width="medium";
}else{
	$width="wide";
}
$alternate = "right";
?>
<section class="layer">
	<?php 
			if (get_sub_field('title')){ ?>
				<?php echo get_sub_field('title'); ?>
		<?php }   ?>       
<div class="experiences"> 
<?php 
	 while ( $wp_query->have_posts()) : 
		$wp_query->the_post(); 
		$bgImage = $bg= "";
		if(get_post_thumbnail_id()){
			//$bgImage =  wp_get_attachment_image_src(get_post_thumbnail_id(), "full", false ); 
			$bgImage =  fly_get_attachment_image_src(get_post_thumbnail_id(),array( 1920, 1100 ), true );
			$bg = 'style="background-image:url('.$bgImage["src"].')"';
		}
		if(get_field('video')){
			// $bg ='';
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
		//$alternate = "left";
		
		//data-aos="fade-in" data-aos-duration="700" data-aos-once="true"
		?>
		<div class="layer vh100 style-<?php echo get_the_id(); ?> color-<?php echo get_field('color_scheme'); ?> mar-bot-20"> 
			<div class="abs bg_color  " <?php echo $bg; ?>  ></div>
			<?php
			// evening
			//echo "MIKE".get_field('video');
		if(get_field('video')){
			
			$random = rand(1000,2000);
			$newId = "video".$random;
		
				?>
			<div class="videocontainer" data-video='<?php echo $newId; ?>' style="<?php echo $vidpos; ?>">
			<video data-object-fit="cover" loop muted autoplay playsinline   id="<?php echo $newId; ?>">
			<?php /* controls  */ ?>
			</video>
				</div>	
				<script>
				jQuery(document).ready(function($) {

				var <?php echo $newId; ?> = [ <?php echo get_field('video'); ?> ];
				
				
				var Controller<?php echo $newId; ?> = new ScrollMagic.Controller();

				var slideScene = new ScrollMagic.Scene({
				    triggerElement: "#<?php echo $newId; ?>", // trigger CSS animation when header is in the middle of the viewport
					triggerHook: 1,
					duration: "90%",
					reverse:false
					// offset: jQuery(window).height(), //"200"
				})
				.on("enter", function (event) {
					//console.log(jQuery("#<?php echo $newId; ?>")[0].html);
					//if(jQuery("#<?php echo $newId; ?>")[0].html == ''){
					 WidthChange(<?php echo $newId; ?>, "#<?php echo $newId; ?>");
					console.log("load video.....");
					//}
					//$("#<?php echo $newId; ?>")[0].play();
					//console.log("play video..... <?php echo $newId; ?>");

					
				})
				.on("leave", function (event) {
					//removeVid(<?php echo $newId; ?>, "#<?php echo $newId; ?>");
					//$("#<?php echo $newId; ?>")[0].stop();
					//console.log("stop video..... <?php echo $newId; ?>" );
					//jQuery('nav').removeAttr('class');
				})
				//.addIndicators()
				.addTo(Controller<?php echo $newId; ?>);
			
				});


				jQuery(window).on("resize", function() {
					WidthChange(<?php echo $newId; ?>, "#<?php echo $newId; ?>");
				});



							
			</script>		
	<?php
	}
	
	?>
			
			<div class=" <?php echo $alternate; ?> clearfix inner inner-1170">
				<div class="grid column-2">
					<div class="col textwrap pad-top-200 pad-bot-200" >
						<div class="_inner">
						<h1 class="element-masked-y" data-aos="text-intro" data-aos-anchor-placement='center-bottom'><span><?php the_title(); ?></span></h1>
<?php /*						<p class="teaser" data-aos="fade-up" data-aos-anchor-placement="top-bottom"><?php echo $sentence; ?></p>  */ ?>
						<p class="element-masked-y" data-aos="text-intro" data-aos-anchor-placement='center-bottom'><span><a href="<?php echo get_the_permalink(); ?>" class="button ghost">Discover</a></span></p>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<?php
	endwhile;


wp_reset_postdata();
?>
		</div>
	</div>
</section>
