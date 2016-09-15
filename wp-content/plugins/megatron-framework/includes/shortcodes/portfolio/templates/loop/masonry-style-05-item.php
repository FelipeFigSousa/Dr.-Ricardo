<?php
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$arrImages = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$width = 380;
$height = 285;
$overlay_height = 'height-50';

$matrix = array(
    array(1,1,4,1),
    array(2,1,2,3),
    array(1,1,1,3)
);
$col_class = 'masonry-20';
$index_row = floor(($index-1) / $column)%3;
$index_col = ($index-1) % $column;
if($matrix[$index_row][$index_col]==4){
    $width = 760;
    $height = 507;
    $overlay_height = '';
    $col_class = 'masonry-40';
}
if($matrix[$index_row][$index_col]==3){
    $width = 760;
    $height = 280;
    $overlay_height = '';
    $col_class = 'masonry-40';
}
if($matrix[$index_row][$index_col]==2){
    $width = 380;
    $height = 502;
    $overlay_height = '';
}

$class_item = array();
$class_item[] ='portfolio-item';
$class_item[] = $col_class;
$class_item[] = $cat_filter;
$class_item[] = $overlay_align;
$class_item[] = $overlay_height;
$class_item[] = $overlay_style;
$class_item[] = $overlay_effect;

?>

<div class="<?php echo implode(' ', $class_item) ?>">

    <?php
    $thumbnail_url = '';
    if (count($arrImages) > 0) {
        $resize = matthewruddy_image_resize($arrImages[0], $width, $height);
        if ($resize != null && is_array($resize))
            $thumbnail_url = $resize['url'];
    }

    $url_origin = $arrImages[0];
    if ($overlay_style == 'left-title-excerpt-link')
        $overlay_style = 'title-excerpt-link';
    $overlay_template = plugin_dir_path( __FILE__ ).'/overlay/'.$overlay_style.'.php';
    if(file_exists($overlay_template)){
        include($overlay_template);
    }
    ?>

    <?php
    $gallery_template = plugin_dir_path(__FILE__) . '/gallery.php';
    if(file_exists($gallery_template)){
        include($gallery_template);
    }
    ?>

</div>


