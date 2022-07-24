<?php
global $post;
if(get_sub_field('id')){
	$id = "id='".get_sub_field('id')."'";
}else{
	$id="";
}
if(get_sub_field('class') && get_sub_field('class') != ""){
	$xclass =  get_sub_field('class');
}else{
	$xclass =  "pad-top-40 pad-bot-100";

}
$parent = get_sub_field('parent_page');
$paged = get_query_var('paged');

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    =>  $parent,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
   // 'paged' => $paged,

    );

$wp_query = new WP_Query(); 			
$wp_query->query($args);
$count =0;
$post_count = $wp_query->post_count;
$random = rand(1000000, 10000000);
if($wp_query->have_posts()):
?>
<div class="section<?php echo $random; ?> layer center">
	<?php
	//echo 'Total Posts: ' . $total;
	while ($wp_query->have_posts()) : 
		$wp_query->the_post();
		$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 600, 600 ), true );
		if(!$image) {
			$image = fly_get_attachment_image_src(510, array( 600, 600 ), true );
		} 
		$link= get_the_permalink();
		?>
		<div class="layer layout_2col_images clearfix  light style-<?php echo get_the_id(); ?> <?php echo ' '.$filter_tags; ?>"> 
			<div class="image_overlay abs"></div>
			<div class="bg-image background-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
			<div class="inner <?php echo $alternate; ?> clearfix">
				<div class="grid column-2">
					<div class="col textwrap pad-top-140 pad-bot-140" >
						<div class="_inner">
						<p class="teaser" ><?php echo get_field('teaser'); ?></p>
						<p><a href="<?php echo get_the_permalink(); ?>/" class="button">View Project</a></p>
						</div>
					</div>
					<div class="col imgwrap"></div>
				</div>
				<a href="<?php echo get_the_permalink(); ?>" class="link-overlay"></a>
			</div>
		</div>
		<article  class="card page_touchpoint <?php echo get_sub_field("color_scheme"); echo " ".get_post_type( $post->ID ); ?>">
			<div class="image_overlay abs"></div>
			<div class="bg-image background-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
			<div class="tile-copy">
			<?php //echo get_sub_field('wpcf-field_link_url'); ?>
				<h3 class=""><a href="<?php echo $link; ?>"><?php echo get_the_title(); ?></a></h3>
				<?php // the_content(); ?>
				<a href="<?php echo $link; ?>" class="button">Find Out More</a>
			</div>
		
			<a href="<?php echo $link; ?>" class="link-overlay">&nbsp;</a>
		</article>
	<?php
	endwhile;
	?>
</div>

<?php	
wp_reset_query();

endif;

