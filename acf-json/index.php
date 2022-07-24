<?php get_header(); 


 //print_r( $imageSpace);
?>

	<section class="layer ">

	<div class="inner pad-top-60 pad-bot-100">
					
	<?php
	
	global $post;
$page_for_posts_id = get_option('page_for_posts');
if ( $page_for_posts_id ) : 
    $post = get_page($page_for_posts_id);
    setup_postdata($post);
    ?>
  
        <h1><?php the_title(); ?></h1>
      
            <?php the_content(); ?>
            
        
    <?php
    rewind_posts();
endif;

?>
	
						
		<ul>
    <?php wp_list_categories( array(
        'orderby'    => 'name',
        'show_count' => true,
        'exclude'    => array( 10 )
    ) ); ?> 
</ul>	
<?php
$taxonomy     = 'genre';
$orderby      = 'name'; 
$show_count   = false;
$pad_counts   = false;
$hierarchical = true;
$title        = '';
 
$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title
);
?>
 
<ul>
    <?php wp_list_categories( $args ); ?>
</ul>				

<div class="grid flex stretch column-3  pad-top-30 " id="load-posts">
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
	$image = fly_get_attachment_image_src(get_post_thumbnail_id(),array( 600, 400 ), true );
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'col' ); ?> >
		<div class="tile">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			<div class="parent" onclick="">
				<div class="child" style="background-image:url(<?php echo  $image['src']; ?>)">
				<img src="<?php echo $imageSpace['src'] ?>" alt="<?php the_title_attribute(); ?>" >
				</div>
			</div>
			<div class="tile-copy">
				<span class="readmore"><i class="icon-docs"></i></span>
				<h4><?php the_title(); ?></h4>
				<p><?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p>
			</div><!-- .tile-copy -->
		</a>
		</div>
	</article>
	<?php endwhile; ?>
</div> <!-- end grid -->


									<?php // bones_page_navi(); ?>

							<?php endif; ?>

					
</div>
<div class="load-more-wrapper clearfix">
					<a href="#" data-page="1" data-ppp="6" class="button load-more">Load more</a>
				</div>
					

				</div>

			</section>




<?php get_footer(); ?>
