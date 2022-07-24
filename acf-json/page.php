<?php
	

get_header();
$c = 0;
/*
// convert shortcode
	function vc_masonry_media_grid($tag) {
	//echo "<br/> wpd_check_shortcode";
	//print_r($tag);
	$attributes = shortcode_parse_atts($tag[1]);
	if (array_key_exists('include', $attributes)) {
		$newTag = '[gallery type="masonry" ids="'.$attributes['include'].'"]';
		//echo $newTag;
		return $newTag;
		}
	return $tag[0];
	}

	function vc_hoverbox($content) {
		//echo "<br/> vc_hoverbox";
		preg_match_all("/(\[vc_hoverbox.*?\[\/vc_hoverbox\])/s", $content, $matches );
		//print_r($tag);
		//print_r($matches);
		
		//$attributes = shortcode_parse_atts($tag[1]);
		if ( ! empty( $matches ) ){
			$i=0;
			//echo $matches[0];
			$text = '';
			foreach ( $matches[0] as $match ) {
				//echo "<br/>match";
				//print_r($match);
				$match  = str_replace('h2', 'h4', $match);
				$attributes = shortcode_parse_atts($match);
				if (array_key_exists('image', $attributes)) {
					$url = wp_get_attachment_image_url((int) $attributes['image'], 'large'); //$matches[2]
					$img = sprintf('<img src="%s" class="alignleft" />', $url);
					//echo $img;
					//echo($matches[0][$i]);
					//echo($img.$match);
					//echo "<br/>";
					$text .= $img;
					//$content = str_replace($matches[0][$i], $img.$match, $content);

				//	$newTag = '[gallery type="masonry" ids="'.$attributes['include'].'"]';
					//echo $newTag;
				//	return $newTag;
					}
					if (array_key_exists('primary_title', $attributes)) {
						$text .= '<h3>'.$attributes['primary_title'].'</h3>';
						//$content = str_replace($matches[0][$i], $img.$match, $content);
					}
					$content = str_replace($matches[0], '<hr/>'.$text.$match, $content);
				//print_r($attributes);
				//$rstr =  preg_replace('/\[vc_raw_html(.*?)\]/s', '', $match);
				//$rstr = str_replace('[/vc_raw_html]', '', $rstr);
				//$rstr = urldecode(base64_decode($rstr));

				//$rstr = base64_decode( $match );
				//$content = str_replace( $match, $rstr, $content );
				//$i++;
				//echo $content;
				$i++;
			}
			
		}
	
		$content =  preg_replace('/\[vc_hoverbox(.*?)\]/s', '', $content);
		$content = str_replace('[/vc_hoverbox]', '', $content);
		return $content;
		}
	
	// You function beuaty 
	function convert_raw_html($content){
		//[vc_raw_html(.*?)?](?:(.+?)?[/vc_raw_html])?
		//$rhtml = preg_match("(?<=\[vc_raw_html]).*?(?=\[\/vc_raw_html])");
		preg_match_all("/(\[vc_raw_html.*?\[\/vc_raw_html\])/s", $content, $matches );
		//preg_match_all("/\[vc_raw_html.*\/vc_raw_html\]/s", $content, $matches );
		//preg_match_all("/\[vc_raw_html\](.*?)\[\/vc_raw_html\]/s", $content, $matches );
		//print_r($matches);
		if ( ! empty( $matches ) ){
			$i=0;
			//echo $matches[0];
			foreach ( $matches[0] as $match ) {
				//echo "<br/>match";
				$rstr =  preg_replace('/\[vc_raw_html(.*?)\]/s', '', $match);
				$rstr = str_replace('[/vc_raw_html]', '', $rstr);
				$rstr = urldecode(base64_decode($rstr));

				//$rstr = base64_decode( $match );
				$content = str_replace( $match, $rstr, $content );
				$i++;
				//echo $content;
			}
		}
		return $content;
	}
	*/
/*
// move data from default acf field.
$wp_query = new WP_Query(array(
	'post_type' => array('page'),
	'posts_per_page'	=> -1,
	'post__not_in' => array(27,51,2915)

));
$count = 0;

while ($wp_query->have_posts()) :  $wp_query->the_post();
*/
/*
	// get post_content from default post WYSIWYG


	 // source text with shortcode



	$default_field_content = get_post_field('post_content', (get_the_ID()));



	///$text = preg_replace('/\[vc_masonry_media_grid(.*?)\]/', '<hr/>', $default_field_content);
	
	
	// process all shortcodes through our callback function
	$default_field_content = preg_replace_callback("/\[vc_masonry_media_grid(.*?)\]/s", 'vc_masonry_media_grid', $default_field_content);
	$default_field_content = preg_replace_callback("/\[vc_masonry_media_grid(.*?)\]/s", 'vc_masonry_media_grid', $default_field_content);
	$default_field_content = preg_replace_callback("/\[vc_masonry_media_grid(.*?)\]/s", 'vc_masonry_media_grid', $default_field_content);
	$default_field_content = preg_replace_callback("/\[vc_masonry_media_grid(.*?)\]/s", 'vc_masonry_media_grid', $default_field_content);
	$default_field_content = convert_raw_html($default_field_content);
	$default_field_content = vc_hoverbox($default_field_content);

	//$default_field_content = preg_replace_callback("/\[vc_raw_html].*?\/[\/vc_raw_html]/s", 'vc_raw_html', $default_field_content);


	//echo $default_field_content;
	//echo get_the_ID();
	//echo $default_field_content;

	// example raw_html "JTNDZGl2JTIwY2xhc3MlM0QlMjJmbGF0aWNvbi1tb25leSUyMiUzRSUzQyUyRmRpdiUzRQ=="
	// be awesome to pregreplace into actual iframes for reference... but can appreciate the simplicity allowed bby using raw base64 encodeed iframes in content.
	// ? import to core
	// replace vc_image to actual <img> :)
	

	//[vc_btn title="Click to listen to full interview with Tom" color="primary" align="center" button_block="true" link="url:https%3A%2F%2Fwww.aucklandseakayaks.co.nz%2Fwp-content%2Fuploads%2F2020%2F09%2Ftom-complete.mp3||target:%20_blank|"]

$default_field_content = str_replace('vc_btn title', 'add_booking_but text', $default_field_content);


$default_field_content = str_replace('[/vc_row]', '[/vc_row]

', $default_field_content);

while ($x <= 50) {
	preg_match('/\[vc_single_image image="(\d+)" img_size="(\w+)"[^\]]*\]/', $default_field_content, $matches);
	if (isset($matches[1])) {
		$url = wp_get_attachment_image_url((int) $matches[1], 'large'); //$matches[2]
		$img = sprintf('<img src="%s" class="aligncenter" />', $url);
		$default_field_content = str_replace($matches[0], $img, $default_field_content);
		//wp_update_post( [ 'ID' => get_the_ID(), 'post_content' => $new_content] );
	}else{
		break;
	}
	$x ++;
}
while ($x <= 50) {
	preg_match('/\[vc_single_imageimage="(\d+)" [^\]]*\]/', $default_field_content, $matches);
	if (isset($matches[1])) {
		$url = wp_get_attachment_image_url((int) $matches[1], 'large'); //$matches[2]
		$img = sprintf('<img src="%s" class="aligncenter" />', $url);
		$default_field_content = str_replace($matches[0], $img, $default_field_content);
		//wp_update_post( [ 'ID' => get_the_ID(), 'post_content' => $new_content] );
	}else{
		break;
	}
	$x ++;
}


$default_field_content = str_replace('[vc_video link', '[video src', $default_field_content);

// [vc_masonry_media_grid element_width="6" grid_id="vc_gid:1587345890616-5df4f651-fc73-5" include="482,481,480,479,484,439,438,432,446,3048"]

$default_field_content = preg_replace('/\[vc_text_separator(.*?)\]/', '<hr/>', $default_field_content);
$default_field_content = preg_replace('/\[vc_separator(.*?)\]/', '<hr/>', $default_field_content);


	//$default_field_content = str_replace('[vc_row]', '', $default_field_content);
	$default_field_content = preg_replace('/\[vc_row(.*?)\]/', '', $default_field_content);


	$default_field_content = preg_replace('/\[\/vc_row(.*?)\]/', '', $default_field_content);

	//$default_field_content = str_replace('[vc_column]', '', $default_field_content);
	$default_field_content = preg_replace('/\[vc_column(.*?)\]/', '', $default_field_content);
	$default_field_content = preg_replace('/\[\/vc_column(.*?)\]/', '', $default_field_content);
	//$default_field_content = str_replace('[vc_column_text]', '', $default_field_content);
	$default_field_content = preg_replace('/\[vc_column_text(.*?)\]/', '', $default_field_content);
	$default_field_content = str_replace('[/vc_column_text]', '', $default_field_content);


// [vc_gallery type="image_grid" images="26783,26785,26784,26999,26997,26996,26998,26993,26992"] => [gallery ids="28474,28473"]
	$default_field_content = str_replace('vc_gallery type="image_grid" images=', 'gallery  columns="3" ids=', $default_field_content);
	//$default_field_content = preg_replace("/\[vc_raw_html.*]/m", "", $default_field_content);


	
	$default_field_content = preg_replace("/\[ultimate_carousel(.|\n|\r)*?ultimate_carousel]/", '', $default_field_content);
	//$default_field_content = preg_replace("/\[(\/*)?vc(.*?)\]/", '', $default_field_content);
	$default_field_content = preg_replace("/\[ultimate_spacer(.*?)\]/", '', $default_field_content);

	

	$default_field_content = str_replace('<h3>', '<h4>', $default_field_content);
	$default_field_content = str_replace('</h3>', '</h4>', $default_field_content);
	$default_field_content = str_replace('<h2>', '<h3>', $default_field_content);
	$default_field_content = str_replace('</h2>', '</h3>', $default_field_content);
	$default_field_content = str_replace('<h1>', '<h2>', $default_field_content);
	$default_field_content = str_replace('</h1>', '</h2>', $default_field_content);
	
	$default_field_content = str_replace('<h5>', '<h4>', $default_field_content);
	$default_field_content = str_replace('</h5>', '</h4>', $default_field_content);
	$default_field_content = str_replace('<h6>', '<h4>', $default_field_content);
	$default_field_content = str_replace('</h6>', '</h4>', $default_field_content);
	//echo apply_filters('the_content', $default_field_content);
	//echo "<hr/><hr/><hr/><hr/><hr/>";

	//break;
	// add to flexible content
	$row = array(
		array(
			'content' => $default_field_content, // field name
			'acf_fc_layout' => 'single_column' // layout name
		),
	);
	// flexible content field key value (have to use ‘inspect’ in ACF admin to get it
	$field_key = 'page_layout';
	
	// update the field
	// MOVE TO ACF
	if (!is_front_page()) {
	//	update_field($field_key, $row, get_the_ID());
	}
	/*
	// REMOVE DEFAULT OCNTENT
	wp_update_post(array(
		'ID' => get_the_ID(),
		'post_content' => '',
	));

	echo get_the_ID() . " ";

endwhile;
wp_reset_postdata();
*/
if(get_the_content()){
	?>
	<div id="main" class="layout_wrap">
		<div class="page_layout" >
			<div class="inner pad-bot-60 pad-top 60">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
	<?php
	}
if (have_rows('page_layout')) : ?>
	<div id="main" class="layout_wrap">

		<?php



		//if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); 
		?>
		<?php
		while (have_rows('page_layout')) : the_row();
			$c++;
			$fields = get_sub_field('settings');
			if (isset($fields[0])) {
				$fields = $fields[0];
			} else {
				$fields = $fields['row-0'];
			}
		?>
			<div class="page_layout loop-<?php echo $c; ?>">
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
	</div>
<?php
endif;



/*
if (is_front_page()) {
} else {
?>
	<section class="layer single single_column grid content  pad-top-default pad-bot-default">
		<div class=" inner inner-1170 col  clearfix ">
			<div class="navigation grid">
				<div class="col">
					<?php //echo previous_page_not_post();
					?>
					<?php //echo next_page_not_post();
					?>
					<?php $prevPost = get_previous_post(); ?>
					<span class="older-posts"><?php previous_post_link('%link', '<i class="icon-left-arrow"></i> PREVIOUS'); ?></span>
					<h4><?php previous_post_link('%link', '%title'); ?></h4>
				</div>
				<div class="col">
					<span class="older-posts"><?php next_post_link('%link', 'NEXT <i class="icon-right-arrow"> </i>'); ?></span>
					<h4><?php next_post_link('%link', '%title'); ?></h4>

				</div>
			</div>
		</div>
	</section><?php
			}
			*/
get_footer(); ?>