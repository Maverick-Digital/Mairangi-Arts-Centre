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
$section_id = $id;
?>
<div id="<?php echo $section_id; ?>" class="layer page_carousel clearfix grid "> 
	<div class="bg-image background-image <?php echo $class; ?>" style=" <?php echo $style; ?>" ></div>
	<div class="inner col inner-<?php echo $inner; ?> clearfix">
<?php


  $args = array(
    'post_type' => 'case-studies',
    'order'          => 'ASC',
    'orderby'        => 'rand',
    /*'tax_query' => array(
      array(
          'taxonomy' => 'deal-categories',
          'field' => 'id',
          'terms' =>$populate // Array of service categories you wish to retrieve posts from
      )
    ),*/
    'post__not_in' => array(get_the_ID()) 
);

/*
}else{

$myarray = get_sub_field("parent_page");
  $posttype = 'page';
  $args = array(
  'post_type' => 'any',
  'post__in' => $myarray,
  'order'          => 'ASC',
    'orderby'        => 'rand'
  );
}
*/
$wp_query = new WP_Query(); 			
$wp_query->query($args);
$count =0;
$post_count = $wp_query->post_count;
//echo $post_count;
//$post_count = wp_count_posts()->publish;
?>
	<div class="_inner pad-bot-40 center">
  <h3><strong>See more Case Study</strong></h3>
	</div>

<div class="scroller ">
<?php
	while ($wp_query->have_posts()) : 
		$wp_query->the_post();
		//echo $count;
		$append=$prepend="";
		$closed=false;
	
    $count++;
    $image = fly_get_attachment_image_src( get_field('tile_image'), array( 600, 600 ), true );
		if(!$image) {
			$image = fly_get_attachment_image_src(get_post_thumbnail_id(), array( 600, 600 ), true );
		}
		if(!$image) {
			$image = fly_get_attachment_image_src(146, array( 600, 600 ), true );
		}
		?>
		<article class="ani carousel-card <?php echo get_field("color_profile"); ?>">
			<div class="card">
				<div class="bg-image" style="background-image:url(<?php echo $image['src']; ?>)" ></div>
			</div>
		<?php /*
			<div class="tile-copy">
				<h3 class="" ><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
				<p class="date-meta" ><?php echo get_the_date(); ?></p>
			</div>
		*/ ?>
    <div class="tile-copy">
		<h3 class="ani ani1"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
				<?php if(get_field('description')){ ?>
				<div class="info-deal ani ani2">
					<?php echo get_field('description'); ?>
				</div>
				<?php } ?>
    </div>
				<div class="action ani ani3"><a href="<?php echo get_the_permalink(); ?>" class="button ghost ">Discover More</a></div>
		<?php if(get_field('url')){ ?>
		<a href="<?php echo get_field('url'); ?>" class="link-overlay">&nbsp;</a>
		<?php }else{ ?>
		<a href="<?php echo get_the_permalink(); ?>" class="link-overlay">&nbsp;</a>
    <?php } ?>		
  </article>
	<?php
	endwhile; ?>
</div>
<?php
wp_reset_query();
?>
			
			
		
	</div>
</div>
<?php
ob_start();
    /*$('#<?php echo $id; ?> .scroller').lightSlider({
        item:3,
        loop:false,
        slideMove:1,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed:600,
        slideMargin:0,
        pager:false,
		adaptiveHeight:true,
        responsive : [
            {
                breakpoint:767,
                settings: {
                    item:2,
                    slideMove:1,
                    slideMargin:0,
                  }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                  }
            }
        ]
    }); */  ?>
    console.log('fire slick ');
	$('#<?php echo $section_id; ?> .scroller').slick({
  dots: true,
  arrows: false,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
}); 
<?php
$myScripts .= ob_get_clean();

