<?php

//https://grid.layoutit.com/?id=1je5n9b

global $post;
$site_description = get_bloginfo('description', 'display');
$site_name = get_bloginfo('name');

//require_once( 'layouts/case-studies-carousel.php' );
//require_once( 'layouts/company_logos.php' );
//require_once( 'library/clip-paths.php' );

require_once( 'layouts/testimonials.php' );
if(get_field("show_instagram")  && !is_plugin_active('sb-instagram-feed') || is_single()){ ?>
	<div class='instagram layer noprint'>
		<?php
		//	echo do_shortcode('[instagram-feed]');
			?>
	</div>
<?php } ?>
<?php
$globalContentID = 2260;
if (have_rows('page_layout',$globalContentID)) : ?>
		<?php
		while (have_rows('page_layout',$globalContentID)) : the_row();
			$c++;
			$fields = get_sub_field('settings');
			if (isset($fields[0])) {
				$fields = $fields[0];
			} else {
				//$fields = $fields['row-0'];
			}
		?>
			<div class="page_layout global-loop-<?php echo $c; ?>">
				<?php if (isset($fields['vertical_title']) && $fields['vertical_title'] != '') : ?>
					<div class="grid grid-nogutter">
						<div class="col col-fixed" style='width:6em;'>
							<div class="verttext">
								<h2><strong><?php echo $fields['vertical_title']; ?></strong></h2>
							</div>
						</div>
						<div class="col ">
						<?php endif;
					ACF_Layout::render(get_row_layout());
						?>
						<?php if (isset($fields['vertical_title']) && $fields['vertical_title'] != '') : ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php
		endwhile; ?>
<?php
endif; ?>
<!-- Footer -->
<footer class="layer pad-top-100  pad-bot-60 noprint">
	<div class="inner">
		<div class="grid grid-between pad-bot-40  clearfix">
			<div class="col  column1 " >
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer1') ) : ?>
				<?php endif; ?>
				<br/>

			</div>
			<div class="col  column2">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer2') ) : ?>
				<?php endif; ?>
			</div>
			<div class="col  column3">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer3') ) : ?>
				<?php endif; ?>
			</div>
			<div class="col  column4">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer4') ) : ?>
				<?php endif; ?>
			</div>
			<div class="col  column5">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer5') ) : ?>
				<?php endif; ?>
			</div>
		</div>
		<?php echo do_shortcode('[affiliates]') ?>
		<div class="subfooter">
			<div class="footer-meta clearfix center"> 
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer6') ) : ?>
				<?php endif; ?>
				<p class="pad-top-20" style="font-size:10px;">&copy; <?php echo get_bloginfo( 'name' );  ?>.  Website by <a id="maverick-logo" href="http://maverickdigital.nz/" target="_blank"></a></p>

			</div>	
		</div>
					
	</div>
	
</footer>




</div><!-- end div.wrap -->
</div><!-- end div.moved -->

	<div id="NavDrawer" class="drawer drawer--right">
		<div class="draw_bg">
			<div class="drawer__inner">
				 <div class="logo_footer">
					<a class="desktop" href="<?php echo get_home_url(); ?>">
						<?php 
						 echo wp_get_attachment_image(get_field('logo_ghost', 'options'), 'large');
						?> </a>
				</div>
				<!-- Menu -->
				<nav id="ml-menu" class="menu">
					<!-- Close button for mobile version -->
					<button class="action action--close js-drawer-close" aria-label="Close Menu"><span class="icon icon--cross"></span></button>
					<div class="menu__wrap">
						<?php custom_menu_output('sub-nav');  ?>
					</div>
				</nav>
			</div>
		</div>
	</div>

	<div class="back-to-top-wrap"><a class="back-to-top" href="#"><img src="<?php echo get_template_directory_uri(); ?>/library/images/icons/arrow-up-plain.svg" alt="top" /></a></div>
	<?php wp_footer(); ?>
	</body>
	</html> <!-- end of site. what a ride! -->