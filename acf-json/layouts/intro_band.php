<section class="row intro_band cf" itemscope  itemtype="http://schema.org/Blog">
    <div class="wrap container_12 cf" role="main">
        <span class="bg_color"></span>



        <?php // loop through the rows of data
        while (have_rows('tiles')) : the_row();

            // display a sub field value
            $image = get_sub_field('image');
           // echo '<h1 style="color:red;">MIKE'.$image.'</h1>';
            $url = false;
            $heading = get_sub_field('heading');
            $company_class = get_sub_field('company_class');
            $layout_class = get_sub_field('layout_class');
            if(get_sub_field('link_tile') == 'true') {
                $post_object = get_sub_field('url');

                if( $post_object ):

                    // override $post
                    $post = $post_object;
                    setup_postdata( $post );
                    $url = get_the_permalink();
                     wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
                     endif;

            }
            $linkS = '';
            $linkE = '';
            if ($url) {
                $linkS = '<a href="' . $url . '" class="tile_link">';
                $linkE = '</a>';
            }

            ?>
            <div class="col-xs-6 col-sm-3 tile <?php echo $company_class; ?> cf">
                <?php echo $linkS; ?>
                <div class="img_wrap <?php echo $layout_class; ?>">
                <span class="content">
                    <?php echo $heading ?>
                    <?php /* <span class="heading">Eastland Tile Heading</span><br/>
                    <span class="subheading">Sub heading</span>  */ ?>
                </span>
                    <span class="overlay"></span>
                    <span class="gradient"></span>

                        <?php $image = wp_get_attachment_image_src($image, array('width' => 540, 'height' => 540, 'crop' => true));
                        if(!$image){
                      $image = wp_get_attachment_image_src(397, array('width' => 540, 'height' => 540, 'crop' => true));
                   } ?>
                    <img src="<?php echo $image[0] ?>" class="img-responsive " alt="<?php echo $heading; ?>" />
                    <?php /* <img
                        src="<?php echo get_template_directory_uri(); ?>/library/images/tiles/<?php echo $section; ?>-bg.png"
                        class="img-responsive tile_img"/> */ ?>
                </div>
                <?php echo $linkE; ?>
                <div class="info">
                    <h2 class='color'>Our Strategy</h2>

                    <p>We are the business behind the businesses that power your local economy out here on the sunny
                        East Coast — <a href="#">See the light »</a></p>
                </div>

            </div>

        <?php
        endwhile;

        ?>


        <div class="col-xs-6 col-sm-3 tile cf">

            <div class="img_wrap">
                <span class="content">
                    <span class="heading">Eastland Tile Heading</span><br/>
                    <span class="subheading">Sub heading</span>
                </span>
                <span class="overlay"></span>
                <span class="gradient"></span>
                <?php if ($i == 1) { ?>
                    <?php $image = wp_get_attachment_image_src(397, array('width' => 540, 'height' => 540, 'crop' => true)); ?>
                <?php } else { ?>
                    <?php $image = wp_get_attachment_image_src(375, array('width' => 540, 'height' => 540, 'crop' => true)); ?>
                <?php } ?>
                <img src="<?php echo $image[0] ?>" class="img-responsive " alt="Eastland Group"/>
                <?php /* <img
                        src="<?php echo get_template_directory_uri(); ?>/library/images/tiles/<?php echo $section; ?>-bg.png"
                        class="img-responsive tile_img"/> */ ?>
            </div>
            <div class="info">
                <h2 class='color'>Our Strategy</h2>

                <p>We are the business behind the businesses that power your local economy out here on the sunny
                    East Coast — <a href="#">See the light »</a></p>
            </div>

        </div>

    </div>

</section>