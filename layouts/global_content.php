<?php
global $post;
global $myScripts;


if(get_sub_field('content_block')){
	$globalContentID = get_sub_field('content_block');
}

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
			<div class="page_layout global global-loop-<?php echo $c; ?>">
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
endif;