<?php

function wpdocs_selectively_enqueue_admin_script( $hook ) {
	wp_enqueue_style( 'app', get_stylesheet_directory_uri() . '/library/css/app.css', array(), '', 'all' );
    wp_enqueue_style( 'grid', get_stylesheet_directory_uri() . '/library/css/grid.css', array(), '', 'all' );
   // wp_enqueue_style( 'typography', get_stylesheet_directory_uri() . '/library/css/typography.css', array(), '', 'all' );

    wp_enqueue_style( 'fonts', get_stylesheet_directory_uri() . '/library/fonts/fonts.css', array(), '', 'all' );

}
add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );
//add_filter('mce_css', 'tuts_mcekit_editor_style');
function tuts_mcekit_editor_style($url) {
 
    if ( !empty($url) )
        $url .= ',';
 
    // Retrieves the plugin directory URL
    // Change the path here if using different directories
    $url .= trailingslashit( plugin_dir_url(__FILE__) ) . '/editor-styles.css';
 
    return $url;
}
 
/**
 * Add "Styles" drop-down
 */
add_filter( 'mce_buttons_2', 'tuts_mce_editor_buttons' );
 
function tuts_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
 
/**
 * Add styles/classes to the "Styles" drop-down
 */
add_filter( 'tiny_mce_before_init', 'tuts_mce_before_init' );
 
function tuts_mce_before_init( $settings ) {
 
    $style_formats = array(
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
            ),
            array(
                'title' => 'Lead Paragraph',
                'selector' => 'p',
                'classes' => 'lead'
                ),
                array(
                    'title' => 'Larger Paragraph',
                    'selector' => 'p',
                    'classes' => 'larger'
                    ),
            array(
                'title' => 'small',
                'inline' => 'small',
                //'classes' => 'green',
                'wrapper' => false
                ),
                array(
                    'title' => 'yellow',
                    'inline' => 'span',
                    'classes' => 'yellow',
                    'wrapper' => true
                    ),
                array(
                    'title' => 'red',
                    'block' => 'span',
                    'classes' => 'red',
                    'wrapper' => true
                    ),
            array(
                'title' => 'green',
                'block' => 'span',
                'classes' => 'green',
                'wrapper' => true
                ),
            array(
                'title' => 'red',
                'block' => 'span',
                'classes' => 'red',
                'wrapper' => true
                ),
            array(
                'title' => 'light',
                'block' => 'span',
                'classes' => 'light',
                'wrapper' => true
                ),
            array(
                'title' => 'dark',
                'block' => 'span',
                'classes' => 'dark',
                'wrapper' => true
                ),
            array(
                'title' => 'List: Tickboxes',
                'selector' => 'ul',
                'classes' => 'tick-box-list',
                ),
                array(
                    'title' => 'List: 2 columns',
                    'selector' => 'ul',
                    'classes' => 'auto_column',
                    ),
               
        /*array(
            'title' => 'Testimonial',
            'selector' => 'p',
            'classes' => 'testimonial',
        ),
        array(
            'title' => 'Warning Box',
            'block' => 'div',
            'classes' => 'warning box',
            'wrapper' => true
        ),
        array(
            'title' => 'Red Uppercase Text',
            'inline' => 'span',
            'styles' => array(
                'color' => '#ff0000',
                'fontWeight' => 'bold',
                'textTransform' => 'uppercase'
            )
        )*/
    );
 
    $settings['style_formats'] = json_encode( $style_formats );
 
    return $settings;
 
}
 
/* Learn TinyMCE style format options at http://www.tinymce.com/wiki.php/Configuration:formats */
 
/*
 * Add custom stylesheet to the website front-end with hook 'wp_enqueue_scripts'
 */
//add_action('wp_enqueue_scripts', 'tuts_mcekit_editor_enqueue');
 
/*
 * Enqueue stylesheet, if it exists.
 */
function tuts_mcekit_editor_enqueue() {
  $StyleUrl = plugin_dir_url(__FILE__).'editor-styles.css'; // Customstyle.css is relative to the current file
  wp_enqueue_style( 'myCustomStyles', $StyleUrl );
}
?>