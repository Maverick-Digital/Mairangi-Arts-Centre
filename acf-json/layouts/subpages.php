<section class="layer blog edge article">
	<div class="inner medium ">
	<?php 
			if (get_sub_field('title')){ ?>
		<h2><strong><?php echo get_sub_field('title'); ?></strong></h2>	
		
		<?php }   ?>
<?php
$currentPage = get_the_ID();
?>          
    <div id="portfolio" class="grid load-posts">
       <?php 
    
       $temp = $wp_query; $wp_query= null;
			$wp_query = new WP_Query(); 

if(get_sub_field('parent')){
	$parent = get_sub_field('parent_page');
}else{
	$parent = get_the_ID();
}

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    =>  $parent,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
    );


$wp_query->query($args);

$count =2;
// if ( $wp_query->have_posts()) :
while ( $wp_query->have_posts()) : 
	$wp_query->the_post(); 


	//$fields = get_fields();

	//$fields["Duration"] = get_field("tour_length");
	//$fields["Regions"] =  get_field("tour_regions");
//	$fields["Highlights"] =   substr(strip_tags(get_field("tour_highlights")), 0, 120).'...'; 
//	$tax = 'destination';


	$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
	if(!$image) {
		$image = fly_get_attachment_image_src(18, array( 650, 650 ), false );
	}
	?>
<div class="all portfolio-item isotope-item portfolio-item--width5">
	<div class="col tile tour" >
	<?php if($image) { ?>
		<div class="card background-image" style="background-image:url(<?php echo $image['src']; ?>)">
			<a class="link-overlay" href="<?php echo get_the_permalink(); ?>"></a>					
		</div>
	<?php } ?>
		<div class="tile-copy clearfix">
			<div class="read-more">
				<h3><a href="<?php echo get_the_permalink(); ?>" ><?php echo get_the_title(); ?></a></h3>
				<?php echo get_field('teaser'); ?>
			</div>
			<a href="<?php echo get_the_permalink(); ?>"  class="button small">Read More</a>
		</div><!-- .tile-copy -->
	</div>
</div>

<?php endwhile;
// Restore original post data.
wp_reset_postdata();
?>

		</div>
		
	</div>
</section>
