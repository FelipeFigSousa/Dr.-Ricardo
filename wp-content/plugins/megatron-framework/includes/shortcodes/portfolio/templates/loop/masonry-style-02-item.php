<?php
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$arrImages = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$width = 370;
$height = 494;
$overlay_height = 'height-50';

$matrix = array(
  array(2,1,2),
  array(2,2,2),
  array(2,1,1)
);

$index_row = floor(($index-1) / $column)%3;
$index_col = ($index-1) % $column;
if($matrix[$index_row][$index_col]==1){
    $width = 370;
    $height = 260;
    $overlay_height = '';
}

$class_item = array();
$class_item[] ='portfolio-item col-md-4';
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
