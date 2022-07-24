<?php
global $myScripts;
global $my_fields;
$fields = get_sub_field('settings');



if(isset($fields[0])){
	$fields = $fields[0];
}else{
	//$fields = $fields['row-0'];
}

$my_fields = $fields;
/*
if( $fields ): ?>
	<ul class="inline">
        <?php foreach( $fields as $name => $value ): ?>
			<li><b><?php echo $name; ?></b> <?php print_r( $value);
				var_dump($value);
			?></li>
        <?php endforeach; ?>
    </ul>
<?php endif;
*/


//print_r($fields);
//echo $fields['color_theme'];
//$myFields =  $fields;

$xclass ="maverick ";
$random = rand(1000000, 10000000);
if(isset($fields['id']) && $fields['id'] != ''){
	$id = $fields['id'];
}else{
	$id= "section-".rand(1000000, 10000000);
	
}
if(isset($fields['class'])){
	$xclass .=  " ".$fields['class'];
}

if(isset($fields['vheight'])&& $fields['vheight'] != ""){
	$xclass .=  " vheight-".$fields['vheight'];
}

//echo "CLASS".$xclass;

if(isset($fields['pad_top'])&& $fields['pad_top'] != ""){
	$xclass .=  " pad-top-".$fields['pad_top'];
}else{
	$xclass .=  " pad-top-default";
}

if(isset($fields['pad_bot'])&& $fields['pad_bot'] != ""){
	$xclass .=  " pad-bot-".$fields['pad_bot'];
}else{
	$xclass .=  " pad-bot-default";
}

if(isset($fields['show_overlay']) && $fields['show_overlay']){
	$xclass .=  " show_overlay";
}

if(isset($fields['image_style']) && $fields['image_style'] != ''){
	$xclass .=  " ".$fields['image_style'];
}

//layer layout_2col_images clearfix full-height parallaxParent 


if(isset($fields['color_theme']) && $fields['color_theme'] != ''){
	$xclass .=  " text-on-".$fields['color_theme'];
}
if(isset($fields['background_pattern']) && $fields['background_pattern']){
	$xclass .=  " background_pattern";
}
if(isset($fields['background_gradient']) && $fields['background_gradient']){
	$xclass .=  " background_gradient";
}
if(get_sub_field('gallery')){
	$xclass .=  " featured";
}
if(isset($fields['text_width']) && $fields['text_width'] != ''){
	$xclass .=  " text-".$fields['text_width'];
}else{
	//$xclass .=  " text-100";
}
if(isset($fields['layout_class'])){
	$xclass .=  " text-on-".$fields['layout_class'];
}
$class = '';
if(isset($fields['show_only_mobile']) && $fields['show_only_mobile']){
	$xclass .=  " image-show-100";
}


/* old integration */
if(isset($fields['bg_image']) && $fields['bg_image'] != ""){ 
	
	$image_src =  fly_get_attachment_image_src($fields['bg_image'],array( 1920, 1920 ), false );
	
	$fields['bg_image_src'] = wp_get_attachment_image($fields['bg_image'], '2048x2048', '', ["class" => "cover"]);
	if($image_src){
	$style .= ' background-image:url('.$image_src['src'].');';
	$xclass .=  " has-bg-image";
	}else{
		$xclass .=  " no-bg-image";
		$class .= ' no-bgimage';
	}
}else{
	$xclass .=  " no-bg-image";
	$class .= ' no-bgimage';
}


if(isset($fields['bg_focal_point'])){
	$coords = explode( ',', $fields['bg_focal_point']);
	if(isset($coords[0]) && isset($coords[1])){
	$style .=   " transform-origin:".$coords[0]." ".$coords[1].";  background-position:".$coords[0]." ".$coords[1]."; ";
	}
		//echo "FOCAL".get_sub_field('focal_point');
}
if(isset($fields['inner_wrap']) && $fields['inner_wrap'] != "" ){ 
	$inner = $fields['inner_wrap'];
}else{
	$inner="1170";
}
//echo $fields['parallax_direction'];
if(isset($fields['parallax_direction']) && $fields['parallax_direction'] != ""   && !is_array($fields['parallax_direction'] )){ 
	$xclass .=  " ".$fields['parallax_direction'];
	//print_r($fields['parallax_direction']);
}
if(isset($fields['parallax'])&& $fields['parallax']){
	$xclass .=  " parallaxParent";
	if(!is_admin()){
?>
<?php
ob_start(); ?>
	var controller = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: "onEnter", duration: "200%"}});
	new ScrollMagic.Scene({triggerElement: "#<?php echo $id; ?>"}) 
	.setTween("#<?php echo $id; ?> > .bg-image", {
	<?php if($fields['parallax_direction'] == "totop"){ ?>
		top: "0",
	<?php }else if($fields['parallax_direction'] == "tobottom"){?>
		bottom: "0",
	<?php }else if($fields['parallax_direction'] == "toleft"){?>
		right: "0",
	<?php }else if($fields['parallax_direction'] == "toright"){?>
		left: "0",	bottom: "0",
	<?php } ?> scale:1, blur:0, ease: Linear.easeNone})
	//.addIndicators()
	.addTo(controller);
	new ScrollMagic.Scene({triggerElement: "#<?php echo $id; ?>"})
	.setTween("#<?php echo $id; ?> .bg-image::before", {scale:1.4, blur:0, ease: Linear.easeNone})
	//.addIndicators()
	.addTo(controller);
	
	<?php
$myScripts .= ob_get_clean();
	}
}

// content <alginment class="">
$content_vertical_align = '';
if(isset($fields['content_vertical_align']) && $fields['content_vertical_align'] != "" && !is_array($fields['content_vertical_align'] )){ 
	$content_vertical_align .=  " col-align-".$fields['content_vertical_align'];
	$xclass .=" content_vertical_align-".$fields['content_vertical_align'];
}else{
	$content_vertical_align .=  "  ";
}

$column_vertical_alignment = '';
// echo $fields['column_vertical_align'];
if(isset($fields['column_vertical_align']) && $fields['column_vertical_align'] != "" && !is_array($fields['column_vertical_align'] )){ 
	$column_vertical_alignment .=  " col-align-".$fields['column_vertical_align'];
	$xclass .=" column_vertical_alignment-".$fields['content_vertical_align'];
}else{
	$column_vertical_alignment .=  "  ";
}


//echo "setup-> XCLASS: ".$xclass."<br>";
//echo "setup-> CLASS: ".$class."<br>";]
//echo "setup-> content_vertical_align: ".$content_vertical_align." column_vertical_align: ".$column_vertical_align."<br>";