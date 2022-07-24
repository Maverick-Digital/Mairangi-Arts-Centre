<?php

$currentPage = get_the_ID();
$paged = get_query_var('paged');
$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); 

$args = array(
    'post_type'      => 'tour',
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'posts_per_page' => -1,
  //  'paged' => $paged,
    );
    	 
$wp_query->query($args);

			
if ($wp_query->have_posts()) :
/*
 ?>
 <section class="layer white filterbar container">
	<div class="inner clearfix">	
			
			<div id="dd" class="wrapper-dropdown-4 drop"><p>Trip Type</p>
				<ul class="dropdown" >
					<?php
					
					 $term="trip-type";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'><label for="'.$termname.'"><span></span>'.$term->name.'</label></li>';
						}
					}
				
					?>
				</ul>
	<section title=".squaredFour">
		<!-- .squaredFour -->
		<div class="squaredFour">
		  <input type="checkbox" value="None" id="squaredFour" name="check" checked />
		  <label for="squaredFour"></label>
		</div>
		<!-- end .squaredFour -->
	</section>
			</div>
			
			<div id="dd2" class="wrapper-dropdown-4 drop"><p>Trip Budget</p>
				<ul class="dropdown" >
					<?php
					 $term="trip-budget";

					$terms = get_terms($term,array( 'hide_empty' => false));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'><label for="'.$termname.'"><span></span>'.$term->name.'</label></li>';
						}
					}
					?>
				</ul>
				
			</div>
			<div class="wrapper-dropdown-4 action">
			<a href="javascript:void(0)" class="button alt find">Inspire Me</a>
			
			<a href="javascript:void(0)" class="reset">reset</a>
			</div>
	</div>
</section>

*/ ?>

<section class="layer yellow">
	<div class="inner pad-bot-80"> 
		<h1 class="center">Tours</h1>
		<div id="portfolio" class="grid load-posts row clearfix">
       <?php 
		// if ( $wp_query->have_posts()) :
		
		$c =0;
		 while ( $wp_query->have_posts()) : 
		 $c ++;
		 $wp_query->the_post();
			$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), true );
			if(!is_array($image)){ $image['src'] = '';}
			
			$term_list = wp_get_post_terms(get_the_ID(), 'trip-type', array("fields" => "id=>slug"));
			if (empty($term_list) || is_wp_error($term_list)){
				$term_list = array();
			}
			$term_list2 = wp_get_post_terms(get_the_ID(), 'trip-budget', array("fields" => "id=>slug"));
			if (empty($term_list2) || is_wp_error($term_list2)){

						$term_list2 = array();


			}

			$tax_links = join( " ", str_replace(' ', '-', $term_list)).' '.join( " ", str_replace(' ', '-', $term_list2));

			$tax_links = str_replace('+-', '', $tax_links);
			$tax = strtolower($tax_links);  
			if($c <7){
			$tax .= " featured";
			}
			  ?>
			<div class="all anim isotope-item portfolio-item <?php echo $tax; ?>">
				<a href="<?php echo get_the_permalink(); ?>">
				<div class="card anim" >
					<div class="imgwrap background-image" style="background-image:url(<?php echo $image['src']; ?>);"><br/>
					</div>
					
					<div class="title">
							<h2><?php the_title() ?></h2>
							<div class="meta"><i class="icon icon-clock-o"></i><?php 
						if(get_field('flight_length')){ 
							the_field( 'flight_length' );
						} ?></div>
					</div>
					<div class="info clearfix">
						
						<?php 
						if(get_field('key_points')){ 
							the_field( 'key_points' );
						}
						
						 /* if(get_field( 'flight_price')){ ?> <div class="price">$<?php the_field( 'flight_price' ); ?><?php if(get_field( 'flight_price_suffix')){ ?><span>/<?php the_field( 'flight_price_suffix' ); ?></span><?php } ?></div><?php } */ ?>
						<div class="action"><object><a href="<?php echo get_the_permalink(); ?>" class="button alt">More Info</a></object></div>
					</div>
				</div>
				
				</a>
			</div>
		<?php endwhile; 
		
		?>
		</div>
		
		
	
	</div>
</section>
<?php
else: ?>
<section class="layer blog article">
		<div class="inner medium center edge">
		<?php if (get_sub_field('title',$currentPage)){ ?>
		<h1 class="center "><?php echo get_sub_field('title', $currentPage); ?></h1>	
		<?php } 
		if($feedback != ''){
			echo "<p class='center'>$feedback</p>";
		}
		?>		
		<div class='center''>
		<p style="max-width:550px; margin:15px auto;">Sorry, no tours found matching your search criteria. </p>
		</div>
		
		</div>
</section>
<?php 
endif;

wp_reset_postdata();

?>

