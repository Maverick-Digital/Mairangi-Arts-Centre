<?php
get_header();
?>
<div class="layer grid single_column maverick   pad-top-default  pad-bot-default image-default text-on-default no-bg-image">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <div class="inner col inner-1170  col-align-top  clearfix">
            <?php if (has_post_thumbnail()) :
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                <div class="full-width-featured-image">
                    <h2> <strong><?php the_title(); ?></strong> </h2>
                </div>
            <?php endif; ?>
            <div class="row">
                <!-- <div class="article-info col-md-3">
                    <?php $categories = get_the_category(); ?>
                    <?php if (!empty($categories)) : ?>
                        <div class="posted-in">
                            <h4><?php _e('Posted In', 'nd_dosth'); ?></h4>
                            <?php the_category(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="published-on">
                        <h4><?php _e('Publish On', 'nd_dosth'); ?></h4>
                        <?php the_date(); ?>
                    </div>
                    <div class="post-author">
                        <h4><?php _e('Author', 'nd_dosth'); ?></h4>
                        <a class="author-archive" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php the_author(); ?>
                        </a>
                        <?php echo get_avatar(get_the_author_meta('ID'), 100); ?>
                    </div>
                </div> -->
                <div id="actual-article" class="col-md-8">
                    <div class='grid grid-nogutter'>
                        <div class='col'>
                            <?php the_field('start_date'); ?> <?php the_field('end_date'); ?>
                        </div>
                        <div class='col'>
                            <?php the_field('price'); ?>
                        </div>
                        <div class='col'>
                            <?php the_field('event_type'); ?>
                        </div>
                    </div>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>