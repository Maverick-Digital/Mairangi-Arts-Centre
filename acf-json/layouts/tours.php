<?php
$currentPage = get_the_ID();
$cat = get_sub_field("layout_tours_category");
$paged = get_query_var('paged');
$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query();



$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); 


$args = array(
    'post_type'      => 'tour',
    'posts_per_page' => -1,
    'tour-type' => $cat->slug,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
    'posts_per_page' => 6,
    'paged' => $paged,
    
    );
    
if($currentPage = 926){
	$feedback ='';
	 if (isset($_POST['tour-type'])) {
        $args['tour-type'] =  $_POST['tour-type'];
		//$args['tour-type'] = '';// $_POST['tour-type'];
		
		if($_POST['tour-type-names'] != ''){
			$feedback .= "<strong>Tour Type:</strong> ".str_replace(",",", ",$_POST['tour-type-names']);
		}
    }else{
    	unset ($args['tour-type']);
    }
     if (isset($_POST['tour-length'])) {
        $args['tour-length'] =  $_POST['tour-length'];
        //$args['tour-length'] = '';
        if($_POST['tour-length-names'] != ''){
			$feedback .= "<br/><strong>Tour Length:</strong> ".str_replace(",",", ",$_POST['tour-length-names']);
		}
    }else{
    	unset($args['tour-length']);
    }
    $args['posts_per_page'] =  -1;

	//print_r($args);

}
 
		 



			
$wp_query->query($args);
		
			
if ($cat && $wp_query->have_posts()) :

 ?>
<section class="layer blog article">
	<div class="inner medium edge">
		<?php if (get_sub_field('title',$currentPage)){ ?>
		<h1 class="center "><?php echo get_sub_field('title', $currentPage); ?></h1>	
		<?php }
		
		if($feedback != ''){
			echo "<p class='center'>$feedback</p>";
		}
		//echo str_replace(",",", ",$_POST['tour-length-names']);

		/* ?>
	<div class="filter">
	        <ul class="main filters" >
	       
	        <?php
	        $term="tour-type";

	            $terms = get_terms($term);
	$count = count($terms);
	// $grid.isotope({ filter: '.metal:not(.transition)' });
	echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All Tour Types</a></li>';
	if ( $count > 0 ) {
		foreach ( $terms as $term ) {
			$termname = strtolower($term->name);
			$termname = str_replace(' ', '-', $termname);
			//.'&nbsp;(' . $term->count . ')'
			echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'">'.$term->name.'</a></li>';
		}
	}
	?>
	    </ul>
	     </div>
	    <?php
*/
		$currentPage = get_the_ID();
		$posttype = 'tour';
		$term="tour-type";
		//echo $currentPage.'   '.$term;	
		?>

		<?php //if($currentPage==6 || $currentPage==19) {











//$cat = 'independant-coach';//get_sub_field("layout_tours_category");
$title = get_sub_field("layout_tours_title");
//echo '&post_type=tour'.'&tour-type='.$cat.'&posts_per_page=3' . '&paged='.$paged;
//var_dump($cat);
//$title = get_sub_field("layout_tours_title");
//echo '&post_type=tour'.'&tour-type='.$cat.'&posts_per_page=3' . '&paged='.$paged;
//http://localhost:8888/inspirednz.co.nz/wp-admin/edit.php?post_type=tour&tour-type=independant-coach

?>          
    <div id="portfolio" class="grid load-posts pad-bot-120">
       <?php 

       //$args = array( 'post_type' =>  $posttype, 'posts_per_page' => -1, 'paged' => $paged);
//$loop = new WP_Query( $args );

$count =2;
		// if ( $wp_query->have_posts()) :
		 while ( $wp_query->have_posts()) : 
		 $wp_query->the_post(); 


//$fields = get_fields();

 	$fields["Duration"] = get_field("tour_length");
 	  $fields["Regions"] =  get_field("tour_regions");
 	 $fields["Highlights"] =  strip_tags(get_field("tour_highlights")); //substr(strip_tags(get_field("tour_highlights")), 0, 120).'...'; 

$terms = get_the_terms( $post->ID, 'tour-type' );
$term_links ="";
$links = array();

if ( $terms && ! is_wp_error( $terms ) ) : 
foreach ( $terms as $term ) {
	$links[] = $term->name;
	}
endif;
$terms = get_the_terms( $post->ID, 'tour-length' );

if ( $terms && ! is_wp_error( $terms ) ) : 
foreach ( $terms as $term ) {
	$links[] = $term->name;
	}
endif;


$tax_links = join( " ", str_replace(' ', '-', $links));
$tax = strtolower($tax_links); 


echo '<div class="all portfolio-item isotope-item portfolio-item--width5  '. $tax .'">';
$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
if(!$image) {
	$image = fly_get_attachment_image_src(5, array( 650, 650 ), false );
}

?>
<div class="col tile tour" >
<?php if($image) { ?>
	<div class="card background-image" style="background-image:url(<?php echo $image['src']; ?>)">
		<a class="link-overlay" href="<?php echo get_the_permalink(); ?>"><span class="category-icon anim <?php echo $tax; ?>"></span></a>					
	</div>
<?php } ?>
	<div class="tile-copy clearfix">
	<div class="read-more">
		<h2 class="marketweb"><a href="<?php echo get_the_permalink(); ?>" ><?php echo get_the_title(); ?></a></h2>
		
<?php
	if( $fields )
	{
		echo "<ul>";
		foreach( $fields as $field_name => $value )
		{
			if($value){
			echo '<li>';
				echo '<strong>' . $field_name . ':</strong> '. $value;

			echo '</li>';
			}
		}
		echo "</ul>";
	}
						?>
						<p class="link_wrap"></p>
					</div>
<a href="#" class="readmore button small">+ Read More</a>
						<a href="<?php echo get_the_permalink(); ?>"  class="tourlink button small alt">view tour</a>
						</div><!-- .tile-copy -->
					</div>
					<?php
					// echo '</a>';
echo '</div>';
?>

<?php
endwhile;

?>

		</div>
		<div class="load-more-wrapper clearfix ">
			<a href="#" data-page="1" data-ppp="6" class="<?php if($currentPage == 926){ echo 'hidden '; } ?>button load-more">Load more</a>
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
		<div class=" center">
		<p style="max-width:550px; margin:15px auto;">Sorry, no tours found matching your search criteria. Please explore our itineraries using the menu above, or <a href="<?php echo get_the_permalink(219); ?>"  class="">contact us directly </a> and we can put together a tailor-made vacation for you.</p>
			<a href="<?php  echo get_the_permalink(219); ?>" class="button load-more">Contact us</a>
		</div>
		
		</div>
</section>
<?php 
endif;
wp_reset_postdata();

?>

