<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post();
	setPostViews(get_the_ID());
?>
<div id="main" class="layout_wrap">
	<?php /*
	<div class="grid inner inner-1170 clearfix">
	<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
	</div>
	*/ 
	if (have_rows('page_layout')): ?>
<div id="main" class="layout_wrap">
<?php 

//if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs();
	while  (have_rows('page_layout')) : the_row();
	$c++;
	$fields = get_sub_field('settings');
	if(isset($fields[0])){
		$fields = $fields[0];
	}else{
		$fields = $fields['row-0'];
	}
	 ?>
	<div class="page_layout loop-<?php echo $c; ?>">
	<?php if(isset($fields['vertical_title']) && $fields['vertical_title'] != '' ): ?>
		<div class="grid grid-nogutter">
			<div class="col col-fixed"  style='width:6em;'>
				<div class="verttext">
					<h2><strong><?php echo $fields['vertical_title']; ?></strong></h2>
				</div>
			</div>
			<div class="col ">
		<?php endif; 
		ACF_Layout::render(get_row_layout());
	?>
	<?php if(isset($fields['vertical_title']) && $fields['vertical_title'] != '' ): ?>
</div>
</div>
<?php endif; ?>
	</div>
	<?php
	endwhile; ?>
</div>
<?php	
else: ?>
	<div class="page_layout loop-1 blog">
		<div id="T8252187" class="layer grid single_column maverick   pad-top-default  pad-bot-0 image-default text-on-default no-bg-image">
			<div class="inner col inner-1170  col-align-top  clearfix">
					<article id="post-<?php the_ID(); ?>"   itemscope itemtype="http://schema.org/BlogPosting">
						<div class="entry-content cf  pad-bot-default " itemprop="articleBody">
							<?php 
							echo "<h2><strong>" . get_the_title() . "</strong></h2>"; ?>
							<p class="date_time"><em> <?php echo get_the_date(); ?> </em></p>
							<?php
							the_content();
							
						/*
							<footer class="article-footer pad-top-40">
								<div class="meta">
								<div class="date_time "><span class="icon icon-clock"></span> <?php echo get_the_date(); ?> </div>
								 <div class="post-count col text-right"><span class="icon icon-eye"></span> <?php echo getPostViews(get_the_ID()); ?></div> 
							</div>
						</footer>
						*/ ?>
						</div>
					</article>
				</div>
			</div>
		</div>
	
<?php 
endif; 
endwhile; ?>
<section class="layer grid content  pad-top-default pad-bot-default"> 
	<div class=" inner inner-1170 col  clearfix ">
		<div class="navigation grid">
			<div class="col">
				<?php $prevPost = get_previous_post(); ?>
				<span class="older-posts"><?php previous_post_link( '%link', '<i class="icon-left-arrow"></i> PREVIOUS' ); ?></span>
				<h4><?php previous_post_link( '%link', '%title' ); ?></h4>
			</div>
			<div class="col">
				<span class="older-posts"><?php next_post_link( '%link', 'NEXT <i class="icon-right-arrow"> </i>' ); ?></span>
				<h4><?php next_post_link( '%link', '%title' ); ?></h4>
				
			</div>
		</div>		
	</div>
</section>
	
<?php else : ?>
<section class="layer article">
<div class="grid inner clearfix">
              <article id="post-not-found" class="hentry cf">
                  <header class="article-header">
                    <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                  </header>
                  <section class="entry-content">
                    <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                  </section>
                  <footer class="article-footer">
                      <p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
                  </footer>
              </article>
    </div>
</section> 
            <?php endif; ?>

<?php get_footer(); ?>