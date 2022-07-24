<?php

function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
   }
add_filter('upload_mimes', 'cc_mime_types');



// This is a decent way of grabbing the dimensions of SVG files.
// Depends on http://php.net/manual/en/function.simplexml-load-file.php
// I believe this to be a reasonable dependency and should be common enough to
// not cause problems.
function get_dimensions( $svg ) {
	$svg = simplexml_load_file( $svg );
	$attributes = $svg->attributes();
	$width = (string) $attributes->width;
	$height = (string) $attributes->height;

	return (object) array( 'width' => $width, 'height' => $height );
}

// Browsers may or may not show SVG files properly without a height/width.
// WordPress specifically defines width/height as "0" if it cannot figure it out.
// Thus the below is needed.
//
// Consider this the "server side" fix for dimensions.
// Which is needed for the Media Grid within the Administration area.
function set_dimensions( $response, $attachment, $meta ) {
	if( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ) {
		$svg_file_path = get_attached_file( $attachment->ID );
		$dimensions = get_dimensions( $svg_file_path );

		$response[ 'sizes' ] = array(
				'full' => array(
					'url' => $response[ 'url' ],
					'width' => $dimensions->width,
					'height' => $dimensions->height,
					'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
			)
		);
	}

	return $response;
}

// Browsers may or may not show SVG files properly without a height/width.
// WordPress specifically defines width/height as "0" if it cannot figure it out.
// Thus the below is needed.
//
// Consider this the "client side" fix for dimensions. But only for the Administration.
//
// WordPress requires inline administration styles to be wrapped in an actionable function.
// These styles specifically address the Media Listing styling and Featured Image
// styling so that the images show up in the Administration area.
function administration_styles() {
	// Media Listing Fix
	wp_add_inline_style( 'wp-admin', ".media .media-icon img[src$='.svg'] { width: auto; height: auto; }" );
	// Featured Image Fix
	wp_add_inline_style( 'wp-admin', "#postimagediv .inside img[src$='.svg'] { width: 100%; height: auto; }" );
}

// Browsers may or may not show SVG files properly without a height/width.
// WordPress specifically defines width/height as "0" if it cannot figure it out.
// Thus the below is needed.
//
// Consider this the "client side" fix for dimensions. But only for the End User.
function public_styles() {
	// Featured Image Fix
	echo "<style>.post-thumbnail img[src$='.svg'] { width: 100%; height: auto; }</style>";
}

// Restores the ability to upload non-image files in WordPress 4.7.1 and 4.7.2.
// Related Trac Ticket: https://core.trac.wordpress.org/ticket/39550
// Credit: @sergeybiryukov
// @TODO: Remove the plugin once WordPress 4.7.3 is available!
function disable_real_mime_check( $data, $file, $filename, $mimes ) {
	$wp_filetype = wp_check_filetype( $filename, $mimes );

	$ext = $wp_filetype['ext'];
	$type = $wp_filetype['type'];
	$proper_filename = $data['proper_filename'];

	return compact( 'ext', 'type', 'proper_filename' );
}

add_filter( 'wp_prepare_attachment_for_js', 'set_dimensions', 10, 3 );
add_action( 'admin_enqueue_scripts', 'administration_styles' );
// add_action( 'wp_head', '\public_styles' );
function wpse240579_fix_svg_size_attributes( $out, $id ) {
    $image_url  = wp_get_attachment_url( $id );
    $file_ext   = pathinfo( $image_url, PATHINFO_EXTENSION );

    if ( is_admin() || 'svg' !== $file_ext ) {
        return false;
    }

    return array( $image_url, null, null, false );
}
add_filter( 'image_downsize', 'wpse240579_fix_svg_size_attributes', 10, 2 ); 

// fix image width warning on svg
function wp_get_attachment_metadata_mine($data) {
    $res = $data;
   if (!isset($data['width']) || !isset($data['height'])) {
        $res = false;
     }
     return $res;                                                                                                                                                            
 }
 add_filter( 'wp_get_attachment_metadata' , 'wp_get_attachment_metadata_mine' );


?>