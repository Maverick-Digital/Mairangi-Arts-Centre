<?php
if( have_rows('videos', 25) ): ?>
<div class=" layer pad-top-60 pad-bot-60">
	<div class="inner"><h2 style="text-align:center;"><strong>Video Resources</strong></h2></div>
	<ul id="responsive" class="gallery content-slider list-unstyled clearfix cS-hidden">
	<?php
	while ( have_rows('videos', 25) ) : the_row(); ?>
		<li data-src="<?php the_sub_field('video'); ?>" >
			<div class="video_wrap" style="background-image:url(<?php the_sub_field('images'); ?>);"><img src="<?php echo get_template_directory_uri(); ?>/library/images/youtube.svg"/></div>
		 	<div class="video_copy">
				<h4><?php the_sub_field('name'); ?><span><?php the_sub_field('length'); ?></span></h4> 
				<p><?php the_sub_field('teaser'); ?></p>
			</div>
		</li>
	<?php
	endwhile;
	?>
	</ul>
	<p class="center"><a href="https://www.youtube.com/channel/UCL7SU1lJg118S_P8QdNoi8g/videos" class="button green" target="_blank">See more videos</a></p>
</div>
<?php 
endif;
if(is_admin()){
	exit;
}

?>