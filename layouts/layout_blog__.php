<section class="content  blog-cards projects page_layout no-bg-image layer">
	<div class="inner inner-1170">
		<div id="load-posts" class="load-posts">		
<?php
$wp_query = new WP_Query(); 			
$paged = get_query_var('paged');
$args = array(
    'post_type'      => 'post',
    //'order'          => 'ASC',
    //'orderby'        => 'menu_order',
    'posts_per_page' => 11,
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
		$append= '<div class="grid articles column-2 big-twin clearfix tight count-'.$count.'">';
	}
	if($count == 2){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==3){
		$append= '<div class="grid articles column-3 clearfix tight count-'.$count.'">';

	}
	if($count == 5){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==6){
		$append= '<div class="grid articles column-3 clearfix tight count-'.$count.'">';
	}
	if($count == 8){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==9){
		$append= '<div class="grid articles column-3  clearfix tight count-'.$count.'">';
	}
	if($count == 11){
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
$tags = '';
if(get_the_tags()){
 foreach (get_the_tags() as $tag)
    {
    //	if($tags==""){$tags = "<i class='icon icon-tag' > </i> "; }
        $tags .= "<a   class=' icon-tag' href='".get_tag_link($tag->term_id)."'>".$tag->name."</a>";
    }
    }




$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 600, 600 ), true );
if(!$image) {
	$image = fly_get_attachment_image_src(109, array( 600, 600 ), true );
}
?>
<?php echo $append; ?>
	<article class="col tile card background-image  <?php body_class(); ?>">
		<div class="bg-image border-bot" >
			<?php 	echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["class" => "cover anim"]); ?>
		</div>
		<div class="tile-copy dark">
			<h3 class="subpage"><a href="<?php echo get_the_permalink(); ?>"><strong><?php echo get_the_title(); ?></strong></a></h3>
			<h5 class="date-meta"><?php echo get_the_date(); ?></h5>
			<?php /* <?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
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
		<?php if($post_count >11){ ?>
		<div class="load-more-wrapper clearfix center pad-top-60 ">
			<a href="#" data-page="1" data-ppp="11" class="button load-more">Load more</a>
		</div>	
		<?php } ?>
	</div>
</section>