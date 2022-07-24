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
	$xclass =  " pad-top-60 pad-bot-40 ";

}


?>
<section class="layer <?php echo $xclass; ?> clearfix">
	<?php if(get_sub_field('heading')){ ?>
	<div class="inner inner-1170 pad-bot-40 ">
		<?php echo get_sub_field('heading'); ?>
	</div>
	<?php } ?>
	<?php

	$args = array(
		'post_type'			=> 'page',
		'post_parent'       => get_the_ID(),                               
		'order'             => 'ASC',
		'orderby'           => 'menu_order',
		'posts_per_page'    => -1,
		'post_status' => 'any'
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
		if(get_field('resource_category')){
			$filter_tags = strtolower(join(" ", str_replace(' ', '-', get_field('resource_category'))));
		}
	 if(get_post_thumbnail_id(get_the_ID())){
		$image = fly_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), array( 600, 600 ), true );
	} else {
		// $image = fly_get_attachment_image_src(929, array( 600, 600 ), true );
	} 
	
	if($count > 9 && is_front_page()){
		// $filter_tags.= " hidden";
	}
	if(get_field('wpcf-field_external_link_title',$post->ID)){
		$linkText = get_field('wpcf-field_external_link_title',$post->ID);


	}else{
		$linkText = "Book Now";

	}
	?>
		<article id="<?php echo $post->post_name; ?>" class="card  all <?php echo get_field('header_class'); ?>  <?php echo $filter_tags; ?> <?php echo get_post_type(); ?>">
			<div class="bg-image background-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
			<div class="tile-copy">
				<h3  class="ani ani1"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
				<?php if(get_field('teaser')){ ?>
				<div class="info-deal ani ani2">
					<?php echo get_field('teaser'); ?>
				</div>
				<?php } 
				
				if(get_field('latitude') && get_field('longitude')){ ?>
				<div class="hidden acf-map-marker" data-title="<?php echo  get_the_title(); ?>" data-lat="<?php echo  get_field('latitude'); ?>" data-lng="<?php echo get_field('longitude'); ?>">
					<div class="center">
					<h4 style="margin-bottom:1em;"><strong><?php echo get_the_title(); ?></strong></h4>
					<a href="<?php echo get_the_permalink(); ?>" class="button alt ">Find out more</a>
				</div>
				</div>
				<?php } ?>
				<p class="info-action pad-top-20 ani ani3">	
				<a href="<?php echo get_the_permalink(); ?>" class="button alt ">Find out more</a></p>
				<?php /* <?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
			</div>
			<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
		</article>
	<?php
	endwhile;
	?>
</div>
<?php
wp_reset_query();
?>
<?php 
/*
 if(is_front_page()):  
 	if($post_type=='bathing'){ ?>
 	 	<div class="center pad-top-40 "><a href="<?php echo get_the_permalink(7); ?>"  class="button pools">Discover More</a></div>
	<?php }else if($post_type=='retreat_product'){ ?>
 	 	<div class="center pad-top-40 "><a href="<?php echo get_the_permalink(8); ?>"  class="button retreat_product spa">Discover More</a></div>
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
if(!is_admin()):
	ob_start(); ?>

		$('article').hover(function(e) {
			console.log("hover");
			$(this).find(".info-deal").stop().slideToggle();
		});

		  var $container = $('#section<?php echo $random; ?>');
		  
		
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
	
	

<?php 
$myScripts .= ob_get_clean();
endif;

?>
