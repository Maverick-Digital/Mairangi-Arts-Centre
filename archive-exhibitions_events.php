<?php get_header(); ?>
<div class="layer layout_tiles">
  <div class="inner inner-narrow clearfix grid gallery-post-archive">
    <?php
    if (have_posts()) {
      while (have_posts()) {
        the_post();
    ?>
        <div class="col">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail('full');
          }
          ?>

          <h4><?php the_title(); ?></h4>

          <?php
          $term_obj_list = get_the_terms($post->ID, 'age_group');
          echo '<strong>Type:</strong> ' . join(', ', wp_list_pluck($term_obj_list, 'name'));
          ?>
          <div class="teaser">
            <br />
            <?php
            if (get_sub_field('content')) {
              echo get_sub_field('content');
            }

            ?>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>
</div>
<?php get_footer(); ?>