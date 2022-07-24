<section class="layer product_group">
<?php

  while (have_rows('testimonial')):
            the_row();
           //print_r( the_row());

 //$testimonial = get_sub_field('product_g_content');
//echo "mike";
// echo get_sub_field('product_g_content');
/*
echo get_sub_field('product_g_content');
 $name = get_sub_field('product_g_name');
 $byline = get_sub_field('product_g_byline');
 $attachment_ID =get_sub_field("product_g_img");
  $sizeS =   array(330,330);
 $img = fly_get_attachment_image_src($attachment_ID, $sizeS, true ); 
 */
//if($testimonial):

$content =  get_sub_field('product_g_content');

?>


<div class="product_g clearfix" id="<?php echo get_sub_field('product_g_icon'); ?>">
	<div class="inner">

	<div class="imgBox <?php echo get_sub_field('product_g_icon'); ?>">	
<i class="icon icon-<?php echo get_sub_field('product_g_icon'); ?>"></i>
</div>
	<div class="layerCopy">
	<?php //echo "mike";
	echo $content;//get_sub_field('product_g_content');
		  ?>
	
										<div class="buttonGroup">
			<a target="_blank" href="#" class="button small">Find out more</a> 
			<a target="_blank" href="#" class="button small">Call to action</a>

		</div><!-- end div.buttonGroup -->
		
	</div><!-- end div.layerCopy -->
</div>
	</div>

						

			      <?php // endif;
endwhile; ?>
</section>