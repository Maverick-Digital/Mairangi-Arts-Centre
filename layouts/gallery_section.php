<section class="layer gallery clearfix">
	<div class="inner clearfix">

        <?php
         $count = 0;
       
		$images = get_sub_field('images_for_gallery');
		if( $images ): ?>
			<ul class="gallery_images"><?php 
			foreach( $images as $image ): 
				//print_r($image);
				$count ++;
				  $class="";
				if($count > 4){
					$class.=" hidden-xs ";
				}
				if($count > 6){
					$class.=" hidden-sm ";

				}
				if($count > 12){
					break;
				}
				?><li class="<?php echo $class; ?> link-overlay" style="position:relative">
						<a class="venobox "  data-gall="gallery01" href="<?php echo $image['url']; ?>">
							 <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
						</a>
					</li><?php endforeach; ?></ul>
		<?php endif; ?> 
        

    </div>
</section>
