<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560,2560);
$size =   array(900,450);
$crop = false;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include( 'set_up_layout_styles.php' );

if(get_sub_field('gallery_layout')):
$images = get_sub_field('gallery_layout');


?>
<div id="<?php echo $id; ?>" class="layer layout_gallery clearfix grid <?php echo $xclass; ?> "> 
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner col inner-<?php echo $inner; ?> clearfix">
		<ul id="gallery-<?php echo $id; ?>" class="cS-hidden">
			<?php foreach( $images as $image ):
		   //print_r($image);
			if($image['caption'] ==''){ $image['caption'] =  get_bloginfo( 'name' ); }
			$thumb =  fly_get_attachment_image_src( $image['ID'], array( 400, 300 ), array( 'center', 'center' ) );
			 //print_r($image);
			 //class="background-image" style="<?php echo ipq_get_theme_image_url( $image['ID'], array( 900, 600, true ) );
			  ?>
			    <li data-thumb="<?php echo wp_get_attachment_image_url($image['ID'],array( 'width' => 400, 'height' => 300, 'crop' => true ) ); ?>" data-src="<?php echo wp_get_attachment_image_url($image['ID'],array( 'width' => 1920, 'height' => 1920, 'crop' => false ) ); ?>" data-sub-html="<?php echo $image['caption']; ?>">		
<?php /*
				<img
					alt="Lazy load image example with srcset"
					sizes="88vw"
					data-srcset="http://placehold.it/1920x1000?text=large 1920w,
						http://placehold.it/960x500?text=medium 960w,
						http://placehold.it/480x250?text=small 480w"
					data-src="http://placehold.it/480x250?text=small 480w"
					src="http://placehold.it/480x250?text=small 480w"
					class="b-lazy" style="width:100%; height:auto;"/> */ ?>
				<img
					alt="<?php echo $image['caption']; ?>"
					sizes="88vw"
					data-srcset="<?php echo wp_get_attachment_image_url( $image['ID'],array( 'width' => 1920, 'height' => 1000, 'crop' => true ) ); ?> 1920w,
					<?php echo wp_get_attachment_image_url( $image['ID'],array( 'width' => 960, 'height' => 500, 'crop' => true ) ); ?> 960w,
					<?php echo wp_get_attachment_image_url( $image['ID'],array( 'width' => 480, 'height' => 250, 'crop' => true ) ); ?> 480w"
					data-src="<?php echo wp_get_attachment_image_url( $image['ID'],array( 'width' => 480, 'height' => 250, 'crop' => true ) ); ?>"
					src="<?php echo wp_get_attachment_image_url($image['ID'],array( 'width' => 480, 'height' => 250, 'crop' => true ) ); ?>"
					class="b-lazy" style="width:100%; height:auto;" />
					<?php //echo wp_get_attachment_image( $image['ID'],array( 'width' => 1920, 'height' => 1000, 'crop' => true ) ); */ ?>
 				 </li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif;
ob_start(); ?>
	$('#gallery-<?php echo $id; ?>').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:6,
        slideMargin:0,
        currentPagerPosition:'left',
        onSliderLoad: function(el) {
			el.removeClass('cS-hidden');
            el.lightGallery({
                selector: '#gallery-<?php echo $id; ?> .lslide'
            });
        }   
    });  
<?php
$myScripts .= ob_get_clean();
