<?php
global $post;
global $myScripts;


$sizeL =   array(2560, 2560);
$size =   array(1400, 900);
$crop = true;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');



$custom_tax = get_sub_field('custom_tax');
$custom_term = get_sub_field('custom_term');


$post_type = get_sub_field("custom_posttype");
$custom_tax = get_sub_field('custom_tax');
$custom_term = get_sub_field('custom_term');
$posts_per_page = 6;
if(get_sub_field('posts_per_page')){
	$posts_per_page = get_sub_field('posts_per_page');
}
//var_dump($custom_term);
//echo "<br/>post_type:".print_r($post_type)."  ".$post_type[0]." <br/>";
//echo "<br/>custom_tax:".print_r($custom_tax)."   ";//.$custom_tax."<br/>";
//echo "<br/>custom_term:".print_r($custom_term)."  ";//.$custom_term."<br/>";
//echo "<br/>custom_term :".print_r($custom_term)."  ";//.$custom_term."<br/>";




$all_terms = get_terms(array(
	'taxonomy' => $custom_tax,
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
$cat_array = get_sub_field('custom_tax');
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
					if (is_array($custom_term) && !in_array($termID,$custom_term)){
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

	$paged = get_query_var('paged');

	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
		// 'no_found_rows'     =>   true,
);
	
	$taxQuery = array();
	if ($custom_term) {
		$taxQuery[] = array(
			'taxonomy' => $custom_tax[0],
			"field" => "name",
			'terms' => $custom_term->name,
		);
	}
	$args['tax_query'] = $taxQuery;
	if (is_admin()) {
		$args['posts_per_page'] = 3;
	}

	$wp_query = new WP_Query();
	$wp_query->query($args);
	$c = 0;
	$post_count = $wp_query->found_posts;
	//var_dump($wp_query);

	$random = rand(1000000, 10000000);
	// echo "post_count: ".$post_count;

	?>
		<ul class="services services-grid list_posts load-posts count-<?php echo $post_count; ?> <?php echo $xclass; ?>">
            <?php
			
			while ($wp_query->have_posts()) :
				$wp_query->the_post();

				$term_links = "";
				$filter_tags = "";
				//print_r($custom_tax);

				$terms = get_the_terms($post->ID, $custom_tax[0]);
				//print_r($terms );
				$links = array('all');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = $term->slug;
					}
				endif;
				$c++;
				
				$filter_tags = strtolower(join(" ", str_replace(' ', '-', $links)));
			
				$labels = array_shift($links);
				
				$filter_labels = "<span class='tag'>".implode("</span> <span class='tag'>",$links)."</span>";
			
				?>
				<li class="item <?php echo $filter_tags; ?>"> 
				<?php // print_r($terms ); ?>
					<div class="product item_inner anim	<?php echo "page-id-" . get_the_ID().'  '.get_post_type(); ?> ">
						<div class="card">
							<div class="bg-image anim abs">
							
								<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", '_sizes' => '100vw']); ?>
								
							</div>
							<div class="tags abs">
							<?php echo $filter_labels; ?>
							</div>
							<div class="title grid grid-nogutter anim abs">
								<?php if (get_post_type() == 'tour_tiles'){ ?>
								<a class="button alt small center" href="/contact-us">Enquire Now</a>
								<?php } ?>
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
							<?php  if (get_post_type() != 'tour_tiles'){ 
								// 	<a class="button alt small center" href="/contact-us">Enquire Now</a>
								?>
							<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only">Find out more about <?php echo get_the_title(); ?></span></a>

							<?php }else{  ?>

							<a class="link-overlay" href="<?php echo get_the_permalink(321); ?>" style="display:block;"><span class=" sr-only">Enquire about <?php echo get_the_title(); ?></span></a>
						<?php 	} ?>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php
			//	echo "post_count: ".$post_count;

			if($post_count > 6){ 
			//	echo "post_count: ".$post_count;
				?>
			<br/>
			<div class="load-more-wrapper clearfix center">
				<a href="#" data-page="1" data-ppp="<?php echo $posts_per_page; ?>" class="button load-more">Load more</a>
			</div>	
			<?php }else{ /* ?>
				<br/>
			<div class="load-more-wrapper clearfix center">
				<a href="<?php echo get_the_permalink(27); ?>" class="button green">Discover more</a>
			</div>
			<?php */
			 } ?>
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
		//console.log('cat: ' + <?php echo $cat; ?>);		
		<?php

		if ($cat != '') {
			$filter = $cat;
		} else {
			$filter = '.' . strtolower(str_replace(' ', '-', $category));
		}
 //echo "// ".$filter ;
?> 		
//console.log('cat: ' + <?php echo $cat; ?>);
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
	if(get_sub_field('show_filter_bar')): 
?>
		// filter items when filter link is clicked
		$('#<?php echo $id; ?> .blog-filter a[data-filter]').click(function(event) {

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

if(!is_admin()):
 ob_start(); ?>
	
	//Global URL string needs to remove ? and # after last slash 
	var url = window.location.href;
	url = url.substr(0, url.lastIndexOf("/"));
	//Ajax load more posts
	$('.load-more[data-page]').click(function(event){

		console.log(url);

		event.preventDefault();
		var articleWrapper = '.load-posts'; //this must exist
		if( $(articleWrapper).length == 0 ){

			alert('"'+articleWrapper+'" not found');

		}
		else{

			if( !$(this).hasClass('loading') ){

				//update loading button class and text
				$(this).addClass('loading').text('Loading...');

				//get page number to ajax new posts
				var pageNumber = parseInt( $(this).attr('data-page') ) + 1;
				var postsPerPage = $(this).attr('data-ppp');
				var link = url + "/page/" + pageNumber;
					
					console.log( pageNumber + ' ' + postsPerPage + ' ' + link );
				var searchterm = getUrlParameter('s');
				
				if(searchterm) {
					link = link + '?s=' + searchterm;
				}

				//console.log(link);

				$.get( link, function(data){
				  	
				  	//setup data attribute
				  	var $div = $('<div></div>');
				  	$(data).appendTo($div);
				  	var html = $div.find(articleWrapper).html();
				  	//amount of posts return was less than ppp
				  	console.log("blog.js");
				  	console.log($div.find('article').length);
				  	console.log( $div.find('.load-posts > article').length);
				  	if( $div.find('article').length < postsPerPage ){
				  	
		
				  	
				  		//hide load more button
				  		$('a.load-more[data-page]').removeClass('loading').text('No more posts');
				  		$('a.load-more[data-page]').css('pointer-events', "none");
				  		$('a.load-more[data-page]').css('opacity', ".5");

				  		setTimeout(function(){ $('a.load-more[data-page]').remove(); }, 5000);

				  		console.log('No more posts available');

				  	}
				  	else{

						//update load button
						$('a.load-more[data-page]').attr('data-page',pageNumber).removeClass('loading').text('Load more'); //update load number


					}

					//add new html
					var displayType = $('a.load-more').attr('data-display');
					console.log(displayType);
					if(displayType == "flickity" ){
				
						$('.flickity-slider').append( html );
						// $('.main-carousel').flickity( 'append', $html );
						//  $('.main-carousel').flickity('resize');
						$('.main-carousel').flickity('reloadCells');
						var $carousel = $('.main-carousel').flickity();
						var flkty = $carousel.data('flickity');
						console.log( flkty.selectedIndex, flkty.selectedElement );
						$('.main-carousel').flickity( 'select', (flkty.cells.length - postsPerPage) );
						
						

					}else{
						$(articleWrapper).append( html );
						$container.isotope('reloadItems');
				$container.isotope();
						AOS.init({
						  offset: 200,
						  duration: 600,
						  easing: 'ease-in-sine',
						  delay: 100,
						});
					}


				
				
				
				/*  	
				var $container = $('#portfolio');
				$container.append( html );
				
				$container.isotope('reloadItems');
				$container.isotope();
				setTimeout(function() {
					$('#portfolio').isotope('layout');
				}, 120);

				  	*/

				}).fail(function() {
				    
				    //page doesn't exist
					$('a.load-more[data-page]').removeClass('loading').text('No more posts');
					setTimeout(function(){ $('a.load-more[data-page]').remove(); }, 3000);
				    console.log('Failed to load posts from url: '+url);
				
				});

			}//no loading

		}//endif

	});
	
	<?php /*
	
	//Category and Archive Dropdown
	$('.blog-filter a[data-filter]').click(function(event){

		event.preventDefault();

		if( !$(this).hasClass('open') ){

			//slider others up first
			//$('.blog-filter .heading').removeClass('open');
			//$('.blog-filter ul.open').removeClass('open').slideUp();

		}

		//change the target element
		var target = '#'+$(this).attr('data-filter'); 
		$(this).toggleClass('open');

		$(target).slideToggle("slow");

	});
*/ ?>


	//http://stackoverflow.com/a/21903119
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
		return false;
	};
<?php
$myScripts .= ob_get_clean();
endif;