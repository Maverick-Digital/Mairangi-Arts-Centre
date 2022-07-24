
<?php
global $post;
global $myScripts;
?>
<section class="layer blog  article post content">
	<div class="inner inner-1170">
			<?php
			$currentPage = get_the_ID();
			$posttype = 'post';
			$term="post-category";
		//if($currentPage==6 || $currentPage==19) {
		/*
		DISABLE FILTERS  NOT MNEEDED YET 	?>
		<div class="filter clearfix">
				<ul class="main filters" >
			
				<?php
		$terms = get_categories();
		$count = count($terms);
		// $grid.isotope({ filter: '.metal:not(.transition)' });
		echo '<li class=" button-group"><a href="javascript:void(0)" title="" data-filter=".all" class="active button ">All</a></li>';
		if ( $count > 0 ) {
			foreach ( $terms as $term ) {
				//print_r($term);
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				//.'&nbsp;(' . $term->count . ')'
				echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'" class="button">'.$term->name.'</a></li>';
			}
		}
		?>
			</ul>
			</div>
			<?php
	// }   */
	?>          		
	<ul id="blog-isotope" class="services services-grid list_posts load-posts clearfix" style="min-height:200px;">
	<?php 
	//'posts_per_page=6' . '&paged='.$paged);
	$wp_query = new WP_Query(); 			
	$paged = get_query_var('paged');
	$wp_query = new WP_Query(); 
	$args = array(
		'post_type'      => 'post',
	// 'order'          => 'ASC',
	// 'orderby'        => 'menu_order',
		'posts_per_page' => 8,
		'paged' => $paged,
		);
		
	$wp_query->query($args);
	$post_count = wp_count_posts()->publish;
	$count =2;
	while ($wp_query->have_posts()) : 
		$wp_query->the_post();

	$count ++;
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
			foreach (get_the_tags() as $tag){
				//	if($tags==""){$tags = "<i class='icon icon-tag' > </i> "; }
				$tags .= "<a   class=' icon-tag' href='".get_tag_link($tag->term_id)."'>".$tag->name."</a>";
			}
		}
		
		
	?><li class="item anim <?php echo $filter_tags; ?>">
	<div class="product item_inner anim	<?php echo "page-id-" . get_the_ID().'  '.get_post_type(); ?> ">
		<div class="card">
			<div class="bg-image anim abs">
				<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'medium', "", ["class" => "cover anim"]); ?>
			</div>
		</div>
		<div class="match anim">
			<h4 class="subpage color"><a href='<?php echo get_the_permalink(); ?>'><?php echo get_the_title(); ?></a></h4>
			<div class="teaser">
				<?php
				echo get_excerpt(300);
				?>
			</div>
		</div>
		
			<?php  if (get_post_type() != 'tour_tiles'){ 
				// 	<a class="button alt small center" href="/contact-us">Enquire Now</a>
				?>
			<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only">Read more about <?php echo get_the_title(); ?></span></a>

			<?php }else{  ?>

			<a class="link-overlay" href="<?php echo get_the_permalink(1383); ?>" style="display:block;"><span class=" sr-only">Read more about <?php echo get_the_title(); ?></span></a>
		<?php 	} ?>
	</div>
</li><?php

	endwhile;
	wp_reset_query();
	?>

</ul>
			<?php
			//	echo "post_count: ".$post_count;

			if($post_count >6 && !is_front_page()){ 
			//	echo "post_count: ".$post_count;
				?>
			<br/>
			<div class="load-more-wrapper clearfix center">
				<a href="#" data-page="1" data-ppp="8" class="button load-more">Load more</a>
			</div>	
			<?php }else{ /* ?>
				<br/>
			<div class="load-more-wrapper clearfix center">
				<a href="<?php echo get_the_permalink(27); ?>" class="button green">Discover more</a>
			</div>
			<?php */
			 } ?>
		</div>
	</section>
<?php 
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
