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

//echo "XCLASS: ".$xclass;

?>
<div id="<?php echo $id; ?>" class="layer grid single_column <?php echo $xclass; ?>">
<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		<?php
		 $text = get_sub_field('content');
			echo $text;
		?>
		<blockquote>mmasmdasmdsadas</blockquote>
    </div>
</div>

