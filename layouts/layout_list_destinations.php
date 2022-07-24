<section class="layer blog edge article">
			<div class="inner medium ">
			
			<?php 
			
		


			
			if (get_sub_field('title')){ ?>
		<h1 class="center "><?php echo get_sub_field('title'); ?></h1>	
		
		<?php } ?>
<?php
$currentPage = get_the_ID();


   

?>          
    <div id="portfolio" class="grid load-posts">
       <?php 
    
       $temp = $wp_query; $wp_query= null;
			$wp_query = new WP_Query(); 


$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    =>  71,
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
 	 $fields["Highlights"] =   substr(strip_tags(get_field("tour_highlights")), 0, 120).'...'; 
 $tax = 'destination';


echo '<div class="all portfolio-item isotope-item portfolio-item--width5">';
$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
if(!$image) {
	$image = fly_get_attachment_image_src(5, array( 650, 650 ), false );
}

?>
<div class="col tile tour" >
<?php if($image) { ?>
	<div class="card background-image" style="background-image:url(<?php echo $image['src']; ?>)">
		<span class="category-icon <?php echo $tax; ?>"></span>
		<a class="link-overlay" href="<?php echo get_the_permalink(); ?>"></a>					
	</div>
<?php } ?>
	<div class="tile-copy clearfix">
<div class="read-more">
		<h2 class="marketweb"><a href="<?php echo get_the_permalink(); ?>" ><?php echo get_the_title(); ?></a></h2>
		<?php 
			$found=false;
			while (have_rows('page_layout', get_the_ID())) : the_row();
			if($found==false && get_row_layout() == "2_column_with_mutliple_images"){ 
					$content = get_sub_field("content");
					echo "<ul><li>".content(55, $content)."</li></ul>";
					$found = true;
					//break 1;
			}else{
			}
		endwhile;
		
		?>
						<p class="link_wrap"></p>
					</div>
<a href="#" class="readmore button small">+ Read More</a>
						<a href="<?php echo get_the_permalink(); ?>"  class="tourlink button small alt">view destination</a>
						</div><!-- .tile-copy -->
					</div>
					<?php
					// echo '</a>';
echo '</div>';
?>

<?php
endwhile;
// Restore original post data.
wp_reset_postdata();
?>

		</div>
		
	</div>
</section>
