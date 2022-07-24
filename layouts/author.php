<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560,2560);
$size =   array(1400,900);
$crop = true;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include( 'set_up_layout_styles.php' );

	$image = fly_get_attachment_image_src( get_sub_field('image'), array( 200, 200 ), array( 'center', 'top' ) );
	$signature = fly_get_attachment_image_src( get_sub_field('signature'), array( 200, 200 ), false );
	$author = get_sub_field("author");
	$text = get_sub_field('content');
?>
<section id="<?php echo $id; ?>" class="layer layout_2col_images clearfix grid <?php echo $xclass; ?> "> 
	<div class="inner <?php echo $xclass; ?>  clearfix">
		<div class="author_content inner-1170">
		<div class="author_image">
			<img class="anim" alt="" src="<?php echo $image['src']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
		</div>
		<div class="author_title">
		<img class="anim" alt="" src="<?php echo $signature['src']; ?>" width="<?php echo $signature['width']; ?>" height="<?php echo $signature['height']; ?>" />
		<p><?php echo $author; ?></p></div>
	<?php 
	 	
        echo $text;
    ?>
     	</div>
    </div>
</section>