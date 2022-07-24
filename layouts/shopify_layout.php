<?php
global $post;
global $myScripts;
// only need these if performing outside of admin environment
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

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




?>


<section id="<?php echo $id; ?>" class="<?php echo $id; ?> layer  <?php echo $xclass; ?> ">
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>

	<?php if (get_sub_field("content")) { ?>
		<div class="clearfix grid pad-bot-40">
			<div class="col inner <?php if($id == 'tracks'){ echo "inner-1170"; }else{ echo "inner-narrow"; } ?> ">
				<?php echo get_sub_field('content'); ?>

			</div>
		</div>
	<?php 	} ?>
	<div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?>  clearfix">
<?php

	/*
	if( get_sub_field('services')):
		$ids = get_sub_field('services');
		$args = array(
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'post__in'			=> $ids,
			'post_status'		=> 'publish',
			'orderby'        	=> 'post__in',
			//'order'          => 'ASC',
			//'orderby'        => 'menu_order'
		);
	*/
	$currentPage = get_the_ID();

	$wp_query = null;
	$wp_query = new WP_Query();
	$args = array();


	if( get_sub_field('services')):
		$ids = get_sub_field('services');
		$args = array(
			'post_type'      => 'any',
			'posts_per_page' => -1,
			'post__in'			=> $ids,
			'post_status'		=> 'publish',
			'orderby'        	=> 'post__in',
			//'order'          => 'ASC',
			//'orderby'        => 'menu_order'
		);

	$wp_query->query($args);
	endif;

// print_r($args);
	if($wp_query->have_posts()):

////////////////////////////////////////
while ($wp_query->have_posts()) :
	$wp_query->the_post();
	// Get all the data 
	$getPostCustom = get_post_custom(); 
	/*
	foreach($getPostCustom as $name=>$value) {
		echo "<br/><strong>" . $name . "</strong>"."  =>  ";
		foreach ($value as $nameAr=>$valueAr) {
				echo "<br/>".$nameAr."  =>  ";
				echo var_dump($valueAr);
		}
		echo "<br/>";
		//echo "<br /><br />";
	}
	*/
	//echo "<br/>".$getPostCustom['product_id'][0];
   
  $Products = ShopWP\Factories\API\Items\Products_Factory::build();
  $post_id = get_the_ID(); // required
  //$storefront_id = base64_decode("Z2lkOi8vc2hvcGlmeS9Qcm9kdWN0LzQxMDc1MTExMw==");
  
  $product_id = $getPostCustom['product_id'][0];
  
  $result = $Products->get_product([
	// 'storefront_id' => $storefront_id,
		'product_id' => $product_id,
	  'schema' => '
		  availableForSale
		   compareAtPriceRange {
			  maxVariantPrice {
				 amount
				 currencyCode
			  }
			  minVariantPrice {
				 amount
				 currencyCode
			  }
		   }
		   createdAt
		   description
		   descriptionHtml
		   handle
		   id
		   onlineStoreUrl
		   featuredImage{
			  id
			  url
			  }
		   options {
			  id
			  name
			  values
		   }
		   priceRange {
			  maxVariantPrice {
				 amount
				 currencyCode
			  }
			  minVariantPrice {
				 amount
				 currencyCode
			  }
		   }
		   productType
		   publishedAt
		   requiresSellingPlan
		   title
		   totalInventory
		   updatedAt
		   vendor
		   images(first: 250) {
			  edges {
				 node {
					width
					height
					altText
					id
					originalSrc
					transformedSrc
				 }
			  }
		   },
		   
	 '
  ]);
  /*
  var_dump($result);
  foreach($result as $name=>$value) {
	  echo "<br/><strong>" . $name . "</strong>"."  =>  ";
	  foreach ($value as $nameAr=>$valueAr) {
			  echo "<br/>".$nameAr."  =>  ";
			  echo var_dump($valueAr);
	  }
	  echo "<br/>";
	  //echo "<br /><br />";
  }
  */
  
  $minVariantPrice = number_format($result->product->priceRange->minVariantPrice->amount,2);
  $maxVariantPrice = number_format($result->product->priceRange->maxVariantPrice->amount,2);
  $currencyCode = $result->product->priceRange->maxVariantPrice->currencyCode;
  
  if($minVariantPrice == $maxVariantPrice){
	  $price = "$".$minVariantPrice.' '.$currencyCode;
	  // echo "<br/>$".$result->product->priceRange->maxVariantPrice->amount.' '.$result->product->priceRange->maxVariantPrice->currencyCode;
  }else{
	  // echo "<br/>Here: $".$minVariantPrice.' - $'.$maxVariantPrice;
	  $price = "$".$minVariantPrice.' - $'.$maxVariantPrice.' '.$currencyCode;
  }
  // echo '<br/> '.get_field('shopify_price').'  '.$price;
  if(get_field('shopify_price') != $price){
	  update_field('shopify_price', $price);
  }

  $descriptionHtml =$result->product->descriptionHtml;
  if(get_field('teaser') != $descriptionHtml){
	update_field('teaser', $descriptionHtml);
}
  //	update_field('shopify_url', $result->product->onlineStoreUrl);
  
  $onlineStoreUrl =$result->product->onlineStoreUrl;
  if(get_field('shopify_url') != $onlineStoreUrl){
	  update_field('shopify_url', $onlineStoreUrl);
  }

  if(!get_field('shopify_featured_image')){
   update_field('shopify_featured_image', "SHOPIFY");
  }
  // example image
  //echo '$result->product->featuredImage->url: '.$result->product->featuredImage->url;
  //echo '$result->product->featuredImages: '.$result->product->featuredImage;
  $image = $result->product->featuredImage->url;
  $post_id = get_the_ID();
  //echo '<br/> shopify_price: '.get_field('shopify_price').'  price: '.$price;
  //echo '<br/> shopify_featured_image: '.get_field('shopify_featured_image');
  //echo '<br/>   :  image: '.$image;
  //echo '<br/>';
 // echo '<br/> '.get_field('shopify_url').'  ';
  
  //echo '<br/> '.strtok(get_field('shopify_featured_image')).'  '.$image;
  //$url = strtok($_SERVER["REQUEST_URI"], '?');
  if(get_field('shopify_featured_image') != $image ){
	//echo '<br/> upload new image:'.$image;
	  // no image in field upload
	  update_field('shopify_featured_image', $image);
	  $new_att_id = media_sideload_image($image, $post_id, "", 'id');	
	  if(!is_wp_error($new_att_id)) { 
		  set_post_thumbnail($post_id, $new_att_id); 
	  }
  }
endwhile;

////////////////////////////////////////


	if (get_sub_field('services_layout') == 'panels') :
	?>
		<div class="inner pad-bot-default">
			<div class="flex-container">
				<?php
				$count = 2;
				// if ( $wp_query->have_posts()) :
				while ($wp_query->have_posts()) :
					$wp_query->the_post();
					$imageID = 686;
					if (get_the_ID() != $currentPage) {
						if(get_field("tile_image")){ 
							$imageID = get_field("tile_image"); 
						}else if(get_post_thumbnail_id()){
							$imageID = get_post_thumbnail_id();
						}
						$image = fly_get_attachment_image_src($imageID, array(950, 720), true);
						

						
						
						if (get_field('tile_image_focal_point')) {
							$coords = explode(',', get_field('tile_image_focal_point'));
							$bgpos =  " background-position:" . $coords[0] . " " . $coords[1] . "; ";
						} else {
							$bgpos = " background-position:center center; ";
						}


				?>
						<div class="flex-slide background-image anim" style="background-image:url(<?php echo $image['src']; ?>); <?php echo $bgpos; ?>">
							<a href="<?php echo get_the_permalink(); ?>" class="link-overlay"> </a>
							<div class="border_wrap anim"><?php echo $badge; ?>
								<div class="flex-about">
									<h3 class="title tohide"><?php echo get_the_title(); ?></h3>
									<div class="content hide">
										<h3 class="title"><?php echo get_the_title(); ?></h3>
										<?php echo get_field('teaser'); ?>
										<p><a href="<?php echo get_the_permalink(); ?>" class="button">Learn More</a></p>
									</div>
								</div>
							</div>
						</div>
				<?php
					}
				endwhile;
				// Restore original post data.
				wp_reset_query();
				?>
			</div>
		</div>
		<?php ob_start(); ?>
		$(".flex-slide").each(function(){
		$(this).hover(function(){
		$(this).find('.tohide').stop().hide();
		$(this).find('.content').stop().delay(350).fadeIn();
		}, function(){
		$(this).find('.tohide').stop().delay(350).fadeIn();
		$(this).find('.content').stop().hide();
		})
		});
	<?php
		$myScripts .= ob_get_clean();

	elseif (get_sub_field('services_layout') == 'carousel') :
	
			?>
					<ul class="services carousel clearfix">
						<?php
						$count = 0;
						
						// if ( $wp_query->have_posts()) :
						while ($wp_query->have_posts()) :
							$wp_query->the_post();
					
							if (get_the_ID() != $currentPage) {
								$count++;

						?>
						<li class="item anim">
							<article class="product item_inner 	<?php // echo getProductType($post); ?>">
								<div class="card">
									<div class="bg-image anim abs">
										<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", '_sizes' => '100vw']); ?>
										<a class="shopifyProductLink link-overlay"  target="_blank" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
									</div>
									<div class="title grid grid-nogutter anim abs">
										<div class="col col-align-bottom anim">
										<?php //echo getProductType($post); ?>
										<h3 class="subpage"><?php the_title() ?></h3>

										<div class="teaser anim">
											<?php if(get_field('teaser')){ 
												echo get_field('teaser');
											}
											?>
										</div>
									</div>
								</div>
								</div>
								<div class="shopify anim">
									<p><a href="<?php echo get_the_permalink(); ?>"><?php the_title() ?></a><br/>
									<?php echo get_field('shopify_price'); ?></p>
								</div>

								<a class="shopifyProductLink link-overlay" target="_blank" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>

							</article>
						</li>

						<?php
							}

						endwhile;
						// Restore original post data.
						wp_reset_query();
						?>
					</ul>

					<?php ob_start(); ?>
					console.log("fire featured products <?php echo $id; ?>");
					var n = $("#<?php echo $id; ?> .carousel .item").length;
					var myCenter = false;
					if(n>2){
						myCenter = true;
					}
					
					$("#<?php echo $id; ?> .carousel").on('init', function(event, slick, direction){
					console.log('redo aos');
					AOS.refresh();
					
					});	
					$("#<?php echo $id; ?> .carousel").slick({
					
						variableWidth: false,
						arrows: true,
						speed: 300,
						slidesToShow: 3,
						slidesToScroll: 1,
						dots: false,
						centerMode: myCenter,
						responsive: [{
							breakpoint: 1480,
							settings: {
								slidesToShow: 3,
							}
						}, {
							breakpoint: 900,
							settings: {
								infinite: true,
								slidesToShow: 3,
								centerMode: myCenter
							}
						}, {
							breakpoint: 600,
							settings: {
								slidesToShow: 1,
								//dots: true,
								centerMode: true
							}
							// settings: "unslick" // destroys slick
						}]

					});
					console.log("fire featured products");
					console.log("hover");
						
								
					/*

				$("#<?php echo $id; ?> li").hover(
					function() {
						console.log("hover" + $(this).find('.teaser'));

						$(this).find('.teaser').fadeIn('fast');
						$(this).find('.col').removeClass('col-align-bottom')
						.addClass('col-align-middle');
						
					}, function() {
						$( this ).find('.teaser').hide();
						$(this).find('.col').removeClass('col-align-middle')
						.addClass('col-align-bottom');
					}
				);
				*/

		<?php	
				$myScripts .= ob_get_clean();
		elseif (get_sub_field('services_layout') == 'slider') :
			?>
					<ul class="services slider  side-by-side clearfix">
						<?php
						$count = 0;
						$array = ['yellow','red','blue','green','yellow','red','blue','green','yellow','red','blue','green'];
						// if ( $wp_query->have_posts()) :
							if($id == 'tracks'){
								$array = [];
							}
						while ($wp_query->have_posts()) :
							$wp_query->the_post();
							
							
                            if (get_the_ID() != $currentPage) {
                                ?>
								<li class="item anim ">
									<article id="<?php echo $post->post_name; ?>" class="product  item_inner page-<?php echo get_the_ID().' '.get_field('page_class').' '.$array[$count]; ?>">
									<div class="bg-image anim abs">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
										</div>
										<div class="title grid anim _abs ">
											<div class="col col-align-middle anim">
											<?php //echo getProductType($post);?>
											<?php if ($id == 'tracks') { ?>
												<h2 class="subpage"><?php the_title() ?></h2>
											<?php } else { ?>
												<h3 class="subpage"><?php the_title() ?></h3>											
											<?php } ?>
											<?php
                            					
											
											?>
												<div class="teaser anim">
													<?php if(get_field('teaser')){ 
														echo get_field('teaser');
													}
													// echo '<div class="shopify lead">'.get_field('shopify_price').'</div>';

													echo do_shortcode('[add_booking_but text="Find out more"]');
													?>
													
												</div>
												<?php

												if(get_post_type() != 'page_touchpoints'){ ?>
													
												<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>
													<?php } ?>
											</div>
										</div>
										
									</article>
								</li>

						<?php
						$count ++;
							}

						endwhile;
						// Restore original post data.
						wp_reset_query();
						?>
					</ul>

					<?php ob_start(); ?>
					console.log("fire slider: <?php echo $id; ?>");
					
					/*
					$("#<?php echo $id; ?> .slider").slick({
						variableWidth: false,
						arrows: true,
						speed: 300,
						slidesToShow: 1,
						slidesToScroll: 1,
						dots: false,
						infinite: true
					});
					console.log("fire featured products");
					console.log("hover");
					
				$("#<?php echo $id; ?> li").hover(
					function() {
						console.log("hover" + $(this).find('.teaser'));

						$(this).find('.teaser').fadeIn('fast');
						$(this).find('.col').removeClass('col-align-bottom')
						.addClass('col-align-middle');
						
					}, function() {
						$( this ).find('.teaser').hide();
						$(this).find('.col').removeClass('col-align-middle')
						.addClass('col-align-bottom');
					}
				);
				*/

		<?php	
					$myScripts .= ob_get_clean();
			
					
		elseif (get_sub_field('services_layout') == 'grid') :
			?>
			
			<div class="services services-grid grid grid-no-gutter grid-center">
				<?php
				$count = 0;
				// if ( $wp_query->have_posts()) :
				while ($wp_query->have_posts()) :
					$wp_query->the_post();




					if (get_the_ID() != $currentPage) {
						$count ++;

				?>	
					
					
									<article class="product item_inner anim	<?php //echo getProductType($post); ?>">
										<div class="bg-image anim abs">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", 'sizes' => '100vw']); ?>
										</div>
										<div class="title grid anim abs">
											<div class="col col-align-bottom anim">
											<?php //echo getProductType($post); ?>
											<h3 class="subpage"><?php the_title() ?></h3>
											<?php echo  $price; ?>
											<div class="teaser anim_slow">
												<?php if(get_field('teaser')){ 
													echo get_field('teaser');
												}
												?>
												<a class="link-overlay shopifyProductLink" href="<?php echo get_the_permalink(); ?>" style="display:block;"><span class=" sr-only"><?php echo get_the_title(); ?></span></a>

											</div>
										</div>
									</article>
								
				
				<?php
					}
				endwhile;
				// Restore original post data.
				wp_reset_query();
				?>
			
		</div>
		<?php
		/*  ob_start(); ?>
		$(".flex-slide").each(function(){
		$(this).hover(function(){
		$(this).find('.tohide').stop().hide();
		$(this).find('.content').stop().delay(350).fadeIn();
		}, function(){
		$(this).find('.tohide').stop().delay(350).fadeIn();
		$(this).find('.content').stop().hide();
		})
		});
	<?php
		$myScripts .= ob_get_clean();

*/

		else :
	?>
		<div class="inner inner-1170 pad-bot-default">
			<div class="services alternating">
				<?php
				$count = 0;
				// if ( $wp_query->have_posts()) :
				while ($wp_query->have_posts()) :
					$wp_query->the_post();

					if (get_the_ID() != $currentPage) {
						$count ++;
						$image = fly_get_attachment_image_src(get_post_thumbnail_id(), array(950, 950), array( 'center', 'center' ));
						if (!$image) {
							$image = fly_get_attachment_image_src(686, array(950, 950), true);
						}

					
				?>
				<article id="<?php echo $post->post_name; ?>" >
							<div class="altern grid page-<?php echo get_the_ID().' '.get_field('page_class'); ?>">
								<div class="col col-align-top  image background-image" <?php /* style="background-image:url(<?php echo $image['src']; ?>);" */ ?>>
									<?php 
									if($fields['class'] == 'slideshow' && get_field('laout_bg_image')){ 
										echo wp_get_attachment_image(get_field('laout_bg_image'), '2048x2048', "", ["class" => "cover anim", 'sizes' => '100vw']); 
									}else{
										echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', "", ["class" => "cover anim", 'sizes' => '100vw']); 

									}
		// echo do_shortcode('[product_icons]'); ?>
										
								</div>
								<div class="col text grid">
									<div class=" pad-top-60 pad-bot-60 inner col col-align-middle">
											<h3 class="subpage"><?php echo get_the_title(); ?></h3>
										<?php 
											
											//echo do_shortcode('[product_price]');
											if(get_field('teaser')){
												echo get_field('teaser'); ?>

												<?php
												}else{ ?>
												
												<?php if(get_post_type() == 'page_touchpoint'){ }else{ ?>
												<p><a href="<?php echo get_the_permalink(); ?>" class="button">Learn More</a></p>
												<?php } 
											} ?>
										
											
									</div>
								</div>
							</div>
										</article>
				<?php
					}
				endwhile;
				// Restore original post data.
				wp_reset_query();
				?>
			</div>
		</div>
		<?php 
		
		if($fields['class'] == 'slideshow'){ 
		ob_start(); ?>
					console.log("fire slider: <?php echo $id; ?>");
					
					
					$("#<?php echo $id; ?> .alternating").slick({
						variableWidth: false,
						arrows: true,
						speed: 300,
						slidesToShow: 1,
						slidesToScroll: 1,
						dots: false,
						infinite: false
					});
				
					
		<?php
                    $myScripts .= ob_get_clean();
                }


	endif;

endif;
?> 
<?php if (get_sub_field("show_content_after") && get_sub_field("content_after")) { ?>
		<div class="clearfix grid content_after">
			<div class="col inner inner-narrow ">
				<?php echo get_sub_field('content_after'); ?>

			</div>
		</div>
	<?php 	} ?>

</div>
</section>
