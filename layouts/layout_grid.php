<section class="layer tile_group blog edge" >
			<div class="inner medium pad-top-20 pad-bot-20">
 
				<div class="section-head">
					<?php if (get_sub_field('title')) {
                	echo "<h1>".get_sub_field('title')."</h1>";
            }
            ?>
				</div><!-- .section-head -->

				
				<div id="portfolio" class="clearfix" >


<?php

if( have_rows('layout_grid_tile') ):

  // loop through the rows of data
    while ( have_rows('layout_grid_tile') ) : the_row();

        // display a sub field value
        //the_sub_field('image');
//echo get_sub_field('image');
$post_object = get_sub_field('image');
if( $post_object ): 
global $post;

  // override $post
  $post = $post_object;
  //print_r($post);
  setup_postdata( $post ); 
//echo "MIKE";

 		

          $size = get_sub_field('size');
          $Isize = array( 400, 400 );
          if($size == 1){
          // $Isize = array( 400, 400 );
          }else if($size == 2){
          $Isize = array( 800, 400 );
          }else if($size == 3){
          	$Isize = array( 1200, 650 );
          }else if($size == 4){
          	$Isize = array( 1600, 650 );
          }
          
//var_dump($post);
//echo "<hr/>";
$tax = '';
if($post->post_type == "tour"){
//echo "TOUR";
	$terms = get_the_terms( $post->ID, 'tour-type' );
	$term_links ="";
	if ( $terms && ! is_wp_error( $terms ) ) : 
	//$links = array();
	foreach ( $terms as $term ) {
		$links[] = $term->name;
		 $term_link = get_term_link( $term );
		// If there was an error, continue to the next term.
		if ( is_wp_error( $term_link ) ) {
			continue;
		}
		
		$tax = 'tour-type_'.$term->term_id.' '.$term->slug;
		break;
		
	}
	endif;
}else if(($post->post_type == "page" && $post->post_parent == 70)  || $post->ID == 70){
	$tax = 'activity';
}else if(($post->post_type == "page" && $post->post_parent == 71) || $post->ID == 71){
	$tax = 'destination';
}else if($post->ID == 67){
/* tour-type_13 self-drive-tours */
	$tax = 'tour-type_13';
}else if($post->ID == 202){
/* tour-type_10 escorted-guided-touring */
	$tax = 'tour-type_10';
}else if($post->ID == 200){
/* independent-coach */
	$tax = 'tour-type_9';
}else if($post->ID == 204){
/*tour-type_12 private-touring */
	$tax = 'tour-type_12';
}else {
	$tax = 'hidden';
	// no category...
}
          
          
$image = fly_get_attachment_image_src( get_post_thumbnail_id(), $Isize, true );
if(!$image) {
	$image = fly_get_attachment_image_src(5, $Isize, true);
}
          
    
         echo '<div class="all portfolio-item isotope-item portfolio-item--width'.$size.' '.$post->ID.' ">';
//echo '<a class="venobox cf" id="'.basename(get_permalink()).'" data-type="ajax"  data-gall="myGallery" href="'. get_the_permalink() .'" title="'. the_title_attribute('echo=0') .'">';

?>
<div class="col tile tour" >
<?php if($image) { ?>
	<div class="card background-image" style="background-image:url(<?php echo $image['src']; ?>)">
		<span class="category-icon <?php echo $tax; ?>"></span>
		<a class="link-overlay" href="<?php echo get_the_permalink(); ?>"></a>					
	</div>
<?php } ?>
	<div class="tile-copy clearfix">
		<h2 class="marketweb"><?php echo get_the_title(); ?></h2>

						</div><!-- .tile-copy -->
					</div> <?php
echo '</div>';

 wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; 

    endwhile;

endif; 
 ?>

   			</div><!-- #portfolio -->
				
				
			</div><!-- .inner -->
		</section>
			
    
