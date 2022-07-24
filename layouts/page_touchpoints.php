<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560,2560);
$size =   array(900,450);
$crop = false;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include( 'set_up_layout_styles.php' );

if(get_sub_field('page_touchpoints')): ?>
<div id="<?php echo $id; ?>" class="layer layout_tiles clearfix grid <?php echo $xclass; ?> "> 
		<div class="inner discover col grid inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
		
			<?php
	
		$ids = get_sub_field('page_touchpoints');

		$wp_query = new WP_Query(array(
			'post_type' => array('page'),
			//'post_type' => 'any',
			'posts_per_page'	=> -1,
			'post__in'			=> $ids,
			// 'post_status'		=> 'any',
			'orderby'        	=> 'post__in',
		));
		$count=0;
		while ($wp_query->have_posts()) : 
			$wp_query->the_post();
			//echo $count;
			$append=$prepend="";
			$closed=false;
		
			$count++;
			
			if(get_post_thumbnail_id(get_the_ID())){
				$image = fly_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), array( 800, 800 ), true );
			} else {
				// $image = fly_get_attachment_image_src(929, array( 600, 600 ), true );
			} 
			?>
		<article id="<?php echo $post->post_name; ?>" class="card anim ">
			<div class="bg-image background-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
			<div class="tile-copy">
				<?php if(get_field('teaser')){ ?>
				<div class="info-deal anim ani2">
					<?php echo get_field('teaser'); ?>
				</div>
				<?php } ?>
				<div class="info-action pad-top-20 anim ani3">	
				<a href="<?php echo get_the_permalink(); ?>" class="button alt ">Find out more</a></div>
				<?php /* <?php $content = get_the_content(); echo wp_trim_words( $content , '25' ); ?></p> */ ?>
			</div>
			<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
		</article>
		<?php
		endwhile;
			wp_reset_query();
	
			?>
		
	</div>
</div>

<?php endif;
