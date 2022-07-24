<div class="wrap container_12   row cf" >
    <div class="cf  <?php echo get_sub_field('layout_class'); ?>">
        <?php
        //left : Images on left
        // right : Images on right
         global $section;
       if (get_sub_field('layout_class') == 'left') {
            $classesLeft = 'col-sm-6 col-sm-push-6 col-md-5 col-md-push-6 textwrap margin50';
            $classesRight = 'col-sm-6 col-sm-pull-6 col-md-6 col-md-pull-5 imgwrap';
        } else if (get_sub_field('layout_class') == 'right') {
            $classesLeft = 'col-sm-6  col-md-5 col-md-push-1 textwrap margin50';
            $classesRight = 'col-sm-6  col-md-6 col-md-push-1 imgwrap';
        }
        ?>
        <div class="<?php echo $classesLeft; ?>">
            <?php if (get_sub_field('text')) {
                echo get_sub_field('text');
            }
            ?>
        </div>
        <div class="<?php echo $classesRight; ?>">

            <?php
                
                $attachment_ID = get_sub_field('image_1');

                if ($attachment_ID) {
                    $image = wp_get_attachment_image_src($attachment_ID, array('width' => 694, 'height' => 495, 'crop' => true));
                    if ($image) {
                        $thumb_img = get_post($attachment_ID); // Get post by ID
                        $caption = false;
                        $caption = $thumb_img->post_excerpt; // Display Caption
                        if (!$caption) {
                         $caption = "";
                           } 
                    }
                } else {

                    $image = wp_get_attachment_image_src(2771, array('width' => 694, 'height' => 495, 'crop' => true));
                    $caption = "";
                }
                ?>

                <img src="<?php echo $image[0] ?>" class="img-responsive max500" alt="<?php echo "Eastland ".ucfirst($section)." "; echo get_the_title(); ?>"  />
                <?php if ($caption) {

                    echo '<p class="caption">' . $caption . '</p>';
                } ?>
        </div>
    </div>
</div>