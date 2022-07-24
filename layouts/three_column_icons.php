<div class="three_column_icons row clearfix" role="main">
    <div class="_col-md-10 _col-md-push-1 text-center cf">
    
        <div class="col-sm-4 cf">
        <a href="<?php echo get_sub_field('left_column_link'); ?>">
            <?php
                $image = wp_get_attachment_image_src(get_sub_field('left_column_icon'), 'full');
                if($image){
                ?>
            <div class="icon">
               
                <img src="<?php echo $image[0] ?>" class="img-responsive waypoint animation_top"  alt="Eastland Group" />
            </div>
            <?php } 
            ?>
            <div class="_content">
                <?php if (get_sub_field('left_column_content')) {
                    echo get_sub_field('left_column_content');
                }
                ?>
                 <span class="readmore">READ MORE</span>
            </div>
            </a>
        </div>
        <div class="col-sm-4 cf">
        <a href="<?php echo get_sub_field('middle_column_link'); ?>">
         <?php
                $image = wp_get_attachment_image_src(get_sub_field('middle_column_icon'), 'full');
                if($image){
                ?>
            <div class="icon">
               
                <img src="<?php echo $image[0] ?>" class="img-responsive waypoint animation_top"  alt="Eastland Group" />
            </div>
            <?php } 
            ?>
            <div class="_content">
                <?php if (get_sub_field('middle_column_content')) {
                    echo get_sub_field('middle_column_content');
                }
                ?>
                 <span class="readmore">READ MORE</span>
            </div>
</a>
        </div>
        <div class="col-sm-4 cf">
        <a href="<?php echo get_sub_field('right_column_link'); ?>">
         <?php
                $image = wp_get_attachment_image_src(get_sub_field('right_column_icon'), 'full');
                if($image){
                ?>
            <div class="icon">
               
                <img src="<?php echo $image[0] ?>" class="img-responsive waypoint animation_top"  alt="Eastland Group" />
            </div>
            <?php } 
            ?>
            <div class="_content">
                <?php if (get_sub_field('right_column_content')) {
                    echo get_sub_field('right_column_content');
                }
                ?>
                <span class="readmore">READ MORE</span>
            </div>
			</a>
        </div>

    </div>
</div>