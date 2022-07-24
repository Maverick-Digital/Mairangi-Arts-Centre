<h4>Example Triple Select Dropdown list</h4>
<!-- The first select list -->

I want to
<select id="slist1" name="slist1">
	<option selected value="kayak">Kayak</option>
	<option value="walk">Walk</option>
</select>
 through Abel Tasman 
<select id="slist2" name="slist2">
	<option selected value="with">with a guide</option>
	<option value="without">without a guide</option>
</select>
with
<select id="slist3" name="slist3">
	<option selected value="1">1</option>
	<option selected value="2">2</option>
	<option selected value="3">3</option>
	<option selected value="4">4</option>
	<option selected value="5">5</option>
	<option selected value="5+">5+</option>
</select>
others

<a class="get_select button">GO</a>
<div id="scontent"></div>

<script>


jQuery("a.get_select").on( "click", function(event) {

		event.preventDefault;
		console.log(jQuery('#slist1').val());
		console.log(jQuery('#slist2').val());
		console.log(jQuery('#slist3').val());


		return false;
});
</script>



<?php
if (isset($_POST['tour-type'])) {
	$types  =  explode(',', $_POST['product-type']);
} else {
	$types = [];
}
if (isset($_POST['tour-length'])) {
	$lengths  =  explode(',', $_POST['product-category']);
} else {
	$lengths = [];
}


$productType = array();
$productCategory = array();
$productTag = array();



?>


<div id="options" class="clearfix">


	<div class="option-set wrapper-dropdown-4" data-group="type">
		<?php
		$term = "product-type";
		$terms = get_terms($term, array('hide_empty' => true));
		$count = count($terms);
		if ($count > 0) { ?>
			<ul class="dropdown">
				<li><input type="checkbox" value="" id="type-all" class="all" checked /><label for="type-all">all types</label></li>
				<?php
				foreach ($terms as $term) {
					$checked = '';
					$termname = $term->slug;
					$productType[] = 't_' . $termname;
					if (in_array($termname, $types)) {
						$checked = 'checked';
					}
					echo '<li><input type="checkbox" id="' . $termname . '" name="' . $termname . '" value=".' . $termname . '"  ' . $checked . '><label for="' . $termname . '">' . $term->name . '</label></li>';
				} ?>
			</ul>
		<?php
		}
		?>
	</div>
	<div class="option-set wrapper-dropdown-4" data-group="category">
		<?php
		$term = "product-category";
		$terms = get_terms($term, array('hide_empty' => true));
		$count = count($terms);
		if ($count > 0) { ?>
			<ul class="dropdown">
				<li><input type="checkbox" value="" id="category-all" class="all" checked /><label for="category-all">all categories</label></li>
				<?php
				foreach ($terms as $term) {
					$checked = '';
					$termname = 'c_' . $term->slug;
					$productCategory[] = $termname;
					if (in_array($termname, $types)) {
						$checked = 'checked';
					}
					echo '<li><input type="checkbox" id="' . $termname . '" name="' . $termname . '" value=".' . $termname . '"  ' . $checked . '><label for="' . $termname . '">' . $term->name . '</label>';
				} ?>
			</ul>
		<?php
		}
		?>
	</div>
	<div class="option-set wrapper-dropdown-4" data-group="tags">

		<?php
		$term = "product-tags";
		$terms = get_terms($term, array('hide_empty' => true));
		$count = count($terms);
		if ($count > 0) { ?>
			<ul class="dropdown">
				<li><input type="checkbox" value="" id="tags-all" class="all" checked /><label for="tags-all">all tags</label></li>
				<?php
				foreach ($terms as $term) {
					$checked = '';
					$termname = 't_' . $term->slug;
					$productTag[] = $termname;
					if (in_array($termname, $types)) {
						$checked = 'checked';
					}
					echo '<li><input type="checkbox" id="' . $termname . '" name="' . $termname . '" value=".' . $termname . '"  ' . $checked . '><label for="' . $termname . '">' . $term->name . '</label></li>';
				} ?>
			</ul>
		<?php
		}
		?>
	</div>
</div>
<div class="wrapper-dropdown-4 actions"> <a href="javascript:void(0)" class="button alt find">Inspire Me</a> <a href="javascript:void(0)" class="reset">reset</a></div>

<?php
// <p id="filter-display"></p>
?>

<?php
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => -1,
);


$wp_query = new WP_Query();
$wp_query->query($args);
$c = 0;
$post_count = $wp_query->post_count;
$random = 'list_posts'; //rand(1000000, 10000000);

?>
<div id="section<?php echo $random; ?>" class="count-<?php echo $post_count; ?> " style="position:relative;">

	<div class="inner inner-wider">



		<ul class="casestudies list_posts">
			<?php

			while ($wp_query->have_posts()) :
				$wp_query->the_post();

				$term_links = "";
				$filter_tags = "";
				$terms = get_the_terms($post->ID, 'product-type');
				$links = array('all');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = 't_' . $term->slug;
					}
				endif;
				$terms = get_the_terms($post->ID, 'product-category');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = 'c_' . $term->slug;
					}
				endif;
				$terms = get_the_terms($post->ID,  'product-tag');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = 't_' . $term->slug;
					}
				endif;


				/*
				$c++;
				if(is_front_page()){
					if($c > 3){$links[] = 'hidden';}
				}else{
					if($c > 6){$links[] = 'hidden';}
				}
				*/

				$filter_tags = strtolower(join(" ", str_replace(' ', '-', $links)));

			?>

				<li class="item <?php echo $filter_tags; ?> <?php echo productGetType($post->ID); ?>">
					<article class="product item_inner">
						<div class="image_card anim">
							<a href="<?php echo get_the_permalink(); ?>" style="display:block;">
								<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
							</a>
							<?php echo productIsSpecial($links); ?>
							<div class="cat_tag">
								<h5 style="margin:0; padding:0; display:inline-block;">CATEGORIES</h5>
								<?php echo productGetCategoryTags($post->ID); ?><br />
								<h5 style="margin:0; padding:0;display:inline-block;">TAGS</h5>
								<?php echo productGetTags($post->ID); ?>
							</div>
						</div>
						<div class="title">

							<h4 class="barlow"><?php echo productGetTypeDescription($post->ID); ?></h4>
							<h3 class="subpage"><?php the_title() ?></h3>
							<div class="teaser"><?php echo get_field("short_description"); ?></div>
							<div class="details grid grid-between">
								<?php if (get_field('price')) : ?>
									<div class="col col_price">
										<h4 class="barlow">Price</h4>
										<p><?php echo (get_field('price')) ? get_field('price') : "<sup>*</sup>$@@pp"; ?></p>
									</div>
								<?php endif; ?>
								<?php if (get_field('duration')) : ?>
									<div class="col col_duration">
										<h4 class="barlow">Duration</h4>
										<p><?php echo (get_field('duration')) ? get_field('duration') : "<sup>*</sup>@ days"; ?></p>
									</div>
								<?php endif; ?>
								<?php //if(get_field('price')): 
								?>
								<div class="col col_action col-middle">
									<?php echo do_shortcode('[add_booking_but style="yellow" ]'); ?>
								</div>
								<?php // endif; 
								?>
							</div>
						</div>
						<?php /*
						<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"></a>
*/ ?>
					</article>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php if ($post_count > 3) { ?>
			<div class="load-more-wrapper clearfix center pad-top-20 pad-bot-default">
				<a href="javascript:void(0)" class="button reset load">View all products</a>
			</div>
		<?php } ?>

	</div>
</div>
<?php
wp_reset_query();
?>
</section>
<script>
	var $container;
	var filters = {};
	jQuery(function($) {
		$container = $('.casestudies.list_posts');
		var $filterDisplay = $('#filter-display');
		$container.isotope();

		function onArrange() {
			AOS.refresh();
		}
		// bind event listener
		$container.on('arrangeComplete', onArrange);

		// do stuff when checkbox change
		$('#options').on('change', function(jQEvent) {
			var $checkbox = $(jQEvent.target);
			manageCheckbox($checkbox);

			var comboFilter = getComboFilter(filters);

			$container.isotope({
				filter: comboFilter
			});

			$filterDisplay.text(comboFilter);
		});

	});

	var data = {
		// brands: '<?php explode($productType, ' '); ?>'.split(' '),
		productTypes: '<?php explode($productType, ' '); ?>'.split(' '),
		productCategories: '<?php explode($productCategories, ' '); ?>'.split(' '),
		productTags: '<?php explode($productTags, ' '); ?>'.split(' ')
	};

	function createContent() {
		var brand, productType, productCategory, productTag;
		var items = '';
		// dynamically create content
		// for (var i=0, len1 = data.brands.length; i < len1; i++) {
		//  brand = data.brands[i];

		for (var j = 0, len2 = data.productTypes.length; j < len2; j++) {
			productType = data.productTypes[j];
			for (var l = 0, len3 = data.productCategories.length; l < len3; l++) {
				productCategory = data.productCategories[l];
				for (var k = 0, len4 = data.productTags.length; k < len4; k++) {
					productTag = data.productTags[k];
					var itemHtml = '<div class="item ' + brand + ' ' +
						productType + ' ' + productCategory + ' ' + productTag + '">' +
						'<p>' + brand + '</p>' +
						'<p>' + productType + '</p>' +
						'<p>' + productTag + '</p>' +
						'</div>';
					items += itemHtml;
				}
			}
		}

		// }

		$container.append(items);
	}


	function getComboFilter(filters) {
		var i = 0;
		var comboFilters = [];
		var message = [];

		for (var prop in filters) {
			message.push(filters[prop].join(' '));
			var filterGroup = filters[prop];
			// skip to next filter group if it doesn't have any values
			if (!filterGroup.length) {
				continue;
			}
			if (i === 0) {
				// copy to new array
				comboFilters = filterGroup.slice(0);
			} else {
				var filterSelectors = [];
				// copy to fresh array
				var groupCombo = comboFilters.slice(0); // [ A, B ]
				// merge filter Groups
				for (var k = 0, len3 = filterGroup.length; k < len3; k++) {
					for (var j = 0, len2 = groupCombo.length; j < len2; j++) {
						filterSelectors.push(groupCombo[j] + filterGroup[k]); // [ 1, 2 ]
					}

				}
				// apply filter selectors to combo filters for next group
				comboFilters = filterSelectors;
			}
			i++;
		}

		var comboFilter = comboFilters.join(', ');
		return comboFilter;
	}

	function manageCheckbox($checkbox) {
		var checkbox = $checkbox[0];

		var group = $checkbox.parents('.option-set').attr('data-group');
		// create array for filter group, if not there yet
		var filterGroup = filters[group];
		if (!filterGroup) {
			console.log('no filter group');
			filterGroup = filters[group] = [];
		}

		var isAll = $checkbox.hasClass('all');

		// reset filter group if the all box was checked
		if (isAll) {
			delete filters[group];
			if (!checkbox.checked) {
				checkbox.checked = 'checked';
			}
		}
		// index of
		var index = jQuery.inArray(checkbox.value, filterGroup);

		if (checkbox.checked) {
			var selector = isAll ? 'input' : 'input.all';
			console.log("here" + selector);
			console.log($checkbox.parents('.option-set').find(selector));
			//$checkbox.siblings( selector ).removeAttr('checked');
			$checkbox.parents('.option-set').find(selector).removeAttr('checked');
			checkbox.checked = 'checked';
			if (!isAll && index === -1) {
				// add filter to group
				filters[group].push(checkbox.value);
			}

		} else if (!isAll) {
			// remove filter from group
			filters[group].splice(index, 1);
			console.log("all clicked");
			console.log($checkbox.parents('.option-set').find('[checked]').length);
			// if unchecked the last box, check the all
			if (!$checkbox.parents('.option-set').find('[checked]').length) {

				$checkbox.parents('.option-set').find('input.all').attr('checked', 'checked');

			}
		}

	}
</script>
<?php /*
	<br/>
	<div class="layer filterbar clearfix">
	<div class="inner clearfix">	
			<div id="dd" class="wrapper-dropdown-4 drop"><p>Type</p>
				<ul class="dropdown" >
					<?php
					 $term="product-type";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
							$checked ='';
							$termname = $term->slug;

							if(in_array($termname,$types)){
									$checked = 'checked';
							}
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'"  '.$checked.'><label for="'.$termname.'">'.$term->name.'<span></span></label></li>';

							//echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'">'.$term->name.'</a></li>';
						}
					}
					?>
				</ul>
			</div>
			<div id="dd2" class="wrapper-dropdown-4 drop"><p>Category</p>
				<ul class="dropdown" >
					<?php
					 $term="product-category";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						if(in_array($termname,$lengths)){
								$checked = 'checked';
							}
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'><label for="'.$termname.'">'.$term->name.'<span></span></label></li>';
						}
					}
					?>
				</ul>
			</div>
			<div id="dd3" class="wrapper-dropdown-4 drop"><p>Tags</p>
				<ul class="dropdown" >
					<?php
					 $term="product-tags";

					$terms = get_terms($term,array( 'hide_empty' => true));
					$c =0;
					$count = count($terms);
					// $grid.isotope({ filter: '.metal:not(.transition)' });
					// echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
					if ( $count > 0 ) {
						foreach ( $terms as $term ) {
						$termname = $term->slug;
						$checked ='';
						if(in_array($termname,$lengths)){
								$checked = 'checked';
							}
								echo '<li><input type="checkbox" id="'.$termname.'" name="'.$termname.'" value="'.$termname.'" '.$checked.'><label for="'.$termname.'">'.$term->name.'<span></span></label></li>';
						}
					}
					?>
				</ul>
			</div>
			<div class="wrapper-dropdown-4 action">
			<a href="javascript:void(0)" class="button find"> Submit</a>
			</div>
	</div>
</div>
<script>

</script>
*/
