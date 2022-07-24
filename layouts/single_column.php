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

?>
<div id="<?php echo $id; ?>" class="layer grid single_column <?php echo $xclass; ?>">
	<div class="bg-image background-image <?php echo $class; ?>" >
		<?php
		if (isset($fields['bg_focal_point'])) {
			$coords = explode(',', $fields['bg_focal_point']);
			$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
		} else {
			$imgpos =  " object-position:50% 50%; ";
		}	
		?>
		<?php 
		/// default <?php echo $xclass; 
		echo wp_get_attachment_image($fields['bg_image'], '2048x2048', "", ["class" => "cover",  'style'=> $imgpos ]);
		?>
	</div>
	<?php if(isset($fields['vertical_title']) && $fields['vertical_title'] != '' ){ ?>
	<div class="col col-fixed"  style='width:6em;'>
		<div class="verttext">
			<h2><strong><?php echo $fields['vertical_title']; ?></strong></h2>
		</div>
	</div>
	<?php } ?>
	<div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
	<?php 
		//  echo get_sub_field('content');
		  echo apply_filters( 'the_content', get_sub_field('content',false, false) );

		?>
    </div>
</div>

