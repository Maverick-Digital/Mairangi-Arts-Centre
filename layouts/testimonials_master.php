<?php
global $post;
 $attachment_ID = get_sub_field("background_image",4);
//echo $attachment_ID;
 // $attachment_ID =get_field("background_image");
 // echo $attachment_ID;
  $sizeS =   array(1920,960);
 $img = fly_get_attachment_image_src($attachment_ID, $sizeS, true ); 

if(have_rows('testimonial',4)):

$rows = get_field('testimonial',4);
$row_count = count(get_sub_field('testimonial',4));

 ?>
<div id="testimonials" class="no-overlay background-image pad-top-160 pad-bot-160" style="background-image:url(<?php echo $img['src']; ?>);" >
	<?php /* <span class="image_overlay"></span> */ ?>	  
	<div class="inner"> 
	<?php // if($row_count >1){ ?>
		<div class="lSAction">
			<a class="lSPrev"><i class="icon icon-left"></i></a>
			<a class="lSNext"><i class="icon icon-right"></i></a>
		</div>
		<?php // } ?>
		<ul id="testimonials_slider">
		<?php	
		while (have_rows('testimonial',4)):
			the_row();
			$testimonial = get_sub_field('content');
			$name = get_sub_field('name');
			$rating = str_replace(".","-", get_sub_field('rating'));
			$date = get_sub_field('date');
			

			if($testimonial): ?>
				<li class="item">
					<div class="star-rating"><div class="rating star-<?php echo $rating; ?>"><?php echo  $rating; ?></div></div>
					<div class="h2"><?php echo $testimonial; ?></div>
					<div class="details pad-top-40 pad-bot-40"><div><?php echo $name; ?> &nbsp; - &nbsp; <span class="date"><?php echo $date; ?></span></div></div>
					<div class="byline"><i class="icon-tripadvisor"></i> See more reviews on TripAdvisor <a href="https://www.tripadvisor.co.nz/Attraction_Review-g616349-d2092194-Reviews-Caveworld-Waitomo_Caves_Waitomo_District_Waikato_Region_North_Island.html" target="_blank">here</a></div>
					<?php /* <p class="source"><?php echo $name; ?><?php if($byline){ ?><br><span class="title"><?php echo $byline; ?></span><?php } ?></p> */ ?>
				</li>
			<?php endif;
		endwhile; ?>
		</ul>
	</div>
</div>	

<?php 
else: 
if (have_rows('page_layout', 4)):
	while (have_rows('page_layout', 4)) : the_row();
		if(get_row_layout() == "testimonials"){
			ACF_Layout::render(get_row_layout());
		}
	endwhile;
	else :
endif;

endif; ?>




