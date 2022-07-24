<?php get_header(); ?>

		<section class="layer ">

	<div class="inner pad-top-60 pad-bot-100">
						<h4 class=" entry-title"><i class="icon icon-search"></i> <?php _e( 'Search Results for:', 'bonestheme' ); ?> <?php echo esc_attr(get_search_query()); ?></h4>
	<div class="grid flex stretch column-3" id="load-posts">	
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('col'); ?> >

								<header class="entry-header article-header">

									<h4 ><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>

                  						

								</header>

								<section class="entry-content hide-for-small-only">
										<?php the_excerpt( '<span class="read-more">' . __( 'Read more &raquo;', 'bonestheme' ) . '</span>' ); ?>

								</section>

								<footer class="article-footer hide-for-small-only">

									<?php if(get_the_category_list(', ') != ''): ?>
                  					<?php printf( __( 'Filed under: %1$s', 'bonestheme' ), get_the_category_list(', ') ); ?>
                  					<?php endif; ?>

                 					<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

								</footer> <!-- end article footer -->
<hr class="hide-for-small-only"/>
							</article>

						<?php endwhile; ?>

								<?php //bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h2><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h2>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Try your search again.', 'bonestheme' ); ?></p>
											<?php get_search_form(); ?>
										</section>
										<footer class="article-footer">
												<p><?php // _e( 'This is the error message in the search.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						

							</div>
							<?php  if ( $wp_query->max_num_pages > 1 ) { ?>
				<div class="load-more-wrapper clearfix">
					<a href="#" data-page="1" data-ppp="6" class="button load-more">Load more</a>
				</div>
					<?php } ?>
					</div>
					

			</section>

<?php get_footer(); ?>
