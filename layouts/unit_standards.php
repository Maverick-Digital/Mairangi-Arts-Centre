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
<div id="<?php echo $id; ?>" class="layer unit_standards clearfix <?php echo $xclass; ?> "> 
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner inner-<?php echo $inner; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		<ul class="hgrid"><?php
		$c =0;
		while (have_rows('standards')): the_row();
			$c++; ?><li class="hcol">
			<div class='square one square-100'>
				<div class='title'>
				<?php echo get_sub_field('unit'); ?> <br/>
				<?php echo get_sub_field('value'); ?>
				</div>
			</div>
			</li><?php
		endwhile; ?></ul>
	</div>
</div>
<?php
