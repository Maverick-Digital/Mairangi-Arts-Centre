<section class="layer edge day-by-day <?php echo get_post_type(); ?>">
	
	<div class="grid inner medium clearfix">
		<div class="section-head">
			<h1>Day By Day</h1>
		</div><!-- .section-head -->
 <?php
          
        while (have_rows('day_by_day')):
            the_row(); ?>
            <div class="daybyday clearfix row">
            	<div class="col-2-3">
				<?php if (get_sub_field('day_number')) { ?>
					<div class="daynum abs"><?php  echo get_sub_field('day_number'); ?></div>
				<?php  } ?>
					 <div class="page_layout blog-section">
						<?php
						if (get_sub_field('title')) { ?>
							<h2 class="marketweb"><?php echo get_sub_field('title'); ?></h2>
						<?php } ?>
						<?php if (get_sub_field('content')) {
							echo get_sub_field('content');
						}
				
						?>
					</div>
				</div>
          <div class="col-1-3">
         <?php 

$images = get_sub_field('gallery');

if( $images ): ?>
    <ul class="image_gallery">
        <?php foreach( $images as $image ): 
        
            $item_image_L = fly_get_attachment_image_src( $image['id'], array( 1024, 1024), false);
    	$item_image = fly_get_attachment_image_src( $image['id'], array( 322, 224), true);
        
        ?>
            <li>
                <a class="venobox hoverfx "  data-gall='gallery' href="<?php echo $item_image_L['src']; ?>" >
                     <img class="anim" src="<?php echo $item_image['src']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $item_image['width']; ?>" height="<?php echo $item_image['height']; ?>" />
                </a>
                <?php if($image['caption']){ ?>
                <p class="caption"><?php echo $image['caption']; ?></p>
                <?php } ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
          </div>
          
        </div>
            
        <?php endwhile; ?>
					
						
										
					
			
<?php /*
									<div class="button-group center">
													<a href="/tips-trends/" class="button black medium">All tips &amp; trends</a>
											</div>	
*/	?>			
			</div><!-- .inner -->
		</section>

