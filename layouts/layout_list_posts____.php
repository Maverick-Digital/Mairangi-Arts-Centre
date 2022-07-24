<?php
global $post;
if (get_sub_field('id')) {
	$id = "id='" . get_sub_field('id') . "'";
} else {
	$id = "";
}
if (get_sub_field('class') && get_sub_field('class') != "") {
	$xclass =  get_sub_field('class');
} else {
	$xclass =  "pad-bot-40";
}
$post_type = get_sub_field("post_type");
if (isset($_GET["category"])) {
	$category = strtolower($_GET["category"]);
} else {
	$category = "all";
}

$myterms = array();

if ($post_type == "bathing") {
	$cat_array = get_sub_field('bath_cat');
} else if ($post_type == "post") {
	$cat_array = get_sub_field('post_cat');
} else if ($post_type == "retreat_product") {
	$cat_array = get_sub_field('retreat_cat');
} else if ($post_type == "work") {
	$cat_array = get_sub_field('work_category');
}

if ($cat_array) {
	$cat = ' .' . $cat_array->slug;
	$myterms[] = $cat_array->term_id;
} else {

	$cat = "." . $category;
}






//foreach( $cat_array as $term ): 
//echo $term;

//endforeach; 

//print_r($myterms);
//echo get_sub_field('show_filter_bar') ;
?>
<section class="layer single_column <?php echo $xclass; ?>">
	<?php if (get_sub_field('content')) {
		echo get_sub_field('content');
	}
	if (!is_front_page()) : ?>
		<div class="blog-filter list_posts pad-top-20 pad-bot-40">
			<ul class="main filters <?php if (get_sub_field('show_filter_bar') != 1) { echo "hidden";} ?>">
			<?php

				$customPostTaxonomies = get_object_taxonomies($post_type);
				if (count($customPostTaxonomies) > 0) {
					foreach ($customPostTaxonomies as $tax) {
						$args = array(
							'orderby' => 'name',
							'show_count' => 0,
							'pad_counts' => 0,
							'hierarchical' => 1,
							'taxonomy' => $tax,
							'title_li' => '',
							'echo' => 1
						);
						//  wp_list_categories( $args );
					}
				}
				$terms = get_terms($tax);
				$count = count($terms);
				if ($category == "all") {
					$class = ' class="active button"';
				} else {
					$class = ' class="button"';
				}
				// $grid.isotope({ filter: '.metal:not(.transition)' });
				echo '<li data-aos="fade-in" data-aos-duration="300"><a href="javascript:void(0)" title="" data-filter=".all" ' . $class . '>All</a></li>';
				$c = 0;
				if ($count > 0) {
					foreach ($terms as $term) {
						//print_r($term);
						$termname = strtolower($term->slug);
						if ($category == $termname || strpos($cat, $termname) !== false) {
							$class = ' class="active button ' . $termname . '"';
						} else {
							$class = ' class="button ' . $termname . '"';
						}

						$termname = str_replace(' ', '-', $termname);
						$c += 100;
						//.'&nbsp;(' . $term->count . ')'
						echo '<li data-aos="fade-in" data-aos-duration="300" data-aos-delay="' . $c . '"><a href="javascript:void(0)" title="" data-filter=".' . $termname . '" ' . $class . ' >' . $term->name . '</a></li>';
					}
				}
				?>
			</ul>
		</div>
	<?php endif; ?>
	<?php
	$parent = get_sub_field('parent_page');
	$paged = get_query_var('paged');
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		//'post_parent'    =>  $parent,
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
	);
	if (is_front_page()) {
		$args['posts_per_page'] = 6;
	} else {
		$args['posts_per_page'] = -1;
	
	}

	if ($post_type == 'work') {
		if (get_sub_field('work_category')) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'work-categories',
					"field" => "id",
					'terms' => get_sub_field('work_category'),
				),
			);
		}
	}
	//print_r($args)
	$wp_query = new WP_Query();
	$wp_query->query($args);
	$count = 0;
	$post_count = $wp_query->post_count;
	$random = rand(1000000, 10000000);
	?>
	<div id="section<?php echo $random; ?>" class="count-<?php echo $post_count; ?> ">
		<ul class="casestudies list_posts">
			<?php
			while ($wp_query->have_posts()) :
				$wp_query->the_post();
				if (get_post_thumbnail_id()) {
					//$bgImage =  wp_get_attachment_image_src(get_post_thumbnail_id(), "full", false ); 
					$bgImage =  fly_get_attachment_image_src(get_post_thumbnail_id(), array(1920, 1100), true);
					$bg = 'style="background-image:url(' . $bgImage["src"] . ')"';
				}
				if (get_field("excerpt")) {
					$sentence = get_field("excerpt");
				} else {
					$content      = get_the_content();
					//$content = strip_shortcodes( $content );
					$superCleaned = strip_tags($content); //No HTML Tags
					$sentence = preg_split('/(\.|!|\?)\s/', $superCleaned, 2, PREG_SPLIT_DELIM_CAPTURE);
					$sentence = strip_shortcodes($sentence['0']);
				}
				if ($alternate == "right") {
					$alternate = "left";
				} else {
					$alternate = "right";
				}
				$term_links = "";
				$filter_tags = "";
				//	echo "tax: ".$tax."<br/>";
				$terms = get_the_terms($post->ID, $tax);
				$links = array('all');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = $term->slug;
						//echo $term->name;
					}
				endif;

				$filter_tags = strtolower(join(" ", str_replace(' ', '-', $links)));

			?>

				<?php
				$c = 5;




				//$term_list = wp_get_post_terms(get_the_ID(), 'work-categories', array("fields" => "names"));
				$getcat = wp_get_post_terms(get_the_ID(), 'work-categories');

				$categoryTitles = array();
				foreach ($getcat as $gotcat) {

					$category .=  ' ' . $gotcat->slug; // Added a space between the slugs with . ' '
					$categoryTitles[] = '<a href="' . get_the_permalink('231') . '?category=' . $gotcat->slug . '">' . $gotcat->name . '</a>';
					//break;
				}
				// print_r($categoryTitles);
				// echo $cat;
				?>
				<li class="item <?php echo $filter_tags; ?>">
					<div class="item_inner anim">
						<div class="card anim">
							<a href="<?php echo get_the_permalink(); ?>" style="display:block;">
								<?php
								echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
							</a>
						</div>
						<div class="title anim grid">
							<h3 class='subpage anim_slow'><?php the_title() ?></h3>
							<p class="meta"><?php echo implode(', ', $categoryTitles); ?></p>
						</div>
						<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"></a>
					</div>
				</li>
				<?php

				$c++;
				?>

				<?php /*
		<div class="layer layout_2col_images clearfix  light style-<?php echo get_the_id(); ?> <?php echo ' '.$filter_tags; ?>"> 
			<div class="abs bg_color  " <?php //echo $bg; ?> ><?php
				echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["class" => "cover anim", 'sizes' => '100vw' ]); ?>
			</div>
			<div class="inner <?php echo $alternate; ?> clearfix">
				<div class="grid column-2">
					<div class="col textwrap pad-top-140 pad-bot-140" >
						<div class="_inner" data-aos="fade-up" data-aos-duration="700">
						<h3 class="larger" ><?php the_title(); ?></h3>
						<p class="teaser" ><?php echo $sentence; ?></p>
						<p><a href="<?php echo get_the_permalink(); ?>/" class="button">View Project</a></p>
						</div>
					</div>
					<div class="col imgwrap"></div>
				</div>
				<a href="<?php echo get_the_permalink(); ?>" class="link-overlay"></a>
			</div>
		</div>
		*/ ?>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php
	wp_reset_query();
	?>
</section>
<script>
	jQuery(function($) {
		console.log('here');
		var $container = $('#section<?php echo $random; ?> ul');
		$container.imagesLoaded().progress(function() {
			$container.isotope('layout');
		});
		//$container.layout();	
		<?php

		if ($cat != '') {
			$filter = $cat;
		} else {
			$filter = '.' . strtolower(str_replace(' ', '-', $category));
		}

		?>
		$container.isotope({
			layoutMode: 'fitRows',
			filter: '<?php echo $filter  ?>',
			itemSelector: '.item'
		});

		// filter items when filter link is clicked
		$('.main.filters a').click(function(event) {


			$('.main.filters a.active').removeClass('active');
			$(this).addClass('active');
			var selector = $(this).attr('data-filter');
			if (selector == ".for-sale") {
				$('.price.filters').slideDown();
			} else {
				$('.price.filters a.active').removeClass('active');
				$('.price.filters a.clearprice').addClass('active');
				priceFilter = [];
				$('.price.filters').slideUp();
			}

			filters = [selector];
			$container.isotope({
				layoutMode: 'fitRows',
				filter: selector,
				animationEngine: "css"
			});
			/*
			setTimeout(function() {
				console.log('layout');
				$container.isotope('layout');
				scroll.update();

			}, 1000);
			*/


			//console.log($container);
			//console.log(filters.join(''));
			return false;

		});



		// Put the following code after isotope js include
		// Override and customize Isotope FitRows layout mode: CENTER each rows

	});
</script>