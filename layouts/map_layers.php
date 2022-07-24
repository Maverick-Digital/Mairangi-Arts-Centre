<?php
global $post;
global $myScripts;

?>
<div id="<?php echo $id; ?>" class="layer clearfix grid <?php echo $xclass; ?> pad-top-default pad-bot-default"> 
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner col inner-full-width clearfix">
		<h2 class="pad-bot-40 center">Trip Map</h2>	
	<ul id="recom_map" class='map_layers'>
			<?php 
			if(get_sub_field('layers')):
				$layers = get_sub_field('layers');
				// reverse from backend..
				$layers = array_reverse($layers);
			foreach( $layers as $image ):
		
			  ?>
			    <li>		
				<?php //echo wp_get_attachment_image(get_post_thumbnail_id($image), array('700', '600'), "", array( "class" => "img-responsive" ) );  ?>
<?php echo wp_get_attachment_image(get_post_thumbnail_id($image),'full','', array( "class" => "img-responsive" )); ?>
 				 </li>
			<?php endforeach;
			endif; ?>
			<?php
		$c=0;
		if( have_rows('amenities') ):
			while( have_rows('amenities') ) : the_row();
			//echo get_sub_field("lat_long");
			
				$c++;
				$coords = explode( ',', get_sub_field('lat_long') );
				$theme = 'amenities';
				//echo strlen(get_sub_field('icon'));
				if(strlen(get_sub_field('icon')) > 1){
					$theme = 'dark';
				}
				echo "<div class='marker pos".$c."' style='top:".$coords[1]."; left:".$coords[0]."; '>
				<a class='marker_a' data-tippy-theme='".$theme."' data-template='pos".$c."'><img src='".get_template_directory_uri()."/library/images/icons/map_marker.svg' >
				</a>
				</div>";
				?>
				<div id='pos<?php echo $c; ?>' class='map_info_pop' >
					<h4><?php echo get_sub_field('name'); ?></h4>
					<?php if(get_sub_field('teaser')){ echo get_sub_field('teaser'); } ?>
				</div>
					
				<?php
			endwhile;
		endif;
		
		if( have_rows('perfomance_sites', 'options') ):
			while( have_rows('perfomance_sites', 'options') ) : the_row();
			//echo get_sub_field("lat_long");
				$c++;
				$coords = explode( ',', get_sub_field('lat_long') );
				echo "<div class='marker pos".$c."' style='top:".$coords[1]."; left:".$coords[0]."; '>
				<a class='marker_a' data-tippy-theme='perfomance_sites' data-template='pos".$c."'><img src='".get_template_directory_uri()."/library/images/map_icons/".get_sub_field('icon').".svg' >
				</a>
				</div>";
				?>
				<div id='pos<?php echo $c; ?>' class='map_info_pop' >
					<h4><?php echo get_sub_field('name'); ?></h4>
					<?php if(get_sub_field('teaser')){ echo get_sub_field('teaser'); } ?>
				</div>
					
				<?php
			endwhile;
		endif;	
		if( have_rows('buildings', 'options') ):
			while( have_rows('buildings', 'options') ) : the_row();
			//echo get_sub_field("lat_long");
				$c++;
				$coords = explode( ',', get_sub_field('lat_long') );
				echo "<div class='marker pos".$c."' style='top:".$coords[1]."; left:".$coords[0]."; '>
				<a class='marker_a' data-tippy-arrowType = 'large' data-tippy-theme='buildings' data-template='pos".$c."'><img src='".get_template_directory_uri()."/library/images/map_icons/".get_sub_field('icon').".svg' >
				</a>
				</div>";
				?>
				<div id='pos<?php echo $c; ?>' class='map_info_pop' >
					<h4><?php echo get_sub_field('name'); ?></h4>
					<?php if(get_sub_field('teaser')){ echo get_sub_field('teaser'); } ?>
				</div>
					
				<?php
			endwhile;
		endif;	
			
			?>
		</ul>

		
	</div>
</div>
<script src="https://unpkg.com/@popperjs/core@2" defer></script>
<script src="https://unpkg.com/tippy.js@6" defer></script>
		<?php ob_start(); ?>
			tippy('.marker_a', {
				content(reference) {
				const id = reference.getAttribute('data-template');
				//console.log(reference + id);
				const template = document.getElementById(id);
				//console.log("tippy" + template);
				return template.innerHTML;
			},
			allowHTML: true,
			});
<?php $myScripts .= ob_get_clean();