<?php
// check if the repeater field has rows of data

if (get_field('company_logos','option')): ?>
        <div class="company_logos">
         
            <div class="inner inner-1170 pad-top-default pad-bot-default">
            <?php if (get_sub_field("content")) { ?>
                <div class="clearfix grid pad-bot-40">
                    <div class="col inner inner-narrow ">
                            <?php echo get_sub_field('content'); ?>
                    
                    </div>
                </div>
            <?php 	} ?>
                <ul class="companies_slider">
                    <?php // loop through the rows of data
                    $c = 0;
                    while (have_rows('company_logos','option')) : the_row();
                        $c ++;
                       // if($c == 5 && is_admin()){break;}
                        // display a sub field value
                        $image = get_sub_field('image');
                        $url = get_sub_field('link');
                            $name = get_sub_field('name');
                        $linkS = '';
                        $linkE = '';
                        if ($url) {
                            $linkS = '<a href="' . $url . '" target="_blank">';
                            $linkE = '</a>';
                        }
                        
                        $item_image = wp_get_attachment_image_src($image, array(
                            'width' => 200,
                            'height' => 130,
                            'crop' => false,
                            'crop_from_position' => 'center,center',
                            'resize' => true,
                            'jpeg_quality' => 100,
                            'return' => 'url',
                            'custom' => false,
                            'background_fill' => 'auto',

                        ));
                        if ($item_image) {
                            echo '<li class="">' . $linkS;
                            echo '<img src="' . $item_image[0] . '" alt="' . $name . '"  width="' . $item_image[1] . '" height="' . $item_image[2] . '"  class="casestudy img-responsive" />';

                            echo $linkE . '</li>';
                        }

                
                        

                    endwhile;

                    ?> </ul>
                    <div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>

            </div>
          
        </div>
<?php endif; ?>