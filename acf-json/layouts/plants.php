<div class="plants">
	<span>
		<?php 
	$attachment_ID = 199;
	 echo ipq_get_theme_image( $attachment_ID, array(
				array( 1920, 621, false ),
				array( 1280, 720, false ),
				array( 600, 400, false ),
			),
			array(
				// 'class' => 'img-responsive'
			)
		);
		// <img src="http://localhost:8888/whakavillage.co.nz/wp-content/themes/whakavillage/library/images/plants.png" />
		?>
	</span>
</div>