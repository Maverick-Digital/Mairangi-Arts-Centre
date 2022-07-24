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

?>
<div id="<?php echo $id; ?>" class="layer single_column <?php echo $xclass; ?>">
<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
<?php if (get_sub_field("content")) { ?>
				<div class="clearfix grid single_column pad-bot-40">
					<div class="col inner inner-1170">
						<?php echo get_sub_field('content'); ?>

					</div>
				</div>
			<?php 	}
			?>  	
<div class="inner  inner-<?php echo $inner; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
	
	<ul class="faq_list list_posts clearfix">
	<?php
		$c =0;
		while (have_rows('tabset')): the_row();
			$c++; ?>
			<li class="item <?php echo $filter_tags; ?>">
					<div class="question"><strong><?php echo get_sub_field('tab_heading'); ?></strong>
					<div class="hamburger hamburger--spring js-hamburger">
						<div class="hamburger-box">
						<div class="hamburger-inner"></div>
						</div>
					</div>
				</div>
					<div class="morecontent clearfix"><?php echo get_sub_field('tab_content'); ?></div>
				</li>	
				<?php
		endwhile; ?>
		</ul>
	</div>
</div>
		<?php
if (!is_admin()) :
	ob_start(); ?>
	
		console.log('here');
		var $container = $('.faq_list');
		
		//$container.layout();	
		<?php

		if ($cat != '') {
			$filter = $cat;
		} else {
			$filter = '.' . strtolower(str_replace(' ', '-', $category));
		}

		?>
		$container.isotope({
			layoutMode: 'masonry',
			itemSelector: '.item'
		});
		
		function onArrange() {
			AOS.refresh();
		}
		// bind event listener
		$container.on( 'arrangeComplete', onArrange );

		
		
	$('body').on('click', '.question', function (event) {
     
			event.preventDefault();
			$(this).children('.hamburger').toggleClass('is-active');
			$(this).next().slideToggle('fast');
			$(this).toggleClass('open');
			setTimeout(function(){ 
				$container.isotope('layout');
				AOS.refresh(); }, 300);

			
			return false;
		});



	<?php
	$myScripts .= ob_get_clean();
	endif;
	/*
	
	<ul class="tabs">
		<?php
		$c =0;
		while (have_rows('tabset')): the_row();
			$c++; ?>
			<li data-tabset="tabset<?php echo $c; ?>" <?php if($c ==1){ echo 'class="current"'; } ?>>
				<?php echo get_sub_field('tab_heading'); ?>
			</li>
		<?php
		endwhile; ?>
		</ul>
		<div class="tab_content_holder">
		<?php
		$c =0;
		while (have_rows('tabset')): the_row(); 
			$c++; ?>
			<div id="tabset<?php echo $c; ?>" class="tab-content <?php if($c==1){ echo 'current'; } ?>">
				<?php echo get_sub_field('tab_content'); ?>
			</div>
			<?php
		endwhile; ?>
		</div>
	</div>
</div> */
