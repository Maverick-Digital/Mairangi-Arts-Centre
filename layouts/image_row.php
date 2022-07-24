<div class="wrap container_12 image_row cf" role="main">
    <div class="col-xs-12 row cf">
        <?php
         global $section;
        while (have_rows('row_images')):
            the_row();

            $attachment_ID = get_sub_field('image');
            if ($attachment_ID) {
                $image = wp_get_attachment_image_src($attachment_ID, array('width' => 540, 'height' => 540, 'crop' => true));
                if ($image) {
                    $thumb_img = get_post($attachment_ID); // Get post by ID
                    $caption = false;
                    $caption = $thumb_img->post_excerpt; // Display Caption
                     if (!$caption) {
                         $caption = "";//CAPTION: We are the business behind the businesses that power your local economy";
                     }
                }
            } else {

                $image = wp_get_attachment_image_src(376, array('width' => 540, 'height' => 540, 'crop' => true));
                $caption = "";
            }
            ?>
            <div class="col-xs-6 col-sm-3">
                <img src="<?php echo $image[0] ?>" class="img-responsive "  alt="<?php echo "Eastland ".ucfirst($section)." "; echo get_the_title(); ?>" />
                <?php if ($caption) {

                    echo '<p class="caption">' . $caption . '</p>';
                } ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>
