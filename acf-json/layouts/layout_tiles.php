<?php
global $post;
global $myScripts;

//image_style
$sizeL =   array(2560, 2560);
$size =   array(900, 450);
$crop = false;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');
?>
<section id="<?php echo $id; ?>" class="layer layout_tiles clearfix  <?php echo $xclass; ?> ">
  <div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>">
    <?php
    if (isset($fields['bg_focal_point'])) {
      $coords = explode(',', $fields['bg_focal_point']);
      $imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
    } else {
      $imgpos =  " object-position:50% 50%; ";
    }
    echo wp_get_attachment_image($fields['bg_image'], '2048x2048', "", ["class" => "cover", 'sizes' => '100vw', 'style' => $imgpos]);
    ?>
  </div>
  <?php if (get_sub_field("content")) { ?>
    <div class="clearfix grid pad-bot-40">
      <div class="col inner inner-narrow ">
        <?php echo get_sub_field('content'); ?>
      </div>
    </div>
  <?php   } ?>
  <div class="inner col inner-<?php echo $inner . '  ' . $column_vertical_alignment; ?>  clearfix">
    <ul class="services services-grid tiles clearfix column-4 <?php echo $xclass; ?>">
      <?php
      while (have_rows('tiles')) :
        the_row();
        $attachment_ID =   get_sub_field('image');
      ?>
        <li class="item anim">
          <div class="card">
            <div class="bg-image anim abs">
              <?php echo wp_get_attachment_image($attachment_ID, 'medium', "", ["class" => "cover anim"]); ?>
            </div>
          </div>
          <div class="match">
            <div class="teaser">
              <br />
              <?php
              if (get_sub_field('content')) {
                echo get_sub_field('content');
              }

              ?>
            </div>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</section>