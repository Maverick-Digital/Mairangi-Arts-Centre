<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560, 2560);
$size =   array(1400, 900);
$crop = true;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');

//echo "XCLASS: ".$xclass;

$post_type = 'staff';

$tax = 'staff_tax';
$all_terms = get_terms(array(
	'taxonomy' => $tax,
	'hide_empty' => true,
) );
$category = "all";
$myterms = array();
$cat = "." . $category;
?>
<section id="section<?php echo $id; ?>" class="layer layout_2col_images clearfix  <?php echo $xclass; ?> count-<?php echo $post_count; ?>  ">
	<div class="bg-image background-image " >
		<?php
			if (isset($fields['bg_focal_point'])) {
				$coords = explode(',', $fields['bg_focal_point']);
				$imgpos =  " object-position:" . $coords[0] . " " . $coords[1] . "; ";
			} else {
				$imgpos =  " object-position:50% 50%; ";
			}	
		?>
		<?php 
		/// default
		echo wp_get_attachment_image($fields['bg_image'], '2048x2048', "", ["class" => "cover", 'style'=> $imgpos ]);
		?>
	</div>
	<div class="bg-color abs"></div>
	<?php if (get_sub_field("content")) { ?>
        <div class="clearfix grid single_column pad-bot-40">
            <div class="col inner inner-<?php echo $inner; ?>">
                <?php echo get_sub_field('content'); ?>
            </div>
        </div>
	<?php 	}?>    
   <div class="inner col inner-<?php echo $inner; echo $column_vertical_alignment; ?> <?php echo get_sub_field('layout_class') ?> clearfix">
	<?php
			
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		'orderby' => 'menu_order'

	);

	if (is_admin()) {
		$args['posts_per_page'] = 5;
	}
	$wp_query = new WP_Query();
	$wp_query->query($args);
	$c = 0;
	$post_count = $wp_query->post_count;
	$random = rand(1000000, 10000000);

	?>

			<ul class="staff list_posts list-unstyled"><?php
			while ($wp_query->have_posts()) :
				$wp_query->the_post();
				
				$term_links = "";
				$filter_tags = "";
				$terms = get_the_terms($post->ID, $tax);
				$links = array('all');
				if ($terms && !is_wp_error($terms)) :
					foreach ($terms as $term) {
						$links[] = $term->slug;
					}
				endif;
				$c++;
				
				$filter_tags = strtolower(join(" ", str_replace(' ', '-', $links)));
				
				
///print_r($term_list);
				
				$getcat = wp_get_post_terms(get_the_ID(), 'staff_tax');
				$myCategory = '';
				foreach ($getcat as $gotcat) {
					//print_r($gotcat);
					if(isset($gotcat->description)){
						$myCategory =  $gotcat->description;
					}else{
                        $myCategory =  $gotcat->name;
                    }
					break;
				}
				$random = (rand(10,100000))
				?><li class="item <?php echo $filter_tags; ?>">
					<div class="tile tooltip " data-template="popper-<?php echo $random; ?>">
						<div class="card anim">
							<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', "", ['alt'=>get_the_title(),"class" => "cover"]); ?>
						</div>
						<div class="title">
						<h4 style="padding:0;"><strong><?php  the_title() ?></strong></h4>
							<?php 
							$fields = get_fields();
							$output = '';
							$output.= '<ul class="list-unstyled">';
							if($fields['role'])
							//$output.= '<li><strong>ROLE</strong>&nbsp;&nbsp;&nbsp;'.$fields['role'].'</li>';
							$output.= '<li><strong>'.$fields['role'].'</strong></li>';
							if($fields['nick_name'])
							$output.= '<li><strong>NICK NAME</strong>&nbsp;&nbsp;&nbsp;'.$fields['nick_name'].'</li>';
							if($fields['born'])
							$output.= '<li><strong>BORN</strong>&nbsp;&nbsp;&nbsp;'.date('jS F Y',strtotime($fields['born'])).'</li>';
							if($fields['grew_up'])
							$output.= '<li><strong>GREW UP</strong>&nbsp;&nbsp;&nbsp;'.$fields['grew_up'].'</li>';
							if($fields['background'])
							$output.= '<li><strong>BACKGROUND</strong>&nbsp;&nbsp;&nbsp;'.$fields['background'].'</li>';
							if($fields['guiding_since'])
							$output.= '<li><strong>GUIDING SINCE</strong>&nbsp;&nbsp;&nbsp;'.$fields['guiding_since'].'</li>';
							if($fields['hobbies'])
							$output.= '<li><strong>HOBBIES</strong>&nbsp;&nbsp;&nbsp;'.$fields['hobbies'].'</li>';
							if($fields['cheese_level'])
							$output.= '<li><strong>CHEESE LEVEL</strong>&nbsp;&nbsp;&nbsp;'.$fields['cheese_level'].'</li>';
		
							$output.= '</ul>';
							
							
							/* <p><?php  echo $myCategory; ?></p> */ ?>
						</div>
						<div id="popper-<?php echo $random; ?>" class="popper_content" style="display: block;">
								<?php  echo $output; ?>
								<?php the_content(); ?>
						</div>

<?php /*
						<a class="link-overlay" href="<?php echo get_the_permalink(); ?>" style="display:block;"></a>
*/ ?>
						</div>
				</li><?php endwhile; ?>
			</ul>
	<?php
	wp_reset_query();
	?>
	</div>
</section>
<?php
if (!is_admin() &&  $post_count != 0) :
	ob_start(); 
	/*
	?>

tippy('.tooltip', {
  content(reference) {
	console.log("tippy");
    const id = reference.getAttribute('data-template');
    const template = document.getElementById(id);
    return template.innerHTML;
  },
  followCursor: true,
  placement: 'top',
  allowHTML: true,
  touch: true
});

*/ ?>
		var $container = $('#section<?php echo $id; ?> ul.staff');
		$container.imagesLoaded().progress(function() {
			$container.isotope('layout');
		});	
		<?php

			$filter = '.all';
		
		?>
		$container.isotope({
			layoutMode: 'fitRows',
			filter: '<?php echo $filter  ?>',
			itemSelector: '.item'
		});
		function onStaffArrange() {
			console.log('AOS.refresh');
			AOS.refresh();
		}
		$container.on( 'arrangeComplete', onStaffArrange );
		

		<?php
	$myScripts .= ob_get_clean();
endif;