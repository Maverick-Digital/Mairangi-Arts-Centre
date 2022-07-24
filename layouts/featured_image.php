<?php
global $post;
global $myScripts;

//image_style

$sizeL =   array(2560, 2560);
$size =   array(900, 450);
$crop = false;
$xclass =  '';
$style = '';
$class = '';
$classes = '';
$id = '';
include('set_up_layout_styles.php');

//echo "XCLASS: ".$xclass;

$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); 
$posttype = 'page';	
if(get_sub_field("case_studies")){
	$myarray = get_sub_field("case_studies");
	$args = array(
		'post_type' => array($posttype),
		'post__in' => $myarray,
		'orderby' => 'post__in',
	);
}else{
	$args = array(
		'post_type' => array($posttype),
		'post_parent' => 848
	);

}
$wp_query->query($args);
$random = rand(1000000, 10000000);

$slide_image = '';
					if(get_post_thumbnail_id()){
						$slide_image = get_post_thumbnail_id();
					}else{
						$slide_image = '685';
					}
					
						//	echo get_sub_field('slide_image');
						//$slide_image = get_post_thumbnail_id();
						$image_full =  fly_get_attachment_image_src($slide_image, array(2560, null), false);
						$image_lg =  fly_get_attachment_image_src($slide_image, array(1920, null), false);
						$image_med = fly_get_attachment_image_src($slide_image, array(1240, null), false);
						$image_sm = fly_get_attachment_image_src($slide_image, array(900, null), false);
					

							$css .= '
				@media only screen and (min-width: 768px) {
					.featured_image .bg-image {
						background-image: url("' . $image_lg['src'] . '");
					}
					}	
				@media only screen and (min-width: 1920px) {
					.featured_image .bg-image {
					background-image: url("' . $image_full['src'] . '");
					}
				}
						
				@media only screen and (max-width: 767px) {
					.featured_image .bg-image {
						background-image: url("' . $image_med['src'] . '");
					}
				}
				@media only screen and (max-width: 600px) {
					.featured_image .bg-image {
						background-image: url("' . $image_sm['src'] . '");
				}
				}
				';


	?>
	<div class="layer grid featured_image">
		<div class="inner col inner-1170  col-align-top  clearfix">
				<div class="bg-image background-image"></div> 
				<div class="info abs">
					<?php
		
					echo "<h4>".get_the_title()."</h4>";
					//if(get_business_location()){
						echo "<p><span class='marker'></span> ".get_business_location()."</p>";
					//}
					?>
				</div>
			
		</div>
	</div>
</div>
<?php
echo '<style>' . $css . '</style>';
 

