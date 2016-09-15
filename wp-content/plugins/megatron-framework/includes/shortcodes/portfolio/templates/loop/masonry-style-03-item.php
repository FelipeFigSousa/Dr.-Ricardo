<?php
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$arrImages = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$width = 370;
$height = 284;
$col_class = 'col-md-4';

if($layout_type=='masonry-style-03'){
    $matrix = array(
        array(2,1.5,1,1,1,2)
    );
}else{
    $matrix = array(
        array(1,2,1.5,1,1,2)
    );
}

$index_col = floor(($index-1)%6);
if($matrix[0][$index_col]==2){
    $width = 770;
    $col_class = 'col-md-8';
}
if($matrix[0][$index_col]==1.5){
    $height = 599;
}

$class_item = array();
$class_item[] ='portfolio-item';
$class_item[] = $cat_filter;
$class_item[] = $overlay_align;
$class_item[] = $overlay_style;
$class_item[] = $overlay_effect;
$class_item[] = $col_class;

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
