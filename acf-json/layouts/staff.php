<section class="layer staff yellow"  id="team">
	<div class="inner narrow clearfix">
		<h1 class="page-title">Meet the Team </h1>
		</div>
	
	<div class="inner staff">
	 <div class="lSAction">
			<a class="lSPrev"><i class="icon icon-left"></i></a>
			<a class="lSNext"><i class="icon icon-right"></i></a>
		<ul id="staff_slider">
			<?php
			while (have_rows('staff_member')):
			the_row();
			$img = false;
			$attachment_ID =   get_sub_field('image');
				//echo $attachment_ID;

			if ($attachment_ID) {
				$size =   array(540,540);			
				$img = fly_get_attachment_image_src($attachment_ID, $size, false ); 
			} 

			$name = get_sub_field('name');
			$title = get_sub_field('title');
			$content = get_sub_field('content');
   
		
			 ?>
			<li class="item">
			<div class="staff_member">
				<?php if ($img) { ?>
					<div class="profile background-image no-overlay" style="background-image:url(<?php echo $img['src']; ?>);">
					</div>
				<?php } ?>
					<div class="tile-copy">
						<h3><?php echo $name; ?><?php if( $title ): ?><span class="role"><?php echo $title; ?></span><?php endif; ?></h3>
						<?php if (get_sub_field('content')) {
						echo "<p>".get_sub_field('content')."</p>";
						}
						?>															
					</div>
			</div>
			</li>
			<?php endwhile; ?>
		</ul>
	</div><!-- .inner -->
</section>
			
    
