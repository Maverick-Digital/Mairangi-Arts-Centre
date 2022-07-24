<?php

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    //if (is_user_logged_in() && $args->theme_location == 'main-nav') {
    $orig_items = $items;
    $items='';
    if ($args->theme_location == 'main-nav' || $args->theme_location == 'sub-nav') {
        //$items .= '<li><div id="cart-bar-button"></div></li>';
       // $items .= '<li>'.do_shortcode('[add_booking_but]').'</li>';
        #cart-bar-button
    }
	if ($args->theme_location == 'main-nav') {
     $items .= '<li class="mobile_nav"><a href="#" class="mobile js-drawer-open-right clearfix">
     <button class="hamburger  hamburger--stand-r" type="button">
						  <span class="hamburger-box">
							<span class="hamburger-inner"></span>
						  </span>
						</button>
     					<span class="translate sr-only">Menu</span>
     					</a></li>';
    //	$items .= '<li class="mobile_nav"><a href="#" class="navToggle mobile js-drawer-open-right"><span>&nbsp;</span></a></li>';

     
        }
   

    // }
    
    return $orig_items.$items;
}

function custom_menu_output( $theme_location ) {
	global $post;
	
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menus = array();

        foreach( $menu_items as $menu_item ) {
            $pid = $menu_item->menu_item_parent ? $menu_item->menu_item_parent : 0;
				//var_dump($menu_item);
		
		$unfiltered_classes = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		//print_r( $unfiltered_classes);
		$classes = $unfiltered_classes;
		$classes[].= "nav-".$menu_item->ID;
		/*
		$classes = array_filter( $unfiltered_classes, array( $this, 'filter_builtin_classes' ) );
		if ( preg_grep("/^current/", $unfiltered_classes) ) {
			$classes[].= 'active';
		}
		$classes[].= "level".$depth;
		
		*/
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item ) );
		//$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' animation_name "' : '';
//echo $class_names;
		//$output .= $indent . '<li'  . $class_names .'>';
		//echo $menu_item->object_id.'   '. $menu_item->title.' |  '.$menu_item->post_parent.' | '.$post->ID.' | '.get_the_title().'<br/>';
		if($post->ID == $menu_item->object_id ){ $class_names .= ' menu__link--current'; }
		
		if(is_singular('bathing') && $menu_item->object_id == 7){ $class_names .= ' menu__link--current';}
		//if(){ $class_names .= ' menu__link--current'; }

            $menus[$pid][] = array(
                'link' => $menu_item->url,
                'title' => $menu_item->title,
                'id' => $menu_item->ID,
                'translate' => $menu_item->post_excerpt,
                'classes' => $class_names
            );
        }


	




        foreach($menus as $key => $menu) {
            if($key == 0)
                echo '<ul data-menu="main" class="menu__level">';
            else
                echo '<ul data-menu="submenu-'.$key.'" class="menu__level">';
            foreach($menu as $item) {
        		//print_r($item);
                if(isset($menus[$item['id']]))
                    echo '<li class="menu__item '.$item['classes'].'"><a class="menu__link" href="'.$item['link'].'">'.$item['title'].'<span class="translate"></span></a><a class="menu__link '.$item['classes'].'" data-submenu="submenu-'.$item['id'].'" href="'.$item['link'].'">&nbsp;</a></li>';
                else
                    echo '<li class="menu__item '.$item['classes'].'"><a class="menu__link" href="'.$item['link'].'">'.$item['title']."<span class='translate'></span>".'</a></li>';
            }
            if($key == 0 && !is_page_template( array( 'page_outdoorgravity.php' ) ) ){
            
             echo '<li class="menu__item widget">';
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer7') ) : endif;
				echo do_shortcode('[affiliates]');
			 echo '</li>';
			 
            }
            echo '</ul>';
        }

    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
   // echo $menu_list;
}
/*
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class($classes, $item){

     if(is_single() && $item->title == 'Blog'){

             $classes[] = 'current-menu-item';

     }

     return $classes;

}
*/

class ifeelfree_Nav_Menu extends Walker_Nav_Menu
{
   /**
	 * What the class handles.
	 *
	 * @since 3.0.0
	 * @access public
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @since 3.0.0
	 * @access public
	 * @todo Decouple this.
	 * @var array
	 *
	 * @see Walker::$db_fields
	 */
	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		//$output .= "{$n}{$indent}<ul class=\"dropdown clearfix\">{$n}";
		$output .= "{$n}{$indent}<ul class=\"dropdown  menu_wrap clearfix\">{$n}";

	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}
function filter_builtin_classes( $var ) {
	    return ( FALSE === strpos( $var, 'item' ) ) ? $var : ''; 
	}
	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	//&$output, $page, $depth = 0, $args = Array, $current_page = 0
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		//var_dump($item);
		$unfiltered_classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes = array_filter( $unfiltered_classes, array( $this, 'filter_builtin_classes' ) );
		if ( preg_grep("/^current/", $unfiltered_classes) ) {
			$classes[].= 'active';
		}
		$classes[].= "level".$depth;
		$classes[].= "nav-".$item->ID;
		
		
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' animation_name "' : '';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li'  . $class_names .'>';
		
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		 
		 
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );


		//print_r($atts);
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
		
			if ( ! empty( $value ) ) {
			//echo  '<br/>' . $attr . '="' . $value ;
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				
			//echo  '<br/>' . $attr . '="' . $value .' '.get_the_permalink(202);
			
			
				if($value == get_the_permalink(9)){
				
					//if(get_post_type() == 'tour' || wp_get_post_parent_id(get_the_ID()) == 70 || wp_get_post_parent_id(get_the_ID()) == 71){
					if(is_single('tour') ){
						$value.="?h=1&interested=".urlencode(get_the_title());
					}
					
				}
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		
		// echo($args->menu_class);
		
		/*
		if(strToLower($title) == "home" && $args->menu_class == "top_nav"){
			$transparent = '4';
			$image = fly_get_attachment_image_src( $transparent, array( 240, 240), true);
			$title='<img src="'.$image['src'].'" width="'.$image['width'].'" height="'.$image['height'].'" class="img-responsive " alt="Inspired New Zealand Travel"><span>Inspired New Zealand Travel</span>';			
		}
		*/
		if(strToLower($title) == "menu" && $args->menu_class == "top_nav"){
			$title = '<i class="icon icon-menu">&nbsp;</i>' ;
			$attributes .= ' class="mobile js-drawer-open-left"';		
		}
		if(strToLower($title) == "enquire" && $args->menu_class == "top_nav"){
			$attributes .= ' class="enquire _js-drawer-open-enquire"';
		}

		if(strToLower($title) == "tours"){
			$attributes .= ' class="tours"';
		}
		if(strToLower($title) == "book now" && $args->menu_class == "top_nav"){
			
			$attributes .= ' class="button book"';
			//echo $attributes;
			//title="button" href="http://localhost:8888/ccc/book-now/" class="button"
		}
		
		
		$pageT = esc_attr($item->object_id);
		$item_output = $args->before;
		//if($depth != 1){
			$item_output .= '<a'. $attributes .'>';
		//}
		
			// $item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= $args->link_before;
			$item_output .= '<span data-hover="'.$title.'">'.$title.'</span>';
			$item_output .= $args->link_after;
			
			$item_output .= '</a>';
		
		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}

}



class list_group_walker extends Walker_page {
	
	function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {
		if ( $depth )
				$indent = str_repeat("\t", $depth);
		else
				$indent = '';
		
		extract($args, EXTR_SKIP);
		$css_class = array('page_item', 'page-item-'.$page->ID);
		if ( !empty($current_page) ) {
				$_current_page = get_page( $current_page );
				_get_post_ancestors($_current_page);
				if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
						$css_class[] = 'current_page_ancestor';
				if ( $page->ID == $current_page )
						$css_class[] = 'current_page_item active';
				elseif ( $_current_page && $page->ID == $_current_page->post_parent )
						$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
				$css_class[] = 'current_page_parent';
		}
		
		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
		
		$output .= $indent . '<a href="' . get_permalink($page->ID) . '" class="' . $css_class . ' list-group-item">' . $link_before .apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';	

	}
}

