<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560,2560);
$size =   array(1800,1180);
$crop = true;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include( 'set_up_layout_styles.php' );
$images = get_sub_field('gallery_layout');
//print_r($images);
//echo 'get_sub_field(use_page_gallery): '.get_sub_field('use_page_gallery');
//echo 'get_field(page_gallery): '.get_field('page_gallery');
if(get_sub_field('use_page_gallery') && get_field('page_gallery')){

	$images = get_field('page_gallery');
}
//print_r($images);
if($images):
//$images = get_sub_field('gallery_layout');


?>
<div id="<?php echo $id; ?>" class="layer layout_gallery clearfix grid <?php echo $xclass; ?> "> 
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		<ul id="gallery-<?php echo $id; ?>" class="cS-hidden" >
			<?php foreach( $images as $image ):
		  //  print_r($image);
			if($image['caption'] !=''){ 
				 $image['caption'] =  '<p>'.$image['caption'].'</p>';
			}

			  ?>
			    <li data-thumb="<?php echo wp_get_attachment_image_url($image['ID'],array( 'width' => 400, 'height' => 300, 'crop' => true ) ); ?>" data-src="<?php echo wp_get_attachment_image_url($image['ID'],'large' ); ?>" data-sub-html="<?php echo $image['caption']; ?>">		
				<a href="<?php echo wp_get_attachment_url($image['ID'], '2048x2048'); ?>" class=" venobox"  >
<?php // echo wp_get_attachment_image($image['ID'],'large','', array("style"=>"width:100%; height:auto;")); 
echo wp_get_attachment_image($image['ID'], array( 'width' => 2048, 'height' => 1125, 'crop' => true ),'', array('class' => 'cover','sizes'=>'(max-width:2048px) 100vw, 2048px', 'alt' => $image['caption'], 'data-src' => wp_get_attachment_image_url($image['ID'],'large' ), 'data-sub-html'=>$image['caption']));
 ?>
 				<div class="gallery_caption"><?php echo $image['caption']; ?></div>

				</a>
				<?php
		
			 endforeach; ?>
		</ul>
	</div>
</div>
<?php endif;
if(!is_admin()){
ob_start(); ?>
	$('#gallery-<?php echo $id; ?>').lightSlider({
		item:1,
        loop:false,
		pager:false,
		controls:true,
		currentPagerPosition:'left',
		slideMargin:0,
        slideMove:1,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed:600,
        onSliderLoad: function(el) {
			el.removeClass('cS-hidden');
			el.lightGallery({
				selector: '#gallery-<?php echo $id; ?> .lslide',
				thumbnail: true
			});
        }   
    });  
	
<?php
$myScripts .= ob_get_clean();
}
