<?php
global $post;
global $myScripts;

if(get_sub_field('id')){
	$id = "id='".get_sub_field('id')."'";
}else{
	$id="";
}
if(get_sub_field('class') && get_sub_field('class') != ""){
	$xclass =  get_sub_field('class');
}else{
	$xclass =  "  pad-top-60 pad-bot-40 ";

}
$post_type = 'page';
$custom_tax = get_sub_field('custom_tax');
$custom_term = get_sub_field('custom_term');


$category = get_term($custom_term[0])->slug;

$myterms = array();
$cat_array = get_sub_field('custom_tax');

if($cat_array){
	$cat = ' .'.$cat_array->slug;
	$myterms[] = $cat_array->term_id;
}else{

$cat= ".".$category;

}

?>
<section class="layer <?php echo $xclass; ?> clearfix">
    <?php // if(!is_front_page() ): ?>
    	<div class="education-filter list_posts">
			<ul class="main filters <?php if(get_sub_field('show_filter_bar') != 1){ echo "hidden";} ?>"><?php
				echo '<li class="button-group"><a href="javascript:void(0)" title="" data-filter=".all" '.$class.'>All</a></li>';
				if ( $count > 0 ) {
					foreach ( $terms as $term ) {
						//print_r($term);
						
						$termname = strtolower($term->slug);
						$termID = strtolower($term->term_id);
						
							if($category == $termname || strpos($cat, $termname) !== false ){
								$class =' class="active"';
							}else{ 
								$class="";
							}

							$termname = str_replace(' ', '-', $termname);
							echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'" '.$class.' >'.$term->name.'</a></li>';
						
					}
				}
			?>
			</ul>
		</div>
	<?php // endif; ?>	
<?php

$args = array(
	'post_parent'       => $post->ID,                               
	'order'             => 'ASC',
	'orderby'           => 'menu_order',
	'posts_per_page'    => -1

   /*'tax_query' => array(
		array(
			'taxonomy' => 'deal-categories',
			'field' => 'tag_id',
			'terms' => '10',
			'operator' => 'NOT IN',
		),
	)*/
);

if(is_admin()){
	$args['posts_per_page'] = 6;
}

$wp_query = new WP_Query(); 				
$wp_query->query($args);
$count =0;
$post_count = $wp_query->post_count;
$random = rand(1000000, 10000000);

?>

<div id="section<?php echo $random; ?>" class="layout_tiles count-<?php echo $post_count; ?>">
	
	<?php

	$count =0;
	while ($wp_query->have_posts()) : 
		$wp_query->the_post();
		$append=$prepend="";
		$closed=false;
		$count++;
		//$display = '';
		$term_links ="";
		$filter_tags = "";
		$terms = get_the_terms( $post->ID, $tax );
		$links = array('all');
	$filter_tags = strtolower(join(" ", str_replace(' ', '-', $links)));
	//echo $post->ID;
	if(get_field('tile_image',$post->ID)) {
		$image = fly_get_attachment_image_src(get_field('tile_image',$post->ID), array( 600, 600 ), true );
	//		echo 'tile_image';
	} else if(get_post_thumbnail_id($post->ID)){

	//			echo 'no tile_image - thumbanil'.get_post_thumbnail_id($post->ID);

		$image = fly_get_attachment_image_src(get_post_thumbnail_id($post->ID), array( 600, 600 ), true );
	} else {
	//			echo 'default tile_image';

		$image = fly_get_attachment_image_src(43, array( 600, 600 ), true );
	} 
	
	if($count > 9 && is_front_page()){
		$filter_tags.= " hidden";
	}
	if(get_field('wpcf-field_external_link_title',$post->ID)){
		$linkText = get_field('wpcf-field_external_link_title',$post->ID);


	}else{
		$linkText = "Book <span>Now</span>";

	}
	?>
		<article id="<?php echo $post->post_name; ?>" class="card <?php echo $filter_tags; ?> all <?php echo get_post_type(); ?>">
			<div class="bg-image background-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
			<div class="tile-copy">
				<h3  class="ani ani1"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
				<?php if(get_field('description')){ ?>
				<div class="info-deal ani ani2">
					<?php echo get_field('description'); ?>
				</div>
				<?php } ?>
				<p class="info-action pad-top-20 ani ani3">	
				<a href="<?php echo get_the_permalink(); ?>" class="button alt ">Learn More</a></p>
				<?php /* <?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
			</div>
		<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
		<div class="abs cat_tag ani"><?php echo $current_cat[0]; ?></div>
		</article>
	<?php
	endwhile;
	?>

</div>

<?php if(is_front_page()){ ?>
<div class="center"><p><a href="#" class="button more">See more</a></div>
<?php } ?>
<?php
wp_reset_query();
?>
<?php 
/*
 if(is_front_page()):  
 	if($post_type=='bathing'){ ?>
 	 	<div class="center pad-top-40 pad-bot-40"><a href="<?php echo get_the_permalink(7); ?>"  class="button pools">Discover More</a></div>
	<?php }else if($post_type=='retreat_product'){ ?>
 	 	<div class="center pad-top-40 pad-bot-40"><a href="<?php echo get_the_permalink(8); ?>"  class="button retreat_product spa">Discover More</a></div>
	 <?php } ?>
<?php endif;
*/
/* if($post_count >3){ ?>
<div class="load-more-wrapper clearfix center pad-top-80 pad-bot-80">
	<a href="#" data-page="1" data-ppp="12" class="button load-more">Load more</a>
</div>	
<?php } */ ?>
	
</section>

<?php
	ob_start(); ?>

	  	var $container = $('#section<?php echo $random; ?>');
	  	$container.imagesLoaded().progress( function() {
  		$container.isotope('layout');
	});
		//$container.layout();
		<?php
		$cat = ".all";
		if($category != ''){
			$filter = '.'.strtolower(str_replace(' ', '-', $category));
		}else{
			$filter = $cat;
		}
		
		?>
	$container.isotope({layoutMode:'fitRows', filter: '<?php echo $filter  ?>'});
	
	// filter items when filter link is clicked
	$('a.more').click(function(event){
		event.preventDefault();
		$(this).fadeOut();
		$container.find('article').removeClass('hidden');
		$container.isotope('layout');
		return false;

	});
    $('.education-filter .main.filters a').click(function(event){
		$('a.more').fadeOut();
		$container.find('article').removeClass('hidden');
		;
         $('.main.filters a.active').removeClass('active');
        $(this).addClass('active');
        var selector = $(this).attr('data-filter');
      
	
        

		filters = [selector];
		console.log('filter ' + filters);
        $container.isotope({ layoutMode:'fitRows', filter: selector, animationEngine : "css" });
        setTimeout(function(){$container.isotope('layout');}, 1000);

        
        //console.log($container);
        //console.log(filters.join(''));
        return false;
 
    });



<?php 
$myScripts .= ob_get_clean();


?>
