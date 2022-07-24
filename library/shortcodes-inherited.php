<?php

/* SHORTCODES */



add_shortcode('alert', 'hwd_alert_wrap');
add_shortcode('label', 'hwd_label_wrap');
add_shortcode('modal', "hwd_modal");
add_shortcode('modal_link', "hwd_modal_link");
add_shortcode('accordion_wrap', 'hwd_accordion_wrap');
add_shortcode('accordion_item', 'hwd_accordion_item');
add_shortcode('make_row', 'hwd_class_row');
add_shortcode('make_col', 'hwd_class_col');
add_shortcode('media_wrap', 'hwd_media_wrap');
add_shortcode('media_body', 'hwd_media_body');
add_shortcode("youtube", "hwd_youtube");
add_shortcode("vimeo", "hwd_vimeo");
add_shortcode("icons", "hwd_icons");
add_shortcode("carousel", "hwd_carousel");
add_shortcode("mobile_carousel", "hwd_portfolio_carousel");
add_shortcode("ibis_booking_iframe", "hwd_ibis_booking_iframe");

add_shortcode('sitemap', 'wp_sitemap_page'); 

add_shortcode('listChildren', 'wp_list_children');

function hwd_alert_wrap( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'type' => 'info',
		'icon' => ''
	), $atts ) );
	
	$output = '<div class="alert alert-'.$type.'">';
	$output.= !empty($icon) ? '<i class="fa fa-'.$icon.' fa-3x pull-left"></i> ' : '';
	$output.= do_shortcode($content) . '</div>';	
	return $output;
}

function hwd_label_wrap( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'type' => 'default',
		'colour' => '',
		'font' => '',
		'icon' => ''
	), $atts ) );
	
	$output = '<span class="label label-'.$type.'"style="';
	$output.= !empty($colour) ? 'background-color:#'.preg_replace('/[^\w-]/', '', $colour).';' : '';
	$output.= !empty($font) ? 'color:#'.preg_replace('/[^\w-]/', '', $font).';' : '';
	$output.= '">';
	$output.= !empty($icon) ? '<i class="fa fa-'.$icon.'"></i> ' : '';
	$output.= do_shortcode($content) . '</span>';		
	return $output;
}


function hwd_modal( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'target' => 'modal_'.uniqid(),
		'btn' => 'btn-primary',
		'btn_text' => '[modal btn_text=""]',
		'title' => '[modal title=""]',
		'link' => true,
		'size' => NULL
	), $atts ) );
	
	if($link===true){
	$output .= '
	<button type="button" class="btn '.$btn.'" data-toggle="modal" data-target="#'.$target.'">'.$btn_text.'</button>
	';
	}
	
	if($size){
		if(in_array(strtolower($size),array('large','lg')))
		$size = 'modal-lg';
		if(in_array(strtolower($size),array('small','sm')))
		$size = 'modal-sm';
	}
              
	$output .= '
	<!-- Modal -->
	<div class="modal fade" id="'.$target.'" tabindex="-1" role="dialog" aria-labelledby="modal_'.get_the_ID().'">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog '.$size.' vertical-align-center" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modal_'.get_the_ID().'Label">'.$title.'</h4>
					</div>
					<div class="modal-body">
					'.do_shortcode($content).'
					</div>
				</div>
			</div>
		</div>
	</div>';
	
	return $output;
}


function hwd_modal_link( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'target' => 'modal_'.get_the_ID(),
		'class' => ''
	), $atts ) );

	return '<a href="#" class="'.$class.'" data-toggle="modal" data-target="#'.$target.'">'.do_shortcode($content).'</a>';
}

function hwd_class_row( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'class' => '',
	), $atts ) );
	return '<div class="row '.$class.'">' . do_shortcode($content) . '</div>';
}

function hwd_class_col( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'type' => 'col-sm-4',
		'class' => '',
	), $atts ) );
	
	return '<div class="'.$type.' '.$class.'">' . do_shortcode($content) . '</div>';
}

function hwd_icons( $atts, $content = null ){	
	return '<div class="clearfix icons">' . do_shortcode($content) . '</div>';
}

function hwd_media_wrap( $atts, $content = null ){	
	return '<div class="media">' . do_shortcode($content) . '</div>';
}

function hwd_media_body( $atts, $content = null ){	
	return '<div class="media-body">' . do_shortcode($content) . '</div>';
}

function hwd_accordion_wrap( $atts, $content = null ){	
	return '<div class="panel-group" id="accordion">' . do_shortcode($content) . '</div>';
}

function hwd_accordion_item( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',		
		'title' => ''
	), $atts ) );
	
	return '
	<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#'.$id.'">'.$title.'</a>
			</h4>
    </div>
    <div id="'.$id.'" class="panel-collapse collapse">
      <div class="panel-body">' . do_shortcode($content) . '</div>
    </div>
  </div>';
}



function hwd_youtube($atts, $content = null) {
	extract( shortcode_atts( array(
		'code' => NULL,
		'related' => false,
		'controls' => false,
		'info' => false,
	), $atts ) );
	
	$variables[] = !$related ? 'rel=0' : '' ;
	$variables[] = !$controls ? 'controls=0' : '' ;
	$variables[] = !$info ? 'showinfo=0' : '' ;
	if($code){
		$output = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="" data-src="//www.youtube.com/embed/'.$code.'?'.implode('&amp;',$variables).'" frameborder="0" allowfullscreen></iframe>';
		$output .= '<p>'. do_shortcode($content) .'</p>';
		$output .= '</div>';
		return $output;
	}
}

function hwd_vimeo($atts, $content = null) {
	extract( shortcode_atts( array(
		'code' => NULL,
		'autoplay' => false,
		'loop' => false,
		'color' => false,
		'title' => false,
		'byline' => false,
		'portrait' => false,
	), $atts ) );
	
	$variables[] = !$autoplay ? '' : 'autoplay=1' ;
	$variables[] = !$controls ? '' : 'loop=1' ;
	$variables[] = $color!=false ? 'color='.$color : '' ;
	$variables[] = $title ? 'title=0' : '' ;
	$variables[] = !$byline ? 'byline=0' : '' ;
	$variables[] = !$portrait ? 'portrait=0' : '' ;
	$output = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="" data-src="https://player.vimeo.com/video/'.$code.'?'.implode('&amp;',$variables).'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	$output .= '<p>'. do_shortcode($content) .'</p>';
	$output .= '</div>';
	return $output;
}


function cmp($a, $b){
    return strcmp($a["attachment_id"], $b["attachment_id"]);
}

function hwd_carousel( $atts, $content = null ){
	extract( shortcode_atts( array(
		'dots' => NULL,		
		'arrows' => NULL,
		'id' => uniqid('carousel_'),
		'shuffle' => false
	), $atts ) );
	
	$output = '<!-- Carousel ================================================== -->
	<div id="'.$id.'" class="carousel slide" data-ride="carousel" data-interval="8000" data-pause="">
				
		<!-- Wrapper for slides -->              
		<div class="carousel-inner">';
		$headers = get_uploaded_header_images();
		rsort($headers);
		if($shuffle) shuffle($headers);
		$i=0;
		$j=0;
		
		foreach($headers as $header) { 
								
			$attachment = get_post($header['attachment_id']);
			$caption = $attachment->post_excerpt;
			$header_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
									
			$output .= '<div class="item ';
			if($i==0) $output .= 'active';
			$output .= '">';
			
			if (!empty($caption)) $output .= '<a href="'.$caption.'">';
			$output .= '<img src="'.$header['url'].'" alt="'.$header_alt.'" />';
			if (!empty($caption)) $output .= '</a>';
			$output .= '</div>';
		
			$i++;
		}
		$output .= '</div>';
		
		if($dots){
			$output .= "\n\t".'<!-- Indicators -->
			<ol class="carousel-indicators">';
				while($j<$i) {
					$output .= '<li data-target="#'.$id.''.$id.'" data-slide-to="'.$j.'" ';
					if($j==0) $output .= 'class="active"';
					$output .= '></li>';
					$j++;
				}
			$output .= '</ol>';
		}
	
		if($arrows){
			$output .= "\n\t".'<!-- Controls -->
			<a class="left carousel-control" href="#'.$id.'" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#'.$id.'" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>';
		}
		
	$output .='</div>';
	return $output;
	
}



// Add 'fancybox' class and title attribute to linked images inserted in post
function fancy_up_the_image_link($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
  $classes = 'fancybox'; // separated by spaces, e.g. 'img image-link'

  // check if there are already classes assigned to the anchor
  if ( preg_match('/<a.*? class=".*?">/', $html) ) {
    $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
  } else {
    $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
  }
	
	//ADD THE IMAGE TITLE TO THE ANCHOR
	$title = get_the_title($id); 
	$html = str_replace("<a ", "<a title=\"$title\" ", $html);
	
  return $html;
}
add_filter('image_send_to_editor','fancy_up_the_image_link',10,8);

// Add 'img-responsive' class to all images & change 'align' to 'pull-' for left and right aligned images

function image_tag_class($class, $id, $align, $size) {
	switch($align){
		default: $output = 'img-responsive align'.$align.' pull-'.$align; break;	
	}	
	return $output;
}
add_filter('get_image_tag_class', 'image_tag_class', 0, 4);



function hwd_portfolio_carousel( $atts, $content = null ){
	extract( shortcode_atts( array(
		'id' => uniqid('carousel_'),
		'minwidth' => 300,		
		'interval' => 5000,
		'dots' => NULL,		
		'arrows' => NULL,		
		'captions' => NULL,
		'thumbnails' => NULL,
		'size' => 'large',
		'class' => ''
	), $atts ) );
	
		
		$i=0;
		$j=0;
		
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => get_the_ID(),
			'orderby' => 'menu_order',
			'order' => 'ASC'
		) );
		
		$attachments = get_attached_media( 'image', get_the_ID() );
				
		if ( $attachments ) {
			
			$output = '<!-- Carousel ================================================== -->
	<div id="'.$id.'" class="hwd-portfolio carousel slide '.$class.'" data-ride="carousel" data-interval="'.$interval.'" data-pause="">
				
		<!-- Wrapper for slides -->              
		<div class="carousel-inner text-center">';
			
			foreach($attachments as $attachment) { 						
				$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
						
				$caption = get_post_field('post_excerpt', $attachment->ID);
				$header_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);										
				$image = wp_get_attachment_image_src($attachment->ID, $size);
											
				if($image[1]>=$minwidth){
					$output .= "\n\t\t".'<div class="item ';
					if($i==0) $output .= 'active';
					$output .= '" style="background: url('.$image[0].') 50% / cover no-repeat">';
					
					$output .= "\n\t\t\t".'<img src="'.$image[0].'" alt="'.$header_alt.'" style="visibility:hidden;height:600px" />';
									
					if($captions){
						$output .= "\n\t\t\t".'<div class="carousel-caption">';
						$output .= '<p>'.$caption.'</p>';
						$output .= '</div>';
					}
					
					$output .= '</div>';
					$i++;
				}
			}
			$output .= '</div>';
			
		if($arrows && $attachments){
			$output .= "\n\t".'<!-- Controls -->
			<a class="left carousel-control" href="#'.$id.'" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#'.$id.'" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>';
		}
		
		$output .='</div><!-- /#'.$id.' -->';	
	}
	
	if($thumbnails){
		$s=0;
		if ( $attachments ) {
			$output .= '<div id="carousel-thumbnails" class="row">';
			foreach($attachments as $attachment) { 						
						
				$header_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);										
				$image = wp_get_attachment_image_src($attachment->ID, 'carousel-thumb');
											
				$output .= "\n\t\t".'<div class="carousel-thumbnail col-xs-4 col-sm-3 col-md-2';
				if($s==0) $output .= ' active';
				$output .= '">';
				
				$output .= "\n\t\t\t".'<img src="'.$image[0].'" alt="'.$header_alt.'" class="img-responsive cursor" data-target="#'.$id.'" data-slide-to="'.$s++.'" />';
										
				$output .= '</div>';
					
			}
			$output .= '</div>';
		}
	}
	
	return $output;
	
}



function hwd_ibis_booking_iframe( $atts, $content = null ){
  $product = get_query_var('product');

  if (!empty($product)) {
      $prodLink = '/Index?ProductCode='.$product;
  }else{
	$prodLink = '/Index?ProductCode=ProdGroup-DuckTours';
  }
  
  $output = '<script src="https://rotoduck.ibisnz.com/Scripts/plugin.js"></script><iframe id="booking-frame" class="ibis-iframe" src="https://rotoduck.ibisnz.com/Departures'.$prodLink.'" width="100%" height="1500" frameborder="0" onload="window.parent.parent.scrollTo(0,0)"></iframe>';
  
  return $output;
  
}


function wp_sitemap_page(){
	return "<ul>".wp_list_pages('title_li=&echo=0')."</ul>";
}
function wp_list_children( $atts, $content = null ){	
	extract( shortcode_atts( array(
		'depth' => 1,
		'children' => false,
	), $atts ) );
	
	global $post;		
	$parent = $post->post_parent;
	
	if(is_user_logged_in()){
		$logoutLink = wp_loginout( site_url( '/trade/' ), false );
	}
	
	if(is_search()) return "&nbsp;";
	
	if($parent!=0 && $children===false){
	
		$siblings = wp_list_pages(array(
			'title_li' 		=> '',
			'child_of' 		=> $parent,
			'echo'		 		=> 0,
			'depth'				=> $depth,
			'walker' 			=> new list_group_walker()
		));
		if($siblings)
			return "<ul class='list-group'>".$siblings.$logoutLink."</ul>";
			
	}else{		
		
		$children = wp_list_pages(array(
			'title_li' 		=> '',
			'child_of' 		=> $post->ID,
			'echo'		 		=> 0,
			'depth'				=> $depth,
			'walker' 			=> new list_group_walker()
		));
		if($children)
			return "<ul class='list-group'>".$children.$logoutLink."</ul>";
			
	}
}
function show_loggedin_function( $atts ) {

	global $current_user, $user_login;
      	get_currentuserinfo();
	add_filter('widget_text', 'do_shortcode');
	if ($user_login) 
		return 'Welcome ' . $current_user->display_name . '!';
	else
		return '<a href="' . wp_login_url() . ' ">Login</a>';
	
}
add_shortcode( 'show_loggedin_as', 'show_loggedin_function' );
?>