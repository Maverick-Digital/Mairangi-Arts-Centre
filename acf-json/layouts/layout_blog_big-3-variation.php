<section class="content blog-cards projects layer">
	<div class="inner inner-1170 pad-top-40 pad-bot-40">
		<div class="blog-filter ">
			<a href="#" class="heading anim"  data-filter="category">Categories</a>

			<ul id="category"><?php wp_list_categories(array(
			'orderby'    => 'name',
			'show_count' => true,
			'title_li' => '',
			'depth' => 1,
		)); ?></ul>
		<?php /*
			<ul id="tag" class="anim"><?php
			$tags = get_tags( array('orderby' => 'count', 'order' => 'DESC') );
		foreach ( (array) $tags as $tag ) {
		echo '<li><a class="underline" href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . '</a> (' . $tag->count . ') </li>';
		}
		?></ul>
		*/ ?>
		</div>	
    	<div class="load-posts pad-top-40 pad-bot-40">		
<?php
$wp_query = new WP_Query(); 			
$paged = get_query_var('paged');
//echo $paged;
$args = array(
    'post_type'      => 'post',
    //'order'          => 'DESC',
   // 'orderby'        => 'menu_order',
    'posts_per_page' => 12,
    'paged' => $paged,
    );
    	 
$wp_query->query($args);
$count =1;
//$post_count = $wp_query->post_count;
//echo $post_count;
$post_count = wp_count_posts()->publish;
//echo 'Total Posts: ' . $total;
while ($wp_query->have_posts()) : 
	$wp_query->the_post();
	//echo $count;
	$append=$prepend="";
	$closed=false;
	if($count==1){
		$append= '<div class="grid articles column-3 clearfix tight count-'.$count.'">';
	}
	if($count == 3){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==4){
		$append= '<div class="grid articles column-3 big-right clearfix tight count-'.$count.'">';

	}
	if($count == 6){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==7){
		$append= '<div class="grid articles column-3 clearfix tight count-'.$count.'">';
	}
	if($count == 9){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==10){
		$append= '<div class="grid articles column-3 big-left clearfix tight count-'.$count.'">';
	}
	if($count == 12){
		$prepend = '</div>';
		$closed=true;
	}
	
	
	
	

	$count++;
//while ( $loop->have_posts() ) : $loop->the_post();
$sold ="";
$terms =  get_categories();
$term_links ="";
if ( $terms && ! is_wp_error( $terms ) ) : 
              $links = array();
foreach ( $terms as $term ) {
	$links[] = $term->name;
	 $term_link = get_term_link( $term );
    
    // If there was an error, continue to the next term.
    if ( is_wp_error( $term_link ) ) {
        continue;
    }
 
    // We successfully got a link. Print it out.
    $term_links .='<a href="' . esc_url( $term_link ) . '">' . $term->name . '</a> ';
	

}
$tax_links = join( " ", str_replace(' ', '-', $links));
$tax = strtolower($tax_links); else :	
	      $tax = '';
endif;




$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 600, 600 ), true );
if(!$image) {
	$image = fly_get_attachment_image_src(109, array( 600, 600 ), true );
}
?>
<?php echo $append; ?>
	<article class="col tile card background-image">
		<div class="bg-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
		<div class="tile-copy dark">
			<h4 class="element-masked-y aos-init" data-aos="text-intro" data-aos-anchor-placement='center-bottom'><a class="anim" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></span></h4>
<?php /*
			<p class="element-masked-y date-meta aos-init" data-aos="text-intro" data-aos-anchor-placement='center-bottom' ><span><?php echo get_the_date(); ?></span></p>
			 <?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
		</div><!-- .post-snip -->
		<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
	</article>
<?php echo $prepend; 

?>
<?php
endwhile;
if(!$closed){echo "</div>";}
wp_reset_query();
?>
			
			
		</div>
		<?php if($post_count >12){ ?>
		<div class="load-more-wrapper clearfix center ">
			<a href="#" data-page="1" data-ppp="12" class="button load-more">Load more</a>
		</div>	
		<?php } ?>
	</div>
</section>
