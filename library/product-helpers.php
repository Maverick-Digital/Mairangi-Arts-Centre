<?php
/*
 * helper functions for posts/products
 */
// remove base category links..
// 
function filter_category_link( $termlink, $term_term_id ) { 
	if(get_field('page_link', 'category_'.$term_term_id)){
		return get_field('page_link', 'category_'.$term_term_id);
	}
    return $termlink; 
}; 
         
// add the filter 
add_filter( 'category_link', 'filter_category_link', 10, 2 ); 



add_filter('post_type_link', function ($post_link, $post, $leavename, $sample) {
  if ($post->post_type == 'wps_products') {

    $post_link = get_field('shopify_url', $post->ID);
    return $post_link;
  }
  return $post_link;
}, 999, 4);

add_shortcode('show_aligned_style_buttons', function($atts) {
	//echo "mike".get_field("instagram_url");
	ob_start();
    if(get_field('alligned_styles')): ?>
      <ul class="aligned_styles buttons clearfix">
							<?php
							$count = 0;
						foreach( get_field('alligned_styles') as $_post ): 
									$count++;	?>
									<li>
											<a class="button alt" href="<?php echo get_the_permalink($_post); ?>"><?php echo get_the_title($_post); ?></a>
									</li>
							<?php
              endforeach;
							?>
						</ul>
    <?php endif; 
	return ob_get_clean();
	
});