<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560, 2560);
$size =   array(1400, 900);
$crop = true;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');

$post_type = 'tours';
$tax = 'tour_cat';
$productType = get_sub_field('custom_tax');
$productTerm = get_sub_field('custom_term');

$all_terms = get_terms(array(
	'taxonomy' => 'tour_cat',
	'hide_empty' => false,
) );

$category = "all";

if (get_sub_field('term_onload')) {
	$term_onload = get_sub_field('term_onload');
	//echo "<br/>term_onload: ".get_sub_field('term_onload').get_term($term_onload)->slug;
	$category = get_term($term_onload)->slug;
} 
if(isset($_GET["category"])){
	$category = strtolower($_GET["category"]);
}

$myterms = array();
$cat_array = get_sub_field('productType');
$cat = "." . $category;

?>
<section id="<?php echo $id; ?>" class="layer layout_2col_images clearfix grid <?php echo $xclass; ?> ">
		<div class="bg-image background-image " >
		<?php
				if (isset($fields['bg_focal_point'])) {
					$coords = explode(',', $fields['bg_focal_point']);
					$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
				} else {
					$imgpos =  " object-position:50% 50%; ";
				}	
			
			?>
			<?php 
			/// default
			echo wp_get_attachment_image($fields['bg_image'], '2048x2048', "", ["class" => "cover", 'sizes' => '100vw', 'style'=> $imgpos ]);
			?>
		</div>
		<div class="bg-color abs"></div>
		<div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		

<?php 
if (get_sub_field("content")) { ?>
		<div class="clearfix inner  ">
			<div class=" pad-bot-40">
				<?php echo get_sub_field('content'); ?>
			</div>
		</div>
	<?php 	} 
		

	if (get_sub_field('show_filter_bar')):
	 ?>
		<div class="blog-filter  pad-bot-40">
			<ul class="main filters">
			<?php
			$class = "";
			if ($category == "all") {
				$class = ' class="active"';
			}
			if (get_sub_field('show_all_link')) {
				echo '<li class=" button-group"><a href="'.get_the_permalink(1383).'" title="" data-filter=".all" ' . $class . '>All</a></li>';
			}
			if ( ! empty( $all_terms ) && ! is_wp_error( $all_terms ) ){		
				foreach ( $all_terms as $myterm ) {
					$termname = strtolower($myterm->slug);
					$termID = strtolower($myterm->term_id);
				 //	echo '$termname: '.$termname;
					$page_link ='javascript:void(0)';
					if(get_field('page_link', $myterm->taxonomy . '_' . $myterm->term_id)){
						$page_link = get_field('page_link', $myterm->taxonomy . '_' . $myterm->term_id);
					}
					if ($category == $termname || strpos($cat, $termname) !== false) {
						$class = ' class="active"';
					} else {
						$class = "";
					}
					$termname = str_replace(' ', '-', $termname);
					if (is_array($productTerm) && !in_array($termID,$productTerm)){
						//echo $myterm->name;
						echo '<li><a href="'.$page_link .'" title="'. $myterm->name .'" data-filter=".' . $termname . '" ' . $class . ' >' . $myterm->name . '</a></li>';

					}else{
                        echo '<li><a href="'.$page_link.'" title="" data-filter=".' . $termname . '" ' . $class . ' >' . $myterm->name . '</a></li>';
                    }
				}
			}
			
			?>
			</ul>
		</div>
	
	<?php
	endif;
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		'no_found_rows'     =>   true,
);
	
	$taxQuery = array();

	
	if (is_array($productTerm)) {
		$taxQuery[] = array(
			'taxonomy' => 'tour_cat',
			"field" => "id",
			'terms' => $productTerm
		);
	}
	$args['tax_query'] = $taxQuery;
	if (is_admin()) {
		$args['posts_per_page'] = 3;
	}

	$wp_query = new WP_Query();
	$wp_query->query($args);
	$c = 0;
	$post_count = $wp_query->post_count;
	$random = rand(1000000, 10000000);

	?>
		<ul class="services services-grid list_posts">
            <?php
			
			while ($wp_query->have_posts()) :
				$wp_query->the_post();

				$term_links = "";
				$filter_tags = "";
				$terms = get_the_terms($post->ID, $tax);
				$links = array('all');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = $term->slug;
					}
				endif;
				$c++;
				
				$filter_tags = strtolower(join(" ", str_replace(' ', '-', $links)));
			
				?>
				<li class="item <?php echo $filter_tags; ?>">
					<div class="product item_inner anim	<?php echo "page-id-" . get_the_ID().'  '.get_post_type(); ?> ">
						<div class="card">
							<div class="bg-image anim abs">
								<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", '_sizes' => '100vw']); ?>
							</div>
						</div>
						<div class="match anim">
							<h4 class="subpage color"><?php echo get_the_title(); ?></h4>
							<div class="teaser">
								<?php if (get_field('teaser')) {
									echo  get_field('teaser');
								}
								?>
							</div>
						</div>
						<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only">Find out more about <?php echo get_the_title(); ?></span></a>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
	<?php
	wp_reset_query(); ?>
	</div>
</section>
<?php 

if (!is_admin() &&  $post_count != 0) :
	ob_start(); ?>
	
		var $container = $('#<?php echo $id; ?> .list_posts');
		//var $container = $('.list_posts');
		//console.log('container: '+ $container);
		<?php

		if ($cat != '') {
			$filter = $cat;
		} else {
			$filter = '.' . strtolower(str_replace(' ', '-', $category));
		}
// <?php echo $filter  ?
?> 		
		$container.isotope({
			layoutMode: 'fitRows',
			filter: '<?php echo $filter  ?>',
			itemSelector: '.item'
		});
		$container.imagesLoaded().progress(function() {
			$container.isotope('layout');
		});

		function onArrange() {
			
			AOS.refresh();
			
		}
		// bind event listener
		$container.on( 'arrangeComplete', onArrange );
<?php 
	if(get_sub_field('activate_filters')): 
?>
		// filter items when filter link is clicked
		$('#<?php echo $id; ?> .main.filters a').click(function(event) {

			console.log('container: '+ $container);
			$('#<?php echo $id; ?> .main.filters a.active').removeClass('active');
			$(this).addClass('active');
			// $('#<?php echo $id; ?> a.reset').trigger('click');

			var selector = $(this).attr('data-filter');
			console.log("selector: " + selector);
			filters = [selector];
			$container.isotope({
				layoutMode: 'masonry',
				filter: selector,
				animationEngine: "css"
			});
			return false;
		});
	<?php 
	 endif;
	/*
		
		$("a.reset").on("click",function(event){
			event.preventDefault();
			$(this).hide();
			//$container.find('li').removeClass('hidden');
			$container.find('li').removeClass('hidden');
			$container.isotope();
			return false;
		});
	*/
		

	?>
<?php
	$myScripts .= ob_get_clean();
endif;