<!doctype html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<?php // force Internet Explorer to use the latest rendering engine available 
	?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title(''); ?></title>
	<?php // mobile meta (hooray!) 
	?>
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php //  
	// * manifest needs credentials	<link rel="manifest" crossorigin="use-credentials" href="/site.webmanifest"> ?>
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" crossorigin="use-credentials" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#05775d">
	<meta name="msapplication-TileColor" content="#05775d">

	<?php // end icons   or, set /favicon.ico for IE10 win below  ?>
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php // wordpress head functions ?>
	<?php wp_head(); ?>
	<?php // end of wordpress head ?>
	<!-- Google Tag Manager (script) -->
	<?php echo get_field('gtm','options'); ?>
	<!-- End Google Tag Manager (script) -->
</head>
<?php
if (is_home() || is_front_page()) { ?>
<body <?php body_class('home'); ?> itemscope itemtype="http://schema.org/WebPage">
<?php } else { ?>
<body <?php body_class('not-home'); ?> itemscope itemtype="http://schema.org/WebPage">
<?php	} ?>
		<!-- Google Tag Manager (noscript) -->
		<?php echo get_field('gtm_noscript','options'); ?>
		<!-- End Google Tag Manager (noscript) -->
		<?php /*
	<div id="preloader">
			<div class="txt">
				<p><h1 class="logo" >
						<a class="desktop" href="<?php echo get_home_url(); ?>">
						<?php echo get_bloginfo( 'name' ).' - <small>'.get_bloginfo( 'description', 'display' ).'</small>'; ?>
						</a>
					</h1>
				<p class="txt-perc">0%</p>
				<div class="progress"><span></span></div>
			</div>
		</div>
		<?php
	*/
		?>
		<div id="PageContainer" class="is-not-moved-by-drawer 	<?php echo get_field('page_class') . ' ' . get_field('header_type') . ' ' . str_replace(".php", "", get_page_template_slug()) . ' '; ?>">
			<div class="background-overlay3" style="background-color: rgba(0, 0, 0, 0);"></div>
			<div class="wrap">
			<header id="header" class="anim header clearfix layer ">
					<div class="inner inner-1170 grid grid-nogutter clearfix">
						<div class="logo col col-fixed col-align-middle"><a class="desktop" href="<?php echo get_home_url(); ?>">
						<?php
							///	Inline svg lgo if you want..
							/* 
							$arrContextOptions=array(
								"ssl"=>array(
									"verify_peer"=>false,
									"verify_peer_name"=>false,
								),
							);  
							$svg_file = file_get_contents(wp_get_attachment_image_url(get_field('logo', 'options'), 'full'), false, stream_context_create($arrContextOptions));
							$find_string   = '<svg';
							$position = strpos($svg_file, $find_string);
							$svg_file_new = substr($svg_file, $position);
							$svg_file_new = str_replace("<svg","<svg id='logo_image'", $svg_file_new);
							echo $svg_file_new;
							*/
						
							if(get_field('light_logo')){
								echo wp_get_attachment_image(get_field('logo', 'options'), 'full');
								// if svg set dimensions manually
								//echo wp_get_attachment_image(get_field('logo_ghost', 'options'), 'full', null, array('width'=>'300', 'height' =>'55', 'alt' =>get_bloginfo( 'name' ), 'class' => 'ghost' ));
							
							}else{
							
								echo wp_get_attachment_image(get_field('logo_ghost', 'options'), 'full');
								// if svg set dimensions manually
								// echo wp_get_attachment_image(get_field('logo_alt', 'options'), 'full', null, array('width'=>'300', 'height' =>'55','alt' =>get_bloginfo( 'name' ), 'class' => 'alt'));
							}
							
							?>
							</a>
						</div>
						<nav class="nav_wrap col col-align-middle">
							<?php
							wp_nav_menu(array(
								'container' => false,
								'container_class' => 'menu cf',
								'menu' => __('The Main Menu', 'bonestheme'),
								'menu_class' => 'top_nav',
								'theme_location' => 'main-nav',
								'before' => '',
								'after' => '',
								'link_before' => '',
								'link_after' => '',
								'depth' => 2,
								'fallback_cb' => '',
								'item_spacing' => 'discard',
								'walker' => new ifeelfree_Nav_Menu()
							));
							?>
						</nav>
					</div>
			</header>
			<?php 
				global $isSearch;
				if (is_search()) {
					$isSearch = true;
				}
				$pageT = get_the_ID();
				if (get_field('header_type', $pageT) == 'no-intro-image') : ?>
					<div class='header-space'></div>
				<?php
				elseif (have_rows('slides', $pageT) && !is_archive()) :
					?>
						<div id="intro" class="layer intro default page_layout  <?php echo get_field('header_class'); ?>">
							<div class=" hero-slider">
								<ul class="slides list-unstyled">
									<?php
									$c = 0;
									$css = "";
									while (have_rows('slides', $pageT)) : the_row();
										$c++;
										$heading = get_sub_field('slide_heading');
										$class = $info = $style = "";
									
										$slide_image = '';
										if (get_sub_field('slide_image')) {
											$slide_image = get_sub_field('slide_image');
										} else if (get_post_thumbnail_id()) {
											$slide_image = get_post_thumbnail_id();
										} 
										if ($slide_image != '') {
		
											$imgpos = '';
											if (get_sub_field('focal_point')) {
												$coords = explode(',', get_sub_field('focal_point'));
												$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
											} else {
												$imgpos =  " object-position:50% 50%; ";
											}
											$class = "class='bg-image background-image slide-" . $c . "'";
											$info = ' has-bg-image';
											$imgstyle = 'style=" ' . $imgpos . ' "';
										} else {
											$class = ' class=" bg-image "';
											$style = "";
											$info = ' no-bg-image';
											$imgstyle = "";
										}
										$skip = '';
										if($c==1){
											$skip = "skip-lazy";
										}else{
											$skip = '';
										}
									?>
										<li class="clearfix <?php echo $info; ?>">
											<div class="bg-color abs"></div>
											<div <?php echo $class; ?>>
												<?php	
												$raw_image =  wp_get_attachment_image($slide_image, '2048x2048', '', [ 'alt'=> get_the_title() ,"class" => "cover ".$skip,  "style" => $imgpos, 'sizes' => '100vw']);
												$final_image = preg_replace('/(height|width)="\d*"\s/', "", $raw_image);
												echo $final_image;		
												?>
											</div>
											<?php
											if (get_sub_field('video_background')) {
												$videoUrls = get_sub_field('video_background');
												$random = rand(1000, 2000);
												$newId = "video" . $random;
											?>
											<div class="videocontainer">
												<?php /*
												// mute button nice if video has sound to toggle
												<div class=" video_mute muted"></div> */ ?>
												<video data-object-fit="cover" loop muted autoplay playsinline id="<?php echo $newId; ?>"></video>
											</div>
											
											<script>
													Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
														get: function () {
															return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
														}
													});
													
													
					
												function WidthChange(vid,el) {
													//data-video-arr
													console.log(vid);
													//this.dataset.shipId
													vid = eval(vid);
													var lPowerTried = false;
													if (jQuery(window).width() <= 640) {
														//console.log("low");
														jQuery(el).html('<source src="' + vid[0] + '" type="video/mp4"></source>' );
													} else if (jQuery(window).width() <= 960) {
														//console.log("med");
														jQuery(el).html('<source src="' + vid[1] + '" type="video/mp4"></source>' );
													}else{
														//console.log("hi");
														jQuery(el).html('<source src="' + vid[2] + '" type="video/mp4"></source>' );
													}
														jQuery(el)[0].load();
													
													
														var promise = jQuery(el)[0].play();
														if (promise !== undefined) {
															promise.catch(error => {
																console.log('Auto-play was prevented');
																// Show a UI element to let the user manually start playback
																// add -> controls to video tag...
																// hide img-bg :before element check versical spce
																if(lPowerTried == false){
																	lPowerTried = true;
																	/*
																	jQuery('body').on('click touchstart', function () {
																				if (jQuery(el)[0].playing) {
																					jQuery('.hero-slider .slides .bg-image').fadeOut();
																					// video is already playing so do nothing
																				}
																				else {
																					// video is not playing
																					// so play video now
																					var promise = jQuery(el)[0].play();
																					if (promise !== undefined) {
																						promise.catch(error => {
																							console.log('Auto-play was prevented');
																							// Show a UI element to let the user manually start playback
																							// add -> controls to video tag...
																							// hide img-bg :before element check versical spce
																						}).then(() => {
																							console.log('Auto-play started');
																							jQuery('.hero-slider .slides .bg-image').fadeOut();
																							
																							
																						});
																					}
																				}
																			}); */
																	}
															}).then(() => {
																console.log('Auto-play started');
																jQuery('.hero-slider .slides .bg-image img').delay(500).fadeOut('slow');
															});
														}
												}
												var <?php echo $newId; ?> = [<?php echo $videoUrls; ?>];
												jQuery(window).on("resize", function() {
													WidthChange(<?php echo $newId; ?>, "#<?php echo $newId; ?>");
												});
												jQuery(window).on("load", function() {
													console.log("load video multi");
													WidthChange(<?php echo $newId; ?>, "#<?php echo $newId; ?>");
												});
											</script>
											<?php
											
											}
		
											?>
											<div class="inner grid inner-1170">
												<div class="intro-copy col col-align-bottom">
													<?php if ($heading) {
														echo $heading;
													}
												//	echo do_shortcode('[add_booking_but  text="Email us now" style="button alt book"]');
												?>
												</div>
											</div>
											
										</li>
									<?php endwhile; ?>
								</ul>
							</div>
						</div>
					<?php
					else :
						$slide_image = '';
						if (get_sub_field('slide_image')) {
							$slide_image = get_sub_field('slide_image');
						} else if (get_post_thumbnail_id()) {
							$slide_image = get_post_thumbnail_id();
						} 
		
						if ($slide_image != '') {
							$imgpos = '';
							if (get_sub_field('focal_point')) {
								$coords = explode(',', get_sub_field('focal_point'));
								$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
							} else {
								$imgpos =  " object-position:50% 50%; ";
							}
							$class = "class='bg-image background-image slide-" . $c . "'";
							$info = ' has-bg-image';
							$imgstyle = 'style=" ' . $imgpos . ' "';
						} else {
							$class = ' class=" bg-image "';
							$style = "";
							$info = ' no-bg-image';
							$imgstyle = "";
						}
					?>
						<div id="intro" class="layer intro default   <?php echo get_field('header_class'); ?>">
							<div class=" hero-slider">
								<ul class="slides">
									<li class="clearfix <?php echo $info; ?>">
										<div class="bg-color abs"></div>
										<div <?php echo $class; ?>>
											<?php
                                                echo wp_get_attachment_image(get_post_thumbnail_id(), '2048x2048', '', ["class" => "cover", "style" => $imgpos]);
											?>
										</div>
										<div class="inner inner-1170 grid">
											<div class="intro-copy col-align-bottom col">
												<?php
										
												if ($isSearch) {
													echo "<h1>Search</h1>";
												} else if (is_archive() || is_category()) {
													echo "<h1>" . str_replace("Category: ", "Blog - ", get_the_archive_title()) . "</h1>";
												}else if(is_singular('faq')){
													echo "<h1><strong>FAQ</strong></h1>";
												} else if (is_single()) {
													//echo "<h4>Blog</h4>";
													// echo "<h1 style='text-align:center;'>" . get_the_title() . "</h1>";
												} else {
													echo "<h1><strong>" . get_the_title() . "</strong></h1>";
												}
												?>
											</div>
										</div>
										
									</li>
								</ul>
							</div>
						</div>
					<?php
					endif;
	
	// breadcrumbs if you like
	if(!is_front_page() ){ ?> 
 	<div class="grid inner inner-1170 clearfix">
		<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
	</div>
<?php } 
		