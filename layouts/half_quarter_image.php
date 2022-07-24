<div class="wrap container_12 half_quarter_image cf">
    <div class="col-xs-10 col-xs-push-1  margin50 cf">

        <div class="col-sm-6">
            <?php
                 global $section;
             if (get_sub_field('12_column_content')) {
                echo get_sub_field('12_column_content');
            }
            ?>
        </div>
        <div class="col-sm-3">
            <?php if (get_sub_field('14_column_content')) {
                echo get_sub_field('14_column_content');
            }
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            $attachment_ID = get_sub_field('image');

            if ($attachment_ID) {
                $image = wp_get_attachment_image_src($attachment_ID, array('width' => 540, 'height' => 540, 'crop' => true));
                if ($image) {
                    $thumb_img = get_post($attachment_ID); // Get post by ID
                    $caption = false;
                    $caption = $thumb_img->post_excerpt; // Display Caption
                }
            } else {

                $image = wp_get_attachment_image_src(376, array('width' => 540, 'height' => 540, 'crop' => true));
                $caption = "";//CAPTION: We are the business behind the businesses that power your local economy";
            }
            ?>

            <img src="<?php echo $image[0] ?>" class="img-responsive "  alt="<?php echo "Eastland ".ucfirst($section)." "; echo get_the_title(); ?>"/>
            <?php if ($caption) {

                echo '<p class="caption">' . $caption . '&nbsp;</p>';
            } ?>

        </div>
    </div>
</div>