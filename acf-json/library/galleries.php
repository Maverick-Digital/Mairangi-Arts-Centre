<?php
global $myScripts;


add_action('print_media_templates', function () {
	// define your backbone template;
	// the "tmpl-" prefix is required,
	// and your input field should have a data-setting attribute
	// matching the shortcode name
	/*
    https://wordpress.stackexchange.com/questions/182821/add-custom-fields-to-wp-native-gallery-settings
    
     adaptiveHeight:<?php  if(get_sub_field('adaptiveheight')){ echo 'true'; }else{ echo 'false';} ?>,
	   gallery:<?php  if(get_sub_field('gallery')){ echo 'true'; }else{ echo 'false';} ?>,
		item:<?php  if(get_sub_field('item')){ echo get_sub_field('item'); }else{ echo '1';} ?>,
		autoWidth:<?php  if(get_sub_field('autowidth')){ echo 'true'; }else{ echo 'false';} ?>,
		slideMargin:<?php  if(get_sub_field('slidemargin')){ echo get_sub_field('slidemargin'); }else{ echo '0';} ?>,
		loop:<?php  if(get_sub_field('loop')){ echo 'true'; }else{ echo 'false';} ?>,
		auto:<?php  if(get_sub_field('auto')){ echo 'true'; }else{ echo 'false';} ?>,
		pause: 5000,
		vertica
		*/
	$gallery_types = apply_filters(
		'print_media_templates_gallery_settings_types',
		array(
			//'swiper'      => ' Swiper',
			//'owl'         => ' Owl Carousel',
			'default_val' => ' Default',
			'carousel'  => ' Carousel',
			'masonry'  => ' Masonry',
		)
	);
?>
	<script type="text/html" id="tmpl-custom-gallery-setting">
		<label class="setting">
			<span><?php _e('Layout Type'); ?></span>
			<select data-setting="type"><?php
										foreach ($gallery_types as $key => $value) {
											echo "<option value=\"$key\">$value</option>";
										}
										?>
			</select>
		</label>
		<hr />
		<h2 style="clear:both;">Custom Settings for Carousel</h2>
		<label class="setting">
			<span>Adaptive height</span>
			<input type="checkbox" data-setting="adaptiveheight">
		</label>
		<label class="setting">
			<span>Gallery</span>
			<input type="checkbox" data-setting="gallery">
		</label>
		<label class="setting">
			<span>Number items to show</span>
			<input type="text" value="" data-setting="item">
		</label>
		<label class="setting">
			<span>Slide margin</span>
			<input type="text" value="" data-setting="slidemargin">
		</label>
		<label class="setting">
			<span>Autowidth</span>
			<input type="checkbox" data-setting="autowidth">
		</label>
		<label class="setting">
			<span>Loop</span>
			<input type="checkbox" data-setting="loop">
		</label>
		<label class="setting">
			<span>Autoplay</span>
			<input type="checkbox" data-setting="auto">
		</label>
		<label class="setting">
			<span>Vertical</span>
			<input type="checkbox" data-setting="vertical">
		</label>
		<label class="setting">
			<span>Round Images</span>
			<input type="checkbox" data-setting="roundimages">
		</label>
		<label class="setting">
			<span>Hide Captions</span>
			<input type="checkbox" data-setting="hidecaptions">
		</label>
	</script>

	<script>
		jQuery(document).ready(function() {
			_.extend(wp.media.gallery.defaults, {
				type: 'default_val',
				adaptiveheight: 'false',
				gallery: 'false',
				item: '1',
				autoWidth: 'false',
				slidemargin: '0',
				loop: 'false',
				auto: 'false',
				pause: 5000,
				vertical: 'false',
				hidecaptions: 'false',
				roundimages: 'false',
			});

			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
				template: function(view) {
					return wp.media.template('gallery-settings')(view) +
						wp.media.template('custom-gallery-setting')(view);
				},
				// this is function copies from WP core /wp-includes/js/media-views.js?ver=4.6.1
				update: function(key) {
					var value = this.model.get(key),
						$setting = this.$('[data-setting="' + key + '"]'),
						$buttons, $value;
					// Bail if we didn't find a matching setting.
					if (!$setting.length) {
						return;
					}

					// Attempt to determine how the setting is rendered and update
					// the selected value.
					// Handle dropdowns.
					if ($setting.is('select')) {
						$value = $setting.find('[value="' + value + '"]');

						if ($value.length) {
							$setting.find('option').prop('selected', false);
							$value.prop('selected', true);
						} else {
							// If we can't find the desired value, record what *is* selected.
							this.model.set(key, $setting.find(':selected').val());
						}

						// Handle button groups.
					} else if ($setting.hasClass('button-group')) {
						$buttons = $setting.find('button').removeClass('active');
						$buttons.filter('[value="' + value + '"]').addClass('active');

						// Handle text inputs and textareas.
					} else if ($setting.is('input[type="text"], textarea')) {
						if (!$setting.is(':focus')) {
							$setting.val(value);
						}
						// Handle checkboxes.
					} else if ($setting.is('input[type="checkbox"]')) {
						$setting.prop('checked', !!value && 'false' !== value);
					}

					// HERE the only modification I made
					else {
						$setting.val(value); // treat any other input type same as text inputs
					}
					// end of that modification
				},
			});
		});
	</script>
	<?php
});

add_filter('use_default_gallery_style', '__return_false');

function add_title_attachment_link($link, $id = null)
{
	$id = intval($id);
	$_post = get_post($id);
	$post_title = esc_attr($_post->post_title);
	return str_replace('<a href', '<a title="' . $post_title . '" href', $link);
}
add_filter('wp_get_attachment_link', 'add_title_attachment_link', 10, 2);
remove_shortcode('gallery'); // Remove the default gallery shortcode implementation
add_shortcode('gallery', "new_gallery_shortcode"); // And replace it with our own!


/**
 * The Gallery shortcode.
 *
 * This has been taken verbatim from wp-includes/media.php. There's a lot of good stuff in there.
*/

function new_gallery_shortcode($attr)
{
	global $myScripts;
	$post = get_post();
	static $instance = 0;
	$instance++;

	if (!empty($attr['ids'])) {
		if (empty($attr['orderby'])) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters('post_gallery', '', $attr, $instance);
	if ($output != '') {
		return $output;
	}
	$html5 = current_theme_supports('html5', 'gallery');
	$atts = shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery');

	$id = intval($atts['id']);

	if (!empty($atts['include'])) {
		$_attachments = get_posts(array('include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif (!empty($atts['exclude'])) {
		$attachments = get_children(array('post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
	} else {
		$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
	}

	if (empty($attachments)) {
		return '';
	}


	if (!isset($attr['type']) || $attr['type'] == 'default_val') :
		if (is_feed()) {
			$output = "\n";
			foreach ($attachments as $att_id => $attachment) {
				$output .= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
			}
			return $output;
		}

		$itemtag = tag_escape($atts['itemtag']);
		$captiontag = tag_escape($atts['captiontag']);
		$icontag = tag_escape($atts['icontag']);
		$valid_tags = wp_kses_allowed_html('post');
		if (!isset($valid_tags[$itemtag])) {
			$itemtag = 'dl';
		}
		if (!isset($valid_tags[$captiontag])) {
			$captiontag = 'dd';
		}
		if (!isset($valid_tags[$icontag])) {
			$icontag = 'dt';
		}

		$columns = intval($atts['columns']);
		$itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = '';
		if (apply_filters('use_default_gallery_style', !$html5)) {
			$gallery_style = "";
		}

		$size_class = sanitize_html_class($atts['size']);
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
		
		ob_start();  ?>

		<ul class="gallery isotope_gallery <?php echo " gallery-columns-" . $columns . " gallery-size-" . $size_class; ?>"><?php
																														foreach ($attachments as $id => $attachment) :
																															// $image['caption'] =='caption';
																															//	if($image['caption'] ==''){ $image['caption'] =  get_bloginfo( 'name' ); }
																															// print_r($attachment);
																															$img = wp_get_attachment_image_src($id, 'full');
																															// print_r($img);
																															$_image = get_post($id);
																															$image_title = $_image->post_title;
																															$image_caption = $_image->post_excerpt;
																														?><li>
					<?php 
					if ($atts['link'] != 'none') { ?>
						<a data-src="<?php echo $img[0];  ?>" href="<?php echo $img[0];  ?>" title="<?php echo $image_caption; ?>" data-gall="myGallery">
						<?php 
					} 
					// image
					if (!$attr['roundimages']) {
						echo wp_get_attachment_image($id, array('width' => 1920, 'height' => 1000, 'crop' => true), "", ["class" => "cover"]);
					} else {
						echo wp_get_attachment_image($id, array('width' => 1000, 'height' => 1000, 'crop' => true), "", ["class" => "cover"]);
					}
					if ($atts['link'] != 'none') { ?>
						</a>
					<?php } 
					// caption
					if ($image_caption != '') { ?>
						<span class="gallery_credit">
							<p><?php echo $image_caption; ?></p>
						</span>
					<?php } ?>
				</li><?php endforeach; ?>
			</ul>
		<script>
			jQuery(document).ready(function($) {
				$("ul.gallery").lightGallery({
					selector: 'ul.gallery a',
					//thumbnail:true
				});

			});
		</script>
	<?php 
		return ob_get_clean();


	elseif ($attr['type'] == 'masonry') :
		ob_start();
		$random = rand(1000000, 10000000);
	?>
		<div class="gallery_wrap_inner  pad-top-20 pad-bot-20">
			<ul id="masonry<?php echo $random; ?>" class="masonry">
				<?php
				foreach ($attachments as $id => $attachment) :
					$image = wp_get_attachment_image_src($id);
					$item_image = wp_get_attachment_image_src($id, array(1400, 1400), false);
				
					$_image = get_post($id);
					if ($_image->post_excerpt) {
						$image_caption = $_image->post_excerpt;
					} else {
						$image_caption = "";
					}
				?>
					<li data-src="<?php echo wp_get_attachment_url($id, '2048x2048'); ?>" data-sub-html="<?php echo $image_caption; ?>">
						<a href="<?php echo wp_get_attachment_url($id, '2048x2048'); ?>" class="venobox"  >
						<?php
							echo wp_get_attachment_image($id, 'medium', "", ["class" => "", 'sizes' => '', 'style' => '']);
							?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		$markup  = ob_get_clean();
		ob_start();
		?>
			$("#masonry<?php echo $random; ?>").lightGallery();
		<?php
		$myScripts .= ob_get_clean();
		return $markup ;

	elseif ($attr['type'] == 'carousel') :
		$random = rand(1000000, 10000000);
		ob_start();
	?>
		<div class="gallery_wrap_inner  pad-top-20 pad-bot-20">
			<ul id="liteSliderGallery<?php echo $random; ?>" class="cS-hidden">
				<?php
				foreach ($attachments as $id => $attachment) :
					$_image = get_post($id);
					if ($_image->post_excerpt) {
						$image_caption = "<div class='gallery_credit'><p>" . $_image->post_excerpt . "</p></div>";
					} else {
						$image_caption = "";
					}
					?>
					<li data-sub-html="<?php echo $image_caption; ?>" data-thumb="<?php echo wp_get_attachment_image_url($id,array(150,100,true)); ?>" data-src="<?php echo wp_get_attachment_url($id, '2048x2048'); ?>">
					<a href="<?php echo wp_get_attachment_url($id, '2048x2048'); ?>" class="gallery_image_wrap venobox"  >

					
							<?php
							if (get_sub_field('adaptiveheight')) {
								echo wp_get_attachment_image($id, 'large', "", []);
							} else {
								echo wp_get_attachment_image($id, 'large', "", []);
							}
							 //echo $image_caption; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php 
		$markup  = ob_get_clean();
		global $myScripts;
		ob_start();
		/* ?>
		$('#liteSliderGallery<?php echo $random; ?>').lightSlider({
			gallery: true,
			item: 1,
			loop:true,
			slideMargin: 0,
			thumbItem: 9
		}); */ ?>

		
	$('#liteSliderGallery<?php echo $random; ?>').lightSlider({
		adaptiveHeight: <?php if (!empty($attr['adaptiveheight'])) {
							echo  $attr['adaptiveheight'];
						} else {
							echo "false";
						} ?>,
		gallery: <?php if (!empty($attr['gallery'])) {
						echo  $attr['gallery'];
					} else {
						echo "false";
					} ?>,
		thumbItem: 9,
		item: <?php if (!empty($attr['item'])) {
					echo  $attr['item'];
				} else {
					echo "1";
				} ?>,
		autoWidth: <?php if (!empty($attr['autowidth'])) {
						echo  $attr['autowidth'];
					} else {
						echo "false";
					} ?>,
		slideMargin: <?php if (!empty($attr['slidemargin'])) {
							echo  $attr['slidemargin'];
						} else {
							echo "0";
						} ?>,
		loop: <?php if (!empty($attr['loop'])) {
					echo  $attr['loop'];
				} else {
					echo "false";
				} ?>,
		auto: <?php if (!empty($attr['auto'])) {
					echo  $attr['auto'];
				} else {
					echo "false";
				} ?>,
		pause: 5000,
	
		vertical: <?php if (!empty($attr['vertical'])) {
						echo  $attr['vertical'];
					} else {
						echo "false";
					} ?>,
		<?php if (!empty($attr['vertical']) && $attr['vertical'] == "true") { ?>
			controls: false,
			gallery: true,
			item: 1,
		<?php } ?>
		enableDrag: true,
		prevHtml: '<i class="icon-left"></i>',
		nextHtml: '<i class="icon-right"></i>',
		currentPagerPosition: 'left',
		onSliderLoad: function(el) {
			$('#liteSliderGallery<?php echo $random; ?>').removeClass('cS-hidden');
			el.lightGallery({
				selector: '#liteSliderGallery<?php echo $random; ?> .lslide',
				thumbnail: true
			});
		},

	});
 
			<?php
	//echo ob_get_clean();
			$myScripts .= ob_get_clean();
		//endif; 
		return $markup;
	endif;
}
