<?php

/**
 * Template Name: Full Width home Page
 */ ?>

<?php get_header(); ?>

<div class="inner-narrow mx-auto">
    <div class='grid'>
        <div class='col'>
            <?php while (have_posts()) : the_post();/* Start loop */ ?>
                <?php the_content(); ?>
            <?php endwhile; /* End loop */ ?>
        </div>
    </div>
</div>
<div class="inner-narrow mx-auto">
    <div class="grid home-post-grid">
        <?php
        //get_template_part('archive', 'loop');
        $args = array(
            'post_type' => 'gallery',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 4,
            'paged' => get_query_var('paged'),
            'post_parent' => $parent
        );
        $q = new WP_Query($args);
        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('col-6 col-md home-posts'); ?>>
                    <div class="card mb-4 border-0">
                        <div class="card-body ">
                            <h3 class="category-header mb-4">
                                <?php
                                foreach ((get_the_category()) as $category) {
                                    echo $category->cat_name . ' ';
                                }
                                ?>
                            </h3>
                            <div class="card-text entry-content pt-4">
                                <?php
                                if (has_post_thumbnail()) :
                                    echo '<div class="post-thumbnail">' . get_the_post_thumbnail(get_the_ID(), 'large') . '</div>';
                                endif;
                                ?>
                                <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . esc_html__('Pages:', 'mairangi-arts-centre') . '</span>', 'after' => '</div>')); ?>
                            </div><!-- /.card-text -->
                            <header class="card-body px-0">
                                <h4 class="card-title my-3">
                                    <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'mairangi-arts-centre'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a>
                                </h4>
                                <?php
                                if (is_search()) :
                                    the_excerpt();
                                else :
                                    the_content();
                                endif;
                                ?>
                                <?php
                                if ('post' === get_post_type()) :
                                ?>
                                    <div class="card-text entry-meta">
                                        <!-- <?php
                                                //mairangi_arts_centre_article_posted_on();

                                                //$num_comments = get_comments_number();
                                                //if (comments_open() && $num_comments >= 1) :
                                                //echo ' <a href="' . get_comments_link() . '" class="badge badge-pill badge-secondary float-end" title="' . esc_attr(sprintf(_n('%s Comment', '%s Comments', $num_comments, 'mairangi-arts-centre'), $num_comments)) . '">' . $num_comments . '</a>';
                                                //endif;
                                                ?> -->
                                    </div><!-- /.entry-meta -->
                                <?php
                                endif;
                                ?>
                                <div class="entry-meta">
                                    <a href="<?php echo get_the_permalink(); ?>" class="button"><?php esc_html_e('Learn more', 'mairangi-arts-centre'); ?></a>
                                </div><!-- /.entry-meta -->
                            </header>
                        </div><!-- /.card-body -->
                    </div><!-- /.col -->
                </article><!-- /#post-<?php the_ID(); ?> -->
        <?php }
        }
        ?>
    </div><!-- /.row -->
</div>

<?php echo do_shortcode('[instagram-feed]'); ?>

<?php get_footer(); ?>