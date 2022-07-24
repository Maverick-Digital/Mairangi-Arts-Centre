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



?>
<div id="<?php echo $id; ?>" class="layer layout_2col_images clearfix grid <?php echo $xclass; ?> ">
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
			<div class="grid">
				<?php
				$classesLeft = 'col textwrap ' . $content_vertical_align;
				$classesRight = 'col imgwrap ' . $content_vertical_align;
				?>
				<div class="<?php echo $classesLeft; ?> ">
					<div class="_inner">
						<?php
						
							echo "<h2><strong>".get_the_title()."</strong></h2>";
							if(get_field('subheading')){ echo "<h4>".get_field('subheading')."</h4>"; } 
								echo get_field('teaser');
							 ?>
						
									<?php if(get_field('dob')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>DOB</strong></div><div class="col col-sm col-8"><?php echo get_field('dob'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('iar')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>IAR</strong></div><div class="col col-sm col-8"><?php echo get_field('iar'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('sex')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Sex</strong></div><div class="col col-sm col-8"><?php echo get_field('sex'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('colour')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Colour</strong></div><div class="col col-sm col-8"><?php echo get_field('colour'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('sire')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Sire</strong></div><div class="col col-sm col-8"><?php echo get_field('sire'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('dam')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Dam</strong></div><div class="col col-sm col-8"><?php echo get_field('dam'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('fleece')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Fleece</strong></div><div class="col col-sm col-8"><?php echo get_field('fleece'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('show_highlights')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Show Highlights</strong></div><div class="col col-sm col-8"><?php echo get_field('show_highlights'); ?></div>
									</div>
									<?php } ?>
									<?php if(get_field('price')){?>
									<div class="grid grid-nogutter">								
										<div class="col col-sm col-4"><strong>Price</strong></div><div class="col col-sm col-8"><?php echo get_field('price'); ?></div>
									</div>
									<?php } ?>
									<br/><br/>
									<p><a class="button" href="<?php echo get_the_permalink(321); ?>">Enquire</a></p>
				
								
					</div>
				</div>
				<?php
					$images = get_field("gallery");
					
					if (is_array($images)) {
							// echo "is here".$fields["image_layout"];
					?>
						<div class="<?php echo $classesRight;  ?>">
							<?php
							
								$sizeS =   array(550, 550);
								$sizeL =   array(1600, 1600);
								$id = "section-" . rand(1000000, 10000000);
							?>
								<ul id="<?php echo $id; ?>" class="gallery_images cS-hidden">
									<?php foreach ($images as $image) :
										//	print_r($image);
										//	$imageID = $image['ID'];
										$imgL = fly_get_attachment_image_src($image, $sizeL, false);

									?>
										<li data-thumb="<?php echo wp_get_attachment_image_url($image, array( 'width' => 500, 'height' => 500, 'crop' => true ), "", ["class" => "cover"]); ?>"  data-src="<?php echo wp_get_attachment_image_url($image,array( 'width' => 500, 'height' => 500, 'crop' => true ), "", ["class" => "cover"]); ?>" >
										<?php /*	<a class='venobox ' data-gall='toam' href='<?php echo $imgL['src']; ?>'> */ ?>
												<span class="image_holder anim">
													<?php
													
														echo wp_get_attachment_image($image, '2048x2048', "", ["class" => "cover"]);

														// echo wp_get_attachment_image($image['ID'], 'large', "", ["class" => "cover"]);
													?>
													<?php
													
													?>
												</span>
												<?php /*	</a> */ ?>
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
								
								//autoWidth:false,
								//adaptiveHeight:true,
								auto:false,
								gallery:true,
								thumbItem:3,
      							thumbMargin:4,

								  infinite: true,
								item:1,
								speed: 300,
								slidesToShow: 1,
								adaptiveHeight: true,
								  
								onSliderLoad: function(el) {
								$('#<?php echo $id; ?>').removeClass('cS-hidden');
								el.lightGallery({
									selector: '#<?php echo $id; ?> .lslide',
									thumbnail:true
								});
								AOS.refresh();
								}

								});
								// }
								<?php
								/*
								slidesToShow: 1,
  								//adaptiveHeight: true,
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
								*/
								$myScripts .= ob_get_clean();
					}
					
					
					?>

		
				


				
			</div>

		</div>

</div>

<?php

$globalContentID = 862;

if (have_rows('page_layout',$globalContentID)) : ?>
		<?php
		while (have_rows('page_layout',$globalContentID)) : the_row();
			$c++;
			$fields = get_sub_field('settings');
			if (isset($fields[0])) {
				$fields = $fields[0];
			} else {
				//$fields = $fields['row-0'];
			}
		?>
			<div class="page_layout clearfix global-loop-<?php echo $c; ?>">
				<?php if (isset($fields['vertical_title']) && $fields['vertical_title'] != '') : ?>
					<div class="grid grid-nogutter">
						<div class="col col-fixed" style='width:6em;'>
							<div class="verttext">
								<h2><strong><?php echo $fields['vertical_title']; ?></strong></h2>
							</div>
						</div>
						<div class="col ">
						<?php endif;
					ACF_Layout::render(get_row_layout());
						?>
						<?php if (isset($fields['vertical_title']) && $fields['vertical_title'] != '') : ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php
		endwhile; ?>
<?php
endif;