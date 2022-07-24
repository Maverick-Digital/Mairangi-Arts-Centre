<?php 



	if(get_sub_field('id')){
		$id = "id='".get_sub_field('id')."'";
	}else{
		$id="";
	}
	
if(is_front_page()):
	?>
	<div class="layer  clearfix  white" <?php echo $id; ?> >
		<div class="<?php echo get_sub_field('class'); ?>  clearfix">
			<?php if(get_sub_field('heading')){ ?>
			<div class="inner inner-1170 pad-bot-40">
				<?php echo get_sub_field('heading'); ?>
			</div>
			<?php } ?>


	<div class="main-carousel load-posts"  data-flickity='{ "contain": "false", "autoPlay":false, "draggable": true, "wrapAround": false, "prevNextButtons": false, "pageDots": false}'>
	
	<?php
	$wp_query = new WP_Query(); 			
	$paged = get_query_var('paged');
	//echo "paged: ".$paged;
	$args = array(
		'post_type'      => 'story',
	   // 'order'          => 'ASC',
	   // 'orderby'        => 'menu_order',
		'posts_per_page' => -1,
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
	<div class="carousel-cell">
		<div class="bg-image background-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
		<article class="col tile card carousel-inner">	
			<div class="tile-copy">
			<?php
				 $terms = get_the_terms($post->ID,'story-categories'  );
				 if(is_array($terms)){ ?>
				 <h4 class="subhead markup">
				 <?php
                    foreach ($terms as $term) {
                        //echo $term->name.' ';
                        $arr = explode("|", $term->name, 2);
						$first = $arr[0];
						echo '<strong>'.$arr[0].'</strong> | '.$arr[1];
                    }
                    ?>
				 </h4>
				 <?php
                }
				// echo get_the_term_list(get_the_ID(), 'story-categories', '', ', ', ''); 
				?>
				<h2 class="element-masked-y"><span><a href="<?php echo get_the_permalink(); ?>" class="underline"><span><?php echo get_the_title(); ?></span></a></span></h2>
				<?php /* 
							<p class="element-masked-y"><span><a href="<?php echo get_the_permalink(); ?>/" class="button">Read Story</a></span></p>

				<h5 class="date-meta"><?php echo get_the_date(); ?></h5>
				<?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
			</div>
			<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
		</article>
	</div>
	<?php
	endwhile;

	wp_reset_query();
	?>
			
			
			</div>
			<div class="icon-wrap pad-top-20 center">
					<div class="icon-arrow-left anim"><i class="icon-left-arrow"> </i></div>
					<div class="icon-drag"></div>
					<div class="icon-arrow-right anim"><i class="icon-right-arrow"> </i></div>
			</div>	
			<?php /* if($post_count >5  && !is_front_page()){ ?>
			<div class="load-more-wrapper clearfix center">
				<a href="#" data-page="1" data-ppp="5" data-display="flickity" class="button load-more">Load more</a>
			</div>	
			<?php } */ ?>
		
			
	<?php
	wp_reset_query();
	?>
	<script>
	jQuery(function($) {
	 setTimeout(openPopup, 200);
	 function openPopup(){
		 $('.carousel-cell.is-selected .element-masked-y').addClass("animate");
		$('.main-carousel').flickity('resize');
		 console.log( 'openPopup' );
	}



		$('.button--resize').on( 'click', function() {
		  // expand carousel by toggling class
		  $carousel.toggleClass('is-expanded')
			.flickity('resize');
		});

		$carousel = $('.main-carousel');
		$carousel.on( 'ready.flickity', function() {
			console.log('Flickity ready');
			$('.carousel-cell.is-selected .tile-copy p, .carousel-cell.is-selected .tile-copy h3').addClass("animate");

		});
	
		$carousel.on( 'change.flickity', function( event, index ) {
	
	
			$('.carousel-cell .element-masked-y').removeClass("animate");
		

		  console.log( 'Slide changed to ' + index );
		  $carousel.flickity('resize');

		});
		$carousel.on( 'staticClick.flickity', function( event, pointer, cellElem, cellIndex ) {
		  if ( cellIndex !== undefined ) {
			$carousel.flickity( 'select', cellIndex );
			//$carousel.delay(.5).flickity('resize');
		  }
		});

		$carousel.on( 'pointerDown.flickity', function( event, pointer ) {
			//$('.carousel-cell').css("transform:scale(.9);");
			//$carousel.css("transform:scale(.9);");

		});




		$carousel.on( 'settle.flickity', function( event, index ) {
				console.log( 'Flickity settled at ' + index );
				$('.main-carousel').flickity('resize');
			openPopup();

				 // setTimeout(openPopup, 500);

		});
	
		$('.icon-arrow-left').on( 'click', function() {
			$carousel.flickity('pausePlayer')
			$carousel.flickity('previous');
		});
		$('.icon-arrow-right').on( 'click', function() {
			$carousel.flickity('pausePlayer')
		  $carousel.flickity('next');
		});
	
		
	$carousel.on( 'mouseover', '.carousel-cell', function( event ) {
	  var index = $( event.currentTarget ).index();
	  $carousel.flickity( 'select', index );
	});
	
	
	
 
 
	});

	</script>
	</div>
</div>
<?php

else:
// blog layout
?>
<section class="content blog-cards projects story-cards">
	<div class="inner  pad-top-40 pad-bot-40">
		
    	<div class="load-posts pad-top-40 pad-bot-40">		
<?php
$wp_query = new WP_Query(); 			
//$paged = get_query_var('paged');
//echo $paged;
$args = array(
    'post_type'      => 'story',
    //'order'          => 'DESC',
   // 'orderby'        => 'menu_order',
    'posts_per_page' => -1,
  //  'paged' => $paged,
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
		$count = 0;
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
		<?php
				 $terms = get_the_terms($post->ID,'story-categories'  );
				 if(is_array($terms)){ ?>
				 <h4 class="subhead markup">
				 <?php
                    foreach ($terms as $term) {
                        //echo $term->name.' ';
                        $arr = explode("|", $term->name, 2);
						$first = $arr[0];
						echo '<strong>'.$arr[0].'</strong> | '.$arr[1];
                    }
                    ?>
				 </h4>
				 <?php
                }
				// echo get_the_term_list(get_the_ID(), 'story-categories', '', ', ', ''); 
				?>
			<h3 class="element-masked-y aos-init" data-aos="text-intro" data-aos-anchor-placement='center-bottom'><span><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></span></h3>
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
		<?php /*if($post_count >12){ ?>
		<div class="load-more-wrapper clearfix center ">
			<a href="#" data-page="1" data-ppp="12" class="button load-more">Load more</a>
		</div>	
		<?php } */ ?>
	</div>
</section>

<?php endif; ?>
	


