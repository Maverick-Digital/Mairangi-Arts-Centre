<?php
function post_title_shortcode(){
    return get_the_title();
}
add_shortcode('page_title','post_title_shortcode');

add_shortcode('affiliates', function($atts) {
	//echo "mike".get_field("instagram_url");
	ob_start();
	
if (get_field('company_logos','option')): ?>
	<div class="afilliates grid grid-nogutter grid-between grid-center">
		<?php /* if (get_sub_field("content")) { ?>
			<div class="clearfix grid pad-bot-40">
				<div class="col inner inner-narrow ">
						<?php echo get_sub_field('content'); ?>
				
				</div>
			</div>
		<?php 	}  */ ?>
		
				<?php // loop through the rows of data
				$c = 0;
				while (have_rows('company_logos','option')) : the_row();
					$c ++;
				   // if($c == 5 && is_admin()){break;}
					// display a sub field value
					$image = get_sub_field('image');
					$url = get_sub_field('url');
						$name = get_sub_field('name');
					$linkS = '';
					$linkE = '';
					if ($url) {
						$linkS = '<a href="' . $url . '" target="_blank">';
						$linkE = '</a>';
					}
					
					$item_image = wp_get_attachment_image_src($image, array(
						'width' => 200,
						'height' => 130,
						'crop' => false,
						'crop_from_position' => 'center,center',
						'resize' => 'resize-crop',
						'jpeg_quality' => 100,
						'return' => 'url',
						'custom' => false,
						'background_fill' => 'auto',

					));
					if ($item_image) {
						echo '<div class="col">' . $linkS;
						// echo '<img src="' . $item_image[0] . '" alt="' . $name . '"  width="' . $item_image[1] . '" height="' . $item_image[2] . '"  class="casestudy img-responsive" />';
						echo wp_get_attachment_image( $image, 'width=500&height=400&crop=0&resize=1&crop_from_position=center,center' );

						echo $linkE . '</div>';
					}

				endwhile;
				?> 
		</div>
<?php endif;
	return ob_get_clean();

	});


	add_shortcode('company_logos', function($atts) {
		//echo "mike".get_field("instagram_url");
		ob_start();
		require_once( __DIR__.'/../layouts/company_logos.php' ); 
		return ob_get_clean();
	
		});

/*
instgram_icon */

add_shortcode('add_instagram_link', function($atts) {
//echo "mike".get_field("instagram_url");
	if(get_field("instagram_url")){
		$output ='<a target="_blank" href="'.get_field("instagram_url").'" title="View Instagram Profile"><svg height="24" viewBox="0 0 48 48" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m31.9591786 4c6.6394276 0 12.0408214 5.26122862 12.0408214 11.7279466v16.5441068c0 6.4668388-5.4013938 11.7279466-12.0408214 11.7279466h-15.9182332c-6.63942762 0-12.0409454-5.2611078-12.0409454-11.7279466v-16.5441068c0-6.46671798 5.40151778-11.7279466 12.0409454-11.7279466zm7.6928228 28.2720534v-16.5441068c0-4.1315881-3.4509697-7.49285141-7.6928228-7.49285141h-15.9182332c-4.2418531 0-7.69282279 3.36126331-7.69282279 7.49285141v16.5441068c0 4.1315881 3.45096969 7.4928514 7.69282279 7.4928514h15.9182332c4.2418531 0 7.6928228-3.3612633 7.6928228-7.4928514zm-15.5744383-19.4380664c3.5180547.1000046 6.4521849 1.2699851 8.4849462 3.3837282 1.9316998 2.008545 2.91615 4.700696 2.847081 7.7851352-.066341 2.9544816-1.2643222 5.7223606-3.3730966 7.7937104-2.1422548 2.1043224-4.9962799 3.2633121-8.0364317 3.2633121-6.2914786 0-11.4100243-4.9854915-11.4100243-11.1135468 0-6.2362728 5.1788106-11.2920573 11.4875254-11.1123391zm6.0187987 11.0558148c.0266604-1.1878558-.1967908-2.8693329-1.4125044-4.1333998-1.043351-1.0849525-2.6897227-1.6894485-4.7612965-1.7483884-.0558008-.0015701-.1112296-.0022947-.1665344-.0022947-1.5429542 0-3.0028273.6166946-4.1109072 1.7364313-1.1224642 1.1344716-1.7407371 2.6275344-1.7407371 4.2041759 0 3.2738197 2.7344874 5.9372254 6.0956798 5.9372254 3.3430881 0 6.0210307-2.6327279 6.0962998-5.9937497zm4.6846386-12.8765373c1.3559596 0 2.4551114 1.0705799 2.4551114 2.3912919 0 1.3205912-1.0991518 2.3911711-2.4551114 2.3911711-1.3559595 0-2.4551113-1.0705799-2.4551113-2.3911711 0-1.320712 1.0991518-2.3912919 2.4551113-2.3912919z" fill-rule="evenodd"/></svg></a>';
		return '<p class="social-links center">' . $output.'</p>';
	
	}
	return false;
});

add_shortcode('add_business_links', function($atts) {
	//echo "mike".get_field("instagram_url");
		$output ='';
		if(get_field("booking_now_link")){
			$output =' <a class="button" target="_blank" href="'.get_field("booking_now_link").'">Contact Business</a> ';
		}
		$output .='<a class="button"  target="_blank" href="'.get_the_permalink(28).'">Get Listed</a> ';
		return  $output;
		//return false;
	});
add_shortcode('__add_logo', function($atts) {
	//echo "mike".get_field("instagram_url");
		if(get_field("logo")){
			//$output ='<a target="_blank" href="'.get_field("instagram_url").'" title="View Instagram Profile"><svg height="24" viewBox="0 0 48 48" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m31.9591786 4c6.6394276 0 12.0408214 5.26122862 12.0408214 11.7279466v16.5441068c0 6.4668388-5.4013938 11.7279466-12.0408214 11.7279466h-15.9182332c-6.63942762 0-12.0409454-5.2611078-12.0409454-11.7279466v-16.5441068c0-6.46671798 5.40151778-11.7279466 12.0409454-11.7279466zm7.6928228 28.2720534v-16.5441068c0-4.1315881-3.4509697-7.49285141-7.6928228-7.49285141h-15.9182332c-4.2418531 0-7.69282279 3.36126331-7.69282279 7.49285141v16.5441068c0 4.1315881 3.45096969 7.4928514 7.69282279 7.4928514h15.9182332c4.2418531 0 7.6928228-3.3612633 7.6928228-7.4928514zm-15.5744383-19.4380664c3.5180547.1000046 6.4521849 1.2699851 8.4849462 3.3837282 1.9316998 2.008545 2.91615 4.700696 2.847081 7.7851352-.066341 2.9544816-1.2643222 5.7223606-3.3730966 7.7937104-2.1422548 2.1043224-4.9962799 3.2633121-8.0364317 3.2633121-6.2914786 0-11.4100243-4.9854915-11.4100243-11.1135468 0-6.2362728 5.1788106-11.2920573 11.4875254-11.1123391zm6.0187987 11.0558148c.0266604-1.1878558-.1967908-2.8693329-1.4125044-4.1333998-1.043351-1.0849525-2.6897227-1.6894485-4.7612965-1.7483884-.0558008-.0015701-.1112296-.0022947-.1665344-.0022947-1.5429542 0-3.0028273.6166946-4.1109072 1.7364313-1.1224642 1.1344716-1.7407371 2.6275344-1.7407371 4.2041759 0 3.2738197 2.7344874 5.9372254 6.0956798 5.9372254 3.3430881 0 6.0210307-2.6327279 6.0962998-5.9937497zm4.6846386-12.8765373c1.3559596 0 2.4551114 1.0705799 2.4551114 2.3912919 0 1.3205912-1.0991518 2.3911711-2.4551114 2.3911711-1.3559595 0-2.4551113-1.0705799-2.4551113-2.3911711 0-1.320712 1.0991518-2.3912919 2.4551113-2.3912919z" fill-rule="evenodd"/></svg></a>';
			//$output = wp_get_attachment_image(get_field("logo"),'medium'); 
			return '<p class="center">' .wp_get_attachment_image(get_field("logo"),'medium').'</p>';
		
		}
		return false;
	});



	function get_business_location($atts  = null, $size = null){
		$taxonomy =  'business-location';
		$terms = wp_get_post_terms(get_the_ID(), $taxonomy);
		if ($terms) {
			$categories = array();
			foreach ($terms as $term) {
				$categories[] = $term->name;
				}
			return implode(",",$categories);
		} 
		return;
	}
	function get_business_type($atts  = null, $size = null){
		$taxonomy =  'business-type';
		$terms = wp_get_post_terms(get_the_ID(), $taxonomy);
	
		if ($terms) {
			$categories = array();
			foreach ($terms as $term) {
				$categories[] = $term->name;
				}
			return implode(",",$categories);
		} 
		return false;
	}
	




/*
//Trade and Media
 */
/* restricted access 
add_action( 'gform_after_submission_1', function ($entry, $form) {

	// uncomment to review the entry
	//echo "<pre>".print_r(￼$entry,true)."</pre>";
    // get the hidden field, the embedded from page
    $from_page = rgar( $entry, '5' );

    // set the cookie
    setcookie( 'unrestrict_'.$from_page, 1, strtotime( '+5 years' ), COOKIEPATH, COOKIE_DOMAIN, false, false);

    // redirect so we dont land on gravity forms "thank you" page
    wp_redirect( get_permalink( $from_page ) );

}, 10, 2);
*/
/*
//Trade and Media
 */


add_shortcode('add_media', 'add_media_func');
function add_media_func($atts, $content = null)
{

    ob_start(); 
    
    //echo "mike";
    $random = rand(1000000, 10000000);

	$images_field = "media_images";
	$videos_field = "media_videos";
	//$activity_files = "media_files";
	$heading = "Media";

 ?>
<?php





if( get_field('files' )):
 $files = get_field('files');
  
?>
<div class="media-gallery gallery_wrap_inner pad-top-20 pad-bot-20">
	<h3 class="center"><?php echo $heading; ?> Files</h3>

	<ul class="gallery-f">
		<?php
		 foreach( $files as $file ):
		// echo( $file['file']['ID']);
		//print_r($file);
		  	$image =  $file['thumbnail'];
		  	$title= $file['title'];
			$file= $file['file'];
		//	echo $image;
		$thumb = fly_get_attachment_image_src( $image, array( 400, 400), true);
		
			if($thumb){
				$thumb = $thumb['src'];
			}else{
				$thumb = $file['icon'];
			}
			$filesize = ' <span>('.size_format($file['filesize'], 1).')</span>';
		 ?>
			 <li class="g-item" ><a target="_blank" href="<?php echo $file['url']; ?>" style=" background:#f5f5f5 no-repeat center url(<?php echo $thumb; ?>);" >
			 <?php
			 //echo  wp_get_attachment_image( $image, array( 300, 300), true); 
			 
			 ?>
			 <div class="g-copy">
			 <?php echo $title.'.'.$file['subtype'];?> <br/><?php echo $filesize; ?></i>
		 	</div>
		 	</a>
		 	</li>
		 <?php
		 endforeach; ?>
	</ul>
</div>

<?php
endif;


 	$images = get_field('images');
 	
//print_r($images);
//echo get_field('test','options');
if( get_field('images')):
	
	?>
	<div class="media-gallery gallery_wrap_inner pad-top-20 pad-bot-20">
	<h3 class="center"><?php echo $heading; ?> Images</h3>

		<ul id="liteSliderGallery<?php echo $random; ?>" class="list-unstyled row gallery-t"><?php 
			
			//echo "MIKE";
			foreach( $images as $image ):
			//echo $image;
					$item_image = fly_get_attachment_image_src( $image['ID'], array( 1400, 800), false);
					//$item_blank = fly_get_attachment_image_src( 86, array( 900, 600), true);
					$item_thumb = fly_get_attachment_image_src( $image['ID'], array( 400, 400), true);
					//
					//print_r($item_image);
				$item_blank = fly_get_attachment_image_src( $image['ID'], array( 400, 400), true);
				  $src = wp_get_attachment_image_src( $image['ID'], "full", false );
				  //echo $src[0];

			 ?><li class="g-item" data-download-url="<?php echo $src[0]; ?>" data-sub-html="<h4><?php echo $image['title']; ?></h4>			
						<p><?php echo $image['caption']; ?></p>" data-thumb="<?php echo $item_thumb['src']; ?>" data-src="<?php echo $item_image['src']; ?>">
				<a href="<?php echo $src[0]; ?>">
				<?php
				// if(get_sub_field('adaptiveheight')){ 
				echo  fly_get_attachment_image( $image['ID'], array( 300, 300), true);
				///echo wp_get_attachment_image($image['ID'], 'thumbnail');
					
				
				
				//}
			 ?> </a>
					
			</li><?php endforeach; ?></ul>
	</div>
<script>
 jQuery(document).ready(function($) {
	$('#liteSliderGallery<?php echo $random; ?>').lightGallery({
    selector: '.g-item'
	});
});
</script> 

<?php
endif;

 $random = rand(1000000, 10000000);

$videos = get_field('videos');
//print_r($videos);
//echo get_field('test','options');
if( get_field('videos')):
	?>
	<div class="media-gallery gallery_wrap_inner pad-top-20 pad-bot-20">
		<h3 class="center"><?php echo $heading; ?> Videos</h3>

		<ul id="liteSliderGallery<?php echo $random; ?>" class="list-unstyled row gallery-v">
	
			<?php 
			
			//echo "MIKE";
			foreach( $videos as $video ):
		
				// get iframe HTML
				$iframe = $video['video'];
				// use preg_match to find iframe src
				preg_match('/src="(.+?)"/', $iframe, $matches);
				$src = $matches[1];
				// add extra params to iframe src
				$params = array(
					'controls'    => 0,
					'hd'        => 1,
					'autohide'    => 1
				);
				$new_src = add_query_arg($params, $src);
				$iframe = str_replace($src, $new_src, $iframe);
				// add extra attributes to iframe html
				$attributes = 'frameborder="0" style="width:"100%" ';
				$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
			//print_r($video['video']);
			 ?>
				
			<li class="g-item" data-download-url="<?php echo $src; ?>" data-src="<?php echo $src; ?>" >
				<a class="overlay" href="<?php echo $src; ?>"> </a>
				<div class="videoWrapper">
				<?php
				echo $iframe;
				?>
				</div>
			
					
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
<script>
 jQuery(document).ready(function($) {
	$('#liteSliderGallery<?php echo $random; ?>').lightGallery();
});
</script> 
<?php
endif;
    return ob_get_clean();
}



/*
//Bloginfo Shortcode
 */

add_shortcode('bloginfo', function($atts) {

   $atts = shortcode_atts(array('filter'=>'', 'info'=>''), $atts, 'bloginfo');

   $infos = array(
     'name', 'description',
     'wpurl', 'url', 'pingback_url',
     'admin_email', 'charset', 'version', 'html_type', 'language',
     'atom_url', 'rdf_url','rss_url', 'rss2_url',
     'comments_atom_url', 'comments_rss2_url',
   );

   $filter = in_array(strtolower($atts['filter']), array('raw', 'display'), true)
     ? strtolower($atts['filter'])
     : 'display';

   return in_array($atts['info'], $infos, true) ? get_bloginfo($atts['info'], $filter) : '';
});

add_shortcode( 'widget', 'my_widget_shortcode' );
function my_widget_shortcode( $atts ) {

	// Configure defaults and extract the attributes into variables
	extract( shortcode_atts( 
		array( 
			'type'  => 'footer-2',
			'title' => ''
		), 
		$atts 
	));

	$args = array(
		'before_widget' => '<div class="box widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	);

	ob_start();
	 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($type) ) :  endif; 
	//the_widget( $type, $atts, $args ); 
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'quicklinks', 'quicklink_menuFunc' );
function quicklink_menuFunc(  ) {


	ob_start();
	$primaryNav = wp_get_nav_menu_items(113); // Get the array of wp objects, the nav items for our queried location.

	if (!empty($primaryNav)) { ?>
	<div class="blog-filter">
		<ul class="filters"><?php
			foreach ($primaryNav as $navItem) {
				echo '<li><a href="'.$navItem->url.'" title="'.$navItem->title.'">'.$navItem->title.'</a></li>';
			}?>
		</ul>
	</div>
	<?php
	}


	//the_widget( $type, $atts, $args ); 
	$output = ob_get_clean();
	echo $atts['menu'];
	return $output;
}

function cal_percentage($num_amount, $num_total) {
	$count1 = $num_amount / $num_total;
	$count2 = $count1 * 100;
	$count = number_format($count2, 0);
	return $count;
  }

add_shortcode( 'stars', 'starsFunc' );
function starsFunc( $atts ) {

	// Configure defaults and extract the attributes into variables
	extract( shortcode_atts( 
		array( 
			'rating'  => '5'
		), 
		$atts 
	));
	ob_start(); 
	?>
	<div class="star-rating">
		<span style="width: <?php echo cal_percentage($atts['rating'], 5); ?>%"></span>
	</div>
	<?php
	
	$output = ob_get_clean();
	return $output;
}

add_shortcode( 'product_details', 'product_detailsFunc' );
function product_detailsFunc( $atts ) {
	//[product_details adults="$68pp" kids="$38pp" family="$225" duration="2 hours"]
	// Configure defaults and extract the attributes into variables
	extract( shortcode_atts( 
		array(
		), 
		$atts 
	));
	if (empty($atts)) {
		//echo "EMPTY";
		return;
	}

	ob_start(); 
	?>
	<div class="price_table">
		<div class="grid grid-between grid-nogutter">
		<?php if(isset($atts['adults'])) { ?>
			<div class="col price table__heading">
				<div class="grid">
					<div class="col icon table__heading">
						<svg enable-background="new 449 249 62 62" height="62" viewBox="449 249 62 62" width="62" xmlns="http://www.w3.org/2000/svg">
							<path fill="#e1b81a" d="m480 249c-17.1 0-31 13.9-31 31s13.9 31 31 31 31-13.9 31-31-13.9-31-31-31zm0 55.6c-13.6 0-24.6-11-24.6-24.6s11-24.6 24.6-24.6 24.6 11 24.6 24.6-11 24.6-24.6 24.6z"/>
							<path fill="#e1b81a"d="m485.3 278.3c-1.5-.8-3.1-1.4-4.7-2.1-.9-.4-1.8-.8-2.5-1.4-1.5-1.2-1.2-3.2.6-4 .5-.2 1-.3 1.6-.3 2.1-.1 4 .3 5.9 1.2.9.4 1.2.3 1.6-.7.3-1 .6-2.1.9-3.1.2-.7-.1-1.2-.7-1.4-1.2-.5-2.4-.9-3.7-1.1-1.7-.3-1.7-.3-1.7-2 0-2.4 0-2.4-2.4-2.4-.3 0-.7 0-1 0-1.1 0-1.3.2-1.3 1.3v1.5c0 1.5 0 1.5-1.4 2-3.5 1.3-5.6 3.6-5.8 7.4-.2 3.3 1.5 5.6 4.3 7.2 1.7 1 3.6 1.6 5.4 2.4.7.3 1.4.7 1.9 1.2 1.7 1.4 1.4 3.8-.6 4.7-1.1.5-2.3.6-3.4.4-1.8-.2-3.6-.7-5.2-1.6-1-.5-1.2-.4-1.6.7-.3.9-.5 1.8-.8 2.7-.3 1.2-.2 1.5 1 2.1 1.5.7 3.1 1.1 4.7 1.4 1.3.2 1.3.3 1.3 1.6v1.8c0 .8.4 1.2 1.2 1.2h2.7c.7 0 1.1-.4 1.1-1.1 0-.8 0-1.6 0-2.5 0-.8.3-1.3 1.1-1.5 1.8-.5 3.4-1.5 4.6-3 2.9-4 1.7-10-3.1-12.6z"/>
						</svg>
					</div>
					<div class="col table__heading">
						<div class="price_table__heading">
							ADULTS
						</div>
						<?php echo $atts['adults']; ?>
					</div>
				</div>
			</div>
			<?php } 
			 if(isset($atts['price'])) { ?>
				<div class="col price table__heading">
					<div class="grid">
						<div class="col icon table__heading">
							<svg enable-background="new 449 249 62 62" height="62" viewBox="449 249 62 62" width="62" xmlns="http://www.w3.org/2000/svg">
								<path fill="#e1b81a" d="m480 249c-17.1 0-31 13.9-31 31s13.9 31 31 31 31-13.9 31-31-13.9-31-31-31zm0 55.6c-13.6 0-24.6-11-24.6-24.6s11-24.6 24.6-24.6 24.6 11 24.6 24.6-11 24.6-24.6 24.6z"/>
								<path fill="#e1b81a"d="m485.3 278.3c-1.5-.8-3.1-1.4-4.7-2.1-.9-.4-1.8-.8-2.5-1.4-1.5-1.2-1.2-3.2.6-4 .5-.2 1-.3 1.6-.3 2.1-.1 4 .3 5.9 1.2.9.4 1.2.3 1.6-.7.3-1 .6-2.1.9-3.1.2-.7-.1-1.2-.7-1.4-1.2-.5-2.4-.9-3.7-1.1-1.7-.3-1.7-.3-1.7-2 0-2.4 0-2.4-2.4-2.4-.3 0-.7 0-1 0-1.1 0-1.3.2-1.3 1.3v1.5c0 1.5 0 1.5-1.4 2-3.5 1.3-5.6 3.6-5.8 7.4-.2 3.3 1.5 5.6 4.3 7.2 1.7 1 3.6 1.6 5.4 2.4.7.3 1.4.7 1.9 1.2 1.7 1.4 1.4 3.8-.6 4.7-1.1.5-2.3.6-3.4.4-1.8-.2-3.6-.7-5.2-1.6-1-.5-1.2-.4-1.6.7-.3.9-.5 1.8-.8 2.7-.3 1.2-.2 1.5 1 2.1 1.5.7 3.1 1.1 4.7 1.4 1.3.2 1.3.3 1.3 1.6v1.8c0 .8.4 1.2 1.2 1.2h2.7c.7 0 1.1-.4 1.1-1.1 0-.8 0-1.6 0-2.5 0-.8.3-1.3 1.1-1.5 1.8-.5 3.4-1.5 4.6-3 2.9-4 1.7-10-3.1-12.6z"/>
							</svg>
						</div>
						<div class="col table__heading">
							<div class="price_table__heading">
								PRICE
							</div>
							<?php echo $atts['price']; ?>
						</div>
					</div>
				</div>
				<?php } 
			
			if(isset($atts['kids'])) { ?>
			<div class="col price table__heading">
				<div class="price_table__heading">
					Kids
				</div>
				<?php echo $atts['kids']; ?>
			</div>
			<?php } 
			
			if(isset($atts['family'])) { ?>
			<div class="col price table__heading">
				<div class="price_table__heading">
					Family
				</div>
				<?php echo $atts['family']; ?>
			</div>
			<?php } 
			if(isset($atts['groups'])) { ?>
				<div class="col duration table__heading">
					<div class="grid">
						<div class="col icon table__heading">
							<svg enable-background="new 449 249 62 62" height="62" viewBox="449 249 62 62" width="62" xmlns="http://www.w3.org/2000/svg">
								<path fill="#e1b81a" d="m481.3 278.8c0-.1 0-.1 0 0l-10.4-10.4v-6.5c0-.5-.2-.9-.5-1.3l-10.9-11c-.5-.5-1.3-.7-2-.4s-1.1.9-1.1 1.7v5.4h-5.6c-.7 0-1.4.4-1.7 1.1s-.1 1.5.4 2l11 11c.3.3.8.5 1.3.5h6.5l10.4 10.4c.7.7 1.8.7 2.5 0 .8-.7.8-1.8.1-2.5z"/>
								<path fill="#e1b81a" d="m480 249c-4.6 0-9 1.2-13 3l5.6 5.6c2.3-.8 4.8-1.2 7.4-1.2 13 0 23.6 10.6 23.6 23.6s-10.6 23.6-23.6 23.6-23.6-10.6-23.6-23.6c0-2.6.4-5.1 1.2-7.4l-5.6-5.6c-1.8 4-3 8.4-3 13 0 17 14 31 31 31s31-14 31-31-14-31-31-31z"/>
								<path fill="#e1b81a" d="m480 263.7c-1.9 0-3.7.4-5.4 1v2.2l4.2 4.2c.4-.1.8-.1 1.2-.1 5 0 9.1 4.1 9.1 9.1s-4.1 9.1-9.1 9.1-9.1-4.1-9.1-9.1c0-.4.1-.8.1-1.2l-4.2-4.2h-2.2c-.6 1.7-1 3.5-1 5.4 0 9 7.3 16.3 16.3 16.3s16.3-7.3 16.3-16.3c.1-9.1-7.2-16.4-16.2-16.4z"/>
							</svg>

						</div>
						<div class="col table__heading col-align-middle">
							<div class="price_table__heading">
								Groups
							</div>
							<?php echo $atts['groups']; ?>
						</div>
					</div>
				</div>
				<?php } 
			if(isset($atts['duration'])) { ?>
			<div class="col duration table__heading">
				<div class="grid">
					<div class="col icon table__heading">
						<svg enable-background="new 449 249 62 62" height="62" viewBox="449 249 62 62" width="62" xmlns="http://www.w3.org/2000/svg">
							<path fill="#e1b81a" d="m480 249c-17.1 0-31 13.9-31 31s13.9 31 31 31 31-13.9 31-31-13.9-31-31-31zm0 55.7c-13.6 0-24.7-11-24.7-24.7s11-24.7 24.7-24.7 24.7 11 24.7 24.7c0 13.6-11.1 24.7-24.7 24.7z"/>
							<path fill="#e1b81a" d="m481.5 280.8v-16.3h-4.6v18.6l16.3 9.8 2.3-3.8z"/>
						</svg>
					</div>
					<div class="col table__heading">
						<div class="price_table__heading">
							DURATION
						</div>
						<?php echo $atts['duration']; ?>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>


	<?php
	
	$output = ob_get_clean();
	return $output;
}

