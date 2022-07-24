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

//print_r($fields);
//$fields = get_fields();



$imageL = wp_get_attachment_image_src(get_sub_field('main_image'), $sizeL, false);
$image = wp_get_attachment_image_src(get_sub_field('main_image'), $size, $crop);



?>
<section id="<?php echo $id; ?>" class="layer layout_2col_images clearfix <?php echo $xclass; ?> ">
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
		<div class="inner inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
			<div class="grid">
				<?php
				$classesLeft = 'col textwrap ' . $content_vertical_align;
				$classesRight = 'col imgwrap ' . $content_vertical_align;
				?>
				<div class="<?php echo $classesLeft; ?> ">
					<div class="_inner">
						<?php
						if (get_sub_field('content')) {
							//echo get_sub_field('content');
						
								//echo get_field('teaser');
								echo preg_replace(
									"#/<p>(\s|&nbsp;|</?\s?br\s?/?>)</?p>#",
									"",
									get_sub_field('content')
								);
							
							
						}

						 ?>
					</div>
				</div>
				<?php if (strpos($xclass, 'map') !== false) { ?>

					<?php } else {
					$images = '';
					if (isset($fields['row_images'])) {
						$images = $fields['row_images'];
					}
					if (is_array($images)) {
						//	echo "is here".$fields["image_layout"];
					?>
						<div class="<?php echo $classesRight;  ?>">
							<?php
							if ($fields["image_layout"] == "gallery") {
								$sizeS =   array(550, 550);
								$sizeL =   array(1600, 1600);
								$id = "section-" . rand(1000000, 10000000);
							?>
								<ul id="<?php echo $id; ?>" class="gallery_images cS-hidden">
									<?php foreach ($images as $image) :
										//	print_r($image);
										//	$imageID = $image['ID'];
										$imgL = fly_get_attachment_image_src($image['ID'], $sizeL, false);

									?>
										<li>
										<?php
										//echo get_the_content($image['ID']);
										//print_r($image);
										if (strpos($xclass, 'full-gallery') !== false && isset($image['description'])) { ?>
											<a href='<?php echo $image['description']; ?>'> 
										<?php } ?>
											
												<span class="image_holder anim">
													<?php
													// echo $fields['image_style'];
													if ($fields['image_style'] == "image-round") {
														$img = fly_get_attachment_image_src($image['ID'], array(900, 900), true);
													?>
														<img class="img-responsive" src="<?php echo $img['src']; ?>" width="<?php echo $img['width']; ?>" height="<?php echo $img['height']; ?>" alt="<?php echo get_the_title(); ?>" />
													<?php
													} else {
														echo wp_get_attachment_image($image['ID'], '2048x2048', "", ["class" => "cover"]);

														// echo wp_get_attachment_image($image['ID'], 'large', "", ["class" => "cover"]);
													?>
													<?php
													}
													?>
												</span>
												<?php if (strpos($xclass, 'full-gallery') !== false && isset($image['description'])) { ?></a><?php } ?>
										</li>
									<?php endforeach; ?>
								</ul>

								<?php
								ob_start(); ?>
								// gallery
								var $gallery = $('#<?php echo $id; ?>');
								//if($gallery.find('li').length == 1){
								//$('#<?php echo $id; ?>').removeClass('cS-hidden');

								//}else{
								console.log("gallery");
								var gallery_images = $gallery.lightSlider({
								item:1,
								loop:true,
								slideMove:1,
								mode:'fade',
								controls:true,
								keyPress:true,
								easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
								speed:1000,
								pause:7000,
								pauseOnHover:true,
								slideMargin: 0,
								pager:true,
								autoWidth:false,
								adaptiveHeight:true,
								auto:false,
								onSliderLoad: function(el) {
								$('#<?php echo $id; ?>').removeClass('cS-hidden');
								
									el.lightGallery({
										selector: '#<?php echo $id; ?> .lslide img'
									});
          
								AOS.refresh();
								}

								});
								// }
								<?php
								$myScripts .= ob_get_clean();
							} else {
								foreach ($images as $image) {
									//print_r($image);
									$attachment_ID =    $image['ID'];
									if ($image['mime_type'] == 'image/svg+xml') {
										$img = wp_get_attachment_image($attachment_ID);
										$imgL = wp_get_attachment_image_src($attachment_ID);
										//echo $img;
									} else {

										if ($attachment_ID) {
											$classes = ""; //"pad-top-20 pad-bot-20";
											$img = fly_get_attachment_image_src($attachment_ID, $size, $crop);
										}

										if ($xclass == 'map') {
											$img = fly_get_attachment_image_src($attachment_ID, $size, false);
										}
										$imgL = fly_get_attachment_image_src($attachment_ID, $sizeL, false);
									}
									if ($img) {
										$thumb_img = get_post($attachment_ID); // Get post by ID
										$caption = false;
										$caption = $thumb_img->post_excerpt; // Display Caption
										if (!$caption) {
											$caption = ""; //CAPTION: We are the business behind the businesses that power your local economy";
										} else {
											//  $classes ="";
										}

								?>
										
											<div class="image_holder anim">

												<?php
												
												if (strpos($xclass, 'video') !== false) {
													
													$start = strpos($xclass, 'video-') + 6;
													$videoUrl = substr($xclass, $start);
													//echo $videoUrl; 
												?>
													<a class="venobox" data-autoplay="true" data-vbtype="video" href="https://youtu.be/<?php echo $videoUrl; ?>?rel=0&amp;autoplay=1">
														<?php
													} else {

														if (strpos($xclass, 'no-links') !== false) {
														} else {
														?>
															<a class='venobox ' data-gall='gall_imagery' href='<?php echo $imgL['src']; ?>'>
														<?php
														}
													} ?>

														<?php
														// echo "MIKE".$fields['image_style']." ". $image['ID'];
														if (strpos($xclass, 'side-by-side') !== false) {
															echo wp_get_attachment_image($image['ID'], '2048x2048', "", ["class" => "cover"]);

														} else {
                                                            if ($fields['image_style'] == "image-round") {
																echo wp_get_attachment_image($image['ID'], array( 'width' => 500, 'height' => 500, 'crop' => true ), "", ["class" => "cover"]);
                                                                /*
                                                                                                                            echo ipq_get_theme_image($image['ID'], array(
                                                                                                                                array(900, 900, true),
                                                                                                                                array(600, 600, true),
                                                                                                                                array(450, 450, true)

                                                                                                                            ));
                                                                                                                            */
                                                            } else {
																echo wp_get_attachment_image($image['ID'], 'large', "", ["class" => "_cover"]);

                                                                //  $img = fly_get_attachment_image_src($image['ID'],array(900,600), true );
/*
                                                            echo ipq_get_theme_image($image['ID'], array(
                                                                array(1350, 900, true),
                                                                array(900, 600, true),
                                                                array(450, 300, true)
                                                            ));
                                                            */
                                                            }
                                                        }
														if ($caption) {

															echo '<p class="wp-caption-text">' . $caption . '</p>';
														} else {
															// echo '<p class="caption">&nbsp;</p>';
														}
														if (strpos($xclass, 'no-links') !== false) {
														} else { ?>
															</a>
														<?php }
														?>


											</div>

							<?php

									}
								}
							}
							?>
						</div>

					<?php
					}else{ ?>
					<div class="<?php echo $classesRight;  ?>"></div> 
					<?php }
					
					?>

				<?php

				}
				?>
			</div>
	</div>
</section>

<?php
