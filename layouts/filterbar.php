<?php
global $myScripts;
?>
<div class="trip-selector headline">
<?php
$types = get_terms( 'product-type');
$terms = get_terms( 'product-category' );
$allTags = get_terms('product-tags');
$typeFilters = array();
$typeSelects = array();
$mainFilters = array();
$mainSelects = array();
$catFilters = array();
$catSelects = array();
$subfilters = array();
$tagSelects = array();

$allTagFilters = array();

$class = " ";

if (get_sub_field('show_all_link')) {
	$mainFilters[]= '<li><a href="javascript:void(0)" title="" data-filter=".all" ' . $class . ' >All</a></li>';
}

foreach ($allTags as $term) {
	$allTagFilters[]= '<li><a href="javascript:void(0)" title="" data-filter=".tag-' .  $term->slug . '" ' . $class . ' >' . $term->name . '</a></li>';

}

foreach ($types as $term) {
    
	//$typeFilters[]= '<li><a href="javascript:void(0)" title="" data-filter=".' .  $term->slug . '" ' . $class . ' >' . $term->name . '</a></li>';
}
$typeFilters[]= '<li class="init"><a href="javascript:void(0)" title=""  > --- </a></li>';
$typeSelects[] = '<option value="------">...</option>';

// echo "<br>types: ".count($types);
foreach ($types as $_type) {
  //  echo "<br>types: ".$_type->name.' '.$_type->term_id;


	$types_array = get_posts(
        array( 'showposts' => -1,
            'post_type' => 'Product',
            'tax_query' => array(
                array(
                'taxonomy' => 'product-type',
                'field' => 'term_id',
                'terms' => $_type->term_id,
                )
            ),
            'fields' => 'ids',
        )
    );
    // echo "<br>types_array: ".count($types_array);

   // print_r($_type);
    if(get_field('trip_selector_text', $_type->taxonomy . '_' . $_type->term_id)){
        $_type->name = get_field('trip_selector_text', $_type->taxonomy . '_' . $_type->term_id);
    }
    //$echo = get_field('tripe_selector_text', $_type->taxonomy . '_' . $_type->term_id);

    if (!get_field('hide_trip_selector', $_type->taxonomy . '_' . $_type->term_id)) {
        $typeFilters[]= '<li><a href="javascript:void(0)" title="" data-filter=".' .  $_type->slug . '" ' . $class . ' >' . $_type->name . '</a></li>';
        $typeSelects[] = '<option value="'.$_type->slug.'">'.$_type->name.'</option>';
    }
 
    $mainSelects[] = '<option value="------">for...</option>';
	$terms = get_terms('product-category', array( 'orderby'  => 'menu_order', 'object_ids'=> $types_array) );
   // echo "<br>terms: ".count($terms);

    foreach ($terms as $term) {
       // echo "<br>select term: ".$term->name." ";
        //$mainFilters = array();
        $posts_array = get_posts(
            array( 'showposts' => -1,
            'post_type' => 'Product',
            'tax_query' => array(
                array(
                'taxonomy' => 'product-category',
                'field' => 'term_id',
                'terms' => $term->term_id,
                )
            ),
            'fields' => 'ids',
			'include' => $types_array
        )
        );
    
        if ($category == $term->slug) {
            $class = ' ';
        } else {
            $class = "";
        }
        if(get_field('trip_selector_text', $term->taxonomy . '_' . $term->term_id)){
            $term->name = get_field('trip_selector_text', $term->taxonomy . '_' . $term->term_id);
        }
        if (!get_field('hide_trip_selector', $term->taxonomy . '_' . $term->term_id)) {
            $mainFilters[]= '<li><a href="javascript:void(0)" title="" data-filter=".' .  $term->slug . '" ' . $class . ' >' . $term->name . '</a></li>';
            $mainSelects[] = '<option value="'.$term->slug.'">'.$term->name.'</option>';
        }
          

            
            $tags = get_terms('product-tags', array( 'orderby'  => 'menu_order', 'object_ids'=> $posts_array));


            if ($tags && !is_wp_error($tags)) :
                $tempArray = array();
                $tempSelects = array();
                $tempSelects[] = '<option value="------">...</option>';

                foreach ($tags as $tag) {
                   // echo "<br>tag: ".$tag->name;
                    //if (!in_array($tag->slug, $all_tags)) {
                    // $all_tags[] = $tag->slug;
                // print_r($tag);
                if(get_field('trip_selector_text', $tag->taxonomy . '_' . $tag->term_id)){
                    $tag->name = get_field('trip_selector_text', $tag->taxonomy . '_' . $tag->term_id);
                }
                if (!get_field('hide_trip_selector', $tag->taxonomy . '_' . $tag->term_id)) {
                    $tempArray[] = '<li><a href="javascript:void(0)" title="" data-filter=".tag-' .  $tag->slug . '" ' . $class . ' >' . $tag->name.' </a><li>';
                    $tempSelects[] = '<option value="'.$tag->slug.'">'.$tag->name.'</option>';
                }
                  

                    ////}
                }
                if (!empty($tempArray)) {
                    // <li><a href='javascript:void(0)' class='cleartags active'>All Tags</a></li>
                    $subfilters[] = "<ul class='tags ".$term->slug.' '.$_type->slug."' >".implode("", $tempArray)."</ul>";

                    $tagSelects[] =  "<select onchange='madeSelection(this);' class='tags ".$term->slug.' '.$_type->slug."' >".implode("", $tempSelects)."</select>";

                }
              //  echo "<br/> - END TAG";
            endif;
       // echo "<br/> - END CAT";
        //
       

    }
    //print_r($mainFilters);
    if (!empty($mainFilters)) {
        // <li><a href='javascript:void(0)' class='cleartags active'>All Tags</a></li>
        $catFilters[] = "<ul class='cats ".$_type->slug."' >".implode("", $mainFilters)."</ul>";
        $catSelects[] =  "<select onchange='madeSelection(this);' class='cats ".$_type->slug."' >".implode("", $mainSelects)."</select>";
        $mainFilters = array();
        $mainSelects = array();
    }
 //   echo "<br/> - END TYPE";

}
//print_r($mainFilters);
//$allTagFilters[] = $term->slug;
$subfilters[] = "<ul class='taxgs all'>".implode("", $allTagFilters)."</ul>";
//echo "<ul class='type filters'>".implode("", $typeFilters)."</ul>";
echo "I WANT TO <select onchange='madeSelection(this);' class='select_type_filters'>".implode("", $typeSelects)."
<option value='guided-kayak-tours'>kayak and walk</option>
</select>";
//echo "<ul class='main filters'>Category ".implode("", $mainFilters)."</ul>";
echo '<span class="catwrap">'.implode("", $catSelects).'</span>';
echo '<span class="tagwrap">'.implode("", $tagSelects).'</span>';
echo "<a id='tripselector' class='headline go_but anim' href = '#'>GO</a>";


?>
</div>
