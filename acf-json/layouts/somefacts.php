		
<section class="layer somefacts clearfix">
	<div class="inner  <?php echo get_sub_field('class'); ?> clearfix">
	<?php if (get_sub_field('somefacts_title')){ ?>
		<h3 class="text-center"><?php echo get_sub_field('somefacts_title'); ?></h3>	
		
		<?php } ?>
		<?php ?>
		<?php if( have_rows('somefacts') ):
			$count=0;
		 ?>
		<div class="cf text-center grid flex column-4">
		<?php while( have_rows('somefacts') ): the_row(); 
		$count ++;
		// vars		
		$somefact_content = get_sub_field('somefact_content');
		$link = get_sub_field('link');
		$datastart = get_sub_field('datastart');
		$dataend = get_sub_field('dataend');
		$dataduration = get_sub_field('dataduration');
		$dataprefix = get_sub_field('dataprefix');
		$datasuffix = get_sub_field('datasuffix');
		$prefixalign = get_sub_field('prefixalign');
		$suffixalign = get_sub_field('suffixalign');
		$datadecimals = get_sub_field('datadecimals');

		?>
			<div class="col">
				<div class="column-inner ">
					<div class="gr-countup" data-start="<?php if($datastart){ echo $datastart; }?>" data-end="<?php if($dataend){ echo $dataend; }?>" data-prefix="<?php if($dataprefix){ echo $dataprefix; }?>" data-suffix="<?php if($datasuffix){ echo $datasuffix; }?>" data-sep="," data-decimals="<?php if($datadecimals){ echo $datadecimals; }else{echo "0"; } ?>" data-dec="." data-duration="<?php if($dataduration){ echo $dataduration; }?>"  data-prefixalign="<?php if($prefixalign){ echo $prefixalign; }?>" data-suffixalign="<?php if($suffixalign){ echo $suffixalign; }?>"  >						
						<div class="countup-digit" id="somefact<?php echo $count; ?>"><?php if($datastart){ echo $datastart; }?></div>
						<div class="countup-content"><?php echo $somefact_content; ?></div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>	
	</div>
</section>

<?php endif; ?>
		



