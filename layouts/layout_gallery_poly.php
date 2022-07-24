<?php 

if(get_sub_field('gallery_layout')):
$images = get_sub_field('gallery_layout');
if(get_sub_field('id')){
	$id = "id='".get_sub_field('id')."'";
}else{
	$id="";
}
if(get_sub_field('class') && get_sub_field('class') != ""){
	$xclass =  get_sub_field('class');
}else{
	$xclass =  "pad-top-40 pad-bot-40";

}
?>
<div class="layer  clearfix  gallery " <?php echo $id; ?> >
	<div class="<?php echo $xclass; ?>  clearfix">
		<div class="main-carousel">
			<?php foreach( $images as $image ):
			if($image['caption'] ==''){ $image['caption'] =  get_bloginfo( 'name' ); }
			 //print_r($image);
			 //class="background-image" style="<?php echo ipq_get_theme_image_url( $image['ID'], array( 900, 600, true ) );
			  ?>
			   <div class="carousel-cell background-image" style="background-image:url(<?php echo ipq_get_theme_image_url( $image['ID'], array( 900, 600, true ) ); ?>);">
					<div class="carousel-inner">
					<a class="venobox lightbox anim" href="<?php echo $image['sizes']['large'];  ?>" title="<?php echo $image['caption']; ?>" data-gall="myGallery"></a>
					<?php
					echo ipq_get_theme_image( $image['ID'], array(
							array( 450, 300, true ),
							array( 900, 600, true )
						)
					);
					?>
					</div>
				</div>
				<?PHP /*<li >
					<a class="venobox" href="<?php echo $image['sizes']['large'];  ?>" title="<?php echo $image['caption']; ?>" data-gall="myGallery">
					<?php
					echo ipq_get_theme_image( $image['ID'], array(
							array( 450, 300, true ),
							array( 900, 600, true )
						)
					);
				//	echo ipq_get_theme_image( $image['ID'], array( 700, 700, true ) );
				//	echo ipq_get_theme_image( $image['ID'], array( 375, 375, true ));
				
	//echo ipq_get_theme_image_url( $image['ID'], array( 368, 246, false ) );
					?>
				
					</a>
				</li>
				*/ ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>


<script>
<?php /*
jQuery(function($) {
 setTimeout(openPopup, 300);
 function openPopup(){
  	$('.main-carousel').flickity('resize');
  	 console.log( 'openPopup' );
}



	$('.button--resize').on( 'click', function() {
	  // expand carousel by toggling class
	  $carousel.toggleClass('is-expanded')
		.flickity('resize');
	});

	$carousel = $('.main-carousel');
	
	$carousel.on( 'change.flickity', function( event, index ) {
	  console.log( 'Slide changed to ' + index );
	  $carousel.flickity('resize');
	  

	});
	$carousel.on( 'staticClick.flickity', function( event, pointer, cellElem, cellIndex ) {
	  if ( cellIndex !== undefined ) {
  
		$carousel.flickity( 'select', cellIndex );
		//$carousel.delay(.5).flickity('resize');
	  }
	});




	$carousel.on( 'settle.flickity', function( event, index ) {
  			console.log( 'Flickity settled at ' + index );
  	  		$('.main-carousel').flickity('resize');
  	  		  			console.log( 'resize' );

			  setTimeout(openPopup, 300);

	});
	
	$('.icon-arrow-left').on( 'click', function() {
		$carousel.flickity('pausePlayer')
	  	$carousel.flickity('previous');
	});
	$('.icon-arrow-right').on( 'click', function() {
		$carousel.flickity('pausePlayer')
	  $carousel.flickity('next');
	});
});
*/ ?>
</script>