<?php get_header(); ?>

<div class="inner inner-narrow clearfix">
  <form method="GET">

    <div class="select-dropdown">
      <select name="orderby" id="orderby">
        <option value="date" <?php echo selected($_GET['orderby'], 'date'); ?>>
          Newest to Oldest
        </option>
        <option value="title" <?php echo selected($_GET['orderby'], 'title'); ?>>
          Alphabetical
        </option>
      </select>
    </div>

    <div class="select-dropdown">
      <select name="" id="">
        <option>Adults</option>
        <option>Children & Young Adults</option>
      </select>
    </div>

    <input id="order" type="hidden" name="order" value="<?php echo (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'ASC' : 'DESC'; ?>" />


    <?php

    $terms = get_terms([
      'taxonomy' => 'age_group',
      'hide_empty' => false
    ]);



    foreach ($terms as $term) :

    ?>

      <label>

        <input type="checkbox" name="age_group[]" value="<?php echo $term->slug; ?>" <?php checked(
                                                                                        (isset($_GET['age_group']) && in_array($term->slug, $_GET['age_group']))
                                                                                      ) ?> />
        <?php echo $term->name; ?>
      </label>
    <?php endforeach; ?>
    <button class="button" type="submit">Apply</button>
  </form>
</div>

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