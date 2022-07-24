<?php
 add_filter('acf/format_value/type=wysiwyg', 'format_value_wysiwyg', 10, 3);
 function format_value_wysiwyg( $value, $post_id, $field ) {
     if(is_admin()){
         $value = preg_replace ( '/\[gravityform(.*?)\]/s' , '[form]' , $value );
         $value = preg_replace ( '/\[ninja(.*?)\]/s' , '[form]' , $value );
         //echo get_sub_field('right_column',false, false);
     }
     $value = apply_filters( 'the_content', $value );
     return $value;
 }
 

add_action('acf/init', 'my_acf_init');
add_filter('acf/prepare_field/type=flexible_content', 'my_flexible_content_layouts');
function my_flexible_content_layouts($field){
    
    // Bail early if no layouts
    if(!isset($field['layouts']) || empty($field['layouts']))
        return $field;
    
    foreach($field['layouts'] as $layout_key => $layout){
        //echo $layout['name'];
        // Target layout name: hero
        //if($layout['name'] === 'layout_3_column' 
       
            //$layout['name'] === 'global_content'
        //|| $layout['name'] === 'testimonials'
       // || $layout['name'] === 'layout_tiles'
       if($layout['name'] === 'layout_subpages'
        || $layout['name'] === 'layout_pages_carousel'
        || $layout['name'] === 'author'
        || $layout['name'] === 'layout_pagenav'
        || $layout['name'] === 'company_logos'
        || $layout['name'] === 'page_touchpoints'
        ){
            
            // Disable
            unset($field['layouts'][$layout_key]);
            
        }
        
    }
    
    // return
    return $field;
    
}
?>