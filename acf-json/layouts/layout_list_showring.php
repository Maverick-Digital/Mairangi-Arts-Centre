<?php
global $post;
global $myScripts;

$post_type = 'shows';
$tax = 'show-category';
$productType = get_sub_field('custom_tax');
$productTerm = get_sub_field('custom_term');


$all_terms = get_terms(array(
	'taxonomy' => 'show-category',
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

$category = "all";
$myterms = array();
$cat_array = get_sub_field('productType');
$cat = "." . $category;
//echo "<H1>dd".$category."</h1>";
//echo "<H1>dd".$cat."</h1>";
?>
<section class="layer single_column <?php echo get_sub_field('class'); ?>">
<?php if (get_sub_field("content")) { ?>
		<div class="clearfix grid single_column">
			<div class="col inner inner-1170">
				<?php echo get_sub_field('content'); ?>

			</div>
		</div>
	<?php 	}
		

	if (get_sub_field('show_filter_bar')):
	 ?>
		<div class="blog-filter list_posts pad-bot-40">
			<ul class="main filters">
			<?php
			$class = "";
			if ($category == "all") {
				$class = ' class="active"';
			}
			if (get_sub_field('show_all_link')) {
				echo '<li class=" button-group"><a href="javascript:void(0)" title="" data-filter=".all" ' . $class . '>All</a></li>';
			}
			if ( ! empty( $all_terms ) && ! is_wp_error( $all_terms ) ){
				foreach ( $all_terms as $myterm ) {


					$termname = strtolower($myterm->slug);
					$termID = strtolower($myterm->term_id);

					if (is_array($productTerm) && !in_array($termID,$productTerm)){
							
						
					}else{
						
                        if ($category == $termname || strpos($cat, $termname) !== false) {
                            $class = ' class="active"';
                        } else {
                            $class = "";
                        }
                        $termname = str_replace(' ', '-', $termname);
                        echo '<li><a href="javascript:void(0)" title="" data-filter=".' . $termname . '" ' . $class . ' >' . $myterm->name . '</a></li>';
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

	if (is_array($productType)) {
		$taxQuery[] = array(
			'taxonomy' => 'show-category',
			"field" => "id",
			'terms' => $productType
		);
	}
	if (is_array($productTerm)) {
		$taxQuery[] = array(
			'taxonomy' => 'faq_tax',
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
	<div id="section<?php echo $random; ?>" class="showring count-<?php echo $post_count; ?> ">
		<div class="inner inner-900">
			
			<ul class="faq_list list_posts">
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
				$open='';
				$style='';
				if($c == 1){
					$open= "open";
					$style="style='display:block;'";
				}
				?>

				<li class="item <?php echo $filter_tags; ?>">
					<div class="question anim <?php echo $open; ?>"><strong><?php echo get_the_title(); ?></strong>
					<br/><?php echo get_sub_field('description'); ?> 
					<div class="hamburger hamburger--spring js-hamburger">
						<div class="hamburger-box">
						<div class="hamburger-inner"></div>
						</div>
					</div>
				</div>
					<div class="morecontent" <?php echo $style; ?> >
					<?php
						
					?>

						<div class="table-container-outer">
							<div class="table-container">
								<table class="showring_table">
									<thead>
										<tr>
											<th scope="col">Alpaca</th>
											<th scope="col">Class</th>
											<th scope="col">Result</th>
											<th scope="col">Championship</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										// Check rows exists.
										if( have_rows('results') ):
											while( have_rows('results') ) : the_row(); ?>
										<tr>

											<td scope="row" data-label="Alpaca" class="bg-gray"><?php echo get_sub_field('alpaca'); ?></td>
											<td data-label="SClass"><?php echo get_sub_field('class'); ?></td>
											<td data-label="SResult"><?php echo get_sub_field('result'); ?></td>
											<td data-label="SChampionship"><?php echo get_sub_field('championship'); ?></td>
										</tr>
										<?php 
											endwhile;
										endif; ?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
		
			
		</div>
	</div>
	<?php
	wp_reset_query();
	?>
</section>
<?php
if (!is_admin() &&  $post_count != 0) :
	ob_start(); ?>
	
		console.log('here');
		var $container = $('#section<?php echo $random; ?> ul');
		
		//$container.layout();	
		<?php

		if ($cat != '') {
			$filter = $cat;
		} else {
			$filter = '.' . strtolower(str_replace(' ', '-', $category));
		}

		?>
		$container.isotope({
			layoutMode: 'masonry',
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

		// filter items when filter link is clicked
		$('.main.filters a').click(function(event) {
			$('.main.filters a.active').removeClass('active');
			$(this).addClass('active');
			$("a.reset").trigger('click');

			var selector = $(this).attr('data-filter');
			filters = [selector];
			$container.isotope({
				layoutMode: 'masonry',
				filter: selector,
				animationEngine: "css"
			});
			return false;
		});
		
		$("a.reset").on("click",function(event){
			event.preventDefault();
			$(this).hide();
			//$container.find('li').removeClass('hidden');
			$container.find('li').removeClass('hidden');
			$container.isotope();
			return false;
		});
		


	$('body').on('click', '.question', function (event) {
     
			event.preventDefault();
			$(this).children('.hamburger').toggleClass('is-active');
			$(this).next().slideToggle('fast');
			$(this).toggleClass('open');
			setTimeout(function(){ 
				$container.isotope('layout');
				AOS.refresh(); }, 300);

			
			return false;
		});



	<?php
	$myScripts .= ob_get_clean();
endif;