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
<div id="<?php echo $id; ?>" class="layer layout_tiles center clearfix grid <?php echo $xclass; ?> "> 
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
  <div class="inner col clearfix grid">
       <?php
        while (have_rows('layout_tile')):
            the_row();
            $attachment_ID =   get_sub_field('tile_image');
            if ($attachment_ID) {
                $size= get_sub_field("size");
                $sizeS =   array(540,540);
                // $image = wp_get_attachment_image_src($attachment_ID, array('width' => 540, 'height' => 540, 'crop' => true));
                $img = fly_get_attachment_image_src($attachment_ID, $sizeS, false ); 
            }
           
            if(get_sub_field('tile_link')){
                $linkstart = "<a href='".get_sub_field('tile_link')."'>";
                $linkend = "</a>";
                $linkoverlay = "<a class='link-overlay' href='".get_sub_field('tile_link')."'></a>";
            }
             ?>
             <div class="col tile">
              <?php  if ($img) { ?>
              <div class="card background-image" style="background-image:url(<?php echo $img['src']; ?>);padding-top: 56.25%; ">
                <?php echo $linkoverlay; ?>
              </div><!-- .card -->
              <?php } ?>
              <div class="tile-copy">
              <?php 
              /* <span class="readmore"><i class="icon-flower"></i></span> */
              if (get_sub_field('tile_heading')) { ?>
              <h3><?php echo $linkstart; ?><?php echo get_sub_field('tile_heading'); ?><?php echo $linkend; ?></h3>
              <?php } ?>
            <?php if (get_sub_field('layout_tile_content')) {
                  echo get_sub_field('layout_tile_content');
              }
              ?>
              </div>
					</div>
        <?php endwhile; ?>
	</div>
</div>

    
