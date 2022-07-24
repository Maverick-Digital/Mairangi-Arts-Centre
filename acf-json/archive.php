<?php get_header();
 ?>
<section class="content blog-cards projects page_layout">
	<div class="inner inner-1170 pad-top-40 pad-bot-40">
	<div class="blog-filter">
			<ul id="category" class="anim"><?php wp_list_categories(array(
			'orderby'    => 'name',
			'show_count' => true,
			'title_li' => '',
			'depth' => 1,
		)); ?></ul>
			<ul id="tag" class="anim"><?php
			$tags = get_tags( array('orderby' => 'count', 'order' => 'DESC') );
		foreach ( (array) $tags as $tag ) {
		echo '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . '</a> (' . $tag->count . ') </li>';
		}
		?></ul>
		
		</div>	
		<div class="load-posts pad-top-40 pad-bot-40">		
<?php
$paged = get_query_var('paged');
 
$count =1;
//$post_count = $wp_query->post_count;
//echo $post_count;
//$post_count = wp_count_posts()->publish;
$category = get_queried_object(); 
$post_count = $category->count;
//echo 'Total Posts: ' . $total;
//while ($wp_query->have_posts()) : 
//	$wp_query->the_post();
	 if (have_posts()) : while (have_posts()) : the_post(); 

	//echo $count;
	$append=$prepend="";
	$closed=false;
	if($count==1){
		$append= '<div class=" articles big-twin clearfix tight count-'.$count.'">';
	}
	if($count == 2){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==3){
		$append= '<div class=" articles column-3 big-right clearfix tight count-'.$count.'">';

	}
	if($count == 5){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==6){
		$append= '<div class=" articles column-3 clearfix tight count-'.$count.'">';
	}
	if($count == 8){
		$prepend = '</div>';
		$closed=true;
	}
	if($count==9){
		$append= '<div class=" articles column-3 big-left clearfix tight count-'.$count.'">';
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
$categories = get_the_category();
if ( ! empty( $categories ) ) {
    $category = '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
}
?>
<?php echo $append; ?>
	<article class="col tile card background-image">
		<div class="bg-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
		<div class="tile-copy dark">
			
			<h3  data-aos="fade-up"><span><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></span></h3>
			<p class="date-meta" data-aos="fade-up" data-aos-delay="200" ><span><?php echo get_the_date('d/m/y'); ?></span> - <?php //echo  $category; ?> </p>
			<?php /* <?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
		</div><!-- .post-snip -->
		<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
	</article>
<?php echo $prepend; 

?>
<?php
endwhile;
endif;
if(!$closed){echo "</div>";}
wp_reset_query();
?>
			
			
		</div>
		<?php if($post_count >11){ ?>
		<div class="load-more-wrapper clearfix center pad-top-80 pad-bot-80">
			<a href="#" data-page="1" data-ppp="11" class="button load-more">Load more</a>
		</div>	
		<?php } ?>
	</div>
</section>

<?php get_footer(); ?>
