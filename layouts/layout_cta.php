<?php
$attachment_ID =   get_sub_field('image');
         

            if ($attachment_ID) {
            $size =   array(1500,null);
             $img = fly_get_attachment_image_src($attachment_ID, $size, false ); 
				}

?>
<section class="layer layout_cta clearfix background-image no-overlay" style="background-image:url(<?php echo $img['src']; ?>)" >
	<div class="inner  <?php echo get_sub_field('class'); ?> ">
					<div class="intro-copy dark inner-700 red_wood center">

	<?php if (get_sub_field('content')) {
            echo get_sub_field('content');
        }
        ?>
        </div>
    </div>
</div> 