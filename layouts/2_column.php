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
<section id="<?php echo $id; ?>" class="layer two_col clearfix grid  grid-nogutter <?php echo $xclass; ?> "> 
    <div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
    <div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
        <div class="grid">
            <?php
				$classesLeft = 'col _inner txtwrap '.$content_vertical_align;
				$classesRight = 'col _inner imgwrap '.$content_vertical_align;
       		 ?>
            <div class="<?php echo $classesLeft; ?>">
                <?php if (get_sub_field('left_column')) {
                   // echo get_sub_field('left_column');
                }
                ?>
            </div>
            <div class="<?php echo $classesRight; ?>">
                <?php if (get_sub_field('right_column')) {
                   // echo get_sub_field('right_column');
                }
                ?>
            </div>
        </div> 
    </div> 
</section>