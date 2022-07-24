<?php
if(is_front_page()):  ?>
	<section class="layer blog  article post content pad-top-default pad-bot-default">
		<div class="inner inner-1170">
			<div id="blog-panels" class="grid load-posts" style="min-height:200px; padding-bottom:2em;">

			<?php
			$currentPage = get_the_ID();
			$posttype = 'post';
			$term="post-category";
				
			//'posts_per_page=6' . '&paged='.$paged);
			$wp_query = new WP_Query(); 			
			$paged = get_query_var('paged');
			$wp_query = new WP_Query(); 
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'paged' => $paged,
				);
			$wp_query->query($args);
			
			while ($wp_query->have_posts()) : 
				$wp_query->the_post();
				$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
				if(!$image) {
				 	$image = fly_get_attachment_image_src(685, array( 650, 650 ), false );
				}
				$bgImage = $bg= "";
				if(get_post_thumbnail_id()){
					//$bgImage =  wp_get_attachment_image_src(get_post_thumbnail_id(), "full", false ); 
					$bgImage =  fly_get_attachment_image_src(get_post_thumbnail_id(),array( 1920, 1100 ), true );
					$bg = 'style="background-image:url('.$bgImage["src"].')"';
				}
			?>
				<article class="all portfolio-item blog-card">
		<div class="blog-card__wrap">
			<?php if($image) { ?>
			<div class="blog-card__image ">
				<div class="background-image bg-image" style="background-image:url(<?php echo $image['src']; ?>)"></div>
				<a class="abs" href="<?php echo get_the_permalink(); ?>">
				</a>
			</div>
			<?php } ?>
			<div class="blog-card__copy">
				<div class="ellipsis">
					<h4><a href="<?php echo get_the_permalink(); ?>" ><?php echo get_the_title(); ?></a></h4>
				</div>
				<div class="teaser "><?php the_excerpt(); ?></div>
				<div class="grid meta">
					<div class="date_time col"><span class="icon icon-clock"></span> <?php echo get_the_date(); ?> </div>
					<div class="post-count col text-right"><span class="icon icon-eye"></span> <?php echo getPostViews(get_the_ID()); ?></div>
				</div>
			</div>
		</div>
	</article>
				<?php
			endwhile;
			wp_reset_query();
			?>
			</div>
			<p style="text-align:center;"><a href="<?php echo get_the_permalink(24); ?>" class="button">Discover More</a></p>
		</div>
		</section>
<?php

else: 
	?>
	<section class="layer blog  article post content pad-top-0 pad-bot-default">
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
	<div id="blog-isotope" class="grid load-posts" style="min-height:200px;">
	<?php 
	//'posts_per_page=6' . '&paged='.$paged);
	$wp_query = new WP_Query(); 			
	$paged = get_query_var('paged');
	$wp_query = new WP_Query(); 
	$args = array(
		'post_type'      => 'post',
	// 'order'          => 'ASC',
	// 'orderby'        => 'menu_order',
		'posts_per_page' => 6,
		'paged' => $paged,
		);
		if(is_front_page()){
			$args['posts_per_page'] =3;
		
		}
	$wp_query->query($args);
	$count =2;
	while ($wp_query->have_posts()) : 
		$wp_query->the_post();
	$post_count = $wp_query->post_count;
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
		$image = fly_get_attachment_image_src( get_post_thumbnail_id(), array( 650, 650 ), false );
				if(!$image) {
				 	$image = fly_get_attachment_image_src(685, array( 650, 650 ), false );
				}
		$bgImage = $bg= "";
		if(get_post_thumbnail_id()){
			//$bgImage =  wp_get_attachment_image_src(get_post_thumbnail_id(), "full", false ); 
			$bgImage =  fly_get_attachment_image_src(get_post_thumbnail_id(),array( 1920, 1100 ), true );
			$bg = 'style="background-image:url('.$bgImage["src"].')"';
		}
	?>
	<article class="all portfolio-item blog-card">
		<div class="blog-card__wrap">
			<?php if($image) { ?>
			<div class="blog-card__image ">
				<div class="background-image bg-image" style="background-image:url(<?php echo $image['src']; ?>)"></div>
				<a class="abs" href="<?php echo get_the_permalink(); ?>">
				</a>
			</div>
			<?php } ?>
			<div class="blog-card__copy">
					<div class="ellipsis">
					<h4><a href="<?php echo get_the_permalink(); ?>" ><?php echo get_the_title(); ?></a></h4>
					</div>
					<div class="grid meta">
					<div class="date_time col"><span class="icon icon-clock"></span> <?php echo get_the_date(); ?> </div>
					<div class="post-count col text-right"><span class="icon icon-eye"></span> <?php echo getPostViews(get_the_ID()); ?></div>
				</div>
			</div>
		</div>
	</article>
	<?php
	endwhile;
	wp_reset_query();
	?>

			</div>
			<?php if($post_count >6 && !is_front_page()){ ?>
			<br/>
			<div class="load-more-wrapper clearfix center">
				<a href="#" data-page="1" data-ppp="6" class="button load-more">Load more</a>
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
<script>
	//This is for the blog specifically 
jQuery(document).ready(function($){
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




});//jQuery

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
</script>
<?php
endif;

